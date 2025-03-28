@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Invoice</h3>
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
            <a href="{{ route('admin.invoice.index') }}">Invoice</a>
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
              <a href="{{ route('admin.invoice.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Invoice</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $invoices->id}}</td>
                    </tr>
                    <tr>
                        <th>Client</th>
                        <td>{{ $invoices->customer_name}}</td>
                    </tr>
                    <tr>
                        <th>Invoice No</th>
                        <td>{{ $invoices->invoice_no}}</td>
                    </tr>
                    <tr>
                        <th>Invoice Date</th>
                        <td>{{ $invoices->invoice_date}}</td>
                    </tr>
                    <tr>
                        <th>Contract No</th>
                        <td>{{ $invoices->contract_no}}</td>
                    </tr>
                </table>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                        <th>Vehicle No</th>
                        <th>Type</th>
                        <th>Min km</th>
                        <th>Rate</th>
                        <th>Extra Rate KM</th>
                        <th>Extra KM Drive</th>
                        <th>KM Drive</th>
                        <th>Total Extra KM Amount</th>
                        <th>Rate Per Hour</th>
                        <th>Overtime</th>
                        <th>Overtime Amount</th>

                    </tr>
                    @foreach($invoice_vehicles as $vehicle)
                        @foreach ($contract_vehicles as $item)
                        <tr>
                            <td>{{ $vehicle->vehicle_no }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->min_km }}</td>
                            <td>{{ $item->rate }}</td>
                            <td>{{ $item->extra_km_rate }}</td>
                            <td>{{ $vehicle->extra_km_drive }}</td>
                            <td>{{ $vehicle->km_drive }}</td>
                            <td>{{ $vehicle->total_extra_km_amount }}</td>
                            <td>{{ $item->rate_per_hour }}</td>
                            <td>{{ $vehicle->overtime }}</td>
                            <td>{{ $vehicle->overtime_amount }}</td>
                        </tr>
                        @endforeach

                    @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
