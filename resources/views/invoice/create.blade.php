@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Invoices</h3>
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
                        <a href="{{ route('admin.invoice.index') }}">Invoices</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Generate Invoice</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Generate Invoice</div>
                        </div>
                        <form method="POST" action="{{ route('admin.invoice.store') }}" id="vehicleForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="driver_name">Customer<span style="color: red">*</span></label>
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}
                                                        GST:{{ $customer->customer_gst }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_no">Invoice No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                                                placeholder="Enter Invoice No" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_no">Invoice Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="invoice_date" id="invoice_date"
                                                placeholder="Enter Invoice Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_no">Contract No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="contract_no" id="contract_no"
                                                placeholder="Enter Invoice Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_date">Contract Date<span
                                                    style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="contract_date"
                                                id="contract_date" placeholder="Enter Invoice Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h5>Journey Date</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="journey_date_from">From<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="journey_date_from"
                                                id="journey_date_from" placeholder="Enter Invoice Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="journey_date_from">To<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="journey_date_from"
                                                id="journey_date_from" placeholder="Enter Invoice Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="vehicle-table" class="display table table-striped-rows table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Vehicle No</th>
                                                        <th>Bus Type</th>
                                                        <th>Rate</th>
                                                        <th>Amount</th>
                                                        <th>Min KM</th>
                                                        <th>Extra Km</th>
                                                        <th>Extra Km Rate</th>
                                                        <th>Extra Km Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle-body">
                                                    <tr class="vehicle-row">
                                                        <td>
                                                            <select name="vehicle_id[]" class="form-control" required>
                                                                <option value="">Select Vehicle</option>
                                                                @foreach($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="type[]" class="form-control" required>
                                                                <option value="">Select Type</option>
                                                                <option value="A.C">A.C</option>
                                                                <option value="Non A/C">Non A/C</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="rate[]" class="form-control rate" required></td>
                                                        <td><input type="text" name="amount[]" class="form-control amount" readonly value="0.00"></td>
                                                        <td><input type="number" name="min_km[]" class="form-control" required></td>
                                                        <td ><input type="number" name="extra_km[]" class="form-control extra-km" required></td>
                                                        <td><input type="text" name="extra_km_rate[]" class="form-control extra-km-rate" required></td>
                                                        <td><input type="text" name="extra_km_amount[]" class="form-control extra-km-amount" readonly value="0.00"></td>
                                                        <td>
                                                            <button type="button" class="btn btn-success add-vehicle">+</button>
                                                            <button type="button" class="btn btn-danger remove-vehicle d-none">−</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Total Km</label>
                                            <input type="text" name="total_km" class="form-control" id="total_km"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Difference Rate</label>
                                            <input type="text" name="difference_rate" class="form-control"
                                                id="difference_rate" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="difference_amount">Difference Amount</label>
                                            <input type="text" name="difference_amount" class="form-control"
                                                id="difference_amount" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="subtotal">Subtotal</label>
                                            <input type="text" name="subtotal" class="form-control" id="subtotal"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tax_type">Select Tax Type:</label>
                                            <select name="tax_type" id="tax_type" class="form-control">
                                                <option value="">Select Tax Type</option>
                                                <option value="cgst_sgst">CGST/SGST</option>
                                                <option value="igst">IGST</option>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="col-md-3"id="cgst_sgst_fields" style="display: none;" >
                                            <div class="form-group">
                                                <label for="">CGST/</label>
                                                <input type="text" name="cgst" class="form-control"
                                                id="cgst" required>
                                            </div>
                                        </div>
                                    <div class="col-md-3" id="igst_field" style="display: none;">
                                        <div class="form-group">
                                            <label>IGST</label><input type="text" name="igst" class="form-control"
                                                            id="igst">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="discount">Total</label>
                                            <input type="text" name="total_amount" class="form-control" id="total_amount" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <a href="{{ route('admin.invoice.index') }}" class="btn btn-danger">Cancel</a>
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
            $("#tax_type").change(function () {
                var selectedTax = $(this).val();
                if (selectedTax === "cgst_sgst") {
                    $("#cgst_sgst_fields").show();
                    $("#igst_field").hide();
                } else if (selectedTax === "igst") {
                    $("#cgst_sgst_fields").hide();
                    $("#igst_field").show();
                }
            });
            $(document).on("click", ".add-vehicle", function () {
            var row = $(".vehicle-row:first").clone(); // Clone the first row
            row.find("input").val(""); // Clear input values
            row.find(".amount, .extra-km-amount").val("0.00"); // Reset calculated fields

            // Remove "+" button from the cloned row
            row.find(".add-vehicle").remove();

            // Show remove button in the new row
            row.find(".remove-vehicle").removeClass("d-none");

            $("#vehicle-body").append(row); // Append the new row
        });

        // Remove row
        $(document).on("click", ".remove-vehicle", function () {
            $(this).closest(".vehicle-row").remove();
        });


        // Auto-calculate extra km amount
        $(document).on("input", ".extra-km, .extra-km-rate", function () {
            var row = $(this).closest(".vehicle-row");
            var extraKm = parseFloat(row.find(".extra-km").val()) || 0;
            var extraKmRate = parseFloat(row.find(".extra-km-rate").val()) || 0;
            var totalExtraAmount = (extraKm * extraKmRate).toFixed(2);
            row.find(".extra-km-amount").val(totalExtraAmount);
        });

        // Auto-calculate total amount
        $(document).on("input", ".rate", function () {
            var row = $(this).closest(".vehicle-row");
            var rate = parseFloat(row.find(".rate").val()) || 0;
            row.find(".amount").val(rate.toFixed(2));
        });

        });
    </script>
@endsection
