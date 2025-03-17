@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif
@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Loan</h3>
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
                        <a href="{{ route('admin.loan.index')}}">Loan</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add Loan</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Loan</div>
                        </div>
                        <form method="POST" action="{{ route('admin.loan.store') }}" id="vehicleForm" >
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
                                            <label for="finance_by">Financed By<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="finance_by" id="finance_by" placeholder="for eg: Bank, firm, etc" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loan_amount">Financed Amount<span style="color: red">*</span> </label>
                                            <input type="number" class="form-control" name="loan_amount" id="loan_amount" placeholder="Enter a financed amount" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loan_account">Financed Account<span style="color: red">*</span> </label>
                                            <input type="text" class="form-control" name="loan_account" id="loan_account" placeholder="Enter a financed Account" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="emi_amount">EMI Amount<span style="color: red">*</span> </label>
                                            <input type="number" class="form-control" name="emi_amount" id="emi_amount" placeholder="Enter a EMI Amount" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_emi">Total EMI<span style="color: red">*</span> </label>
                                            <input type="number" class="form-control" name="total_emi" id="total_emi" placeholder="Enter a Total EMI " required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="emi_paid">EMI Paid<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="emi_paid" id="emi_paid" placeholder="Enter a Total EMI " required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pending_emi">Pending EMI<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="pending_emi" id="pending_emi" placeholder="Enter a EMI Pending" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date">Start Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="start_date" id="start_date" placeholder=""  required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date">End Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="end_date" id="end_date" placeholder="" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate_of_interest">Rate of Interst<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="rate_of_interest" id="rate_of_interest" placeholder="Enter Rate of Interst" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="installment_date">Date of Installment<span style="color: red">*</span></label>
                                            <select name="installment_date" id="" class="form-control">
                                                <option value="">Select Installment Date</option>
                                                @foreach(range(1, 28) as $day)
                                                    <option value="{{$day}}">{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.loan.index')}}" class="btn btn-danger" >Cancel</a>
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
    function calculatePendingEMI() {
        var totalEmi = parseInt($("#total_emi").val()) || 0;
        var emiPaid = parseInt($("#emi_paid").val()) || 0;

        var pendingEmi = totalEmi - emiPaid;

        if (pendingEmi < 0) {
            pendingEmi = 0; // Prevent negative pending EMI
        }

        $("#pending_emi").val(pendingEmi);
    }

    // Trigger calculation on input change
    $("#total_emi, #emi_paid").on("input", function () {
        calculatePendingEMI();
    });

    // Make pending EMI readonly
    $("#pending_emi").prop("readonly", true);
});
</script>
<script>
    $(document).ready(function () {
        $("#vehicle_id").change(function () {
            var vehicleId = $(this).val();
            if (vehicleId) {
                $.ajax({
                    url: "{{ route('admin.loan.checkVehicle') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        vehicle_id: vehicleId
                    },
                    success: function (response) {
                        if (response.exists === true) {
                            $("#vehicleError").text("TThis vehicle is already associated with a loan.").show();
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


    $("#vehicleForm").validate({
        onfocusout: function (element) {
            this.element(element); // Validate the field on blur
        },
        onkeyup: false, // Disable validation on keyup for better performance
        rules: {
            vehicle_id: {
                required: true
            },
            finance_by: {
                required: true,
                maxlength: 255
            },
            loan_amount: {
                required: true,
                min: 0
            },
            loan_account: {
                required: true
            },
            emi_amount: {
                required: true,
                number: true,
                min: 0
            },
            total_emi: {
                required: true,
                digits: true,
                min: 0
            },
            emi_paid: {
                required: true,
                digits: true,
                min: 0
            },
            pending_emi: {
                required: true,
                digits: true,
                min: 0
            },
            start_date: {
                required: true,
                date: true
            },
            end_date: {
                required: true,
                date: true
            },
            rate_of_interest: {
                required: true,
                number: true,
                min: 0
            },
            installment_date: {
                required: true,
                digits: true,
                min: 0
            }
        },
        messages: {
            vehicle_id:{
                required: "Please select a vehicle."
            },
            finance_by: {
                required: "Please enter finance by.",
                maxlength: "Finance by cannot exceed 255 characters."
            },
            loan_amount: {
                required: "Please enter loan amount.",
                number: "Please enter a valid loan amount.",
                min: "Loan amount cannot be negative."
            },
            loan_account: {
                required: "Please enter loan account number.",
            },
            emi_amount: {
                required: "Please enter EMI amount.",
                number: "Please enter a valid EMI amount.",
                min: "EMI amount cannot be negative."
            },
            total_emi: {
                required: "Please enter total EMI to be paid.",
                digits: "Please enter a valid total EMI.",
                min: "Total EMI cannot be negative."
            },
            emi_paid: {
                required: "Please enter EMI paid.",
                digits: "Please enter a valid EMI paid.",
                min: "EMI paid cannot be negative."
            },
            pending_emi: {
                required: "Please enter pending EMI.",
                digits: "Please enter a valid Pending EMI .",
                min: "Pending EMI cannot be negative."
            },
            start_date: {
                required: "Please select start date.",
                date: "Please enter a valid start date."
            },
            end_date: {
                required: "Please select end date.",
                date: "Please enter a valid end date."
            },
            rate_of_interest: {
                required: "Please enter rate of interest.",
                number: "Please enter a valid rate of interest.",
                min: "Rate of interest cannot be negative."
            },
            installment_date: {
                required: "Please select installment date.",
                digits: "Please enter a valid installment date.",
                min: "Installment date cannot be negative."
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
