@extends('layouts.app',['title'=> __('labels.stu_student_registration')])
@section('title', __('labels.stu_student_registration'))
@section('content')
<section class="register_sec">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 m-auto">
				<div class="register_inner">
                    {!! Form::model('registration', ['method' => 'POST',  'id'=>'registration','route' => ['students.register.store'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                    <div class="row justify-content-center">
                        <div class="col-xs-12 col-12">
                            <div class="custom_stepper">
                                <div class="strep_form_register">
                                    <div class="custom_form">
                                        <!--div class="steps">
                                            <ul role="tablist">
                                                <li role="tab" class="active" aria-disabled="false">
                                                    <a href="javascript:void()">
                                                        <span class="Number">1</span>
                                                    </a>
                                                    <span class="text">{{__('labels.stu_register')}}</span>
                                                </li>
                                                <li role="tab"  aria-disabled="true">
                                                    <a href="javascript:void()">
                                                        <span class="Number">2</span>

                                                    </a><span class="text">{{__('labels.stu_select')}}</span>
                                                </li>
                                                <li role="tab" aria-disabled="true">
                                                    <a href="javascript:void()"><span class="Number">3</span>
                                                    </a>
                                                    <span class="text">{{__('labels.stu_demo_lesson')}}</span>
                                                </li>
                                            </ul>
                                        </div-->

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
                                        <section class="mt-40">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="header_form">
                                                        <!--h3>{{ __('labels.stu_free_trial_lesson')}}</h3-->
                                                        <span>*{{ __('labels.stu_denotes_require')}} </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">{{ __('labels.stu_first_name')}} <span class="astric">*</span></label>
                                                        {!! Form::text('firstname', '', array('placeholder' =>  __('labels.stu_first_name') ,'class'=> 'form-control','id' => 'firstname','required'))!!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">{{ __('labels.stu_last_name')}}<span class="astric">*</span></label>
                                                        {!! Form::text('lastname', '', array('placeholder' =>  __('labels.stu_last_name'),'class'=> 'form-control','id' => 'lastname','required'))!!}
                                                    </div>
                                                </div>
                                            </div>
											@if(App::isLocale('jp'))
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="firstname">{{ __('labels.stu_first_name_ja')}}<span class="astric">*</span></label>
															{!! Form::text('firstname_ja', '', array('placeholder' =>  __('labels.stu_first_name_ja') ,'class'=> 'form-control','id' => 'firstname_ja','required'))!!}
															<label id="firstname_ja2-error" class="d-none" style="color:#f00" for="firstname_ja2">Only japanese is allowed.</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="lastname">{{ __('labels.stu_last_name_ja')}}<span class="astric">*</span></label>
															{!! Form::text('lastname_ja', '', array('placeholder' =>  __('labels.stu_last_name_ja'),'class'=> 'form-control','id' => 'lastname_ja','required'))!!}
															<label id="lastname_ja2-error" class="d-none" style="color:#f00" for="lastname_ja2">Only japanese is allowed.</label>
														</div>
													</div>
												</div>
											@endif
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">{{ __('labels.stu_email')}}<span class="astric">*</span></label>
                                                        {!! Form::text('email', '', array('placeholder' =>  __('labels.stu_email'),'class'=> 'form-control','id' => 'email'))!!}
                                                    </div>
                                                </div>
                                            </div>
											
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="referral_code">{{ __('labels.stu_level')}}</label>
                                                        
														{!! Form::select('stu_level',['Beginner', 'Intermediate', 'Advanced'],'', array('class'=>'form-control','id' => 'stu_level')) !!}
														
                                                    </div>
                                                </div>
                                            </div>
											
                                            <!--div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="password">{{ __('labels.stu_password')}}<span class="astric">*</span></label>
                                                        {!! Form::password('password', array('placeholder' =>  __('labels.stu_password'),'class'=> 'form-control','id' => 'password'))!!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="confirm_password">{{ __('labels.stu_confirm_pass')}}<span class="astric">*</span></label>
                                                        {!! Form::password('confirm_password',  array('placeholder' => __('labels.stu_confirm_pass'),'class'=> 'form-control','id' => 'confirm_password'))!!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="contact_no">{{ __('labels.stu_contact_num')}}<span class="astric">*</span></label>
                                                        {!! Form::text('contact_no', '', array('placeholder' => __('labels.stu_contact_num'),'class'=> 'form-control','id' => 'contact_no'))!!}
                                                    </div>
                                                </div>
                                            </div-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group captcha_text">
                                                        <label for="exampleInputEmail1">{{ __('labels.stu_captcha')}}</label>
                                                        {!! captcha_image_html('ExampleCaptcha') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('labels.stu_enter_captcha')}}<span class="astric">*</span></label>
                                                        {!! Form::text('captcha_code', '', array('placeholder' => __('labels.stu_enter_captcha'),'class'=> 'form-control','id' => 'captcha_code' ,'required'))!!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="checkcontainer">

                                                        {{ __('labels.stu_please_accept_our')}}
                                                        <a href="{{ url('terms-of-use') }}">{{ __('labels.home_terms_of_use')}}</a> &
                                                        <a href="{{ url('privacy-policy') }}">{{ __('labels.home_privacy_policy')}}</a>
                                                        <input type="checkbox" name="terms" id="terms">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn_sub">{{ __('labels.btn_register')}}</button>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="login_b">
                                                        {{ __('labels.stu_already_an_account')}}
                                                        <a href="{{ route('login') }}">
                                                            {{ __('labels.stu_login_here')}}
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
				</div>
			</div>
		</div>
    </div>

</section>
	@push('scripts')
	<script>
        var required = [];
        var equalTo = [];
        required.firstname = '{{ __("jsValidate.required.firstname") }}';
        required.lastname = '{{ __("jsValidate.required.lastname") }}';
        required.email = '{{ __("jsValidate.required.email") }}';
        //required.password = '{{ __("jsValidate.required.password") }}';
        //required.contact_no = '{{ __("jsValidate.required.contact_no") }}';
        //required.status = '{{ __("jsValidate.required.status") }}';
        required.terms = '{{ __("jsValidate.required.terms") }}';
        //equalTo.confirm_password = '{{ __("jsValidate.equalTo.confirm_password") }}';
        var existUrl = '{{ route('teachers.register.email.exist') }}';
	</script>
	<script src="{{ asset('js/student/register/index.js') }}"></script>

    <style>
        .checkcontainer {
            line-height: 32px;
        }
        a#ExampleCaptcha_SoundLink {
            display: none !important;
        }
    </style>
	
	@if(App::isLocale('jp'))
		<script type="text/javascript">
			$('#firstname_ja').keyup(function() {	
				var regex = /[\u3000-\u303F]|[\u3040-\u309F]|[\u30A0-\u30FF]|[\uFF00-\uFFEF]|[\u4E00-\u9FAF]|[\u2605-\u2606]|[\u2190-\u2195]|\u203B/g; 
				var input = $('#firstname_ja').val(); 
				if(!regex.test(input)) {
					$('#firstname_ja2-error').removeClass('d-none');
					$('#firstname_ja2-error').show();
					return false;
				} else {
					$('#firstname_ja2-error').addClass('d-none');
					$('#firstname_ja2-error').hide();
					return true;
				}
			});
			
			$('#lastname_ja').keyup(function() {	
				var regex = /[\u3000-\u303F]|[\u3040-\u309F]|[\u30A0-\u30FF]|[\uFF00-\uFFEF]|[\u4E00-\u9FAF]|[\u2605-\u2606]|[\u2190-\u2195]|\u203B/g; 
				var input = $('#lastname_ja').val(); 
				if(!regex.test(input)) {
					$('#lastname_ja2-error').removeClass('d-none');
					$('#lastname_ja2-error').show();
					return false;
				} else {
					$('#lastname_ja2-error').addClass('d-none');
					$('#lastname_ja2-error').hide();
					return true;
				}
			});
			
			$('#registration').submit(function() {	
				var regex = /[\u3000-\u303F]|[\u3040-\u309F]|[\u30A0-\u30FF]|[\uFF00-\uFFEF]|[\u4E00-\u9FAF]|[\u2605-\u2606]|[\u2190-\u2195]|\u203B/g; 
				var input = $('#firstname_ja').val(); 
				if(!regex.test(input)) {
					$('#firstname_ja2-error').removeClass('d-none');
					$('#firstname_ja2-error').show();
					return false;
				} else {			
					var input = $('#lastname_ja').val(); 
					if(!regex.test(input)) {
						$('#lastname_ja2-error').removeClass('d-none');
						$('#lastname_ja2-error').show();
						return false;
					} else {
						$('#lastname_ja2-error').addClass('d-none');
						$('#lastname_ja2-error').hide();
						return true;
					}
				}
			});
		</script>
	@endif
	
    @endpush

@endsection
