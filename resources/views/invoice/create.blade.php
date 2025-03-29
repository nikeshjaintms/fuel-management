@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
@endif

@section('content-page')
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css')}}" /> --}}
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
                        <a href="{{ route('admin.contract.index') }}">Invoice</a>
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
                            <div class="card-title">Add Invoice</div>
                        </div>
                        <form method="POST" action="{{ route('admin.invoice.store') }}" id="vehicleForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
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
                                            <select class="form-control" name="contract_id" id="contract_id">
                                                <option value="">Select Contract</option>
                                            </select>
                                            <div id="contract-message" style="display: none; color: red; margin-top: 5px;"></div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_no">Invoice NO<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                                                placeholder="Enter Invoice" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="invoice_date" id="invoice_date"
                                                placeholder="Enter Contract Date" required />
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
                                            <h5>Journey Route</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="from_point">From Pickup Point <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="from_point"
                                                id="from_point" placeholder="Enter Contract Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to_point">To Drop Point<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="to_point"
                                                id="to_point" placeholder="Enter Contract Date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="vehicle-table" class="display table table-striped-rows table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Vehicle No</th>
                                                        <th>Min KM</th>
                                                        <th>Rate</th>
                                                        <th>Extra Km Rate</th>
                                                        <th>Extra Km Drive</th>
                                                        <th>Total Drive</th>
                                                        <th>Extra km Amount</th>
                                                        <th>OT Rate</th>
                                                        <th>OT</th>
                                                        <th>OT Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle-body">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Total KM</label>
                                            <input type="text" readonly name="total_km" id="total_km"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Diesel differenes rate</label>
                                            <input type="text" name="diesel_diff_rate" id="diesel_diff_rate"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Diesel COST</label>
                                            <input type="text" readonly name="diesel_cost" id="diesel_cost"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Subtotal</label>
                                            <input type="text" readonly name="grand_subtotal" id="grand_subtotal"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">GST Type</label>
                                            <select class="form-control" name="tax_type" required>
                                                <option value="">Select GST Type</option>
                                                <option value="cgst/sgst">CGST/SGST</option>
                                                <option value="igst">IGST</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">TAX</label>
                                            <input type="text" name="tax" id="tax" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Tax Amount</label>
                                            <input type="text" name="tax_amount" id="tax_amount" readonly
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Total Amount</label>
                                            <input type="text" readonly name="total_amount" id="total_amount"
                                                class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success" id="submit-button" type="submit">Submit</button>
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
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}" // Set CSRF token globally
                }
            });
            $('select[name="contract_id"]').change(function() {
                var contractId = $(this).val();
                var messageDiv = $("#contract-message"); // Div to show the message
                var submitBtn = $("#submit-button");

                messageDiv.text("").hide(); // Clear message initially
                submitBtn.prop("disabled", false); // Enable button by default

                if (contractId) {
                    $.ajax({
                        url: "{{ route('admin.invoice.checkContract') }}",
                        type: "POST",
                        data: {
                            contract_id: contractId
                        },
                        success: function(response) {
                            if (response.exists) {
                                messageDiv.text(
                                    "This contract is already linked to an invoice.").css(
                                    "color", "red").show();
                                $('select[name="contract_id"]').val('');
                                submitBtn.prop("disabled", true);
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#customer_id').on('change', function() {
                var customerId = $(this).val(); // Get selected customer ID

                if (customerId) {
                    $.ajax({
                        url: "{{ route('admin.getContracts') }}", // Route to fetch contracts
                        type: "GET",
                        data: {
                            customer_id: customerId
                        }, // Send customer ID
                        success: function(response) {
                            var contractDropdown = $('select[name="contract_id"]');
                            contractDropdown.empty();
                            contractDropdown.append(
                                '<option value="">Select Contract</option>');

                            if (response.length > 0) {
                                $.each(response, function(key, contract) {
                                    contractDropdown.append('<option value="' + contract
                                        .id + '">' + contract.contract_no +
                                        '</option>');
                                });
                            } else {
                                contractDropdown.append(
                                    '<option value="">No Contracts Found</option>');
                            }
                        }
                    });
                } else {
                    $('select[name="contract_id"]').html('<option value="">Select Contract</option>');
                }
            });
            $('select[name="contract_id"]').on('change', function() {
                var contractId = $(this).val();
                if (contractId) {
                    $.ajax({
                        url: "{{ route('admin.getContractDetails') }}", // Ensure this route is correct
                        type: "GET",
                        data: {
                            contract_id: contractId
                        },
                        success: function(response) {
                            console.log(response); // Log the response for debugging
                            var vehicleBody = $('#vehicle-body');
                            vehicleBody.empty(); // Clear existing rows

                            if (response.vehicles.length > 0) {
                                $.each(response.vehicles, function(index, vehicle) {
                                    var newRow = `<tr class="vehicle-row">
                                        <td>
                                            <select class="form-control" readonly name="vehicle_id[]" required>
                                                <option value="${vehicle.vehicle_id}" selected>${vehicle.vehicle_no}</option>
                                            </select>
                                        </td>
                                        <td><input type="number" readonly name="min_km[]" class="form-control min_km" value="${vehicle.min_km}" ></td>
                                        <td><input type="text" readonly name="rate[]" class="form-control rate" value="${vehicle.rate}" ></td>
                                        <td><input type="text" readonly name="extra_km_rate[]" class="form-control extra-km-rate" value="${vehicle.extra_km_rate}" ></td>
                                        <td><input type="number" readonly name="extra_km_drive[]" class="form-control extra_km_drive" ></td>
                                        <td><input type="number" name="km_drive[]" class="form-control"></td>
                                        <td><input type="number" readonly name="total_extra_km_amount[]" class="form-control total_extra_km_amount" ></td>
                                        <td><input type="text" readonly name="rate_per_hour[]" class="form-control rate_per_hour" value="${vehicle.rate_per_hour}" ></td>
                                        <td><input type="number" name="overtime[]" class="form-control overtime"></td>
                                        <td><input type="number" readonly name="overtime_amount[]" class="form-control overtime_amount" ></td>
                                    </tr>`;
                                    vehicleBody.append(newRow);
                                });
                            } else {
                                vehicleBody.append(
                                    '<tr><td colspan="10" class="text-center">No Vehicles Found</td></tr>'
                                );
                            }

                        }
                    });
                }
            });


            $(document).on("input", "input[name='km_drive[]']", function() {
                var currentRow = $(this).closest("tr");
                var kmDrive = parseFloat($(this).val()) || 0;
                var minKm = parseFloat(currentRow.find("input[name='min_km[]']").val()) || 0;

                if (kmDrive <= minKm) {
                    currentRow.find("input[name='extra_km_drive[]']").val(0);
                } else {
                    var extraKmDrive = kmDrive - minKm;
                    currentRow.find("input[name='extra_km_drive[]']").val(extraKmDrive);
                }
            });

            function updateExtraKmAmount(row) {
                var extraKmDrive = parseFloat(row.find("input[name='extra_km_drive[]']").val()) || 0;
                var extraKmRate = parseFloat(row.find("input[name='extra_km_rate[]']").val()) || 0;

                var extraKmAmount = extraKmDrive * extraKmRate;
                row.find("input[name='total_extra_km_amount[]']").val(extraKmAmount.toFixed(
                    2)); // Set with 2 decimal places
            }

            // Trigger calculation when km_drive or extra_km_rate changes
            $(document).on("input", "input[name='km_drive[]'], input[name='extra_km_rate[]']", function() {
                var currentRow = $(this).closest("tr");
                updateExtraKmAmount(currentRow);
                calculateSubtotal();

            });

            function updateOtAmount(row) {
                var overtime = parseFloat(row.find("input[name='overtime[]']").val()) || 0;
                var ratePerHour = parseFloat(row.find("input[name='rate_per_hour[]']").val()) || 0;

                var otAmount = overtime * ratePerHour;
                row.find("input[name='overtime_amount[]']").val(otAmount.toFixed(2)); // Set with 2 decimal places
            }

            // Trigger calculation when overtime or rate_per_hour changes
            $(document).on("input", "input[name='overtime[]'], input[name='rate_per_hour[]']", function() {
                var currentRow = $(this).closest("tr");
                updateOtAmount(currentRow);
                calculateSubtotal();

            });

            function updateTotalKM() {
                var totalKM = 0;

                $("input[name='km_drive[]']").each(function() {
                    var kmValue = parseFloat($(this).val()) || 0;
                    totalKM += kmValue;
                });

                $("#total_km").val(totalKM);
            }

            // Trigger the function when any "km_drive[]" input changes
            $(document).on("input", "input[name='km_drive[]']", function() {
                updateTotalKM();
                calculateSubtotal();

            });

            function updateDieselCost() {
                var totalKM = parseFloat($("#total_km").val()) || 0;
                var dieselRate = parseFloat($("#diesel_diff_rate").val()) || 0;

                var dieselCost = totalKM * dieselRate;
                $("#diesel_cost").val(dieselCost.toFixed(2)); // Set value with 2 decimal places
            }

            // Trigger function when "diesel_diff_rate" or "total_km" changes
            $(document).on("input", "#diesel_diff_rate, #total_km", function() {
                updateDieselCost();
                calculateSubtotal();
            });


            // Custom validator for date comparison
            function calculateSubtotal() {
                var totalRate = 0,
                    totalExtraKmAmount = 0,
                    totalOtAmount = 0;
                var dieselCost = parseFloat($("#diesel_cost").val()) || 0;

                console.log("Diesel Cost:", dieselCost);

                $(".rate").each(function() {
                    totalRate += parseFloat($(this).val()) || 0;
                });

                $(".total_extra_km_amount").each(function() {
                    totalExtraKmAmount += parseFloat($(this).val()) || 0;
                });

                $(".overtime_amount").each(function() {
                    totalOtAmount += parseFloat($(this).val()) || 0;
                });

                var subtotal = totalRate + totalExtraKmAmount + totalOtAmount - dieselCost;
                console.log("Subtotal:", subtotal);

                var $grandSubtotal = $("#grand_subtotal");
                if ($grandSubtotal.length > 0) {
                    $grandSubtotal.val(subtotal.toFixed(2));
                } else {
                    console.error("Element #grand_subtotal not found!");
                }
            }

            // Event listener for input changes
            $(document).on("keyup", ".rate, .total_extra_km_amount, .overtime_amount, #diesel_cost", function() {
                calculateSubtotal();
            });

            // Initial calculation on page load
            calculateSubtotal();

            function calculateTaxAndTotal() {
                var subtotal = parseFloat($("#grand_subtotal").val()) || 0;
                var taxPercentage = parseFloat($("#tax").val()) || 0;

                var taxAmount = (subtotal * taxPercentage) / 100;
                $("#tax_amount").val(taxAmount.toFixed(2));

                var totalAmount = subtotal + taxAmount;
                $("#total_amount").val(totalAmount.toFixed(2));
            }

            // Trigger calculations when tax input changes
            $(document).on("input", "#tax", function() {
                calculateTaxAndTotal();
            });

            $.validator.addMethod("greaterThan", function(value, element, param) {
                var startDate = $(param).val();
                return Date.parse(value) > Date.parse(startDate);
            }, "End date must be after start date");

            $('#vehicleForm').validate({
                rules: {
                    customer_id: {
                        required: true
                    },
                    contract_id: {
                        required: true
                    },
                    invoice_no: {
                        required: true
                    },
                    invoice_date: {
                        required: true,
                        date: true
                    },
                    start_date: {
                        required: true,
                        date: true,
                    },
                    end_date: {
                        required: true,
                        date: true,
                        greaterThan: "#start_date"
                    },
                    from_point: {
                        required: true
                    },
                    to_point: {
                        required: true
                    },
                    diesel_diff_rate: {
                        required: true,
                        number: true
                    },
                    tax: {
                        required: true,
                        number: true
                    },
                    tax_type: {
                        required: true
                    }
                },
                messages: {
                    customer_id: {
                        required: "Please select a customer."
                    },
                    contract_id: {
                        required: "Please select a contract."
                    },
                    invoice_no: {
                        required: "Please enter an invoice number."
                    },
                    invoice_date: {
                        required: "Please select an invoice date.",
                        date: "Please enter a valid date."
                    },
                    start_date: {
                        required: "Please select a start date.",
                        date: "Please enter a valid date."
                    },
                    end_date: {
                        required: "Please select an end date.",
                        date: "Please enter a valid date.",
                        greaterThan: "End date must be after start date."
                    },
                    from_point: {
                        required: "Please enter a pickup point."
                    },
                    to_point: {
                        required: "Please enter a drop point."
                    },
                    diesel_diff_rate: {
                        required: "Please enter diesel rate.",
                        number: "Please enter a valid diesel rate."
                    },
                    tax: {
                        required: "Please enter tax (in Percentage).",
                        number: "Please enter a valid tax (in Percentage)."
                    },
                    tax_type: {
                        required: "Please select a tax type."
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass("text-danger small");
                    if (element.closest("td").length) {
                        element.closest("td").append(error); // Place error inside the table cell
                    } else {
                        element.closest(".form-group").append(error);
                    }
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                }
            });

            $('#vehicleForm').on('submit', function(e) {
                let isValid = true;

                // Loop through each row
                $('.vehicle-row').each(function() {
                    let kmDrive = $(this).find('input[name="km_drive[]"]');
                    let ot = $(this).find('input[name="overtime[]"]');

                    if (!kmDrive.val() || isNaN(kmDrive.val())) {
                        kmDrive.addClass('is-invalid');
                        kmDrive.after(
                            '<span class="text-danger">Please enter extra KM drive.</span>');
                        isValid = false;
                    } else {
                        kmDrive.removeClass('is-invalid');
                        kmDrive.next('.text-danger').remove();
                    }

                    if (!ot.val() || isNaN(ot.val())) {
                        ot.addClass('is-invalid');
                        ot.after('<span class="text-danger">Please enter OT.</span>');
                        isValid = false;
                    } else {
                        ot.removeClass('is-invalid');
                        ot.next('.text-danger').remove();
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>

@endsection
