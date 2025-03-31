@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
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
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('admin.credits.index') }}">Credits</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Credits</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Credit Note</div>
                        </div>
                        <form method="POST" action="{{ route('admin.credits.update', $credits->id) }}" id="creditForm">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-red-500">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="customer_id">Customer<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="customer_name"
                                                id="customer_name" value="{{ $credits->customer_name }} GST:{{ $credits->customer_gst }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="invoice_id">Invoice No<span style="color: red">*</span></label>
                                           <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ $credits->invoice_no }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="credit_number">Credit no<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="credit_number"
                                                id="credit_number" value="{{ $credits->credit_number }}" readonly required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="credit_date">Credit Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" readonly value="{{ $credits->credit_date }}" name="credit_date" id="credit_date"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="vehicle-table" class="display table table-striped-rows table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>SR No</th>
                                                        <th>Item</th>
                                                        <th>HSN/SAC</th>
                                                        <th>Quantity</th>
                                                        <th>Rate</th>
                                                        <th>Unit</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle-body">
                                                    @foreach ($credits_items as $key => $ci)
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <input type="hidden" name="credit_item_id[]" value="{{ $ci->id }}">
                                                            <input type="text" class="form-control" name="item[]"
                                                                required value="{{ $ci->item }}" /></td>
                                                        <td><input type="text" class="form-control" name="hsn_sac[]"
                                                                required value="{{ $ci->hsn_sac }}" /></td>
                                                        <td><input type="number" class="form-control quantity"
                                                                name="quantity[]" value="{{ $ci->quantity }}" /></td>
                                                        <td><input type="number" class="form-control rate"
                                                                name="rate[]" value="{{ $ci->rate }}" /></td>
                                                        <td><input type="text" class="form-control" name="unit[]" value="{{ $ci->unit }}" />
                                                        </td>
                                                        <td><input type="number" class="form-control amount" readonly
                                                            value="{{ $ci->amount }}"
                                                                name="amount[]" /></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary add-row"><i
                                                                    class="fa fa-plus"></i></button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="subtotal_amount">Sub Total <span style="color: red">*</span></label>
                                            <input type="number" readonly value="{{ $credits->subtotal_amount }}"  class="form-control" name="subtotal_amount"
                                                id="subtotal_amount" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tax_type">Tax Type<span style="color: red">*</span></label>
                                            <select name="tax_type" id="tax_type" class="form-control" required>
                                                <option value="">Select Tax Type</option>
                                                <option {{ $credits->tax_type == 'cgst/sgst' ? "selected" : "" }} value="cgst/sgst">CGST/SGST</option>
                                                <option {{ $credits->tax_type == 'igst' ? "selected" : "" }} value="igst">IGST</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tax">Tax<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" value="{{ $credits->tax }}" name="tax" id="tax"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tax_amount">Tax Amount<span style="color: red">*</span></label>
                                            <input type="number" readonly class="form-control" value="{{ $credits->tax_amount }}" name="tax_amount"
                                                id="tax_amount" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="total_amount">Total Amount<span
                                                    style="color: red">*</span></label>
                                            <input type="number" readonly class="form-control" value="{{ $credits->total_amount }}" name="total_amount"
                                                id="total_amount" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#customer_id').on('change', function() {
                let customerId = $(this).val();
                if (customerId) {
                    $.ajax({
                        url: "{{ route('fetch.invoices', ':id') }}".replace(':id', customerId),
                        type: 'GET',
                        success: function(response) {
                            $('#invoice_id').empty().append(
                                '<option value="">Select Invoice</option>');

                            if (response.length > 0) {
                                response.forEach(function(invoice) {
                                    $('#invoice_id').append(
                                        `<option value="${invoice.id}">${invoice.invoice_no}</option>`
                                    );
                                });
                            } else {
                                $('#invoice_id').append(
                                    '<option value="">No invoices found</option>');
                            }
                        },
                        error: function() {
                            alert('Error fetching invoices. Please try again.');
                        }
                    });
                } else {
                    $('#invoice_id').empty().append('<option value="">Select Contract</option>');
                }
            });

            function updateSerialNumbers() {
                $('#vehicle-body tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }

            function calculateSubtotal() {
                let subtotal = 0;
                $('.amount').each(function() {
                    subtotal += parseFloat($(this).val()) || 0;
                });
                $('#subtotal_amount').val(subtotal.toFixed(2));
                calculateTotal();
            }

            function calculateTotal() {
                let subtotal = parseFloat($('#subtotal_amount').val()) || 0;
                let taxPercent = parseFloat($('#tax').val()) || 0;
                let taxAmount = (subtotal * taxPercent) / 100;
                $('#tax_amount').val(taxAmount.toFixed(2));

                let totalAmount = subtotal + taxAmount;
                $('#total_amount').val(totalAmount.toFixed(2));
            }

            $(document).on('input', '.quantity, .rate', function() {
                let row = $(this).closest('tr');
                let quantity = parseFloat(row.find('.quantity').val()) || 0;
                let rate = parseFloat(row.find('.rate').val()) || 0;
                let amount = quantity * rate;
                row.find('.amount').val(amount.toFixed(2));
                calculateSubtotal();
            });

            $('.add-row').on('click', function() {
                let newRow = `<tr>
                    <td></td>
                    <td><input type="text" class="form-control" name="item[]" required /></td>
                    <td><input type="text" class="form-control" name="hsn_sac[]" required /></td>
                    <td><input type="number" class="form-control quantity" name="quantity[]"  /></td>
                    <td><input type="number" class="form-control rate" name="rate[]"  /></td>
                    <td><input type="text" class="form-control" name="unit[]"  /></td>
                    <td><input type="number" class="form-control amount" readonly name="amount[]"  /></td>
                    <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-trash"></i></button></td>
                </tr>`;
                $('#vehicle-body').append(newRow);
                updateSerialNumbers();


                $('#vehicle-body tr:last input').each(function() {
                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: "This field is required."
                        }
                    });
                });
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                updateSerialNumbers();
                calculateSubtotal();
            });

            $(document).on('input', '#tax', function() {
                calculateTotal();
            });

            $("#creditForm").validate({
                rules: {
                    customer_id: {
                        required: true
                    },
                    invoice_id: {
                        required: true
                    },
                    credit_number: {
                        required: true
                    },
                    credit_date: {
                        required: true,
                        date: true
                    },
                    "item[]": {
                        required: true
                    },
                    "hsn_sac[]": {
                        required: true
                    },
                    "quantity[]": {

                        number: true,
                        min: 1
                    },
                    "rate[]": {
                        number: true,
                        min: 0.01
                    },
                    subtotal_amount: {
                        number: true
                    },
                    tax_type: {
                        required: true
                    },
                    tax: {
                        number: true,
                        min: 0
                    },
                    total_amount: {
                        number: true
                    }
                },
                messages: {
                    customer_id: {
                        required: "Customer selection is required."
                    },
                    invoice_id: {
                        required: "Invoice selection is required."
                    },
                    credit_number: {
                        required: "Credit number is required."
                    },
                    credit_date: {
                        required: "Invoice date is required.",
                        date: "Please enter a valid date."
                    },
                    "item[]": {
                        required: "Item name is required."
                    },
                    "hsn_sac[]": {
                        required: "HSN/SAC code is required."
                    },
                    "quantity[]": {
                        required: "Quantity is required.",
                        number: "Please enter a valid number.",
                        min: "Quantity must be at least 1."
                    },
                    "rate[]": {
                        required: "Rate is required.",
                        number: "Please enter a valid number.",
                        min: "Rate must be at least 0.01."
                    },
                    tax_type: {
                        required: "Tax type is required."
                    },
                    tax: {
                        number: "Please enter a valid number.",
                        min: "Tax cannot be negative."
                    },
                },
                errorClass: "text-danger",
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });



        });
    </script>
@endsection
