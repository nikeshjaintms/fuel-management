@extends('layouts.app')

@if(Auth::guard('admin')->check())
    @section('title','Admin Panel')
@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Customer Information</h3>
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
                        <a href="{{ route('admin.customer_info.index')}}">Customer Information</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add Customer Information</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Customer Information</div>
                        </div>
                        <form method="POST" action="{{ route('admin.customer_info.store') }}" id="customerForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_type_id">Customer Type<span style="color: red">*</span></label>
                                            <select class="form-control" name="customer_type" id="customer_type_id" required>
                                                <option value="">Select Customer Type</option>
                                                <option value="Companies">Companies</option>
                                                <option value="Individual">Individual</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_name">Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_mobile_no">Mobile No</label>
                                            <input type="text" class="form-control" name="customer_mobile_no" id="customer_mobile_no" placeholder="Enter Mobile No"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_email">Email<span style="color: red">*</span></label>
                                            <input type="email" class="form-control" name="customer_email" id="customer_email" placeholder="Enter Email" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_address">Address<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="customer_address" id="customer_address" placeholder="Enter Address" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_gst">GST<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="customer_gst" id="customer_gst" placeholder="Enter GST" required />
                                            <span id="gst-error" class="text-danger" style="display: none;">GST number already exists.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.customer_info.index') }}" class="btn btn-danger">Cancel</a>
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
    let gstExists = false; // Flag to track GST existence
    let gstError = $("#gst-error"); // Error message span
    let gstInput = $("#customer_gst"); // GST input field
    let submitButton = $("#customerForm button[type=submit]"); // Submit button

    // Check GST when user stops typing (debounce effect)
    gstInput.on("blur", function () {
        let gstNumber = $(this).val().trim();
        if (gstNumber) {
            $.ajax({
                url: "{{ route('admin.check.customer_gst') }}", // Adjust this route as needed
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    field: "customer_gst",
                    value: gstNumber
                },
                success: function (response) {
                    if (response.exists) {
                        gstExists = true;
                        gstError.text("GST number already exists. Please enter a unique GST number.").show();
                        gstInput.addClass("is-invalid");
                        submitButton.prop("disabled", true);
                    } else {
                        gstExists = false;
                        gstError.hide();
                        gstInput.removeClass("is-invalid");
                        submitButton.prop("disabled", false);
                    }
                },
                error: function () {
                    alert("An error occurred while checking the GST number. Please try again.");
                }
            });
        } else {
            gstError.hide();
            gstInput.removeClass("is-invalid");
            submitButton.prop("disabled", false);
        }
    });

    // Prevent form submission if GST exists
    $("#customerForm").on("submit", function (e) {
        if (gstExists) {
            e.preventDefault(); // Prevent submission
            gstError.text("GST number already exists. Please enter a unique GST number.").show();
            gstInput.addClass("is-invalid");
            alert("Please fix errors before submitting the form.");
        }
    });
});
</script>
<script>
$(document).ready(function () {

        // jQuery Validation Setup
         $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^(?=.*[a-zA-Z])(?=.*[0-9]).+$/.test(value);
        }, "Please enter a valid alphanumeric value that contains both letters and numbers.");

        $.validator.addMethod("regexEmail", function(value, element) {
        var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return this.optional(element) || regex.test(value);
        }, "Please enter a valid email address");


        $("#customerForm").validate({
            onfocusout: function (element) {
                this.element(element); // Validate the field on blur
            },
            onkeyup: false, // Optional: Disable validation on keyup for performance
            rules: {
                customer_type: {
                    required: true,
                },
                customer_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
                },
                customer_mobile_no: {
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                },
                customer_email: {
                    required: true,
                   regexEmail: true
                },
                customer_address: {
                    required: true,
                    maxlength: 500,
                },
                customer_gst: {
                    required: true,
                    minlength: 15,
                    maxlength: 15,
                    alphanumeric: true,
                },
            },
            messages: {
                customer_type: {
                    required: "Please Select Customer Type",
                },
                customer_name: {
                    required: "Name is required",
                    minlength: "Name should be at least 2 characters",
                    maxlength: "Name cannot exceed 50 characters"
                },
                customer_mobile_no: {
                    minlength: "Mobile number cannot be less than 10 characters",
                    digits: "Mobile number should only contain digits",
                    maxlength: "Mobile number cannot exceed 10 characters"
                },
                customer_email: {
                    required: "Email is required",
                    regexEmail: "Please enter a valid email (e.g., example@domain.com)",

                },
                customer_address: {
                    required: "Address is required",
                    maxlength: "Address cannot exceed 500 characters"
                },
                customer_gst: {
                    required: "GST is required",
                    minlength: "GST should be 15 characters",
                    maxlength: "GST should be 15 characters",
                },
            },
            errorClass: "text-danger",
            errorElement: "span",
            highlight: function (element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid");
            }
        });
    });
</script>

@endsection
