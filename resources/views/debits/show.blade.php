@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Debits</h3>
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
            <a href="{{ route('admin.debits.index') }}">Debits</a>
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
              <a href="{{ route('admin.debits.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Dedit Detailed</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $debits->id}}</td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{ $debits->customer_name}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $debits->customer_address}}</td>
                    </tr>
                    <tr>
                        <th>GST</th>
                        <td>{{ $debits->customer_gst}}</td>
                    </tr>
                    <tr>
                        <th>Invoice No</th>
                        <td>{{ $debits->invoice_no}}</td>
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
                        @foreach($debits_items as $detail)
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
                        <td>{{ $debits->subtotal_amount}}</td>
                    </tr>
                    @php
                    $tax = $debits->tax / 2;
                    $cgst= $debits->tax_amount / 2;
                    @endphp
                    @if($debits->tax_type == 'igst')
                    <tr>
                        <th>IGST {{ $debits->tax  }}</th>
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
                        <td>{{ $debits->total_amount}}</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
