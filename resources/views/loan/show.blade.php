@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Loan</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="{{ route('index') }}">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.owner.index') }}">Loan</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Detailed</a>
          </li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <a href="{{ route('admin.loan.index') }}" class="btn btn-rounded btn-primary float-end"><i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Detailed</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $data->id }}</td>
                    </tr>
                    <tr>
                        <th>Registered Number</th>
                        <td>{{ $data->vehicle_no }}</td>
                    </tr>
                    <tr>
                        <th>Finance by</th>
                        <td>{{ $data->finance_by ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Loan Amount</th>
                        <td>{{ $data->loan_amount ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Loan Account</th>
                        <td>{{ $data->loan_account ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>EMI Account</th>
                        <td>{{ $data->emi_amount ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Total EMI</th>
                        <td>{{ $data->total_emi ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>EMI Paid</th>
                        <td>{{ $data->emi_paid ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>EMI Remaining</th>
                        <td>{{ $data->pending_emi ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $data->start_date ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{ $data->end_date ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Rate Of Interst</th>
                        <td>{{ $data->rate_of_interest ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($data->status == 'On Going')
                            <div class="badge badge-primary">
                                {{$data->status }}
                            </div>
                            @else
                            <div class="badge badge-success">
                                {{$data->status }}
                            </div>
                            @endif</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
