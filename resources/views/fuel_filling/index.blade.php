@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif

@section('content-page')


    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Fuel Fillings information</h3>
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
                        <a href="{{ route('admin.fuel_filling.index')}}">Fuel Fillings  Information</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">List of Fuel Fillings Information</a>
                    </li>
                </ul>

            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.fuel_filling.pdf')}}" class="float-end btn btn-sm btn-rounded btn-info ">PDF</a>
                        <a href="{{ route('admin.fuel_filling.export')}}" class=" float-end btn btn-sm btn-rounded btn-success me-2"><i class="fas fa-file-excel"></i> Export</a>
                        @can('fuel-filling-create')
                        <a href="{{ route('admin.fuel_filling.create') }}" class=" float-end btn btn-sm btn-rounded btn-primary me-2"><i class="fas fa-plus"></i> Fuel Filling Information</a>
                        @endcan
                        <h4 class="card-title">Add Fuel Fillings Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('admin.fuel_filling.custompdf')}}" method="POST" >
                                    @csrf
                                     @if(Session::has('error'))
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var myModal = new bootstrap.Modal(document.getElementById('errorModal'));
                                                myModal.show();
                                            });
                                        </script>
                                    @endif
                                    <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                            <label for="" class="me-2">Vehicle No</label>
                                            <select class="form-control me-2" name="vehicle_no" id="">
                                                <option value="">Select Vehicle</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{$vehicle->vehicle_no }}">{{ $vehicle->vehicle_no }}</option>
                                                @endforeach
                                            </select>
                                            <label for="" class="me-2">Customer</label>
                                            <select class="form-control me-2" name="customer_id" id="">
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id }}">{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="" class="ms-2 me-2">From Date</label>
                                            <input type="date" id="start_date"  max="{{ \Carbon\Carbon::now()->toDateString() }}" name="start_date" class="form-control">
                                            <label for="" class="ms-2 me-2">To Date</label>
                                            <input type="date" id="end_date" max="{{ \Carbon\Carbon::now()->toDateString() }}"  name="end_date" class="form-control">
                                            <button type="submit" class=" me-2 ms-2 btn btn-primary">Search</button>
                                             <button type="reset" class=" me-2 ms-2 btn btn-primary">Clear fliter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                        <hr>
                      <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Driver Name</th>
                              <th>Customer Name</th>
                              <th>Vehicle No</th>
                              <th>fillling Date</th>
                              <th>Quantity</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($fuelFillings as $item)
                            <tr>
                              <td>{{$item->id }}</td>
                              <td>{{$item->driver_name }}</td>
                              <td>{{$item->customer_name }}</td>
                              <td>{{$item->vehicle_no }}</td>
                              <td>{{$item->filling_date }}</td>
                              <td>{{$item->quantity }}</td>
                              <td>
                                @can('fuel-filling-show')
                                <a href="{{ route('admin.fuel_filling.show', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-eye">
                                </i></a>
                                @endcan
                                @can('fuel-filling-edit')
                                <a href="{{ route('admin.fuel_filling.edit', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-edit">
                                </i></a>
                                @endcan
                                @can('fuel-filling-delete')
                                <button  onclick="deletevehicle_info({{ $item->id }})" class="btn btn-link btn-danger">
                                  <i class="fa fa-trash">
                                </i>
                                </button>
                                @endcan
                              </td>
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
     <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ Session::get('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function deletevehicle_info(id) {
        var url = '{{ route("admin.fuel_filling.destroy", "id") }}'.replace("id", id);

        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response) {
                            Swal.fire(
                                'Deleted!',
                                'Your Record has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete record.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'An error occurred: ' + xhr.responseText,
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>

@endsection



