@extends('layouts.app')

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
                                            <label for="vehicle_no">Vehicle No</label>
                                            <input type="text" class="form-control" value="{{ $vehicle->vehicle_no }}" {{ $vehicle->vehicle_no != NULL ? 'readonly' : '' }} name="vehicle_no" id="vehicle_no" placeholder="GJ 16 XX 0000" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_engine_no">Vehicle Engine No</label>
                                            <input type="text" class="form-control" value="{{ $vehicle->vehicle_engine_no }}" name="vehicle_engine_no" id="vehicle_engine_no" placeholder="Enter Vechile no" required readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_chassis_no">Vehicle Chassis No</label>
                                            <input type="text" class="form-control" value="{{ $vehicle->vehicle_chassis_no }}" name="vehicle_chassis_no" id="vehicle_chassis_no" placeholder="Enter Chassic no" required readonly/>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_policy_no">Vehicle Policy No</label>
                                            <input type="text" class="form-control" name="vehicle_policy_no" value="{{ $vehicle->vehicle_policy_no }}" id="vehicle_policy_no" placeholder="Enter Policy no" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_policy_expiry_date">Vehicle Policy Expiry Date</label>
                                            <input type="date" class="form-control" name="vehicle_policy_expiry_date" value="{{ $vehicle->vehicle_policy_expiry_date }}" id="vehicle_policy_expiry_date" placeholder="GJ 16 XX 0000" />
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_fitness_expiry_date">Vehicle Fitness Expiry Date</label>
                                            <input type="date" class="form-control" name="vehicle_fitness_expiry_date" value="{{ $vehicle->vehicle_fitness_expiry_date }}" id="vehicle_fitness_expiry_date" placeholder="GJ 16 XX 0000" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_puc_expiry_date">Vehicle PUC Expiry Date</label>
                                            <input type="date" class="form-control" name="vehicle_puc_expiry_date" value="{{ $vehicle->vehicle_puc_expiry_date }}" id="vehicle_puc_expiry_date" placeholder="GJ 16 XX 0000" />
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
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "Please enter a valid alphanumeric value.");
    
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
                vehicle_policy_no: {
                    required: true,
                    maxlength: 20,
                    alphanumeric: true
                },
                vehicle_policy_expiry_date: {
                    required: true,
                    date: true
                },
                vehicle_fitness_expiry_date: {
                    required: true,
                    date: true
                },
                vehicle_puc_expiry_date: {
                    required: true,
                    date: true
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
                vehicle_policy_no: {
                    required: "Policy number is required",
                    maxlength: "Policy number cannot exceed 20 characters"
                },
                vehicle_policy_expiry_date: {
                    required: "Policy expiry date is required",
                    date: "Please enter a valid date"
                },
                vehicle_fitness_expiry_date: {
                    required: "Fitness expiry date is required",
                    date: "Please enter a valid date"
                },
                vehicle_puc_expiry_date: {
                    required: "PUC expiry date is required",
                    date: "Please enter a valid date"
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
