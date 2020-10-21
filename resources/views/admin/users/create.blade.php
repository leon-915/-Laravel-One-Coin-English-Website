@extends('layouts.admin',['title'=>'Create User'])

@section('title','Create User')

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Create User </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manage Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create User</li>
            </ol>
        </nav>
    </div>
    <div class="row grid-margin">
    	<div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create New User</h4>

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ $error }}
                        </div>
                        @endforeach
                    @endif

                    {!! Form::open(array('route' => 'users.store','class'=>'cmxform', 'id'=>'create_user','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
	                        @include('admin.users.form',['disable' => false, 'form'=> 'create'])
	                    </fieldset>
                    {!! Form::close() !!}

					<?php /*
                    <form class="cmxform" id="signupForm" method="get" action="#">
                        <fieldset>
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input id="firstname" class="form-control" name="firstname" type="text">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input id="lastname" class="form-control" name="lastname" type="text">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" class="form-control" name="username" type="text">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" class="form-control" name="password" type="password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm password</label>
                                <input id="confirm_password" class="form-control" name="confirm_password" type="password">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" class="form-control" name="email" type="email">
                            </div>
                            <input class="btn btn-primary" type="submit" value="Submit">
                        </fieldset>
                    </form> */ ?>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });

        $('#datepicker-popup').datepicker({
            format: "yyyy-mm-dd",
            enableOnReadonly: true,
            todayHighlight: true,
			endDate : '-1d'
        });

        var re = /[12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])/;
        $.validator.addMethod(
            "DateFormat",
            function(value, element) {
                return re.test(value);
            },
            "Please enter date in yyyy/mm/dd format."
        );

        $.validator.addMethod("zipcode", function(value, element) {
            return this.optional(element) || /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(value);
            }, "Please provide a valid zip code."
        );

        $("#state").select2({
            placeholder: 'Please Select State',
            allowClear: true
        });

        function AjaxCity(){
            $.ajax({
                type :'POST',
                url : "<?= route('users.cities') ?>",
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    state : $('#state').val()
                },
                success: function (resp) {
                    $('#city-container').html(resp.citiesHtml);
                    $("#city").select2({
                        placeholder: 'Please Select City',
                        allowClear: true
                    });
                }
            });
        }

        $("#state").select2({
            placeholder: 'Please Select State',
            allowClear: true
        });

        $('#state').on('select2:select', function (e) {
            AjaxCity();
        });

        function setStateField(ddl) {
            document.getElementById('state_name').value = ddl.options[ddl.selectedIndex].text;
        }

        function setCityField(ddl) {
            document.getElementById('city_name').value = ddl.options[ddl.selectedIndex].text;
        }


        $(document).ready(function () {

            //
            // jQuery plugin to prevent double submission of forms
            jQuery.fn.preventDoubleSubmission = function () {
                $(this).on('submit', function (e) {
                    var $form = $(this);
                    if ($form.valid()) {
                        if ($form.data('submitted') === true) {
                            // Previously submitted - don't submit again
                            e.preventDefault();
                        } else {
                            // Mark it so that the next submit can be ignored
                            $form.data('submitted', true);
                        }
                    }
                });
                // Keep chainability
                return this;
            };
            $('form').preventDoubleSubmission();
        });

        $('#create_user').validate({ // initialize the plugin
            rules: {
                'name' : {
                    required: true,
                    pattern : /^[a-zA-Z\s]+$/,
                },
                'email': {
                    required: true,
                    //email: true,
                    pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                    remote : {
                        url : '{{ url('/users/email-exists') }}',
                        type : 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data : {
                            email : function () {
                                return $('#email').val();
                            }
                        }
                    }
                },
                'password':{
                    required: true,
                    minlength : 6
                },
                'confirm_password' : {
                    equalTo : "#password"
                },
        		'status':{
                    required: true
                },
                'state' : {
                    required : true
                },
                'zip_code' : {
                    required : true,
                    zipcode: true,
                },
                'birth_date' : {
                    required : true ,
                    DateFormat : true 
                }
            },
            messages: {
                name : {
                    required : "Please enter name",
                    pattern : "Only alphabets are allowed"
                },
                email: {
                    required: "Please enter email",
                    pattern : 'Please enter a valid email',
                    remote : 'Email already exists'
                },
                password: {
                    required: "Please enter password",
                    minlength: "Please enter minimum 6 characters"
                },
                confirm_password:{
                    equalTo: "Confirm password is not matched with password"
                },

                status:{
                    required: "Please select status"
                },
                state : {
                    required : "Please select state"
                },
                zip_code : {
                    required : "Please enter zip-code"
                },
                birth_date : {
                    required : "Please enter birth date"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "state") {
                    error.insertAfter("#state_name");
                }
                else if (element.attr("name") == "birth_date") {
                    error.insertAfter("#datepicker-popup");
                }
                else{
                    error.insertAfter(element);
                }
            }
        })

    </script>
@endpush
@endsection
