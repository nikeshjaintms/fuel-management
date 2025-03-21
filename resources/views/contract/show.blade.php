@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Contract</h3>
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
            <a href="{{ route('admin.contract.index') }}">Contract</a>
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
              <a href="{{ route('admin.contract.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Contract</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $data->id}}</td>
                    </tr>
                    <tr>
                        <th>Driver Name</th>
                        <td>{{ $data->cname}}</td>
                    </tr>
                    <tr>
                        <th>Contract No</th>
                        <td>{{ $data->contract_no}}</td>
                    </tr>
                    <tr>
                        <th>Contract Date</th>
                        <td>{{ $data->contract_date}}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $data->start_date}}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{ $data->end_date}}</td>
                    </tr>
                </table>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                        <th>Vehicle No</th>
                        <th>Type</th>
                        <th>Min km</th>
                        <th>Rate</th>
                        <th>Extra Rate KM</th>
                        <th>Rate Per Hour</th>
                    </tr>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->vehicle_no }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td>{{ $vehicle->min_km }}</td>
                        <td>{{ $vehicle->rate }}</td>
                        <td>{{ $vehicle->extra_km_rate }}</td>
                        <td>{{ $vehicle->rate_per_hour }}</td>
                    </tr>
                    @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
