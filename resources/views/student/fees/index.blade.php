@extends('student.layouts.master')
@section('title', 'Fees Payment')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Fees</h5>
                 
                        <h5 class="mb-0"> <a href="{{ route('student.my.mpesa.statement') }}" class="btn btn-primary btn-sm" target="_blank">
                            View Statement
                        </a>    </h5>
                       
                
                        
                    </div>
                    
                    <div class="card-block">
                        @isset($rows)
                        <div class="table-responsive">
                            <table id="basic-table" class="display table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Session</th>
                                        <th>Semester</th>
                                        <th>Fees Type</th>
                                        <th>Total Fee</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->studentEnroll->session->title ?? '' }}</td>
                                        <td>{{ $row->studentEnroll->semester->title ?? '' }}</td>
                                        <td>{{ $row->category->title ?? '' }}</td>
                                        <td>{{ number_format($row->fee_amount, 2) }} {{ $setting->currency_symbol }}</td>
                                        <td>{{ number_format($row->paid_amount, 2) }} {{ $setting->currency_symbol }}</td>
                                        <td>{{ number_format(max(0, $row->fee_amount - $row->paid_amount), 2) }} {{ $setting->currency_symbol }}</td>
                                        <td>{{ $row->due_date ? date('Y-m-d', strtotime($row->due_date)) : '-' }}</td>
                                        <td>
                                            {{-- <a href="{{ route('paymentprocess', ['id' => $row->id]) }}" class="btn btn-success">
                                                <i class="fas fa-money-bill"></i> Pay Now
                                            </a> --}}

                                            <td>
                                                <a href="{{ route('studentprocess', ['id' => $row->id, 'payment_amount' => max(0, $row->fee_amount - $row->paid_amount)]) }}" class="btn btn-success">
                                                    <i class="fas fa-money-bill"></i> Pay
                                                </a>
                                            </td> 
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#basic-table').DataTable();
    });
</script>

@endsection
