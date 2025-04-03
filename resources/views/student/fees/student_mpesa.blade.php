@extends('student.layouts.master')
@section('title', 'M-Pesa Payment')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <!-- M-Pesa Payment Form -->
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>M-Pesa Payment</h5>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{ route('stkpush') }}" id="paymentForm">
                            @csrf
                            <input type="hidden" name="fee_id" value="{{ $fee->id }}">

                            <div class="row">
                                <!-- Fee Category -->
                                <div class="form-group col-md-6">
                                    <label>Fee Category</label>
                                    <input type="text" class="form-control" value="{{ $fee->category->title ?? '' }}" readonly>
                                </div>

                                <!-- Fee Amount -->
                                <div class="form-group col-md-6">
                                    <label>Fee Amount ({{ $setting->currency_symbol }})</label>
                                    <input type="text" class="form-control" value="{{ number_format($fee->fee_amount, 2) }}" readonly>
                                </div>

                                <!-- Balance Due -->
                                <div class="form-group col-md-6">
                                    <label>Balance Due ({{ $setting->currency_symbol }})</label>
                                    <input type="text" class="form-control" value="{{ number_format($balance, 2) }}" readonly id="balance">
                                </div>

                                <!-- Phone Number -->
                                <div class="form-group col-md-6">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $phoneNumber) }}" required>
                                </div>

                                <!-- Amount to Pay -->
                                <div class="form-group col-md-6">
                                    <label>Amount to Pay ({{ $setting->currency_symbol }})</label>
                                    <input type="number" class="form-control" name="payment_amount" required id="payment_amount">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="payButton">
                                    <i class="fas fa-money-check"></i> Pay with M-Pesa
                                </button>
                            </div>
                        </form>

                        <div id="feedback" class="mt-3"></div>
                    </div>
                </div>
            </div>

            <!-- Bank Details Section -->
            <div class="col-sm-6">
                @if ($bankDetails)
                    <div class="card">
                        <div class="card-header bg-primary text-white text-center">
                            <h5>Bank Payment Details</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Bank Name:</strong> {{ $bankDetails->bank_name }}</p>
                            <p><strong>Account Number:</strong> {{ $bankDetails->bank_account }}</p>
                            <p><strong>Branch:</strong> {{ $bankDetails->bank_branch }}</p>
                        </div>
                    </div>
                @endif

                @if ($paybill)
                    <div class="card">
                        <div class="card-header bg-secondary text-white text-center">
                            <h5>M-Pesa PayBill Details</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>PayBill Number:</strong> {{ $paybill->paybill_number }}</p>
                            <p><strong>Account Number:</strong> {{ $paybill->paybill_account }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Update Balance Display Script -->
<script>
    document.getElementById("payment_amount").addEventListener("input", function () {
        var balance = {{ $balance }};
        var paymentAmount = parseFloat(this.value) || 0;
        var newBalance = balance - paymentAmount;
        document.getElementById("balance").value = newBalance.toFixed(2);
    });
</script>

<!-- M-Pesa Ajax Handling -->
<script>
    $('#paymentForm').on('submit', function (e) {
        e.preventDefault();

        let paymentAmount = parseFloat($('#payment_amount').val());
        if (!paymentAmount || paymentAmount <= 0) {
            $('#feedback').html('<div class="alert alert-warning">Please enter a valid payment amount.</div>');
            return;
        }

        $('#payButton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending STK Push...');

        $.ajax({
            url: '{{ route("stkpush") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#feedback').html('<div class="alert alert-info">' + response.message + '</div>');

                setTimeout(function () {
                    checkPaymentStatus();
                }, 20000); // check status after 20 seconds
            },
            error: function (xhr) {
    let response = xhr.responseJSON;
    let message = response && response.message ? response.message : 'An unexpected error occurred.';

    $('#feedback').html('<div class="alert alert-danger">' + message + '</div>');
    $('#payButton').prop('disabled', false).html('<i class="fas fa-money-check"></i> Pay with M-Pesa');
}

        });
    });

    function checkPaymentStatus() {
        $.ajax({
            url: '{{ route("check.payment.status", $fee->id) }}',
            type: 'GET',
            success: function (res) {
                if (res.status === 'Paid') {
                    window.location.href = "{{ route('student.fees.index') }}";
                } else if (res.status === 'Failed') {
                    $('#feedback').html('<div class="alert alert-warning">Payment failed or cancelled. Please try again.</div>');
                    $('#payButton').prop('disabled', false).html('<i class="fas fa-money-check"></i> Pay with M-Pesa');
                } else {
                    $('#feedback').html('<div class="alert alert-info">Still waiting for confirmation...</div>');
                    $('#payButton').prop('disabled', false).html('<i class="fas fa-money-check"></i> Retry');
                }
            }
        });
    }
</script>
@endsection
