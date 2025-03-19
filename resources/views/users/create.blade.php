@extends('layouts.app')
@if (Auth::guard('admin')->check())
    @section('title', 'Admin Panel')
@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Users</h3>
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
                        <a href="{{ route('admin.driver.index') }}">Users</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Users</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add User</div>
                        </div>
                        <form method="POST" action="{{ route('admin.driver.store') }}" id="vehicleForm">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-red-500">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="Name">Name <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control mt-1 whitespace-trim" id="name"
                                        name="name" placeholder="Enter Full Name here" required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="email" class="required-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control mt-1 whitespace-trim" id="email"
                                        name="email" placeholder="Enter Email here" required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="password" class="required-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control mt-1" id="password" name="password"
                                        placeholder="Enter Password" required />
                                </div>


                                <div class="col-md-6 mb-2">
                                    <label for="role" class="required-label">Role <span
                                            class="text-danger">*</span></label>
                                    <select name="roles[]" id="roles" class="form-control" multiple required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
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
        $(document).ready(function() {
            $("#vehicleForm").validate({
                onfocusout: function(element) {
                    this.element(element); // Validate the field on blur
                },
                onkeyup: false, // Optional: Disable validation on keyup for performance
                rules: {
                    driver_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                        lettersonly: true
                    },

                },
                messages: {
                    customer_type_id: {
                        required: "Please Select Customer Type",
                        minleght: "Please Enter Minimum 3 Characters",
                        maxlength: "Please Enter Maximum 50 Characters",
                        lettersonly: "Please Enter Only Letters"

                    },
                },
                errorClass: "text-danger",
                errorElement: "span",
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    // Handle successful validation here
                    form.submit();
                }
            });
        });
    </script>
@endsection
