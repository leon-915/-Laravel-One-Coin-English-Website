@extends('layouts.app',['title'=> __('labels.stu_student_registration')])
@section('title', __('labels.stu_student_registration'))
@section('content')
<style>
</style>
<section class="register_sec techregister_two">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-12 col-md-12 m-auto">
				<div class="register_inner">
                    {!! Form::model('stepTwo', ['method' => 'POST',  'id'=>'stepTwo','route' => ['students.register.storeStepTwo'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <div class="row justify-content-center">
							<div class="col-12">
								<div class="custom_form">
                                    <div class="steps">
                                        <ul role="tablist">
                                            <li role="tab"  aria-disabled="false">
                                                <a href="javascript:void()">
                                                    <span class="Number">1</span>
                                                </a>
                                                <span class="text">{{__('labels.stu_register')}}</span>
                                            </li>
                                            <li role="tab" class="active" aria-disabled="true">
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
                                    </div>
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
                                    <section>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="header_form">
                                                    <h3 class="form_header">{{__('labels.stu_accent_schedule')}}</h3>
                                                    <span>{{__('labels.stu_supporting_language')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="row" id="services">
                                            <div class="col-12">
                                                <div class="title_step">
                                                    <label>{{__('labels.stu_step_1')}}<span class="astric">*</span></label>
                                                    <span>({{__('labels.stu_step_1_detail')}})</span>
                                                </div>
                                            </div>
                                            @foreach($services as $id => $value)
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="checkcontainer">
                                                        {{ Form::radio('service', $id , false, ['class'=>'form-control']) }}
                                                        {{$value}}
                                                        <span class="radiobtn"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="title_step">
                                                        <label>{{__('labels.stu_step_2')}}<span class="astric">*</span></label>
                                                        <span>({{__('labels.stu_step_2_detail')}})</span>
                                                    </div>
                                                    <div class="select cust">
                                                    {!! Form::select('teacher',[],'', array('placeholder' => __('labels.stu_step_2_detail'),'class'=>'form-control','id' => 'teacher')) !!}
                                                    </div>
                                                    <label id="teacher-error" class="error" for="teacher"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="title_step">
                                                        <label>{{__('labels.stu_step_3')}}<span class="astric">*</span></label>
                                                        <span>({{__('labels.stu_step_3_detail')}})</span>
                                                    </div>
                                                    <div class="select cust">
                                                    {!! Form::select('location',[],'', array('placeholder' => __('labels.select_location'),'form-control'=>'form-control','id' => 'location')) !!}
                                                    </div>
                                                    <label id="location-error" class="error" for="location"></label>
                                                </div>
                                            </div>
                                        </div>
                                       {{--  <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="title_step">
                                                        <label>Step 4 : Service <span class="astric">*</span></label>
                                                        <span>(Choose a Service.)</span>
                                                    </div>
                                                    <div class="select cust">
                                                    {!! Form::select('service',[],'',['id'=>'service','class'=>'form-control','placeholder' => 'Select Service']) !!}
                                                    </div>
                                                    <label id="service-error" class="error" for="service"></label>
                                                </div>
                                            </div>
                                        </div> --}}
                                            <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="title_step">
                                                        <label>{{__('labels.stu_step_4')}}<span class="astric">*</span></label>
                                                        <span>({{__('labels.stu_step_4_detail')}})</span>
                                                    </div>
                                                    {!! Form::text('reserve_date','',['id'=>'reserve_date','class'=>'form-control reserve_date','placeholder' => __('labels.select_date')]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" id="available_time">
                                                    <label for="exampleInputEmail1" class="grey">{{__('labels.time')}}<span class="astric">*</span></label>
                                                    <input type="hidden" name="time" id="time" class= 'form-control'>
                                                </div>
                                                <label id="time-error" class="error" for="time"></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="firstname">{{__('labels.stu_first_name')}}<span class="astric">*</span></label>
                                                    <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="emailHelp" placeholder="{{__('labels.stu_first_name')}}"
                                                    value = "{{!empty($student->firstname) ? $student->firstname : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="lastname">{{__('labels.stu_last_name')}}<span class="astric">*</span></label>
                                                    <input type="text" class="form-control" id="lastname"  name="lastname" aria-describedby="emailHelp" placeholder="{{__('labels.stu_last_name')}}" value = "{{!empty($student->lastname) ? $student->lastname : ''}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email">{{__('labels.stu_email')}}<span class="astric">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="{{__('labels.stu_email')}}" value = "{{!empty($student->email) ? $student->email : ''}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-none" id="skype-id-container">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="skype_id">{{__('labels.stu_skype_id')}}<span class="astric">*</span></label>
                                                    <input type="text" class="form-control" id="skype_id" name="skype_id"placeholder="{{__('labels.stu_skype_id')}}" value = "{{!empty($student->skype_name) ? $student->skype_name : ''}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="location-details-container">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="location_details">{{__('labels.stu_location_detail')}}<span class="astric">*</span></label>
                                                    <textarea name="location_details" id="location_details" class="form-control textarea_custom" placeholder="{{__('labels.stu_location_detail')}}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-right mt-3">
                                                 <input type="hidden" name="moveOn" value="Yes" />
                                                <button  role="menuitem" id="moveOn" class="btn_custon" >{{__('labels.btn_next')}}</button>
                                            </div>
                                        </div>
                                    </section>
								</div>
							</div>
					    </div>
                    {!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="skype_location_id" value="{{ env('SKYPE_LOCATION_ID') }}" />
	<input type="hidden" id="studio_location_id" value="{{ env('CLASSROOM_LOCATION_ID') }}" />
{{-- <div id="dialog-confirm" title="Ready?">
    <p>Are you sure?</p>
</div> --}}
</section>
	@push('scripts')
	<script>
	var required = [];
    var equalTo = [];

	var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var getLocationUrl = '{{ route('student.register.getLocations') }}';
    var setDatePickerUrl = '{{ route('student.register.setDatepicker') }}';
    var getServices = '{{ route('student.register.getServices') }}';
	required.session_style = '{{ __("jsValidate.required.session_style") }}';
	required.teacher = '{{ __("jsValidate.required.teacher") }}';
	required.reserve_date = '{{ __("jsValidate.required.reserve_date") }}';
	required.service = '{{ __("jsValidate.required.service") }}';
	required.location = '{{ __("jsValidate.required.location") }}';
	required.location_details = '{{ __("jsValidate.required.location_details") }}';
	required.time = '{{ __("jsValidate.required.time") }}';
	required.firstname = '{{ __("jsValidate.required.firstname") }}';
	required.lastname = '{{ __("jsValidate.required.lastname") }}';
    required.email = '{{ __("jsValidate.required.email") }}';
    var submitLables = "{{__('labels.do_you_want_to_submit')}}";
    var chooseTeacher = "{{__('labels.stu_step_2_detail')}}";
    var selectLocation = "{{__('labels.select_location')}}";

    <?php
        $upToMonth = \App\Models\Settings::getSettings('book_upto_month');
        $maxDate = date('Y-m-d', strtotime("+".$upToMonth." months"));
    ?>

    var vmaxDate = '<?= $maxDate ?>';

    </script>
    <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('js/student/register/stepTwo.js') }}"></script>
    @endpush

@endsection
