@extends('layouts.app')

@if(Auth::guard('admin')->check())
    @section('title','Admin Panel')
@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Vendor</h3>
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
                        <a href="{{ route('admin.vendor.index')}}">Vendor</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add Vendor</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Vendor</div>
                        </div>
                        <form method="POST" action="{{ route('admin.vendor.store') }}" id="customerForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="enter a Vendor Name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Mobile No<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Mobile No" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email<span style="color: red">*</span></label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vendor_gst">GST<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="vendor_gst" id="vendor_gst" placeholder="Enter GST" required />
                                            <span id="gst-error" class="text-danger" style="display: none;">GST number already exists.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.vendor.index') }}" class="btn btn-danger">Cancel</a>
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
    let gstExists = false;  // Flag to track if GST exists
    let gstInput = $("#vendor_gst"); // GST input field
    let submitButton = $("#customerForm button[type=submit]"); // Submit button

    // Check if the GST number already exists when the user blurs the GST field
    gstInput.on("blur", function () {
        let gstNumber = $(this).val().trim();
        if (gstNumber) {
            $.ajax({
                url: "{{ route('admin.check.vendor_gst') }}",  // Adjust this route according to your setup
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    field: "vendor_gst",
                    value: gstNumber,
                },
                success: function (response) {
                    if (response.exists) {
                        gstExists = true;
                        gstInput.addClass("is-invalid");
                        gstInput.next(".invalid-feedback").remove();
                        gstInput.after(`<div class="invalid-feedback">${response.message}</div>`);
                        submitButton.prop("disabled", true);
                    } else {
                        gstExists = false;
                        gstInput.removeClass("is-invalid");
                        gstInput.next(".invalid-feedback").remove();
                        submitButton.prop("disabled", false);
                    }
                },
                error: function () {
                    alert("An error occurred while checking the GST number. Please try again.");
                }
            });
        } else {
            gstExists = false;
            gstInput.removeClass("is-invalid");
            gstInput.next(".invalid-feedback").remove();
            submitButton.prop("disabled", false);
        }
    });

    // Prevent form submission if GST already exists
    $("#customerForm").on("submit", function (e) {
        if (gstExists) {
            e.preventDefault(); // Prevent form submission
            gstInput.addClass("is-invalid");
            if (!gstInput.next(".invalid-feedback").length) {
                gstInput.after(`<div class="invalid-feedback">GST number already exists. Please enter a unique GST number.</div>`);
            }
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
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50,
                },
                phone_number: {
                    required:true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                },
                email: {
                    required: true,
                   regexEmail: true
                },
                address: {
                    required: true,
                    maxlength: 500,
                },
                vendor_gst: {
                    required: true,
                    minlength: 15,
                    maxlength: 15,
                    alphanumeric: true,
                },
            },
            messages: {
                name: {
                    required: "Name is required",
                    minlength: "Name should be at least 2 characters",
                    maxlength: "Name cannot exceed 50 characters"
                },
                phone_number: {
                    minlength: "Mobile number cannot be less than 10 characters",
                    digits: "Mobile number should only contain digits",
                    maxlength: "Mobile number cannot exceed 10 characters"
                },
                email: {
                    required: "Email is required",
                    regexEmail: "Please enter a valid email (e.g., example@domain.com)",

                },
                address: {
                    required: "Address is required",
                    maxlength: "Address cannot exceed 500 characters"
                },
                vendor_gst: {
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
