@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Maintenance Information</h3>
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
                        <a href="{{ route('admin.driver.index') }}">Maintenance Information</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add Maintenance Information</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Maintenance Information</div>
                        </div>
                        <form method="POST" action="{{ route('admin.driver.store') }}" id="vehicleForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="driver_name">Vendor<span style="color: red">*</span></label>
                                            <select name="driver_name" id="driver_name" class="form-control" required>
                                                <option value="">Select Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_number">Vehicle Number<span
                                                    style="color: red">*</span></label>
                                            <select name="vehicle_id" id="vehicle_id" class="form-control">
                                                <option value="">Select Vehicle Number</option>
                                                @foreach ($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="maintenance_date">Maintenance Date<span
                                                    style="color: red">*</span></label>
                                            <input type="date" id="maintenance_date" name="maintenance_date"
                                                class="form-control datepicker" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_no">Invoice No<span style="color: red">*</span></label>
                                            <input type="text" id="invoice_no" name="invoice_no" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date<span style="color: red">*</span></label>
                                            <input type="date" id="invoice_date" name="invoice_date"
                                                class="form-control datepicker" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="supervisor_name">Supervisor_name<span
                                                    style="color: red">*</span></label>
                                            <input type="text" id="supervisor_name" name="supervisor_name"
                                                class="form-control" required placeholder="Enter a Supervisor Name">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <table id="basic-datatables" class="display table table-striped table-hover">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>HSN</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Cost</th>
                                                <th>Discount</th>
                                                <th>SubTotal</th>
                                                <th>Tax</th>
                                                <th>Tax Amount</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                            <tbody id="product-list">
                                                <tr>
                                                    <td>
                                                        <input type="text" id="product_name" name="product_name[]"
                                                            class="form-control" required >
                                                    </td>
                                                    <td>
                                                        <input type="text" id="hsn" name="hsn[]"
                                                            class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="description" name="description[]"
                                                            class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="unit" name="unit[]"
                                                            class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="quantity" name="quantity[]"
                                                            class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="cost" name="cost[]"
                                                            class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="discount" name="discount[]"
                                                            placeholder="0.00" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="amount_without_tax"
                                                            name="amount_without_tax[]" placeholder="0.00"
                                                            class="form-control" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="tax" name="tax[]"
                                                            placeholder="0.00" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="tax_amount" name="tax_amount[]"
                                                            placeholder="0.00" class="form-control" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="amount" name="amount[]"
                                                            value="0.00" readonly class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-primary add-product">+</button>
                                                    </td>
                                                </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="subtotal">Subtotal  Amount<span
                                                    style="color: red">*</span></label>
                                            <input type="text" id="subtotal" name="subtotal"
                                                value="0.00" readonly class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mdiscount">Discount<span
                                                    style="color: red">*</span></label>
                                            <input type="text" id="mdiscount" name="mdiscount"
                                                value="0.00"  class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mtax">Tax<span
                                                    style="color: red">*</span></label>
                                            <input type="text" id="mtax" name="mtax"
                                                value="0.00"  class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mtax_amount">Tax_amount<span
                                                    style="color: red">*</span></label>
                                            <input type="text" id="mtax_amount" name="mtax_amount"
                                                value="0.00" readonly class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_bill_amount">Total Amount<span
                                                    style="color: red">*</span></label>
                                            <input type="text" id="total_bill_amount" name="total_bill_amount"
                                                value="0.00" readonly class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_tax">Status<span style="color: red">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="pending">Pending</option>
                                                <option value="paid">Paid</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="card-action">
                                        <button class="btn btn-success" type="submit">Submit</button>
                                        <a href="{{ route('admin.customer_info.index') }}"
                                            class="btn btn-danger">Cancel</a>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // Function to calculate total cost for each row
            function calculateAmounts(row) {
                let quantity = parseFloat($(row).find("input[name='quantity[]']").val()) || 0;
                let cost = parseFloat($(row).find("input[name='cost[]']").val()) || 0;
                let discount = parseFloat($(row).find("input[name='discount[]']").val()) || 0;
                let tax = parseFloat($(row).find("input[name='tax[]']").val()) || 0;

                // Calculate Subtotal
                let subtotal = quantity * cost;

                // Apply discount if any (percentage-based)
                if (discount > 0) {
                    subtotal -= (subtotal * discount) / 100;
                }

                // Calculate Tax Amount
                let tax_amount = (subtotal * tax) / 100;

                // Calculate Total Amount
                let total_amount = subtotal + tax_amount;

                // Set values in respective fields
                $(row).find("input[name='amount_without_tax[]']").val(subtotal.toFixed(2));
                $(row).find("input[name='tax_amount[]']").val(tax_amount.toFixed(2));
                $(row).find("input[name='amount[]']").val(total_amount.toFixed(2));
            }

            function calculateTotalBill() {
                let totalBill = 0;
                $("input[name='amount[]']").each(function() {
                    totalBill += parseFloat($(this).val()) || 0;
                });
                $("#subtotal").val(totalBill.toFixed(2));
            }

            $(document).on("input",
                "input[name='quantity[]'], input[name='cost[]'], input[name='discount[]'], input[name='tax[]']",
                function() {
                    let row = $(this).closest("tr");
                    calculateAmounts(row);
                    calculateTotalBill();
                });

            // Add new row dynamically
            $(document).on('click', '.add-product', function() {
                let newRow = `
            <tr>
                <td><input type="text" name="product_name[]" class="form-control" required></td>
                <td><input type="text" name="hsn[]" class="form-control" required></td>
                <td><input type="text" name="description[]" class="form-control" required></td>
                <td><input type="text" name="unit[]" class="form-control" required></td>
                <td><input type="number" name="quantity[]" class="form-control" required></td>
                <td><input type="number" name="cost[]" class="form-control" required></td>
                <td><input type="number" name="discount[]" placeholder="0.00" class="form-control"></td>
                <td><input type="text" name="amount_without_tax[]" placeholder="0.00" class="form-control" readonly></td>
                <td><input type="number" name="tax[]" placeholder="0.00" class="form-control"></td>
                <td><input type="text" name="tax_amount[]" placeholder="0.00" class="form-control" readonly></td>
                <td><input type="text" name="amount[]" value="0.00" readonly class="form-control"></td>
                <td><button type="button" class="btn btn-danger remove-product">-</button></td>
            </tr>`;
                $("#product-list").append(newRow);
            });

            // Remove row dynamically
            $(document).on('click', '.remove-product', function() {
                $(this).closest('tr').remove();
            });


            $("#vehicleForm").validate({
                rules: {
                    driver_name: {
                        required: true
                    },
                    vehicle_id: {
                        required: true
                    },
                    maintenance_date: {
                        required: true,
                        date: true
                    },
                    invoice_no: {
                        required: true
                    },
                    invoice_date: {
                        required: true,
                        date: true
                    },
                    supervisor_name: {
                        required: true,
                        minlength: 2,

                    },
                    "product_name[]": {
                        required: true

                    },
                    "hsn[]": {
                        required: true
                    },
                    "description[]": {
                        required: true
                    },
                    "unit[]": {
                        required: true
                    },
                    "quantity[]": {
                        required: true,
                        min: 1,
                        digits: true
                    },
                    "cost[]": {
                        required: true,
                        min: 1,
                        number: true
                    },
                    "discount[]": {
                        min: 0,
                        max: 100,
                        number: true
                    },
                    "tax[]": {
                        min: 0,
                        max: 100,
                        number: true
                    }
                },
                messages: {
                    driver_name: {
                        required: "Please select a vendor"
                    },
                    vehicle_id: {
                        required: "Please select a vehicle"
                    },
                    maintenance_date: {
                        required: "Please enter a valid maintenance date"
                    },
                    invoice_no: {
                        required: "Invoice number is required"
                    },
                    invoice_date: {
                        required: "Please enter a valid invoice date"
                    },
                    supervisor_name: {
                        required: "Supervisor name is required",
                        minlength: "Supervisor name must be at least 2 characters long"
                    },
                    "product_name[]": {
                        required: "Enter product name"
                    },
                    "hsn[]": {
                        required: "Enter HSN code"
                    },
                    "description[]": {
                        required: "Enter product description"
                    },
                    "unit[]": {
                        required: "Enter unit (e.g., NOS, KG)"
                    },
                    "quantity[]": {
                        required: "Enter quantity",
                        min: "Quantity must be at least 1",
                        digits: "Only whole numbers allowed"
                    },
                    "cost[]": {
                        required: "Enter cost",
                        min: "Cost must be at least 1",
                        number: "Only numeric values allowed"
                    },
                    "discount[]": {
                        min: "Discount cannot be negative",
                        max: "Discount cannot exceed 100%",
                        number: "Only numbers allowed"
                    },
                    "tax[]": {
                        min: "Tax cannot be negative",
                        max: "Tax cannot exceed 100%",
                        number: "Only numbers allowed"
                    }
                },
                errorClass: "text-danger",
                errorElement: "span",
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
