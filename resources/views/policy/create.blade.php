@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Insurance Policy</h3>
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
                        <a href="{{ route('admin.policy.index')}}">Insurance Policy</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Insurance Policy</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Insurance Policy Details </div>
                        </div>
                        <form method="POST" action="{{ route('admin.policy.store') }}" id="vehicleForm" >
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_no">Vehicle No<span style="color: red">*</span></label>
                                            <select name="vehicle_id" id="vehicle_id" class="form-control">
                                                <option value="">Select Vehicle</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                                                @endforeach
                                            </select>
                                            <span id="vehicleError" class="text-danger" style="display:none;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Policy No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="policy_no" id="policy_no" placeholder="Enter a Policy no" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="expiry_date">Policy Expiry Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="expiry_date" id="expiry_date"  required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.policy.index')}}" class="btn btn-danger" >Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
<script>

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $("#vehicle_id").change(function () {
        var vehicleId = $(this).val();
        if (vehicleId) {
            $.ajax({
                url: "{{ route('admin.policy.checkVehicle') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    vehicle_id: vehicleId
                },
                success: function (response) {
                    if (response.exists === true) {
                        $("#vehicleError").text("This vehicle already exists in the RTO records.").show();
                        $("#vehicleForm button[type=submit]").prop("disabled", true);
                    } else {
                        $("#vehicleError").hide();
                        $("#vehicleForm button[type=submit]").prop("disabled", false);
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error:", xhr.responseText);
                }
            });
        } else {
            $("#vehicleError").hide();
            $("#vehicleForm button[type=submit]").prop("disabled", false);
        }
    });
});

</script>
<script>
    $(document).ready(function () {
    $("#policy_no").on("blur", function () {
        var policyNo = $(this).val();
        if (policyNo) {
            $.ajax({
                url: "{{ route('admin.policy.checkPolicy') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    policy_no: policyNo
                },
                success: function (response) {
                    if (response.exists === true) {
                        $("#policy_no").after('<span class="text-danger" id="policyError">This policy number already exists.</span>');
                        $("#vehicleForm button[type=submit]").prop("disabled", true);
                    } else {
                        $("#policyError").remove();
                        $("#vehicleForm button[type=submit]").prop("disabled", false);
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error:", xhr.responseText);
                }
            });
        } else {
            $("#policyError").remove();
            $("#vehicleForm button[type=submit]").prop("disabled", false);
        }
    });
});
</script>
<script>
$(document).ready(function () {

        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^(?=.*[a-zA-Z])(?=.*[0-9]).+$/.test(value);
        }, "Please enter a valid alphanumeric value that contains both letters and numbers.");

        $("#vehicleForm").validate({
            rules: {
                vehicle_id: {
                    required: true,
                },
                policy_no: {
                    required: true,
                    minlength: 5,
                    maxlength: 20,
                    alphanumeric: true
                },
                expiry_date: {
                    required: true,
                    date: true, // Ensure it's a valid date
                },
            },
            messages: {
                vehicle_id: {
                    required: "Please select a vehicle.",
                },
                policy_no: {
                    required: "Please enter a policy number.",
                    minlength: "Policy number should not be less than 5 characters.",
                    maxlength: "Policy number should not exceed 20 characters.",
                },
                expiry_date: {
                    required: "Please enter the policy expiry date.",
                    date: "Please enter a valid date.",
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
