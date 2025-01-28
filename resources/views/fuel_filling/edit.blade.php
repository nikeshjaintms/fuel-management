@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Fuel Filling Information</h3>
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
                        <a href="{{ route('admin.fuel_filling.index')}}">Fuel Filling Information</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Fuel Filling Information</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Fuel Filling Information </div>
                        </div>
                        <form method="POST" action="{{ route('admin.fuel_filling.update', $fuelFilling->id ) }}" id="vehicleForm" >
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="driver_id">Drive By</label>
                                            <select name="driver_id" class="form-control" id="">
                                                <option value="">Select Driver</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{$driver->id }}"
                                                        {{ $driver->id == $fuelFilling->driver_id ? 'selected' : '' }}>{{ $driver->driver_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_no">Vehicle No</label>
                                            <select name="vehicle_id" id="" class="form-control">
                                                <option value="">Select Vehicle</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id }}"
                                                        {{ $vehicle->id == $fuelFilling->vehicle_id ? 'selected' : '' }}>{{ $vehicle->vehicle_no }}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="filling_date">Filling Date</label>
                                            <input type="date" class="form-control" value="{{$fuelFilling->filling_date }}"  name="filling_date" id="filling_date" placeholder="Enter Vechile no" required />
                                        </div>

                                        <div class="form-group">
                                            <label for="quantity">Quantity (ltr)</label>
                                            <input type="text" class="form-control" value="{{$fuelFilling->quantity }}"  name="quantity" id="quantity" placeholder="Enter Chassic no" required />
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kilometers">Kilometers Driven</label>
                                            <input type="text" class="form-control" value="{{$fuelFilling->kilometers }}"  name="kilometers" id="kilometers" placeholder="Enter Policy no" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="average_fuel_consumption">Average </label>
                                            <input type="text" readonly class="form-control" value="{{$fuelFilling->average_fuel_consumption }}" name="average_fuel_consumption" id="average_fuel_consumption" placeholder="GJ 16 XX 0000" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.fuel_filling.index')}}" class="btn btn-danger" >Cancel</a>
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
        // Apply validation to the form
        $("#vehicleForm").validate({
            rules: {
                driver_id: {
                    required: true,
                },
                vehicle_id: {
                    required: true,
                },
                filling_date: {
                    required: true,
                    date: true,
                },
                quantity: {
                    required: true,
                    number: true,
                    min: 1,
                },
                kilometers: {
                    required: true,
                    number: true,
                    min: 0,
                },
            },
            messages: {
                driver_id: {
                    required: "Please select a driver.",
                },
                vehicle_id: {
                    required: "Please select a vehicle.",
                },
                filling_date: {
                    required: "Please enter a filling date.",
                    date: "Please enter a valid date.",
                },
                quantity: {
                    required: "Please enter the quantity.",
                    number: "Please enter a valid number.",
                    min: "Quantity must be greater than zero.",
                },
                kilometers: {
                    required: "Please enter kilometers driven.",
                    number: "Please enter a valid number.",
                    min: "Kilometers must not be negative.",
                },
            },
            errorElement: "span",
            errorClass: "text-danger",
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
        });
    });
</script>

@endsection
