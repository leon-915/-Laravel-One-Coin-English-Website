@extends('admin.layouts.admin',['title'=>'Create Teacher'])

@section('title','Create Teacher')

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Create Teacher </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Manage Teachers</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Teacher</li>
            </ol>
        </nav>
    </div>
    <div class="row grid-margin">
    	<div class="col-lg-12">
            <div class="card">
                <div class="card-body">
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

                    {!! Form::open(array('route' => 'admin.teachers.store','class'=>'cmxform', 'id'=>'create_user','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
	                        @include('admin.teachers.form',['disable' => false, 'form'=> 'create'])
	                    </fieldset>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
    <script>
        var resize = $('#upload-demo').croppie({
            enableExif: true,
            enableOrientation: true,
            viewport: { // Default { width: 100, height: 100, type: 'square' }
                width: 200,
                height: 200,
                //type: 'circle' //square
                type: 'square' //square
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#image').on('change', function () {
            $('#image-error').html('');
            var reader = new FileReader();
            reader.onload = function (e) {
                    resize.croppie('bind',{
                    url: e.target.result
                });
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('.file-upload-browse').on('click', function() {
            //var file = $(this).parent().parent().parent().find('.file-upload-default');
            $('#image').trigger('click');
        });
        $('#image').on('change', function() {
            $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });

        $(document).on('submit','#create_user', function(e){
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (img) {
              /* console.log($(".file-upload-info").val());
               console.log($(".file-upload-info").val().length);
               return false;*/
               if($(".file-upload-info").val().length > 0){
                    $('input[name=image]').val(img);
               }else{
                    $('input[name=image]').val('');
               }
                var data = new FormData($('#create_user')[0]);
                $.ajax({
                    url: "<?= route('admin.teachers.store') ?>",
                    type: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if(res.type == 'success'){
                            window.location.href = res.redirect;
                        }
                    }
                });
            });
            e.preventDefault();
        });

        $("#nationality").select2({
            placeholder: 'Please Select Country',
            allowClear: true
        });
        $("#country").select2({
            placeholder: 'Please Select Country',
            allowClear: true
        });

        $('#country').on('select2:select', function (e) {
             $("#country-error").hide();
        });

        $('#nationality').on('select2:select', function (e) {
             $("#nationality-error").hide();
        });

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });

        $('#datepicker-popup').datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            yearRange: "-150:+0",
            onSelect: function (dateText, inst) {
                $("#datepicker-popup-error").hide();
              }
        });

        // var re = /(0[1-9]|[12]\d|3[01])-(0[1-9]|1[0-2])-[12]\d{3}/;
        // $.validator.addMethod(
        //     "DateFormat",
        //     function(value, element) {
        //         return re.test(value);
        //     },
        //     "Please enter date in yyyy-mm-dd format."
        // );

        jQuery.validator.addMethod("DateFormat", function(value, element) {
            return value.match(/^dddd?-dd?-dd$/);
        },"Please enter date in yyyy-mm-dd format.");

        $(document).ready(function () {
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

        $.validator.addMethod("phone", function(value, element) {
            return  this.optional(element) || /^\+(?:[0-9] ?){6,14}[0-9]$/.test(value);
            }, "Please provide a valid phone number."
        );

        $('#create_user').validate({ // initialize the plugin
            rules: {
                'firstname' : {
                    required: true,
                    pattern : /^[a-zA-Z\s]+$/,
                    maxlength: 50
                },
                'lastname' : {
                    required: true,
                    pattern : /^[a-zA-Z\s]+$/,
                    maxlength: 50
                },
                'email': {
                    required: true,
                    maxlength: 100,
                    //email: true,
                    pattern : /^\b[a-z0-9._-]+@[a-z_.\-]+?\.[a-z]{2,4}\b$/i,
                    remote : {
                        url : '{{ route('admin.teachers.email.exist') }}',
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
                    minlength : 6,
                    maxlength : 30
                },
                'confirm_password' : {
                    equalTo : "#password"
                },
        		'status':{
                    required: true
                },
                'state' : {
                    required : true,
                    maxlength: 100
                },
                'city' : {
                    required : true,
                    maxlength: 100
                },
                'zipcode' : {
                    required : true,
                    maxlength: 10
                },
                'dob' : {
                    required : true ,
                    date: true  ,
                    //DateFormat : true
                },
                'address_line1' : {
                    required : true,
                    maxlength: 100
                },
                'address_line2' : {
                    required : true,
                    maxlength: 100
                },
                'contact_no' : {
                    required : true,
                    digits : true,
                    maxlength: 15
                },
            },
            messages: {
                firstname : {
                    required : "Please enter first name",
                    pattern : "Only alphabets are allowed",
                    maxlength: "Please enter maximum 50 characters"
                },
                lastname : {
                    required : "Please enter last name",
                    pattern : "Only alphabets are allowed",
                    maxlength: "Please enter maximum 50 characters"
                },
                email: {
                    required: "Please enter email",
                    pattern : 'Please enter a valid email',
                    remote : 'Email already exists',
                    maxlength: "Please enter maximum 100 characters"
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
                contact_no : {
                    required : "Please enter phone",
                    maxlength: "Please enter maximum 15 digits"
                },
                address_line1 : {
                    required : "Please enter street address",
                    maxlength: "Please enter maximum 100 characters"
                },
                address_line2 : {
                    required : "Please enter address line 2",
                    maxlength: "Please enter maximum 100 characters"
                },
                state : {
                    required : "Please enter state",
                    maxlength: "Please enter maximum 100 characters"
                },
                city : {
                    required : "Please enter city",
                    maxlength: "Please enter maximum 100 characters"
                },
                nationality : {
                    required : "Please select nationality"
                },
                country : {
                    required : "Please select country"
                },
                zipcode : {
                    required : "Please enter zip-code",
                    maxlength: "Please enter maximum 10 characters"
                },
                dob : {
                    required : "Please enter birth date"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "state") {
                    error.insertAfter("#state_name");
                }
                if (element.attr("name") == "img") {
                        error.insertAfter("#cimage");
                }
                else if (element.attr("name") == "birth_date") {
                    error.insertAfter("#datepicker-popup");
                }
                else{
                    error.insertAfter(element);
                }
            }
        })

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });

        $(document).on('change','#image', function () {
            var val = $("#image").val();
            if (!val.match(/(?:jpg|png|jpeg)$/)) {
                var errorHtml =  'Only jpg,jpeg, png files allowed.';
                $('#image-error').append(errorHtml);
            }
        })

        $(document).on('change','#image', function () {
            $("#image" ).rules( "add", {
                extension: "jpg,jpeg,png",
                messages: {
                    extension: "Only jpg,jpeg,png file allowed",
                }
            });
        });

    </script>
@endpush
@endsection
