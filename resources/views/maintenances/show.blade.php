@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Maintenance Information</h3>
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
            <a href="{{ route('admin.maintenance.index') }}">Maintenance Information</a>
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
              <a href="{{ route('admin.maintenance.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Maintenance Detailed</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $maintenance->id}}</td>
                    </tr>
                    <tr>
                        <th>Vendor Name</th>
                        <td>{{ $maintenance->vendor_name}}</td>
                    </tr>
                    <tr>
                        <td>Vehicle No</td>
                        <td>{{ $maintenance->vehicle_no}}</td>
                    </tr>
                    <tr>
                        <td>Invoice no</td>
                        <td>{{ $maintenance->invoice_no}}</td>
                    </tr>
                    <tr>
                        <td>Invoice Date</td>
                        <td>{{ $maintenance->invoice_date}}</td>
                    </tr>
                    <tr>
                        <td>Maintence Date</td>
                        <td>{{ $maintenance->maintenance_date}}</td>
                    </tr>
                    <tr>
                        <td>Supervisor</td>
                        <td>{{ $maintenance->supervisor_name}}</td>
                    </tr>
                </table>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                        <th>Product</th>
                        <th>HSN</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Rate</th>
                        <th>Discount</th>
                        <th>SubTotal</th>
                        <th>Tax %</th>
                        <th>Tax Amount</th>
                        <th>Total</th>
                    </tr>
                    @foreach($maintenanceItems as $item)
                    <tr>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->hsn_code}}</td>
                        <td>{{ $item->quantity}}</td>
                        <td>{{ $item->unit}}</td>
                        <td>{{ $item->rate}}</td>
                        <td>{{ $item->discount}}</td>
                        <td>{{ $item->amount_without_tax}}</td>
                        <td>{{ $item->tax}}</td>
                        <td>{{ $item->tax_amount}}</td>
                        <td>{{ $item->amount}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td >{{ $maintenance->total_bill_amount}}</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
