@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Vehicle Information</h3>
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
                        <a href="{{ route('admin.vehicles.index')}}">Vehicle Information</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">List of Vehicle Information</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.vehicles.create') }}" class=" float-end btn btn-sm btn-rounded btn-primary"><i class="fas fa-plus"></i> Vehicle Information</a>
                      <h4 class="card-title">Add Vehicle Information</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Vehicle No</th>
                              <th>Engine No</th>
                              <th>Chassis No</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($vehicles as $item)
                            <tr>
                              <td>{{$item->id }}</td>
                              <td>{{$item->vehicle_no }}</td>
                              <td>{{$item->vehicle_engine_no }}</td>
                              <td>{{$item->vehicle_chassis_no }}</td>
                              <td>
                                <a href="{{ route('admin.vehicles.show', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-eye">
                                </i></a>
                                <a href="{{ route('admin.vehicles.edit', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-edit">
                                </i></a>
                                <a href="#" class="btn btn-link btn-danger">
                                  <i class="fa fa-trash">
                                </i>
                                </a>                   
                            </tr>                                
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection



