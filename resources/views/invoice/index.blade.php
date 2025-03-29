@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
@endif

@section('content-page')


    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Invoice</h3>
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
                        <a href="{{ route('admin.invoice.index') }}">Invoice</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Invoice</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.invoice.create') }}"
                                class=" float-end btn btn-sm btn-rounded btn-primary"><i class="fas fa-plus"></i>
                                Invoice</a>
                            <h4 class="card-title">Invoice</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Client</th>
                                            <th>Invoice No</th>
                                            <th>Contract</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}">
                                                    {{ $item->id }}
                                                </td>
                                                <td>{{ $item->customer_name }}</td>
                                                <td>{{ $item->invoice_no }}</td>
                                                <td>{{ $item->contract_no }}</td>
                                                <td>
                                                    @if ($item->status == 'paid')
                                                        <span
                                                            class="badge badge-success">{{ ucfirst($item->status) }}</span>
                                                    @elseif($item->status == 'cancelled')
                                                        <span class="badge badge-danger">{{ ucfirst($item->status) }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-warning">{{ ucfirst($item->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.invoice.show', $item->id) }}"
                                                        class="btn btn-lg btn-link btn-primary">
                                                        <i class="fa fa-eye">
                                                        </i></a>

                                                    <a href="{{ route('admin.invoice.edit', $item->id) }}"
                                                        class="btn btn-lg btn-link btn-primary">
                                                        <i class="fa fa-edit">
                                                        </i></a>
                                                    @if ($item->status != 'cancelled')
                                                        <button onclick="cancelInvoice({{ $item->id }})"
                                                            class="btn btn-link btn-danger"
                                                            id="cancel-btn-{{ $item->id }}">
                                                            <i class="fa fa-ban"></i>
                                                        </button>
                                                    @endif
                                                    <button onclick="deletevehicle_info({{ $item->id }})"
                                                        class="btn btn-link btn-danger">
                                                        <i class="fa fa-trash">
                                                        </i>
                                                    </button>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button id="mark-paid" class="btn btn-success btn-sm mt-2 mb-2"> <i class="fas fa-money-check-alt"></i> Pay TAX</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    


    <script>
        $(document).ready(function() {
            $("#mark-paid").click(function() {
                let selectedIds = [];

                // Collect selected invoice IDs
                $('input[name="ids[]"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    Swal.fire("No Selection", "Please select at least one invoice.", "warning");
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will mark selected invoices as Paid.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Mark as Paid'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.invoice.bulkUpdateStatus') }}', // Adjust route accordingly
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                invoice_ids: selectedIds
                            },
                            success: function(response) {
                                Swal.fire("Updated!", response.message, "success").then(
                                    () => {
                                        window.location.reload();
                                    });
                            },
                            error: function(xhr) {
                                let response = JSON.parse(xhr.responseText);
                                if (response.message ===
                                    "All selected invoices are already paid.") {
                                    Swal.fire("No Changes",
                                        "Selected invoices are already fully paid!",
                                        "info");
                                } else {
                                    Swal.fire("Error!",
                                        "An error occurred while updating invoices.",
                                        "error");
                                }
                            }
                        });
                    }
                });
            });
        });

        function deletevehicle_info(id) {
            var url = '{{ route('admin.invoice.destroy', 'id') }}'.replace("id", id);

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
                                    'Invoice  has been deleted.',
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to delete Invoice Information.',
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

        function cancelInvoice(id) {
            var url = '{{ route('admin.invoice.cancel', 'id') }}'.replace("id", id);

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to cancel this invoice!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Cancelled!',
                                    'Invoice has been cancelled successfully.',
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });

                                // Update the status in the table
                                $("#status-" + id).html(
                                    '<span class="badge badge-danger">Cancelled</span>');
                                $("#cancel-btn-" + id).remove(); // Remove the cancel button
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to cancel the invoice. Try again.',
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
