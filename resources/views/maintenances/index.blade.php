@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif

@section('content-page')

{{-- @if (!empty($alerts))
    <script>
        window.onload = function() {
            let alerts = @json($alerts);
            console.log(alerts);
            alerts.forEach(function(alert) {
                Swal.fire({
                    title: 'Reminder',
                    text: alert,
                    icon: 'info',
                    confirmButtonText: 'Okay'
                });
            });
        };
    </script>
@endif --}}
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Maintenance information</h3>
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
                        <a href="{{ route('admin.driver.index')}}">Maintenance Information</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">List of Maintenance Information</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.maintenance.create') }}" class=" float-end btn btn-sm btn-rounded btn-primary"><i class="fas fa-plus"></i> Maintenance Information</a>
                      <h4 class="card-title">Add Maintenance Information</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Vehicle</th>
                              <th>Vendor Name</th>
                              <th>Total Bill Amount</th>
                              <th>Status</th>
                            <th>Action</th>

                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($maintenances as $item)
                            <tr>
                              <td>{{$item->id }}</td>
                              <td>{{$item->vehicle_no }}</td>
                              <td>{{$item->vendor_name }}</td>
                              <td>{{$item->total_bill_amount }}</td>
                              <td>
                                @if($item->status != 'paid')
                                <span class="badge badge-danger">Not Paid</span>
                                @else
                                <span class="badge badge-success">Paid</span>
                                @endif
                              </td>
                              <td>
                                <a href="{{ route('admin.maintenance.show', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-eye">
                                </i></a>
                                <a href="{{ route('admin.maintenance.edit', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-edit">
                                </i></a>
                                <button  onclick="deletevehicle_info({{ $item->id }})" class="btn btn-link btn-danger">
                                  <i class="fa fa-trash">
                                </i>
                                </button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function deletevehicle_info(id) {
        var url = '{{ route("admin.maintenance.destroy", "id") }}'.replace("id", id);

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
                                'Maintenances Information has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete Maintenances Information.',
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



