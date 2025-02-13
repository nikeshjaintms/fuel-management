@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">RTO Information</h3>
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
            <a href="{{ route('admin.rto.index') }}">RTO Information</a>
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
              <a href="{{ route('admin.rto.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">RTO Detailed</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $data->id}}</td>
                    </tr>
                    <tr>
                        <th>Vehicle no</th>
                        <td>{{ $data->vehicle_no}}</td>
                    </tr>
                    <tr>
                        <th>Policy No</th>
                        <td>{{ $data->policy_no}}</td>
                    </tr>
                    <tr>
                        <th>Policy Expiry</th>
                        <td>{{ $data->policy_expiry_date }}</td>
                    </tr>
                    <tr>
                        <th>Fitness Expiry</th>
                        <td>{{ $data->fitness_expiry_date}}</td>
                    </tr>
                    <tr>
                        <th>PUC Expiry</th>
                        <td>{{ $data->puc_expiry_date}}</td>
                    </tr><tr>
                        <th>Road Tax Status</th>
                        <td>{{ $data->status ?? "--"}}</td>
                    </tr>
                    <tr>
                        <th>Paid Month</th>
                        <td>{{ $data->month ?? "--"}}</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
