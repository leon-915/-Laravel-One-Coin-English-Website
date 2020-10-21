@extends('layouts.app',['title'=> __('labels.stu_head_profile')])
@section('title', __('labels.stu_head_profile'))
@section('content')


<style>
    .container {
        margin: 0 auto;
    }

    .lp-profile {
        width: 100%;
    }
    
    .lp-profile .container {
        max-width: 970px;
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 100%;
            width: 100%;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .col-md-7 {
            -ms-flex: 0 0 70%;
            flex: 0 0 70%;
            max-width: 70%;
            width: 70%;
        }

        .col-md-5 {
            -ms-flex: 0 0 30%;
            flex: 0 0 30%;
            max-width: 30%;
            width: 30%;
        }
    }
</style>

<div class="lp-profile l-profile">
    <div class="container">
        <div class="row graphics">
            <div class="col-md-6">
                <div class="graphic">
                    <img src="{{ asset('images/chart.png') }}">
                </div>
                <p>Sessions</p>
            </div>

            <div class="col-md-6">
                <div class="graphic">
                    <img src="{{ asset('images/chart.png') }}">
                </div>
                <p>Star Ratings</p>
            </div>              
        </div>

        <div class="accordion">
            <button class="collapsible-3">
                Personal Details
                <img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
                <img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
            </button>
            
            <div class="accordion-content">
                <div class="inner-content">
					 {!! Form::model('profile', ['method' => 'POST',  'id'=>'profile','route' => ['students.profile.update'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                    <div class="row">

                        <div class="col-md-7 padding-2">
                            <div>
								<?php
									$image = asset('images/default.png');
									if(!empty($user->profile_image)){
										$image = asset($user->profile_image);
									}

								?>
                                <div id="upload-demo"></div>
									<label id="croppie-image-upload">
										<input type="file" id="image"  data-default-file="{{ $image }}" style="display: none">
										<div class="input-group col-xs-12">
											<input class="form-control file-upload-info" disabled="" placeholder="Upload Image" type="text">
											<span class="input-group-append file-upload-browse">
												<button class="freetrial_btn" type="button">Select Image</button>
											</span>
										</div>
										<label id="image-error" class="error d-none" for="image"></label>
										<input type="hidden" name="image">
										<input type="hidden" id="url" value="{{$image}}">
									</label>

								<div class="btn-container">
									<button class="btn-save">Save</button>
								</div>

                                <div class="profile-data">
                                    <div class="table-row">
                                        <div class="left table-cell">Nickname</div>
                                        <div class="right table-cell">
                                            <input type="text" value="{{$user->nickname}}" name="nickname" placeholder="Enter Nickname">
                                        </div>
                                    </div>

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">*</font>Nationality</div>
                                        <div class="right table-cell">
                                            {!!
												Form::select(
													'nationality',
													$countries,
													$student->nationality,
													array(
														'class' 		=> '',
														'placeholder' 	=> 'Select Nationality',
														"data-plugin" 	=> "selectpicker",
														"id" 			=> "nationality",
														"required" 		=> "true"
													)
												)
											!!}
                                        </div>
                                    </div>

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">*</font>First Name</div>
                                        <div class="right table-cell">
											{!! Form::text('firstname', $user->firstname, array('placeholder' =>  __('labels.stu_first_name') ,'class'=> '','id' => 'firstname'))!!}
                                        </div>
                                    </div>

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">*</font>Last Name</div>
                                        <div class="right table-cell">
											{!! Form::text('lastname', $user->lastname, array('placeholder' =>  __('labels.stu_last_name'),'class'=> '','id' => 'lastname'))!!}
                                        </div>
                                    </div>

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">*</font>Gender</div>
                                        <div class="right table-cell">
                                            
											<label class="radio-container">Male
											  <!--input type="radio" checked="checked" name="radio"-->
											  <input type="radio" {{$user->gender == '' || $user->gender == 'male' ? 'checked' : ''}} name="gender" value="male">
											  <span class="checkmark"></span>
											</label>
											<label class="radio-container">Female
											  <!--input type="radio" name="radio"-->
											  <input type="radio" {{$user->gender == 'female' ? 'checked' : ''}} name="gender" value="female">
											  <span class="checkmark"></span>
											</label>

                                        </div>
                                    </div>

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">**</font>Date of Birth</div>
                                        <div class="right table-cell">
                                            <input type="text" placeholder="Select Date from Date Picker" class="" id="dob" name="dob" value="{{$user->dob}}">
                                        </div>
                                    </div>

                                    <!--div class="table-row">
                                        <div class="left table-cell"><font color="red">**</font>Email</div>
                                        <div class="right table-cell">
                                            <input type="text" name="" placeholder="Enter Email">
                                        </div>
                                    </div-->

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">**</font>Reside in Japan</div>
                                        <div class="right table-cell line-height-1">
                                            @foreach($japanese_resident as $key => $resident)
												@php
													$checkedA = ($key == $user->japanese_resident) ? 'checked' : '';
												@endphp
												<label class="radio-container mt-5 mb-5">{{ $resident }}
													<input type="radio" name="japanese_resident" {{ $checkedA }} value="<?php echo $key; ?>">													
													<span class="checkmark"></span>
												</label>
											@endforeach
											<?php
											$hide_address_line_div = 'd-none';
											if($user->japanese_resident == 0) {
												$hide_address_line_div = '';
											}
											?>

                                            <div id="address_line_div" class="mb-5 <?php echo $hide_address_line_div;?>">
												<!--input type="text" name="" class="placeholder-8" placeholder="If no Search Country"-->
												<input type="text" placeholder="If no Search Country" name="address_line1" value="{{$user->address_line1}}" id="autocomplete" class="placeholder-8" required="">
											</div>
                                        </div>
                                    </div>

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">*</font>Occupation</div>
                                        <div class="right table-cell line-height-1">
                                            <input type="text" placeholder="Occupation" class="" name="occupation" id="occupation" value="{{$user->occupation}}">
                                            <input type="text" name="" class="placeholder-8" placeholder="If Occuption is Student then this field appears to Search Studies">
                                        </div>
                                    </div>

                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">*</font>Topic Specializtion</div>
                                        <div class="right table-cell">
                                            @foreach($conversation_topic as $ckey => $topic)
												@php
													$checkedC = in_array($ckey, explode(',', $user->conversation_topic)) ? 'checked' : '';
												@endphp
												<label class="checkcontainer">
													{{ $topic }}
													<input class="conversation_topic" type="checkbox" name="conversation_topic[]" {{ $checkedC }}  value="<?= $ckey ?>">
													<span class="checkmark"></span>
												</label>
											@endforeach
                                        </div>
                                    </div>
									<?php
									if($student->speaking_level != '') {
										$speaking_level1 = $student->speaking_level;
									} else {
										$speaking_level1 = '';
									}
									?>
                                    <div class="table-row">
                                        <div class="left table-cell"><font color="red">*</font>English Level</div>
                                        <div class="right table-cell">
                                            @foreach($speaking_level as $key => $value)
												@php
													$checkedA = ($key == $speaking_level1 || $key == 1) ? 'checked' : '';
												@endphp
												<label class="radio-container">{{ $value }}
													<input type="radio" name="speaking_level1" {{$checkedA}} value="<?php echo $key; ?>">													
													<span class="checkmark"></span>
												</label>
											@endforeach
                                        </div>
                                    </div>

                                    <div class="required-desc">
                                        <p><font color="red">*Required</font></p>
                                        <p><font color="red">**Required / Not Shared with Language Partner</font></p>
                                    </div>

                                </div>  
                            </div>
                        </div>
                        
                        <div class="col-md-5 padding-2">
                            <div class="audio-upload upload-section">
                                <textarea class="desc" name="message_en" rows="2" placeholder="*Please write an appealing introduction message for your Learners.  [ Min. 50 / Max. 120 words]"></textarea>
                            </div>
                        </div>
                    </div>
					{!! Form::close() !!}
                </div>
            </div>
            
            <button class="collapsible-3">
                Lesson Records
                <img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
                <img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
            </button>
            
            <div class="accordion-content">
                content
            </div>
            
            <button class="collapsible-3">
                Reviews
                <img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
                <img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
            </button>
            
            <div class="accordion-content">
                content
            </div>

            <button class="collapsible-3">
                Referral
                <img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
                <img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
            </button>
            
            <div class="accordion-content">
                content
            </div>

            <button class="collapsible-3">
                Settings
                <img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
                <img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
            </button>
            
            <div class="accordion-content">
                content
            </div>

        </div>
        
        <script>
            var coll_3 = document.getElementsByClassName("collapsible-3");
            var i;

            for (i = 0; i < coll_3.length; i++) {
                coll_3[i].addEventListener("click", function() {
                    console.log(this.classList['value']);

                    if( (this.classList['value']).indexOf("active") >= 0 ) {
                        this.classList.remove("active");
                        
                        var content = this.nextElementSibling;
                        content.style.maxHeight = null;
                    } else {

                        for (var j = 0; j < coll_3.length; j++) {
                        
                            coll_3[j].classList.remove("active");

                            var content = coll_3[j].nextElementSibling;
                            content.style.maxHeight = null;
                        }

                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            }

            // Tab
            function openTab2(tabName) {
                var i;
                var x = document.getElementsByClassName("tab-content");
                
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";  
                }
                
                document.getElementById(tabName).style.display = "block";  
            }

            $(".lp-profile .image-upload .tab").on("click", function() {
                $(".lp-profile .image-upload .tab").removeClass("active");
                $(this).addClass("active");
            })
        </script>
    </div>
</div>



    @push('scripts')
        <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

        <script>
            var required = [];
            var equalTo = [];
            required.firstname = '{{ __("jsValidate.required.firstname") }}';
            required.lastname = '{{ __("jsValidate.required.lastname") }}';
            required.email = '{{ __("jsValidate.required.email") }}';
            required.password = '{{ __("jsValidate.required.password") }}';
            required.contact_no = '{{ __("jsValidate.required.contact_no") }}';
            required.status = '{{ __("jsValidate.required.status") }}';
            required.terms = '{{ __("jsValidate.required.terms") }}';
            equalTo.confirm_password = '{{ __("jsValidate.equalTo.confirm_password") }}';
			
			let Url = '{{ route('students.profile.update') }}';
			
        </script>
        <script src="{{ asset('js/student/profile/index.js') }}"></script>

        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter : 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif


        <script>
            
            $('#refer_earn_reward').validate({
                ignore: "",
                rules: {
                    email: {
                        required: true,
                    },

                },
                messages: {
                    email: {
                        required: "{{__('jsValidate.required.email')}}"
                    },
                }
            });

            $('#share_gift_point').validate({
                ignore: "",
                rules: {
                    email: {
                        required: true,
                        maxlength:70
                    },
                    amount: {
                        required: true,
                        number:true,
                        maxlength:6
                    },
                },
                messages: {
                    email: {
                        required: "{{__('jsValidate.required.email')}}",
                        maxlength:"{{__('jsValidate.required.valid_length')}}"
                    },
                    amount: {
                        required: "{{__('jsValidate.required.amount')}}",
                        number:"{{__('jsValidate.required.numeric_value')}}",
                    },
                }
            });
            
            <?php
                $lastID = 0;
                if(isset($emails) && (!($emails->isEmpty()))){
                    $total = count($emails);
                    $lastID = $emails[$total - 1]['id'];
                }
            ?>

        

        optionAction = {
            inx : {{ (isset($emails)) ? ($lastID+1) : 1 }},
            mchtml : <?= json_encode(View::make('students.profile.email.form')->render()) ?>,
            addOption : function(){
                var type = $('#question_type').val();
                
                $('#email-container').append(this.mchtml.replace(/{inx}/g, this.inx));
                $('#title-'+this.inx).rules("add", {
                    pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                    messages: {
                        pattern: "{{__('jsValidate.required.valid_email')}}"
                    }
                });
                this.inx++;

                
            },
            removeOption : function(dis){
                var i = $(dis).data('id');
                $('#email-'+i).remove();
                //this.inx--;
            }
        }

        

        $(document).ready(function() {
            $("#frm_share_record").validate();
            $('input[data-email]').each(function (index, value) {
                var id=$(value).attr('id');
                //console.log($("input#"+id));
                console.log(id);
                $(value).rules( "remove" );
                $(value).rules("add", {
                    pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                    messages: {
                        pattern: "{{__('jsValidate.required.valid_email')}}"
                    }
                });
            });
        });
        </script>
		
		<script type="text/javascript">
		var setLineNotificationFlag = '{{ route('setLineNotificationFlag') }}';
        $(document).ready(function(){
            $('#disable_lineNotification').on('click',function(){
                let user_id = $(this).val(),
                csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: setLineNotificationFlag,
                    type: 'POST',
                    data: { user_id : user_id, data_to_update : 0 },
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    beforeSend:function(){
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.app-loader').addClass('d-none');
                        //$('#qrModal').modal('hide');
                        $.toast({
                            heading: 'Success',
                            text: "Line notification status saved successfully",
                            icon: 'success',
                            position: 'top-right',
                        })
                    }
                });
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });
		
		$('#dob').datepicker({
			dateFormat: "yy-mm-dd",
			maxDate: '-1d',
			changeMonth: true,
			changeYear: true,
			yearRange: "-150:+0",
		});
		
		$(document).on('change', 'input[name=japanese_resident]', function(e){
			e.preventDefault();
			let checked =  $(this).val();
			console.log(checked);
			if(checked == '1'){
				$('#address_line_div').addClass('d-none');
				$("#address_line1").rules( "remove" );
			} else {
				$('#address_line_div').removeClass('d-none');
				$("#address_line1").rules( "add", { required: true });
			}
		});
    </script>
	
	<script type="text/javascript">
		var placeSearch, autocomplete;

		function initAutocomplete() {
		  // Create the autocomplete object, restricting the search predictions to
		  // geographical location types.
		  autocomplete = new google.maps.places.Autocomplete(
			  document.getElementById('autocomplete'), {types: ['geocode']});

		}


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqxjEfLVCgHXTLHfwcbEqSjk3cmzqc6ME&libraries=places&callback=initAutocomplete" async defer></script>
    @endpush
@endsection
