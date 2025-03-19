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
                        <a href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Users</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Drivers Information</div>
                        </div>
                        <form action="{{ route('admin.users.update', $admin->id) }}" method="POST" id="UserForm">
                            @method('PUT')
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
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="Name">Name <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control mt-1 whitespace-trim" id="name"
                                        value="{{ $admin->name }}" name="name" placeholder="Enter Full Name here"
                                        required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="email" class="required-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control mt-1 whitespace-trim" id="email"
                                        value="{{ $admin->email }}" name="email" placeholder="Enter Email here"
                                        required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="password" class="required-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control mt-1" id="password" name="password"
                                        placeholder="Enter Password" />
                                </div>


                                <div class="col-md-6 mb-2">
                                    <label for="role" class="required-label">Role <span
                                            class="text-danger">*</span></label>
                                    <select name="roles[]" id="roles" class="form-control">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option {{ $admin->hasRole($role->name) ? 'selected' : '' }}
                                                value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="card-action" style="border:none;">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Cancel</a>
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
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
            }, "Please enter only alphabetic characters and spaces.");

            $.validator.addMethod("regexEmail", function(value, element) {
                var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return this.optional(element) || regex.test(value);
            });

            $.validator.addMethod("regexPassword", function(value, element) {
                var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
                return this.optional(element) || regex.test(value);
            });

            $("#UserForm").validate({
                rules: {
                    name: {
                        required: true,
                        lettersonly: true, // Only allow letters and spaces
                    },
                    email: {
                        required: true,
                        email: true,
                        regexEmail: true // Custom email validation regex
                    },
                    password: {
                        minlength: 8,
                        maxlength: 12,
                        regexPassword: true // Custom password complexity rule
                    },
                    'roles[]': {
                        required: true,
                        minlength: 1 // At least one role must be selected
                    },
                },
                messages: {
                    name: {
                        required: 'Name field is required.',
                        lettersonly: 'Name should only contain letters and spaces.',
                    },
                    email: {
                        required: ' Email field is required.',
                        email: 'Please enter a valid email address.',
                        regexEmail: ' Please enter a valid email address (e.g., user@example.com).'
                    },
                    password: {
                        minlength: ' Password must be at least 8 characters long.',
                        maxlength: ' Password cannot exceed 12 characters',
                        regexPassword: ' Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
                    },
                    'roles[]': {
                        required: ' At least one role must be selected.',
                        minlength: 'Please select at least one role.'
                    },
                },
                errorClass: "text-danger",
                errorElement: "div",
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
