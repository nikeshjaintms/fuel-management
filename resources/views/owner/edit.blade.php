@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Owners </h3>
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
                        <a href="{{ route('admin.owner.index')}}">Owners </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Owners </a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Owners  </div>
                        </div>
                        <form method="POST" action="{{ route('admin.owner.update', $data->id ) }}" id="vehicleForm" >
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_no">Vehicle No<span style="color: red">*</span></label>
                                            <select name="vehicle_id" id="" class="form-control">
                                                <option value="">Select Vehicle</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option {{ $data->vehicle_id == $vehicle->id ? 'selected' : '' }}
                                                     value="{{$vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="owner_name">Name<span style="color: red">*</span></label>
                                            <input type="text" value="{{ $data->owner_name }}" class="form-control" name="owner_name" id="owner_name" placeholder="Vehile Owner name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Relationship<span style="color: red">*</span></label>
                                            <input type="text" value="{{ $data->type }}" class="form-control" name="type" id="type" placeholder="Proprietor" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="asset_make_model">Asset make and model<span style="color: red">*</span></label>
                                            <input type="text" value="{{ $data->asset_make_model }}" class="form-control" name="asset_make_model" id="asset_make_model" placeholder="Enter Company name and model" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="segment">Segment<span style="color: red">*</span></label>
                                            <input type="text"  value="{{ $data->segment }}" class="form-control" name="segment" id="segment" placeholder="Enter a Vehicle Category " />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="model">Model<span style="color: red">*</span></label>
                                            <input type="text" value="{{ $data->model }}" class="form-control" name="model" id="model" placeholder="for eg: Car, TATA LPO 1618, ASHOK LEY TF 18.12" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="body">Body<span style="color: red">*</span></label>
                                            <input type="text"  value="{{ $data->body }}" class="form-control" name="body" id="body" placeholder="for eg: Bus, Travller, Tanker , etc" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="yom">Year of Model<span style="color: red">*</span></label>
                                            <select id="yom" name="yom" class="form-control">
                                                <option value="">Select Year</option>
                                                @php
                                                    $startYear = 1990;
                                                    $endYear = date('Y');
                                                @endphp
                                                @for ($year = $endYear; $year >= $startYear; $year--)
                                                    <option value="{{ $year }}" {{ (isset($data->yom) && $data->yom == $year) ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id">Customer<span style="color: red">*</span></label>
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $customer)
                                                    <option {{ $customer->id == $data->customer_id ? 'selected' : '' }}
                                                    value="{{$customer->id }}">{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.owner.index')}}" class="btn btn-danger" >Cancel</a>
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
        $('#vehicle_no, #vehicle_chassis_no').on('blur', function () {
            let field = $(this).attr('name'); // Get the field name ('vehicle_no' or 'vehicle_chassis_no')
            let value = $(this).val();
            let input = $(this);

            if (value) {
                $.ajax({
                    url: "{{ route('admin.vehicles.check') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        field: field,
                        value: value,
                    },
                    success: function (response) {
                        if (response.exists) {
                            // Display the error message
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                            input.after(`<div class="invalid-feedback">${response.message}</div>`);
                        } else {
                            // Clear the error message if the field is valid
                            input.removeClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                        }
                    },
                    error: function () {
                        alert('An error occurred while checking the field. Please try again.');
                    }
                });
            }
        });

        $('#vehicleForm').on('submit', function (e) {
            if ($('.is-invalid').length > 0) {
                e.preventDefault(); // Prevent submission if there are errors
                alert('Please fix errors before submitting the form.');
            }
        });
    });
</script>

<script>


$(document).ready(function () {
    $("#vehicleForm").validate({
        onfocusout: function (element) {
            this.element(element); // Validate the field on blur
        },
        onkeyup: false, // Disable validation on keyup for better performance
        rules: {
            vehicle_id: {
                required: true
            },
            owner_name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            type: {
                required: true,
                maxlength: 255
            },
            asset_make_model: {
                required: true,
                maxlength: 255
            },
            segment: {
                required: true,
                maxlength: 255
            },
            model: {
                required: true,
                maxlength: 255
            },
            body: {
                required: true,
                maxlength: 255
            },
            yom: {
                required: true,
                number: true,
                min: 1990,
                max: new Date().getFullYear()
            },
            customer_id: {
                required: true
            },
        },
        messages: {
            vehicle_id:{
                required: "Please select a vehicle."
            },
            owner_name: {
                required: "Owner name is required.",
                minlength: "Owner name must be at least 3 characters.",
                maxlength: "Owner name cannot exceed 255 characters."
            },
            type: {
                required: "Relationship is required."
            },
            asset_make_model: {
                required: "Asset make and model is required."
            },
            segment: {
                required: "Segment is required."
            },
            model: {
                required: "Model is required.",
                maxlength: "Model cannot exceed 255 characters."
                },
            body: {
                required: "Body is required."
            },
            yom: {
                required: "Year is required.",
                number: "Please enter a valid year.",
                min: "Year cannot be before 1990.",
                max: "Year cannot be in the future."
            },
            customer_id: {
                required: "Please select a customer."
            },

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
