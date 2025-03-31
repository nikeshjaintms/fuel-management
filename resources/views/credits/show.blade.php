@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Credits</h3>
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
            <a href="{{ route('admin.credits.index') }}">Credits</a>
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
              <a href="{{ route('admin.credits.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Credit Detailed</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $credits->id}}</td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{ $credits->customer_name}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $credits->customer_address}}</td>
                    </tr>
                    <tr>
                        <th>GST</th>
                        <td>{{ $credits->customer_gst}}</td>
                    </tr>
                    <tr>
                        <th>Invoice No</th>
                        <td>{{ $credits->invoice_no}}</td>
                    </tr>
                </table>
                <br>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead>
                        <th>Item</th>
                        <th>HSN/SAC</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Unit</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        @foreach($credits_items as $detail)
                        <tr>
                            <td>{{ $detail->item}}</td>
                            <td>{{ $detail->hsn_sac}}</td>
                            <td>{{ $detail->quantity}}</td>
                            <td>{{ $detail->rate}}</td>
                            <td>{{ $detail->unit}}</td>
                            <td>{{ $detail->amount}}</td>
                        </tr>
                        @endforeach
                </table>
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                        <th>Sub Total</th>
                        <td>{{ $credits->subtotal_amount}}</td>
                    </tr>
                    @php
                    $tax = $credits->tax / 2;
                    $cgst= $credits->tax_amount / 2;
                    @endphp
                    @if($credits->tax_type == 'igst')
                    <tr>
                        <th>IGST {{ $credits->tax  }}</th>
                        <td>{{ $tax_anount}}</td>
                    </tr>
                    @else
                    <tr>
                        <th>CGST {{ $tax  }}%</th>
                        <td>{{ $cgst}}</td>
                    </tr>
                    <tr>
                        <th>SGST {{ $tax  }}%</th>
                        <td>{{ $cgst}}</td>
                    </tr>
                    @endif

                    <tr>
                        <th>Total Amount</th>
                        <td>{{ $credits->total_amount}}</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
