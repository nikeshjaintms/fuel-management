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
                        <a href="{{ route('index') }}">
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
                        <a href="#">Edit Vehicle Information</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Vehicle Information </div>
                        </div>
                        <form method="POST" action="{{ route('admin.vehicles.update', $vehicle->id ) }}" id="vehicleForm" >
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_no">Vehicle No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" value="{{ $vehicle->vehicle_no }}" {{ $vehicle->vehicle_no != NULL ? 'readonly' : '' }} name="vehicle_no" id="vehicle_no" placeholder="GJ16XX0000" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_engine_no">Vehicle Engine No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" value="{{ $vehicle->vehicle_engine_no }}" name="vehicle_engine_no" id="vehicle_engine_no" placeholder="Enter Vechile no" required readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_chassis_no">Vehicle Chassis No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" value="{{ $vehicle->vehicle_chassis_no }}" name="vehicle_chassis_no" id="vehicle_chassis_no" placeholder="Enter Chassic no" required readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="average">Average Claim by Company<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" value="{{ $vehicle->average }}" name="average" id="average" placeholder="Enter a Average" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="road_tax_amount">Road Tax Amount<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" value="{{ $vehicle->road_tax_amount }}" name="road_tax_amount" id="road_tax_amount" required placeholder="Enter a Amount" />
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
          $.validator.addMethod("alphanumeric", function(value, element) {
    // Check if the value contains at least one letter, one number, and no special characters
    return this.optional(element) || /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/.test(value);
}, "Please enter a valid alphanumeric value containing both letters and numbers without special characters.");

    $(document).ready(function () {
        $("#vehicleForm").validate({
            onfocusout: function (element) {
                this.element(element); // Validate the field on blur
            },
            onkeyup: false, // Optional: Disable validation on keyup for performance
            rules: {
                vehicle_no: {
                    required: true,
                    maxlength: 10,
                    alphanumeric: true
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
                    min: 0
                }
            },
            messages: {
                vehicle_no: {
                    required: "Vehicle number is required",
                    maxlength: "Vehicle number cannot exceed 10 characters"
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
