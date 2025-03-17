@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Owner Information</h3>
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
            <a href="{{ route('admin.owner.index') }}">Owner Information</a>
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
              <a href="{{ route('admin.owner.index') }}" class="btn btn-rounded btn-primary float-end" > <i class="fas fa-angle-left"></i> Back</a>
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
                        <th>Name</th>
                        <td>{{ $data->owner_name }}</td>
                    </tr>
                    <tr>
                        <th>Relationship</th>
                        <td>{{ $data->type }}</td>
                    </tr>
                    <tr>
                        <th>Asset make Model</th>
                        <td>{{ $data->asset_make_model }}</td>
                    </tr>
                    <tr>
                        <th> Segement</th>
                        <td>{{ $data->segment }}</td>
                    </tr>
                    <tr>
                        <th>Model </th>
                        <td>{{ $data->model }}</td>
                    </tr>
                    <tr>
                        <th>Body </th>
                        <td>{{ $data->body }}</td>
                    </tr>
                    <tr>
                        <th>Year of Model</th>
                        <td>{{ $data->yom }}</td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $data->customer_name ?? '--' }}</td>
                    </tr>
                </table>
              </div>
            </div>
          </div>
        </div>



  @endsection
