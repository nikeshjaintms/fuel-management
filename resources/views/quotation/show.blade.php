@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Quotation</h3>
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
            <a href="{{ route('admin.quotations.index') }}">Quotation</a>
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
              <a href="{{ route('admin.quotations.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Quotation</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $data->id}}</td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{ $data->customer_name}}</td>
                    </tr>
                    <tr>
                        <th>Customer GSTIN</th>
                        <td>{{ $data->customer_gst}}</td>
                    </tr>
                    <tr>
                        <th>Quotation Date</th>
                        <td>{{ $data->quotation_date}}</td>
                    </tr>
                </table>
                <br>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                        <th>Type of Vehicle</th>
                        <th>KM</th>
                        <th>Rate</th>
                        <th>Extra Rate KM</th>
                        <th>Rate Per Hour</th>
                        <th>Average</th>
                    </tr>
                    @foreach($quotation_items as $item)
                    <tr>
                        <td>{{ $item->type_of_vehicle }}</td>
                        <td>{{ $item->km }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{ $item->extra_km_rate }}</td>
                        <td>{{ $item->over_time_rate }}</td>
                        <td>{{ $item->average }}</td>
                    </tr>
                    @endforeach
                </table>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                        <th>GST</th>
                        <td>{{ $data->gst_charge }}</td>
                    </tr>
                    <tr>
                        <th>Price Variation</th>
                        <td>{{ $data->price_variation }}</td>
                    </tr>
                    <tr>
                        <th>Present Fuel Rate</th>
                        <td>{{ $data->present_fuel_rate }}</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
