<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Setting;
use App\Models\FeesCategory;
use App\Models\Fee;
use App\Models\MpesaSetting;
use App\Models\BankMpesaDetails;
use App\Models\PaybillDetail;
use App\Models\Transaction;
use App\Models\MpesaTrascation;
use App\Models\PaymentTransaction;
Use Auth;
use Toastr;
use Illuminate\Support\Facades\DB;
use Str;
use Illuminate\Support\Facades\Http;
use Log;
use Carbon\Carbon;
use App\Models\Stkpush;
use Storage;
class MpesaController extends Controller
{
    private $status;
    private $shortcode_type;
    private $app_url;

    public function __construct()
    {
        $this->status = config('mpesa.status');
        $this->shortcode_type = config('mpesa.shortcode_type');
        $this->app_url = config('app.url');
    }

    public function token()
    {
        $config = ($this->status === 'sandbox') ? [
            'consumerKey' => config('mpesa.consumerkey_sandbox'),
            'consumerSecret' => config('mpesa.consumersecret_sandbox'),
            'url' => 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        ] : [
            'consumerKey' => config('mpesa.consumerkey'),
            'consumerSecret' => config('mpesa.consumersecret'),
            'url' => 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        ];

        $response = Http::withBasicAuth($config['consumerKey'], $config['consumerSecret'])
                        ->withoutVerifying()
                        ->get($config['url']);

        if ($response->successful()) {
            return response()->json(['access_token' => $response['access_token']], 200);
        }

        $message = json_decode($response->body(), true);
        Log::error('Token Generation Failed', ['error' => $message['errorMessage'] ?? 'Unknown error']);
        return response()->json(['error' => $message['errorMessage'] ?? 'Failed to generate token'], 400);
    }
    public function initiatePush(Request $request)
    {
        $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'phone_number' => 'required|string',
            'payment_amount' => 'required|numeric|min:1'
        ]);
    
        // Log the initiation
        Log::info('STK Push Initiated', [
            'phone' => $request->phone_number,
            'amount' => $request->payment_amount,
            'fee_id' => $request->fee_id
        ]);
    
        $tokenResponse = $this->token();
        if ($tokenResponse->getStatusCode() !== 200) {
            Log::error('Token Generation Failed');
            return response()->json(['error' => 'Failed to get access token'], 400);
        }
    
        $accessToken = $tokenResponse->getData(true)['access_token'];
        $config = $this->getMpesaConfig();
    
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($config['businessShortCode'] . $config['passKey'] . $timestamp);
        $phoneNumber = $this->formatPhoneNumber($request->phone_number);
    
        if (!$phoneNumber) {
            Log::error('Invalid Phone Number Format', ['phone' => $request->phone_number]);
            return response()->json(['error' => 'Invalid phone number format'], 400);
        }
    
        $callbackUrl = $this->app_url .'/stkcallback';
        
        // Log the callback URL for verification
        Log::info('Callback URL Verification', [
            'constructed_url' => $callbackUrl,
            'app_url_config' => $this->app_url
        ]);
    
        try {
            $response = Http::withToken($accessToken)
                ->withoutVerifying()
                ->timeout(30)
                ->post($config['url'], [
                    'BusinessShortCode' => $config['businessShortCode'],
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => $config['transactionType'],
                    'Amount' => $request->payment_amount,
                    'PartyA' => $phoneNumber,
                    'PartyB' => $config['partyB'],
                    'PhoneNumber' => $phoneNumber,
                    'CallBackURL' => $callbackUrl,
                    'AccountReference' => 'Fee Payment',
                    'TransactionDesc' => 'Student Fee Payment'
                ]);
    
            $responseData = $response->json();
            Log::info('STK Push Response', ['response' => $responseData]);
    
            if ($response->successful() && isset($responseData['ResponseCode'])) {
                if ($responseData['ResponseCode'] == 0) {
                    $this->createStkPushRecord($responseData, $request);
                    return response()->json([
                        'message' => 'Check your phone to complete payment',
                        'checkout_request_id' => $responseData['CheckoutRequestID'],
                        'redirect' => route('student.fees.index')
                    ]);
                }
                return response()->json(['error' => $responseData['ResponseDescription'] ?? 'Payment request failed'], 400);
            }
    
            $error = $response->json();
            Log::error('STK Push Failed', ['error' => $error]);
            return response()->json(['error' => $error['errorMessage'] ?? 'Payment request failed'], 400);
    
        } catch (\Exception $e) {
            Log::error('STK Push Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Payment processing error'], 500);
        }
    }
    
    public function StkCallBack(Request $request)
    {
        // Enhanced logging at the start
        Log::info('Raw MPESA Callback Request', [
            'headers' => $request->headers->all(),
            'content' => $request->getContent(),
            'ip' => $request->ip()
        ]);
    
        // Handle different content types
        if ($request->isJson()) {
            $data = $request->json()->all();
        } else {
            $data = json_decode($request->getContent(), true);
        }
    
        // Validate callback structure
        if (!isset($data['Body']) || !isset($data['Body']['stkCallback'])) {
            Log::error('Invalid Callback Structure', ['data' => $data]);
            return response()->json(['message' => 'Invalid callback structure'], 400);
        }
    
        $callback = $data['Body']['stkCallback'];
        $checkoutRequestId = $callback['CheckoutRequestID'];
        $resultCode = $callback['ResultCode'];
        $resultDesc = $callback['ResultDesc'];
    
        Log::info('Callback Processing', [
            'CheckoutRequestID' => $checkoutRequestId,
            'ResultCode' => $resultCode,
            'ResultDesc' => $resultDesc
        ]);
    
        DB::beginTransaction();
        try {
            $payment = Stkpush::where('CheckoutRequestID', $checkoutRequestId)->lockForUpdate()->first();
            
            if (!$payment) {
                Log::error('Payment Record Not Found', ['CheckoutRequestID' => $checkoutRequestId]);
                DB::rollBack();
                return response()->json(['message' => 'Payment record not found'], 404);
            }
    
            if ($resultCode == 0) {
                $this->handleSuccessfulPayment($callback, $payment);
                DB::commit();
                Log::info('Payment Processed Successfully', ['CheckoutRequestID' => $checkoutRequestId]);
                return response()->json(['message' => 'Payment processed']);
            } else {
                $this->handleFailedPayment($callback, $payment);
                DB::commit();
                Log::warning('Payment Failed', [
                    'CheckoutRequestID' => $checkoutRequestId,
                    'ResultCode' => $resultCode,
                    'ResultDesc' => $resultDesc
                ]);
                return response()->json(['message' => 'Payment failed: ' . $resultDesc], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Callback Processing Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'CheckoutRequestID' => $checkoutRequestId
            ]);
            return response()->json(['message' => 'Processing error'], 500);
        }
    }
  

    private function getMpesaConfig()
    {
        return ($this->status === 'sandbox') ? [
            'passKey' => config('mpesa.passkey_sandbox'),
            'businessShortCode' => config('mpesa.shortcode_sandbox'),
            'url' => 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            'transactionType' => 'CustomerPayBillOnline',
            'partyB' => config('mpesa.shortcode_sandbox')
        ] : [
            'passKey' => config('mpesa.passkey'),
            'businessShortCode' => config('mpesa.shortcode'),
            'url' => 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            'transactionType' => ($this->shortcode_type === 'till') ? 'CustomerBuyGoodsOnline' : 'CustomerPayBillOnline',
            'partyB' => ($this->shortcode_type === 'till') ? config('mpesa.till') : config('mpesa.shortcode')
        ];
    }

    private function formatPhoneNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        
        if (strlen($number) === 10 && $number[0] === '0') {
            return '254' . substr($number, 1);
        }
        
        if (strlen($number) === 9 && $number[0] === '7') {
            return '254' . $number;
        }
        
        if (strlen($number) === 12 && substr($number, 0, 3) === '254') {
            return $number;
        }
        
        return false;
    }
    public function checkPaymentStatus(Request $request)
{
    $request->validate([
        'checkout_request_id' => 'required|string'
    ]);

    $checkoutRequestId = $request->checkout_request_id;
    
    // Check if payment exists and is successful
    $payment = Stkpush::where('CheckoutRequestID', $checkoutRequestId)
                     ->where('ResultCode', 0)
                     ->first();

    if ($payment) {
        return response()->json([
            'status' => 'success',
            'message' => 'Payment completed successfully'
        ]);
    }

    return response()->json([
        'status' => 'pending',
        'message' => 'Payment not yet completed'
    ], 202);
}



    private function createStkPushRecord($response, $request)
    {
        $fee = Fee::findOrFail($request->fee_id);
        
        Stkpush::create([
            'MerchantRequestID' => $response['MerchantRequestID'],
            'CheckoutRequestID' => $response['CheckoutRequestID'],
            'CustomerMessage' => $response['CustomerMessage'],
            'amount' => $request->payment_amount,
            'PhoneNumber' => $this->formatPhoneNumber($request->phone_number),
            'status' => 'Requested',
            'ResponseCode' => $response['ResponseCode'],
            'AccountReference' => 'Fee Payment',
            'TransactionDesc' => 'Student Fee Payment',
            'fee_id' => $fee->id,
            'original_paid_amount' => $fee->paid_amount,
            'original_due_amount' => $fee->due_amount
        ]);
    }

    protected function handleSuccessfulPayment(array $callback, Stkpush $payment)
    {
        try {
            // Check if CallbackMetadata exists and has items
            if (!isset($callback['CallbackMetadata'])) {
                throw new \Exception('CallbackMetadata missing in response');
            }
    
            $metadata = $callback['CallbackMetadata'];
            $items = $metadata['Item'] ?? [];
    
            $paymentData = [
                'ResultCode' => $callback['ResultCode'],
                'ResultDesc' => $callback['ResultDesc'],
                'MerchantRequestID' => $callback['MerchantRequestID'],
                'CheckoutRequestID' => $callback['CheckoutRequestID'],
                'Amount' => null,
                'MpesaReceiptNumber' => null,
                'TransactionDate' => null,
                'PhoneNumber' => null
            ];
    
            // Process metadata items
            foreach ($items as $item) {
                if (!isset($item['Name']) || !isset($item['Value'])) continue;
                
                switch ($item['Name']) {
                    case 'Amount':
                        $paymentData['Amount'] = $item['Value'];
                        break;
                    case 'MpesaReceiptNumber':
                        $paymentData['MpesaReceiptNumber'] = $item['Value'];
                        break;
                    case 'TransactionDate':
                        $paymentData['TransactionDate'] = $item['Value'];
                        break;
                    case 'PhoneNumber':
                        $paymentData['PhoneNumber'] = $item['Value'];
                        break;
                }
            }
    
            // Update payment record
            $payment->update([
                'ResultCode' => $paymentData['ResultCode'],
                'ResultDesc' => $paymentData['ResultDesc'],
                'MerchantRequestID' => $paymentData['MerchantRequestID'],
                'CheckoutRequestID' => $paymentData['CheckoutRequestID'],
                'Amount' => $paymentData['Amount'],
                'MpesaReceiptNumber' => $paymentData['MpesaReceiptNumber'],
                'TransactionDate' => $paymentData['TransactionDate'],
                'PhoneNumber' => $paymentData['PhoneNumber'],
                'Status' => 'completed'
            ]);
    
            // Additional business logic (e.g., update fee payment status)
            $this->processPaymentSuccess($payment);
    
        } catch (\Exception $e) {
            Log::error('Payment Processing Error', [
                'error' => $e->getMessage(),
                'callback' => $callback,
                'payment_id' => $payment->id
            ]);
            throw $e;
        }
    }

    private function handleFailedPayment($callback, $payment)
    {
        $payment->update([
            'status' => 'Failed',
            'ResultCode' => $callback->ResultCode,
            'ResultDesc' => $callback->ResultDesc
        ]);
    }
    
    
    
    
    public function checkPaymentStatusByRequestId(Request $request)
    {
        $request->validate(['checkout_request_id' => 'required']);
        
        $stk = Stkpush::where('CheckoutRequestID', $request->checkout_request_id)->first();
    
        if (!$stk) {
            return response()->json(['status' => 'Not Found']);
        }
    
        return response()->json([
            'status' => $stk->status,
            'result_code' => $stk->ResultCode,
            'message' => $stk->ResultDesc ?? $stk->CustomerMessage
        ]);
    }

    
public function StudentProcess($id, Request $request)
{
    $fee = Fee::findOrFail($id);

    // Retrieve student information (assuming there's a relationship between Fee and Student)
    $student = $fee->studentEnroll->student;  // Adjust this based on your model relationships
    $phoneNumber = $student->phone ?? '';  // Assuming 'phone' is the phone number field

    // Calculate the payment amount and balance
    $paymentAmount = $request->get('payment_amount', max(0, $fee->fee_amount - $fee->paid_amount));
    $balance = $fee->fee_amount - $fee->paid_amount;
    
    $bankDetails = BankMpesaDetails::first();
    $paybill = PaybillDetail::first(); // or PaybillDetails::first()

    // Pass all relevant data to the view
    return view('student.fees.student_mpesa', compact('fee', 'bankDetails', 'paybill', 'balance', 'paymentAmount', 'phoneNumber'));
}


public function index()
{
    $title = 'Payment Gateway';
    $access = 'sms';
    $rows= 'row';

    $mpesaSettings = MpesaSetting::first(); // Assuming a single record
    $bankDetails = BankMpesaDetails::first(); // Assuming a single record
    $paybillDetails = PaybillDetail::first(); // Assuming a single record

    return view('admin.payment-setting.index', compact('mpesaSettings', 'bankDetails', 'paybillDetails'));

}




public function myMpesaStatement()
{
   // $user = Auth::user();
   //$studentId = session('student_id'); 
   //Auth::guard('student')->login($student);

   $student = Auth::guard('student')->user();
    //dd($student);

    if (!$student) {
        return redirect()->route('login')->with('error', 'Please log in again.');
    }

    $enrollIds = \App\Models\StudentEnroll::where('student_id', $student->id)->pluck('id');

    $feeIds = \App\Models\Fee::whereIn('student_enroll_id', $enrollIds)->pluck('id');

    $transactions = \App\Models\Stkpush::with('fee.category')
        ->whereIn('fee_id', $feeIds)
        ->orderByDesc('created_at')
        ->get();

       // dd($transactions);
    return view('student.fees.my_statement', compact('transactions', 'student'));
}






    // public function StudentProcess($id)
    // {
    //     //dd($id); 
    //     $fee = Fee::findOrFail($id);

    //     // Retrieve the bank details and Paybill information if available
    //     $bankDetails = BankDetails::first(); // Modify this based on your actual database structure
    //     $paybill = PaybillDetails::first();  // Modify this based on your actual database structure

    //     // Calculate the balance or any other data you need to display
    //     $balance = $fee->fee_amount - $fee->amount_paid; // Adjust this calculation based on your fee structure

    //     // Pass the data to the view
    //     return view('student.mpesa_payment', compact('fee', 'bankDetails', 'paybill', 'balance'));
    // }


}
