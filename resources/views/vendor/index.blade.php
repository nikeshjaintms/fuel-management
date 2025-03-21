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
                        <a href="{{ route('admin.vendor.index')}}">Vendor</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">List of Vendor</a>
                    </li>
                </ul>
            </div>
            {{-- <div class="row">
                <div class="col-md-6">
                <form action="{{ route('admin.vendor.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="d-flex align-items-center">
                        <div class="mb-2">
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary ms-2 mb-2">
                            <i class="fas fa-upload"></i> import
                        </button>
                        <a href="{{ asset('samples/customer.xlsx') }}" download class="ms-3 mb-2 btn btn-info btn-sm ">
                            <i class="fas fa-download"></i> Download Sample
                        </a>

                </form>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                        @can('vendor-create')
                        <a href="{{ route('admin.vendor.create') }}" class=" float-end btn btn-sm btn-rounded btn-primary"><i class="fas fa-plus"></i> Vendor</a>
                        @endcan
                        <h4 class="card-title">Vendor</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Name</th>
                              <th>GST</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($vendors as $item)
                            <tr>
                              <td>{{$item->id }}</td>
                              <td>{{$item->name }}</td>
                              <td>{{$item->vendor_gst }}</td>
                              <td>{{$item->email }}</td>
                              <td>{{$item->phone_number }}</td>
                              <td>
                                @can('vendor-show')
                                <a href="{{ route('admin.vendor.show', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-eye">
                                </i></a>
                                @endcan
                                @can('vendor-edit')
                                <a href="{{ route('admin.vendor.edit', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-edit">
                                </i></a>
                                @endcan
                                @can('vendor-delete')
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function deletevehicle_info(id) {
        var url = '{{ route("admin.vendor.destroy", "id") }}'.replace("id", id);

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
                                'Customer Information has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete Customer Information.',
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



