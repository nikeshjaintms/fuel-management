@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
@endif

@section('content-page')
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css')}}" /> --}}
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quotation</h3>
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
                        <a href="{{ route('admin.quotations.index') }}">Quotation</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Quotation</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Quotation</div>
                        </div>
                        <form method="POST" action="{{ route('admin.quotations.update', $data->id) }}" id="vehicleForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="driver_name">Customer<span style="color: red">*</span></label>
                                            <input type="text" name="" id=""
                                                value="{{ $data->customer_name . ' GST:' . $data->customer_gst }}" readonly
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quotation_date">Quotation Date<span
                                                    style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="quotation_date"
                                                value="{{ $data->quotation_date }}" readonly id="quotation_date"
                                                placeholder="Enter Quotation Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="vehicle-table" class="display table table-striped-rows table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Type of Vehicle</th>
                                                        <th>KM</th>
                                                        <th>Rate</th>
                                                        <th>Extra Km Rate</th>
                                                        <th>OT Rate</th>
                                                        <th>Average</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle-body">
                                                    @foreach ($quotation_items as $key => $item)
                                                        <tr class="vehicle-row">
                                                            <input type="hidden" name="item_id[]"
                                                                value="{{ $item->id }}">

                                                            <td>
                                                                <input type="text" name="type_of_vehicle[]"
                                                                    value="{{ $item->type_of_vehicle }}"
                                                                    class="form-control rate" required>
                                                            </td>
                                                            </td>
                                                            <td><input type="number" name="km[]" class="form-control"
                                                                    value="{{ $item->km }}" required></td>
                                                            <td><input type="text" name="rate[]"
                                                                    class="form-control rate" value="{{ $item->rate }}"
                                                                    required></td>
                                                            <td><input type="text" name="extra_km_rate[]"
                                                                    value="{{ $item->extra_km_rate }}"
                                                                    class="form-control extra-km-rate" required></td>
                                                            <td><input type="text" name="over_time_rate[]"
                                                                    value="{{ $item->over_time_rate }}"
                                                                    class="form-control average" required></td>
                                                            <td><input type="text" name="average[]"
                                                                    value="{{ $item->average }}"
                                                                    class="form-control average" required></td>
                                                            <td>
                                                                @if ($key == 0)
                                                                    <button type="button"
                                                                        class="btn btn-success add-vehicle">+</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-vehicle d-none">−</button>
                                                                @else
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-vehicle">−</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_amount">GST Charge<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" value="{{ $data->gst_charge }}"
                                                name="gst_charge" id="gst_charge" placeholder="18" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_amount">Price Variation<span
                                                    style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="price_variation"
                                                value="{{ $data->price_variation }}" id="price_variation"
                                                placeholder="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_amount">Present Fuel Rate<span
                                                    style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="present_fuel_rate"
                                                value="{{ $data->present_fuel_rate }}" id="present_fuel_rate"
                                                placeholder="0" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-action">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <a href="{{ route('admin.quotations.index') }}" class="btn btn-danger">Cancel</a>
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
    {{-- <script src="{{ asset('backend/assets/js/select2.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {

            $(document).on("click", ".add-vehicle", function() {
                var row = $(".vehicle-row:first").clone(); // Clone the first row
                row.find("input").val(""); // Clear input values


                // Remove "+" button from the cloned row
                row.find(".add-vehicle").remove();

                // Show remove button in the new row
                row.find(".remove-vehicle").removeClass("d-none");

                $("#vehicle-body").append(row); // Append the new row
            });

            // Remove row
            $(document).on("click", ".remove-vehicle", function() {
                $(this).closest(".vehicle-row").remove();
            });


        });
    </script>
    <script>
        $(document).ready(function() {

            // Custom validator for date comparison
            $.validator.addMethod("greaterThan", function(value, element, param) {
                var startDate = $(param).val();
                return Date.parse(value) > Date.parse(startDate);
            }, "End date must be after start date");

            // Validate form

            $('#vehicleForm').validate({

                rules: {
                    customer_id: {
                        required: true
                    },
                    quotation_date: {
                        required: true,
                        date: true
                    },
                    "type_of_vehicle[]": {
                        required: true
                    },
                    "km[]": {
                        required: true,
                        number: true,
                        min: 1
                    },
                    "rate[]": {
                        required: true,
                        number: true
                    },
                    "extra_km_rate[]": {
                        required: true,
                        number: true
                    },
                    "over_time_rate[]": {
                        required: true,
                        number: true
                    },
                    gst_charge: {
                        required: true,
                        number: true
                    },
                    price_variation: {
                        required: true,
                        number: true
                    },
                    present_fuel_rate: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    customer_id: {
                        required: "Please select a valid customer"
                    },
                    quotation_date: {
                        required: "Please enter a valid quotation date",
                        date: "Please enter a valid date format"
                    },
                    "type_of_vehicle[]": {
                        required: "Enter vehicle type"
                    },
                    "km[]": {
                        required: "Enter a valid KM",
                        number: "KM must be a number",
                        min: "KM must be at least 1"
                    },
                    "rate[]": {
                        required: "Enter a valid rate",
                        number: "Rate must be a number"
                    },
                    "extra_km_rate[]": {
                        required: "Enter a valid extra km rate",
                        number: "Extra KM rate must be a number"
                    },
                    "over_time_rate[]": {
                        required: "Enter a valid OT rate",
                        number: "OT rate must be a number"
                    },
                    gst_charge: {
                        required: "Enter a valid GST charge",
                        number: "GST charge must be a number"
                    },
                    price_variation: {
                        required: "Enter a valid price variation",
                        number: "Price variation must be a number"
                    },
                    present_fuel_rate: {
                        required: "Enter a valid fuel rate",
                        number: "Fuel rate must be a number"
                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('text-danger');
                    if (element.closest('td').length) {
                        element.closest('td').append(error);
                    } else {
                        element.closest('.form-group').append(error);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

@endsection
