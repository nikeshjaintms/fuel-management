@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif

@section('content-page')


    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Loan</h3>
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
                        <a href="{{ route('admin.owner.index')}}">Loan </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">List of Loan </a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                        @can('loan-create')
                        <a href="{{ route('admin.loan.create') }}" class=" float-end btn btn-sm btn-rounded btn-primary"><i class="fas fa-plus"></i> Owner Information</a>
                        @endcan
                        <h4 class="card-title">Loan</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                          <thead>
                            <tr>
                            <th><input type="checkbox" id="select-all"></th>
                              <th>Id</th>
                              <th>Vehicle No</th>
                              <th>Finance By</th>
                              <th>Loan Account</th>
                              <th>Loan Amount</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($loans as $item)
                            <tr>
                              <td><input type="checkbox" name="id[]" value="{{ $item->id }}"></td>
                              <td> {{$item->id }}</td>
                              <td>{{$item->vehicle_no }}</td>
                              <td>{{$item->finance_by }}</td>
                              <td>{{$item->loan_account }}</td>
                              <td>{{$item->loan_amount }}</td>
                              <td>
                                @if($item->status == 'On Going')
                                <div class="badge badge-primary">
                                    {{$item->status }}
                                </div>
                                @else
                                <div class="badge badge-success">
                                    {{$item->status }}
                                </div>
                                @endif
                              </td>
                              <td>
                                @can('loan-show')
                                <a href="{{ route('admin.loan.show', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-eye">
                                </i></a>
                                @endcan
                                @can('loan-edit')
                                <a href="{{ route('admin.loan.edit', $item->id) }}" class="btn btn-lg btn-link btn-primary">
                                  <i class="fa fa-edit">
                                </i></a>
                                @endcan
                                @can('loan-delete')
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
                        <button id="mark-paid" class="btn btn-success btn-sm mt-2 mb-2 ">Mark as Paid</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById("select-all").addEventListener("click", function() {
            let checkboxes = document.querySelectorAll('input[name="id[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#mark-paid").click(function () {
                let selectedIds = [];

                // Collect selected loan IDs
                $('input[name="id[]"]:checked').each(function () {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    Swal.fire("No Selection", "Please select at least one loan.", "warning");
                    return;
                }
                $.ajax({
                    url: '{{ route("admin.loan.updateEmiPaid") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds
                    },
                    success: function (response) {
                        Swal.fire("Updated!", response.message, "success").then(() => {
                            window.location.reload();
                        });
                    },
                    error: function (xhr) {
                        // Parse JSON response
                        let response = JSON.parse(xhr.responseText);

                        // Check for "All selected loans are already paid." message
                        if (response.message === "All selected loans are already paid.") {
                            Swal.fire("No Changes", "Selected loans are already fully paid!", "info");
                        } else {
                            Swal.fire("Error!", "An error occurred while updating EMI payments.", "error");
                        }
                    }
                });
            });
        });
    </script>

<script>
    function deletevehicle_info(id) {
        var url = '{{ route("admin.loan.destroy", "id") }}'.replace("id", id);

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
                                'Loan Deleted Successfully.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete Vehicle Information.',
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



