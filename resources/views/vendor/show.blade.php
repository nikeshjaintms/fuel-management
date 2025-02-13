@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Vendor</h3>
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
            <a href="{{ route('admin.vendor.index') }}">Vendor</a>
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
              <a href="{{ route('admin.vendor.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
              <h4 class="card-title">Vendor Detailed</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <tr>
                      <th>ID</th>
                      <td>{{ $data->id}}</td>
                    </tr>
                    <tr>
                        <th>Vendor Name</th>
                        <td>{{ $data->name}}</td>
                    </tr>
                    <tr>
                      <th>GST</th>
                      <td>{{ $data->vendor_gst}}</td>
                  </tr>
                    <tr>
                        <th>Mobile NO</th>
                        <td>{{ $data->phone_number}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $data->email}}</td>
                    </tr>
                    <tr>
                      <th>Address</th>
                      <td>{{ $data->address}}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
