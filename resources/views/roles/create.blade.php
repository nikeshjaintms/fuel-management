@extends('layouts.app')
@if(Auth::guard('admin')->check())
@section('title','Admin Panel')

@endif

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Roles</h3>
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
                        <a href="{{ route('admin.roles.index')}}">Roles</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add Roles</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Roles</div>
                        </div>
                        <form method="POST" action="{{ route('admin.roles.store') }}" id="vehicleForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" id="select_all"> Select All
                                            </label>
                                            @foreach($permissions as $permission)
                                             <label for=""><input class="permission-checkbox" type="checkbox" name="permissions[{{ $permission->name }}]" value="{{ $permission->name }}" id="">  {{ $permission->name }}</label>
                                            @endforeach
                                            <span id="permissions-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-danger">Cancel</a>
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
        // Select all checkboxes feature
        $('#select_all').on('change', function () {
            $('.permission-checkbox').prop('checked', this.checked);
        });

        $('.permission-checkbox').on('change', function () {
            if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });

        // jQuery Validation
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
        }, "Please enter only letters");

        $("#roleForm").validate({
            onfocusout: function (element) {
                this.element(element);
            },
            onkeyup: false,
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50,
                    lettersonly: true
                },
                'permissions[]': {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    minlength: "Please enter at least 3 characters",
                    maxlength: "Please enter no more than 50 characters",
                    lettersonly: "Please enter only letters"
                },
                'permissions[]': {
                    required: "Please select at least one permission"
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
                if ($('.permission-checkbox:checked').length === 0) {
                    $('#permissions-error').text("Please select at least one permission");
                    return false;
                } else {
                    $('#permissions-error').text("");
                    form.submit();
                }
            }
        });
    });
</script>
@endsection
