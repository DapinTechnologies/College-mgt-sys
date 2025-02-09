<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\SMSMessage;
use App\Models\SmsConfiguration;
use Illuminate\Support\Facades\Log;
class SMSService
{

    protected $apiUrl; 
    protected $serviceId; 
    public function __construct() 
    { $smsConfig = SmsConfiguration::first(); if ($smsConfig)
         { $this->apiUrl = $smsConfig->api_url; 
            $this->serviceId = $smsConfig->service_id; 



                       
         }
         }
    //protected $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/profile';

    public function checkBalance()
    {
        $smsConfig = SmsConfiguration::first();
        if (!$smsConfig) {
            return 'No SMS configuration found';
        }
    
        $apiKey = $smsConfig->api_key;
    
        try {
            $response = Http::withOptions([
                'verify' => false  // Disables SSL certificate verification
            ])->post('https://smsportal.dapintechnologies.com/sms/v3/profile', [
                'api_key' => $apiKey
            ]);
    
            if ($response->successful()) {
                $responseJson = $response->json();
                return $responseJson[0]['wallet']['credit_balance'] ?? 'Balance not found';
            } else {
                Log::error("Failed to authenticate API key.", ['response' => $response->body()]);
                return 'Failed to authenticate API key.';
            }
        } catch (\Exception $e) {
            Log::error("SMS API request exception: " . $e->getMessage());
            return 'Error fetching balance';
        }
    }
    

    public function alertIfLowCredit($apiKey)
    {
        $credits = $this->checkBalance($apiKey);
        if ($credits !== null && $credits < 10) {
            // Notify the user to top up
            \Notification::send(auth()->user(), new \App\Notifications\LowSmsCredits($credits));
        }
    }


    public function sendSMS($apiKey, $recipients, $message, $isBulk = false)
    {
        // Ensure serviceId is correctly set
        $smsConfig = SmsConfiguration::first();
        $this->serviceId = $smsConfig->service_id ?? 'default_service_id';
    
        $payload = [
            'api_key' => $apiKey,
            'serviceId' => $this->serviceId,
            'from' => 'Dapin',
            'date_send' => now()->format('Y-m-d H:i:s'),
            'messages' => []
        ];
    
        $uniqueRecipients = array_unique($recipients);
        foreach ($uniqueRecipients as $recipient) {
            // Check if this message has already been sent to this recipient today
            $alreadySent = SMSMessage::where('phone_number', $recipient)
                                    ->where('message', $message)
                                    ->whereDate('sent_at', now())
                                    ->exists();
    
            if (!$alreadySent) {
                $payload['messages'][] = [
                    'mobile' => (string)$recipient, // Ensure mobile is a string
                    'message' => $message,
                    'client_ref' => (string)rand(10000, 99999) // Ensure client_ref is a string
                ];
            }
        }
    
        if (empty($payload['messages'])) {
            Log::info('No new SMS to send. Messages already exist in the database.');
            return ['status' => 'No Messages', 'message' => 'All recipients already received this message today.'];
        }
    
        Log::info('Sending SMS Payload:', ['payload' => json_encode($payload)]);
    
        try {
            $client = new \GuzzleHttp\Client(['verify' => false]); // Disable SSL verification
    
            $response = $client->post($this->apiUrl, [
                'json' => $payload, // Ensures the correct JSON format
                'headers' => [
                    'Content-Type' => 'application/json', // Explicitly set the content type
                    'Accept' => 'application/json'
                ]
            ]);
    
            $responseJson = json_decode($response->getBody(), true);
    
            Log::info('Full SMS API Response:', ['response' => $responseJson]);
    
            if ($response->getStatusCode() === 200 && isset($responseJson['status_code']) && $responseJson['status_code'] == 1000) {
                // Save each sent message to the database
                foreach ($payload['messages'] as $sentMessage) {
                    SMSMessage::create([
                        'phone_number' => $sentMessage['mobile'],
                        'message' => $sentMessage['message'],
                        'is_bulk' => $isBulk,
                        'status' => 'Success',
                        'sent_at' => now(),
                        'api_configuration_id' => $smsConfig->id,
                    ]);
                }
    
                return ['status' => 'Success', 'remaining_credits' => $responseJson['credit_balance'] ?? 'Unknown'];
            } else {
                Log::error('SMS API Error:', ['response' => $responseJson]);
                return ['status' => 'Failed', 'error' => $responseJson['status_desc'] ?? 'Unknown error'];
            }
        } catch (\Exception $e) {
            Log::error('SMS API Exception:', ['error' => $e->getMessage()]);
            return ['status' => 'Failed', 'error' => $e->getMessage()];
        }
    }
    

    

    

    public function sendSingleSMS($apiUrl, $data) 
    { 
    // Send the POST request to the SMS API 
    $response = Http::timeout(60)->post($apiUrl, $data);
     // Log the request data and response 
    Log::info('Sending SMS with data: ', 
    ['data' => $data]);
     Log::info('SMS API Response: ', 
    ['response' => $response->json()]);
     return $response->json(); 
    }
  
}