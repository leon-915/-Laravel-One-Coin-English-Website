@extends('layouts.admin',['title'=>'Edit User'])

@section('title','Edit User')

@section('content')
	<div class="content-wrapper">
	    <div class="page-header">
	        <h3 class="page-title"> Edit User </h3>
	        <nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
	                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manage Users</a></li>
	                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
	            </ol>
	        </nav>
	    </div>
	    <div class="row grid-margin">
	    	<div class="col-lg-12">
	            <div class="card">
	                <div class="card-body">
	                    <h4 class="card-title">Edit User</h4>

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


	                    {!! Form::model($user, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_user','route' => ['users.update', $user->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        	@include('admin.users.form',['disable' => true,'form'=> 'edit', 'cities' => $cities])
                        {!! Form::close() !!}

	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php /*
    <div class="panel-body container-fluid">
        <div class="row row-lg">
            <div class="col-md-12">
                <div class="example-wrap">
                    <div class="example">
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
                        {!! Form::model($user, ['method' => 'PATCH','id'=>'edit_user','route' => ['users.update', $user->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        @include('admin.users.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    */ ?>
    @push('scripts')
        <script>
           
            $('#datepicker-popup').datepicker({
                format: "yyyy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
            });

            var reg = /[12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])/;
            $.validator.addMethod(
                "DateFormat",
                function(value, element) {
                    return reg.test(value);
                },
                "Please enter date in yyyy/mm/dd format."
            );

            $.validator.addMethod("zipcode", function(value, element) {
                return this.optional(element) || /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(value);
                }, "Please provide a valid zip code."
            );

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

            $("#city").select2({
                placeholder: 'Please Select City',
                allowClear: true
            });

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

            $('#edit_user').validate({ // initialize the plugin
                rules: {
                    name : {
                        required: true,
                        pattern : /^[a-zA-Z\s]+$/,
                    },
                    birth_date : {
                        required: true ,
                        DateFormat : true  
                    },
                    email: {
                        required: true,
                        // email: true,
                        pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                        remote: {
                            url: '{{ route('users.email.exist') }}',
                            type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                email : function () {
                                    return $('#email').val();
                                },
                                user_id : function () {
                                    return '{{$user->id}}';
                                },
                                success: function (response) {
                                    // console.log(response);
                                }
                            }

                        }
                    },
                    status:{
                        required: true
                    },
                    state : {
                        required : true
                    },
                    zip_code : {
                        required : true,
                        zipcode: true,
                    }
                },
                messages: {
                    name : {
                        required : "Please enter name.",
                        pattern : "Only alphabets are allowed."
                    },
                    birth_date : {
                        required : "Please enter birth date."
                    },
                    email: {
                        required: "Please enter email",
                        //email : "Please enter a valid email",
                        pattern : 'Please enter a valid email.',
                        remote : "Email already exists."
                    },
                    status:{
                        required: "Please select status."
                    },
                    state : {
                        required: "Please select state."
                    },
                    zip_code : {
                        required : "Please enter zip code."
                    }

                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "state") {
                        error.insertAfter("#state_name");
                    }else if (element.attr("name") == "birth_date") {
                        error.insertAfter("#datepicker-popup");
                    }else{
                        error.insertAfter(element);
                    }
                }
            })
        </script>
    @endpush
@endsection
