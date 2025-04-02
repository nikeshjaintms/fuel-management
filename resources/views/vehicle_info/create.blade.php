@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Vehicle Information</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a hreAf="{{ route('index') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.vehicles.index')}}">Vehicle Information</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add Vehicle Information</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Vehicle Information </div>
                        </div>
                        <form method="POST" action="{{ route('admin.vehicles.store') }}" id="vehicleForm" >
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_no">Vehicle No</label>
                                            <input type="text" class="form-control" name="vehicle_no" id="vehicle_no" placeholder="GJ16XX0000 " />
                                            <span id="vehicle_noError" class="text-danger" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_engine_no">Vehicle Engine No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="vehicle_engine_no" id="vehicle_engine_no" placeholder="Enter Vechile no" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_chassis_no">Vehicle Chassis No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="vehicle_chassis_no" id="vehicle_chassis_no" placeholder="Enter Chassic no" required />
                                            <span id="vehicle_chassis_noError" class="text-danger" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="average">Average Claim by Company<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="average" id="average" required placeholder="Enter a Average" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="road_tax_amount">Type of Vehicle<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="type_of_vehicle" id="type_of_vehicle" required placeholder="56 seat Bus..." />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="road_tax_amount">Road Tax Amount<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="road_tax_amount" id="road_tax_amount" required placeholder="Enter a Amount" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.vehicles.index')}}" class="btn btn-danger" >Cancel</a>
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
  $(document).ready(function () {
    $("#vehicle_no, #vehicle_chassis_no").on("blur", function () {
        let field = $(this).attr("name"); // Get the field name ('vehicle_no' or 'vehicle_chassis_no')
        let value = $(this).val();
        let input = $(this);
        let errorSpan = $("#" + field + "Error"); // Get the corresponding error message span

        if (value) {
            $.ajax({
                url: "{{ route('admin.vehicles.check') }}", // Adjust this route accordingly
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    field: field,
                    value: value,
                },
                success: function (response) {
                    if (response.exists) {
                        errorSpan.text(response.message).show(); // Show error message
                        input.addClass("is-invalid");
                        $("#vehicleForm button[type=submit]").prop("disabled", true);
                    } else {
                        errorSpan.hide();
                        input.removeClass("is-invalid");
                        $("#vehicleForm button[type=submit]").prop("disabled", false);
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error:", xhr.responseText);
                }
            });
        } else {
            errorSpan.hide();
            input.removeClass("is-invalid");
            $("#vehicleForm button[type=submit]").prop("disabled", false);
        }
    });
});
</script>

<script>
     $.validator.addMethod("alphanumeric", function(value, element) {
    // Check if the value contains at least one letter, one number, and no special characters
    return this.optional(element) || /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/.test(value);
}, "Please enter a valid alphanumeric value containing both letters and numbers without special characters.");

    $(document).ready(function () {
        $("#vehicleForm").validate({
            onfocusout: function (element) {
               let $el = $(element);
                if ($el.attr("name") === "vehicle_no") {
                    $el.val($el.val().replace(/\s+/g, '')); // Remove all spaces
                }
                this.element(element); // Validate the field on blur
            },
            onkeyup: false, // Optional: Disable validation on keyup for performance
            rules: {
                vehicle_no: {
                    maxlength: 10,
                    alphanumeric: true
                },
                type_of_vehicle:{
                    required: true,
                    minlength: 3,
                },
                vehicle_engine_no: {
                    required: true,
                    maxlength: 20,
                    alphanumeric: true
                },
                vehicle_chassis_no: {
                    required: true,
                    maxlength: 17,
                    alphanumeric: true
                },
                average: {
                    required: true,
                },
                road_tax_amount: {
                    required: true,
                    number: true,
                    min: 0,
                }
            },
            messages: {
                vehicle_no: {
                    required: "Vehicle number is required",
                    maxlength: "Vehicle number cannot exceed 10 characters"
                },
                type_of_vehicle:{
                    required: "Type of vehicle is required",
                    minlength: "Type of vehicle should be at least 3 characters long"
                    },
                vehicle_engine_no: {
                    required: "Engine number is required",
                    maxlength: "Engine number cannot exceed 20 characters"
                },
                vehicle_chassis_no: {
                    required: "Chassis number is required",
                    maxlength: "Chassis number cannot exceed 17 characters"
                },
                average: {
                    required: "Average claim by company is required",
                },
                road_tax_amount: {
                    required: "Road tax amount is required",
                    number: "Please enter a valid number",
                    min: "Road tax amount cannot be negative"
                }
            },
            errorClass: "text-danger",
            errorElement: "span",
            highlight: function (element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid");
            },
            submitHandler: function (form) {
                // Handle successful validation here
                form.submit();
            }
        });
    });
    </script>

@endsection
