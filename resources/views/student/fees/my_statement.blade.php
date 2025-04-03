@extends('student.layouts.master')
@section('title', 'My M-Pesa Statement')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">M-Pesa Transactions for <strong>{{ $student->first_name }} {{ $student->last_name }}</strong></h5>
            </div>

            <div class="card-block">
                @if($transactions->count())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fee Category</th>
                            <th>Amount</th>
                            <th>Receipt</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $tx)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tx->fee->category->title ?? 'N/A' }}</td>
                            <td>{{ number_format($tx->Amount, 2) }}</td>
                            <td>{{ $tx->MpesaReceiptNumber ?? 'Not Paid' }}</td>
                            <td>
                                <span class="badge badge-{{ $tx->status === 'Paid' ? 'success' : 'warning' }}">
                                    {{ $tx->status }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($tx->created_at)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($tx->created_at)->format('h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <p>No M-Pesa transactions found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
