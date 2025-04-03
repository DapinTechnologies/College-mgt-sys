@extends('student.layouts.master')
@section('title', 'M-Pesa Payment')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>M-Pesa Payment</h5>
                    </div>

                    <div class="card-block">
                        <form method="post" action="{{ url('initiatepush') }}">
                            @csrf
                            <input type="hidden" name="fee_id" value="{{ $fee->id }}">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Fee Category</label>
                                    <input type="text" class="form-control" value="{{ $fee->category->title ?? '' }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Fee Amount ({{ $setting->currency_symbol }})</label>
                                    <input type="text" class="form-control" value="{{ number_format($fee->fee_amount, 2) }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Balance Due ({{ $setting->currency_symbol }})</label>
                                    <input type="text" class="form-control" value="{{ number_format($balance, 2) }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Amount to Pay ({{ $setting->currency_symbol }})</label>
                                    <input type="number" class="form-control" name="payment_amount" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-money-check"></i> Pay with M-Pesa
                                </button>
                            </div>
                        </form>
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

@endsection
