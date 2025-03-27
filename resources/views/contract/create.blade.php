@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
@endif

@section('content-page')
{{-- <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css')}}" /> --}}
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Contract</h3>
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
                        <a href="{{ route('admin.contract.index') }}">Contract</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Contract</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Contract</div>
                        </div>
                        <form method="POST" action="{{ route('admin.contract.store') }}" id="vehicleForm">
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
                                            <label for="contract_no">Contract No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="contract_no" id="contract_no"
                                                placeholder="Enter Contract Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract_date">Contract Date<span
                                                    style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="contract_date"
                                                id="contract_date" placeholder="Enter Contract Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h5>Journey Date</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date">From<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="start_date"
                                                id="start_date" placeholder="Enter Contract Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="journey_date_from">To<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="end_date"
                                                id="end_date" placeholder="Enter Contract Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="vehicle-table" class="display table table-striped-rows table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Vehicle No</th>
                                                        <th>Bus Type</th>
                                                        <th>Min KM</th>
                                                        <th>Rate</th>
                                                        <th>Extra Km Rate</th>
                                                        <th>OT Rate</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle-body">
                                                    <tr class="vehicle-row">
                                                        <td>
                                                            <select class="form-control"
                                                                name="vehicle_id[]" required>
                                                                <option value="">Select Vehicle</option>
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->id }}">
                                                                        {{ $vehicle->vehicle_no }}</option>
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
                                                        <td><input type="number" name="min_km[]" class="form-control"
                                                                required></td>
                                                        <td><input type="text" name="rate[]" class="form-control rate"
                                                                required></td>
                                                        <td><input type="text" name="extra_km_rate[]"
                                                                class="form-control extra-km-rate" required></td>
                                                        <td><input type="text" name="rate_per_hour[]"
                                                                class="form-control extra-km-amount" required></td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-success add-vehicle">+</button>
                                                            <button type="button"
                                                                class="btn btn-danger remove-vehicle d-none">−</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
        $(document).ready(function () {
            // Custom method to check duplicate vehicle selection
            $.validator.addMethod("uniqueVehicle", function (value, element) {
                var selectedVehicles = [];
                var isValid = true;

                $("select[name='vehicle_id[]']").each(function () {
                    var vehicleVal = $(this).val();
                    if (vehicleVal !== "") {
                        if (selectedVehicles.includes(vehicleVal)) {
                            isValid = false;
                        } else {
                            selectedVehicles.push(vehicleVal);
                        }
                    }
                });

                return isValid;
            });

            // Custom validator for date comparison
            $.validator.addMethod("greaterThan", function (value, element, param) {
                var startDate = $(param).val();
                return Date.parse(value) > Date.parse(startDate);
            }, "End date must be after start date");

            // Validate form
            $("#vehicleForm").validate({
                rules: {
                    customer_id: {
                        required: true
                    },
                    contract_no: {
                        required: true
                    },
                    contract_date: {
                        required: true,
                        date: true
                    },
                    start_date: {
                        required: true,
                        date: true
                    },
                    end_date: {
                        required: true,
                        date: true,
                        greaterThan: "#start_date"
                    },
                    "vehicle_id[]": {
                        required: true,
                        uniqueVehicle: true
                    },
                    "type[]": {
                        required: true
                    },
                    "min_km[]": {
                        required: true,
                        number: true,
                        min: 1
                    },
                    "rate[]": {
                        required: true,
                        number: true,
                        min: 0
                    },
                    "extra_km_rate[]": {
                        required: true,
                        number: true,
                        min: 0
                    },
                    "rate_per_hour[]": {
                        required: true,
                        number: true,
                        min: 0
                    }
                },
                messages: {
                    customer_id: {
                        required: "Please select a customer"
                    },
                    contract_no: {
                        required: "Please enter contract number"
                    },
                    contract_date: {
                        required: "Please select a valid contract date"
                    },
                    start_date: {
                        required: "Please select a journey start date"},
                    end_date: {
                        required: "Please select a journey end date",
                        greaterThan: "End date must be after start date"
                    },
                    "vehicle_id[]": {
                        required: "Please select a vehicle",
                        uniqueVehicle: "Duplicate vehicle selection is not allowed"
                    },
                    "type[]": {
                        required: "Please select a bus type"
                    },
                    "min_km[]": {
                        required: "Please enter minimum km",
                        number: "Please enter a valid number",
                        min: "Value must be greater than 0"
                    },
                    "rate[]": {
                        required: "Please enter rate",
                        number: "Please enter a valid number",
                        min: "Value must be 0 or greater"
                    },
                    "extra_km_rate[]": {
                        required: "Please enter extra km rate",
                        number: "Please enter a valid number",
                        min: "Value must be 0 or greater"
                    },
                    "rate_per_hour[]": {
                        required: "Please enter overtime rate",
                        number: "Please enter a valid number",
                        min: "Value must be 0 or greater"
                    }
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("text-danger small");
                    if (element.closest("td").length) {
                        element.closest("td").append(error); // Place error inside the table cell
                    } else {
                        element.closest(".form-group").append(error);
                    }
                },
                highlight: function (element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid");
                }
            });


        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("change", "select[name='vehicle_id[]']", function() {
                var vehicleId = $(this).val();
                var startDate = $("#start_date").val();
                var endDate = $("#end_date").val();
                var currentRow = $(this).closest("tr");

                if (vehicleId && startDate && endDate) {
                    $.ajax({
                        url: "{{ route('admin.contract.checkVehicle') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            vehicle_id: vehicleId,
                            start_date: startDate,
                            end_date: endDate
                        },
                        success: function(response) {
                            currentRow.find(".error-message").remove();
                            currentRow.append('<span class="text-success">✔ ' + response.message + '</span>');
                        },
                        error: function(xhr) {
                            currentRow.find(".error-message").remove();
                            currentRow.append('<span class="text-danger error-message">❌ ' + xhr.responseJSON.message + '</span>');
                            currentRow.find("select[name='vehicle_id[]']").val(""); // Reset selection
                        }
                    });
                }
            });
        });
        </script>
@endsection
