@extends('admin.layouts.admin',['title'=>'Edit Teacher'])

@section('title','Edit Teacher')

@section('content')
	<div class="content-wrapper">
	    <div class="page-header">
	        <h3 class="page-title"> Edit Teacher </h3>
	        <nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
	                <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Manage Teachers</a></li>
	                <li class="breadcrumb-item active" aria-current="page">Edit Teacher</li>
	            </ol>
	        </nav>
	    </div>
	    <div class="row grid-margin">
	    	<div class="col-lg-12">
	            <div class="card">
	                <div class="card-body">
	                    <h4 class="card-title">Edit Teacher</h4>

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

	                    {!! Form::model($teacher, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_user','route' => ['admin.teachers.update', $teacher->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        	@include('admin.teachers.form',['disable' => true,'form'=> 'edit'])
                        {!! Form::close() !!}

	                </div>
	            </div>
	        </div>
	    </div>
    </div>

    @push('scripts')
        <script>

            var counter = 0;
            var resize = $('#upload-demo').croppie({
                url:  $("#url").val(),
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
                },
                update: function() {
                    if(counter==0){
                        counter++;
                        jQuery('#upload-demo').croppie('setZoom', '0');
                    }

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

            /*$('#datepicker-popup').datepicker({
                format: "yy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
            });*/
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

            // jQuery.validator.addMethod("DateFormat", function(value, element) {
            //     return value.match(/^dddd?-dd?-dd$/);
            // },"Please enter date in yyyy-mm-dd format.");

            $(document).on('submit','#edit_user', function(e){
                var frm = $(this);
                resize.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (img) {
                    if($(".file-upload-info").val().length > 0){
                        $('input[name=image]').val(img);
                    }else{
                        $('input[name=image]').val('');
                    }

                    console.log(frm);
                    console.log(frm.valid());

                    if(!frm.valid()) return false;
                    //$('input[name=image]').val(img);
                    var data = new FormData($('#edit_user')[0]);
                    $.ajax({
                        url: "<?= route('admin.teachers.update',$teacher->id) ?>",
                        type: "POST",
                        data: data,
                        contentType: false,
                        cache: false,
                        processData:false,
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend:function(){
                            $('.el-loading').removeClass('d-none');
                        },
                        success: function (res) {
                            $('.el-loading').addClass('d-none');
                            if(res.type == 'success'){
                                window.location.href = res.redirect;
                            }
                        },error :function(res){
                            $('.el-loading').addClass('d-none');
                            $.each(res.responseJSON.errors,function(key, value){
                                $.toast({
                                    heading: 'Error',
                                    text: value,
                                    icon: 'error',
                                    position: 'top-right',
                                })
                            });
                        }
                    });
                });
                e.preventDefault();
            });

            $(document).on('change','select#country',function(e){
                e.preventDefault();
                if($(this).val().toLowerCase() == 'japan'){
                    $('.teaching_mode_jp_container').removeClass('d-none');
                    $('.teaching_mode_remote_container').addClass('d-none');
                    $('#teaching_mode_remote').children('input[type=checkbox]').prop("checked",false);
                    $( "input[name='teaching_locations[]']" ).rules( "add", {
                        required: true
                    });
                } else {
                    $('.teaching_mode_remote_container').removeClass('d-none');
                    $('.teaching_mode_jp_container').addClass('d-none');
                    $('.teaching_mode_jp').children('input[type=checkbox]').prop("checked",false);
                    $('input[type=checkbox].teacher_locations').prop("checked",false);
                    $( "input[name='teaching_locations[]']" ).rules("remove");
                }
            });

            $(document).ready(function() {
                //alert($( "#country option:selected" ).text());
                if($( "#country option:selected" ).text() == 'Japan'){
                    $('.teaching_mode_jp_container').removeClass('d-none');
                    $('.teaching_mode_remote_container').addClass('d-none');
                    $('#teaching_mode_remote').children('input[type=checkbox]').prop("checked",false);
                    $( "input[name='teaching_locations[]']" ).rules( "add", {
                        required: true
                    });
                } else {
                    $('.teaching_mode_remote_container').removeClass('d-none');
                    $('.teaching_mode_jp_container').addClass('d-none');
                    $('.teaching_mode_jp').children('input[type=checkbox]').prop("checked",false);
                    $('input[type=checkbox].teacher_locations').prop("checked",false);
                    $( "input[name='teaching_locations[]']" ).rules("remove");
                }

                if($('#is_remote_teaching').prop("checked") == true){
                    $('#skype_container').removeClass('d-none');
                    $("#skype_id").rules( "add", { required: true });
                    $('#internet_link_container').removeClass('d-none');
                }else{
                    $('#skype_container').addClass('d-none');
                    $("#skype_id").rules("remove");
                    $('#internet_link_container').addClass('d-none');
                }

            });

            $(document).on("keyup", "#myInput",function() {
                var value = this.value.toLowerCase().trim();
                $(".register-locations label").show().filter(function() {
                    return $(this).data('text').toLowerCase().trim().indexOf(value) == -1;
                }).hide();
            });

            $(document).on('change','#image', function () {
                var val = $("#image").val();
                if (!val.match(/(?:jpg|png|jpeg)$/)) {
                    var errorHtml =  'Only jpg,jpeg, png files allowed.';
                    $('#image-error').append(errorHtml);
                }
            })

            $('.file-upload-browse').on('click', function() {
                $('#image').trigger('click');
            });

            $('#image').on('change', function() {
                $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });

            $(document).on('change','#audio_attachment', function () {
                $("#audio_attachment" ).rules( "add", {
                    extension: "mp4|mp3",
                    messages: {
                        extension: "Only Mp4, Mp3 file allowed",
                    }
                });
            });
			
			$('#video').on('change', function () {
				$(this).rules( "add", {
					extension: "mp4",
					messages: {
						extension: "Only mp4 file allowed.",
					}
				});
			});


            $.validator.addMethod("phone", function(value, element) {
                return  this.optional(element) || /^\+(?:[0-9] ?){6,14}[0-9]$/.test(value);
                }, "Please provide a valid phone number."
            );


            $('#edit_user').validate({ // initialize the plugin
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
                  /*  'email': {
                        required: true,
                        // email: true,
                        pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                        remote: {
                            url: '{{ route('admin.teachers.email.exist') }}',
                            type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                email : function () {
                                    return $('#email').val();
                                },
                                user_id : function () {
                                    return '{{$teacher->id}}';
                                },
                                success: function (response) {
                                    // console.log(response);
                                }
                            }

                        }
                    },*/
                    'paypal_email':{
                        pattern : /^\b[a-z0-9._-]+@[a-z_.\-]+?\.[a-z]{2,4}\b$/i,
                    },
                    'status':{
                        required: true
                    },
                    /*'state' : {
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
                    'address_line2' : {
                        required : true,
                        maxlength: 100
                    },*/
                    'country' : {
                        required : true
                    },
                    'address_line1' : {
                        required : true,
                        maxlength: 100
                    },
                    'hobby' : {
                        required : true,
                        maxlength: 100
                    },
                    // 'skype_id' : {
                    //     required : true
                    // },
                    'major_subject' : {
                        required : true,
                        maxlength: 100
                    },
                    'global_lesson_price' : {
                        required : true,
                        //range: [0, parseInt($('#max_global').val()],
                        number: true,
                        /*max : function () {
                            return parseInt($('#max_global').val());
                        }*/

                    },
                    'japanese_ability' : {
                        required : true
                    },
                    'teaching_certificate[]' : {
                        required : true
                    },
                    'lesson_minute_able_to_teach[]' : {
                        required : true
                    },
                   'internet_connection_speed_link' : {
                        // required: true,
                        url: true
                    },
                    'freshbook_api_url' : {
                        // required: true,
                        url: true
                    },
                    'teaching_year_begun' : {
                        required : true,
                        digits: true,
                        maxlength: 4
                    },
                    // 'jplt_score' : {
                    //     required : true
                    // },
                    'dob' : {
                        required : true ,
                        //date: true  ,
                        //DateFormat : true
                    },
                    'virtual_lesson_percentage' : {
                       range: [0, 100],
                        max: function () {
                            return parseInt($('#max_virtual').val());
                        }
                    },
                    'cafe_lesson_percentage' : {
                        range: [0, 100],
                        max: function () {
                            return parseInt($('#max_cafe').val());
                        }
                    },
                    'classroom_lesson_percentage' : {
                        range: [0, 100],
                        max: function () {
                            return parseInt($('#max_classroom').val());
                        }
                    },
                    'contact_no' : {
                        required : true,
                        phone: true
                    },
                    'message_jp' :{
                        maxlength: 800
                    },
                    'message_en' :{
                        maxlength: 800
                    }
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
                        remote : 'Email already exists'
                    },
                    paypal_email:{
                        pattern : "Please enter a valid email",
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
                    /*address_line2 : {
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
					zipcode : {
                        required : "Please enter zip-code",
                        maxlength: "Please enter maximum 10 characters"
                    },*/                    
                    hobby : {
                        required : "Please enter hobby",
                        maxlength: "Please enter maximum 100 characters"
                    },
                    japanese_ability : {
                        required : "Please select japanese ability"
                    },
                    global_lesson_price : {
                        required : "Please enter global lesson price"
                    },
                    major_subject : {
                        required : "Please enter major subject"
                    },
                    'teaching_certificate[]' : {
                        required : "Please select teaching certificate."
                    },
                    'lesson_minute_able_to_teach[]' : {
                        required : "Please select lesson duration able to teach."
                    },
                    teaching_year_begun : {
                        required : "Please enter year teaching began",
                        digits: "Only digits are allowed",
                        maxlength: "Please enter maximum 4 digits"
                    },
                    per_hour_salary : {
                        required : "Please enter per hour salary."
                    },
                    jplt_score : {
                        required : "Please enter jplt score"
                    },
                    internet_connection_speed_link : {
                        required : "Please enter internet connection speed"
                    },
                    nationality : {
                        required : "Please select nationality"
                    },
                    country : {
                        required : "Please select country"
                    },
                    skype_id : {
                        required : "Please enter skype id",
                        digits: "Only digits are allowed",
                        maxlength: "Please enter maximum 6 digits"
                    },
                    dob : {
                        required : "Please select birth date"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "state") {
                        error.insertAfter("#state_name");
                    }else if (element.attr("name") == "dob") {
                        error.insertAfter("#datepicker-popup");
                    }else{
                        error.insertAfter(element);
                    }
                }
            })

            $(document).on('change', 'input[name=japanese_ability]', function(e){
                e.preventDefault();
                let checked =  $(this).val();
                console.log(checked);
                if(checked == 'jplt_score'){
                    $('#jplt_score_container').removeClass('d-none');
                    $("#jplt_score").rules( "add", { required: true });
                } else {
                    $('#jplt_score_container').addClass('d-none');
                    $("#jplt_score").rules( "remove" );
                }
            });
			
			$(document).on('change', 'input[name=is_ambassador]', function(e){
                e.preventDefault();
                if($(this).prop("checked") == true){
                    $('#per_hour_salary').addClass('d-none');
                    $("#per_hour_salary").rules( "remove" );
                } else {
                    $('#per_hour_salary').removeClass('d-none');
                    $("#per_hour_salary").rules( "add", { required: true } );
                }
            });

            $(document).on('change', '#is_remote_teaching', function(e){
                e.preventDefault();
                if($(this).prop("checked") == true){
                    //let checked =  $(this).val();
                   // alert(checked);
                    $('#skype_container').removeClass('d-none');
                    $("#skype_id").rules( "add", { required: true });
                    $('#internet_link_container').removeClass('d-none');
                }else{
                    $('#skype_container').addClass('d-none');
                    $("#skype_id").rules("remove");
                    $('#internet_link_container').addClass('d-none');
                }
            });
        </script>
		
		<script type="text/javascript">
		var placeSearch, autocomplete;

		function initAutocomplete() {
		  // Create the autocomplete object, restricting the search predictions to
		  // geographical location types.
		  autocomplete = new google.maps.places.Autocomplete(
			  document.getElementById('address_line1'), {types: ['geocode']});

		}


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqxjEfLVCgHXTLHfwcbEqSjk3cmzqc6ME&libraries=places&callback=initAutocomplete" async defer></script>
    @endpush
@endsection
