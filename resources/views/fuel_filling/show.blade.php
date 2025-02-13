@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Fuel Fillings Information</h3>
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
            <a href="{{ route('admin.fuel_filling.index') }}">Fuel Fillings Information</a>
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
              <a href="{{ route('admin.fuel_filling.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Fuel Filled Detailed</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $data->id}}</td>
                    </tr>
                    <tr>
                        <th>Driver</th>
                        <td>{{ $data->driver_name}}</td>
                    </tr>
                     <tr>
                        <th>Customer</th>
                        <td>{{ $data->customer_name}}</td>
                    </tr>
                    <tr>
                        <th>Regen no</th>
                        <td>{{ $data->vehicle_no}}</td>
                    </tr>
                    <tr>
                        <th>Filling Date</th>
                        <td>{{ $data->filling_date}}</td>
                    </tr>
                    <tr>
                        <th>Nozzle</th>
                        <td>{{ $data->nozzle_no }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $data->quantity}}</td>
                    </tr>
                    <tr>
                        <th>kilometer</th>
                        <td>{{ $data->kilometers}}</td>
                    </tr><tr>
                        <th>Average (Fuel Consumption) </th>
                        <td>{{ $data->average_fuel_consumption ?? 0}}</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
