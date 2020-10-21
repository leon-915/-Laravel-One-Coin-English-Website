<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="book_before_time">{{ __('labels.book_before_time') }}</label>

        <input type="hidden" name="id" value="{{!empty($settings->id) ? $settings->id : ''}}">
        {!! Form::text('book_before_time', isset($settings->book_before_time) ? $settings->book_before_time : '', array('placeholder' => 'Book Before Hours','class'=> 'form-control','id' => 'book_before_time'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="cancel_before_time">{{ __('labels.cancel_before_time') }}</label>
        {!! Form::text('cancel_before_time', isset($settings->cancel_before_time) ? $settings->cancel_before_time : '', array('placeholder' => 'Cancel Before Hours','class'=> 'form-control','id' => 'cancel_before_time'))!!}
    </div>
</div>

<!--div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="max_globle_lesson_price">{{ __('labels.max_globle_lesson_price') }}</label>
        {!! Form::text('max_globle_lesson_price', isset($settings->max_globle_lesson_price) ? $settings->max_globle_lesson_price : '', array('placeholder' => 'Max Globle Lesson rice','class'=> 'form-control','id' => 'max_globle_lesson_price'))!!}
    </div>
</div-->

<div class="row">
    <div class="form-group col-md-9">
        <lable><b>{{__('admin_labels.manage_teacher_lesson_price')}}</b></lable>
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="max_price_upto_2_year">{{ __('admin_labels.max_price_upto_2_year_experience') }}</label>
        {!! Form::text('max_price_upto_2_year', isset($settings->max_price_upto_2_year) ? $settings->max_price_upto_2_year : '', array('placeholder' => 'Max price upto 2 year experience','class'=> 'form-control','id' => 'max_price_upto_2_year'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="max_price_upto_4_year">{{ __('admin_labels.max_price_upto_4_year_experience') }}</label>
        {!! Form::text('max_price_upto_4_year', isset($settings->max_price_upto_4_year) ? $settings->max_price_upto_4_year : '', array('placeholder' => 'Max price upto 2 year experience','class'=> 'form-control','id' => 'max_price_upto_4_year'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="max_price_above_4_year">{{ __('admin_labels.max_price_above_4_year_experience') }}</label>
        {!! Form::text('max_price_above_4_year', isset($settings->max_price_above_4_year) ? $settings->max_price_above_4_year : '', array('placeholder' => 'Max price upto 2 year experience','class'=> 'form-control','id' => 'max_price_above_4_year'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="kids_lesson_max_price">{{ __('admin_labels.kids_lesson_max_price') }}</label>
        {!! Form::text('kids_lesson_max_price', isset($settings->kids_lesson_max_price) ? $settings->kids_lesson_max_price : '', array('placeholder' => 'Kids lesson max price','class'=> 'form-control','id' => 'kids_lesson_max_price'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="aspire_lesson_max_price">{{ __('admin_labels.aspire_lesson_max_price') }}</label>
        {!! Form::text('aspire_lesson_max_price', isset($settings->aspire_lesson_max_price) ? $settings->aspire_lesson_max_price : '', array('placeholder' => 'Aspire lesson max price','class'=> 'form-control','id' => 'aspire_lesson_max_price'))!!}
    </div>
</div>

<!--div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="max_classroom_lesson_price_per">{{ __('labels.max_classroom_lesson_price_per') }}</label>
        <div id="class-room-lesson-range" class="ul-slider slider-success"></div>
        <p class="mt-3">Value: <span id="class-room-lesson-value"></span> %</p>
        <input type="hidden" name="max_classroom_lesson_price_per" id="max_classroom_lesson_price_per">
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="max_vertual_lesson_price_per">{{ __('labels.max_vertual_lesson_price_per') }}</label>
        <div id="vertual-lesson-range" class="ul-slider slider-success"></div>
        <p class="mt-3">Value: <span id="vertual-lesson-value"></span> %</p>
        <input type="hidden" name="max_vertual_lesson_price_per" id="max_vertual_lesson_price_per">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="max_cafe_lesson_price_per">{{ __('labels.max_cafe_lesson_price_per') }}</label>
        <div id="cafe-lesson-range" class="ul-slider slider-success"></div>
        <p class="mt-3">Value: <span id="cafe-lesson-value"></span> %</p>
        <input type="hidden" name="max_cafe_lesson_price_per" id="max_cafe_lesson_price_per">
    </div>
</div-->

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="admin_commision">{{ __('labels.admin_commision') }}</label>
        <div id="admin-commision-range" class="ul-slider slider-success"></div>
        <p class="mt-3">Value: <span id="admin-commision-value"></span> %</p>
        <input type="hidden" name="admin_commision" id="admin_commision">
    </div>
</div>


<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="student_referred_admin_commision">{{ __('labels.student_referred_admin_commision') }}</label>
        <div id="student-referred-admin-commision-range" class="ul-slider slider-success"></div>
        <p class="mt-3">Value: <span id="student-referred-admin-commision-value"></span> %</p>
        <input type="hidden" name="student_referred_admin_commision" id="student_referred_admin_commision">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mb-4"
               for="regular_course_rollover_precentage">{{ __('labels.regular_course_rollover_precentage') }}</label>
        <div id="regular-course-rollover-precentage-range" class="ul-slider slider-success"></div>
        <p class="mt-3">Value: <span id="regular-course-rollover-precentage-value"></span> %</p>
        <input type="hidden" name="regular_course_rollover_precentage" id="regular_course_rollover_precentage">
    </div>
</div>


<div class="row">
    <div class="form-group col-md-9">
        <lable><b>{{__('admin_labels.manage_trial_lesson_settings')}}</b></lable>
    </div>
</div>

<div id="kids_lesson_price_div" class="row">
   <div class="form-group col-md-12">
		<label class="form-control-label" for="allowed_trial_lessons">{{ __('admin_labels.allowed_trail_lessons')}}</label>
		<div>
			<input type="range" class="range_slide" style="width:75%;" min="1" max="10" step="1" value="{{($settings->allowed_trial_lessons) ? $settings->allowed_trial_lessons : 1}}" onchange="changePercentageGlobal(this)" id="allowed_trial_lessons" name="allowed_trial_lessons" step="1" value="{{($settings->allowed_trial_lessons) ? $settings->allowed_trial_lessons : 1}}">
		</div>
		<div class="value" id="allowed_trial_lessons_val">  {{($settings->allowed_trial_lessons)? $settings->allowed_trial_lessons : 1}}</div>
	</div>
</div>

<div class="row">
   <div class="form-group col-md-12">
		<label class="form-control-label" for="allowed_trial_lessons_period">{{ __('admin_labels.allowed_trial_lessons_period')}}</label>
		<div>
			<input type="range" class="range_slide" style="width:75%;" min="1" max="10" step="1" value="{{($settings->allowed_trial_lessons_period) ? $settings->allowed_trial_lessons_period : 1}}" onchange="changePercentageGlobal(this)" id="allowed_trial_lessons_period" name="allowed_trial_lessons_period" step="1" value="{{($settings->allowed_trial_lessons_period) ? $settings->allowed_trial_lessons_period : 1}}">
		</div>
		<div class="value" id="allowed_trial_lessons_period_val">  {{($settings->allowed_trial_lessons_period)? $settings->allowed_trial_lessons_period : 1}}</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-md-2">
		<div class="form-check form-check-primary">
			<label class="form-check-label">
				<input type="checkbox" name="reset_trial_lessons" value="yes"
					   <?php echo !empty($settings->reset_trial_lessons) && $settings->reset_trial_lessons == 'yes' ? 'checked' : ''?> class="form-check-input">
				{{ __('admin_labels.reset_trial_lessons') }}
				<i class="input-helper"></i>
			</label>
		</div>
	</div>	
</div>

<hr>
<div class="row">
    <div class="form-group col-md-9">
        <lable><b>{{__('labels.manage_schedule_available_time')}}</b></lable>
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label " for="start_time">{{ __('labels.start_time') }}</label>
        {!! Form::text('start_time', isset($settings->start_time) ? date("H:i", strtotime($settings->start_time)): '', array('placeholder' => 'Start Time','class'=> 'form-control timepicker','id' => 'start_time'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="end_time">{{ __('labels.end_time') }}</label>
        {!! Form::text('end_time', isset($settings->end_time) ? date("H:i", strtotime($settings->end_time)) : '', array('placeholder' => 'End Time','class'=> 'form-control timepicker','id' => 'end_time'))!!}
    </div>
</div>

<hr>
<div class="row">
    <div class="form-group col-md-9">
        <lable><b>{{__('labels.general_setting')}}</b></lable>
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="site_title">{{ __('labels.site_title') }}</label>
        {!! Form::text('site_title', isset($settings->site_title) ? $settings->site_title : '', array('placeholder' => 'Site Title','class'=> 'form-control','id' => 'site_title'))!!}
    </div>
</div>

{{-- <div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="email_address">{{ __('labels.email_address') }}</label>
        {!! Form::email('email_address', isset($settings->email_address) ? $settings->email_address : '', array('placeholder' => 'E-Mail Address','class'=> 'form-control','id' => 'email_address'))!!}
    </div>
</div> --}}

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="from_email">From Email</label>
        {!! Form::email('from_email', isset($settings->from_email) ? $settings->from_email : '', array('placeholder' => 'E-Mail Address','class'=> 'form-control','id' => 'from_email'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="to_email">To Email</label>
        {!! Form::email('to_email', isset($settings->to_email) ? $settings->to_email : '', array('placeholder' => 'E-Mail Address','class'=> 'form-control','id' => 'to_email'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="onepage_certified_fee">{{ __('labels.onepage_certified_fee') }}</label>
        {!! Form::text('onepage_certified_fee', isset($onepageFee->price) ? $onepageFee->price : 0, array('placeholder' => 'Onepage Certified Fee','class'=> 'form-control','id' => 'onepage_certified_fee'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="registration_fee">{{ __('Registration Fee') }}</label>
        {!! Form::text('registration_fee', isset($registrationFee->price) ? $registrationFee->price : 0, array('placeholder' => 'Registration Fee','class'=> 'form-control','id' => 'registration_fee'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="onepage_certified_fee">{{ __('Tax(%)') }}</label>
        {!! Form::text('tax', isset($settings->tax) ? $settings->tax : '', array('placeholder' => 'Tax','class'=> 'form-control','id' => 'tax'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4 ">
        <lable class="form-control-label" for="default_payment_getway">{{ __('labels.default_payment_getway') }}</lable>
    </div>
</div>

<div class="form-group row">
    <?php /*
    <div class="form-group col-md-2">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" name="default_payment_getway[]" value="stripe"
                       <?= (!empty($settings->default_payment_getway) && in_array("stripe", $settings->default_payment_getway)) ? 'checked' : ''?> class="form-check-input">
                {{ __('labels.stripe') }}
                <i class="input-helper"></i>
            </label>
        </div>
    </div> */ ?>

    <div class="form-group col-md-2">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" name="default_payment_getway[]" value="paypal"
                       <?= (!empty($settings->default_payment_getway) && in_array("paypal", $settings->default_payment_getway)) ? 'checked' : ''?> class="form-check-input">
                {{ __('labels.paypal') }}
                <i class="input-helper"></i>
            </label>
        </div>
    </div>
	
	<div class="form-group col-md-2">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" name="default_payment_getway[]" value="direct_bank_transfer"
                       <?= (!empty($settings->default_payment_getway) && in_array("direct_bank_transfer", $settings->default_payment_getway)) ? 'checked' : ''?> class="form-check-input">
                {{ __('labels.direct_bank_transfer') }}
                <i class="input-helper"></i>
            </label>
        </div>
    </div>
	
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="asana_access_token">{{ __('labels.asana_access_token') }}</label>
        {!! Form::text('asana_access_token', isset($settings->asana_access_token) ? $settings->asana_access_token : '', array('placeholder' => 'Asana Access Token','class'=> 'form-control','id' => 'asana_access_token'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="asana_workspace_id">{{ __('labels.asana_workspace_id') }}</label>
        {!! Form::text('asana_workspace_id', isset($settings->asana_workspace_id) ? $settings->asana_workspace_id : '', array('placeholder' => 'Asana Workspace Id','class'=> 'form-control','id' => 'asana_workspace_id'))!!}
    </div>
</div>

{{--<div class="form-group row">--}}
    {{--<div class="form-group col-md-6">--}}
        {{--<label class="form-control-label" for="stripe_publishable_key">{{ __('labels.stripe_publishable_key') }}</label>--}}
        {{--{!! Form::text('stripe_publishable_key', isset($settings->stripe_publishable_key) ? $settings->stripe_publishable_key : '', array('placeholder' => 'Stripe Publishable Key','class'=> 'form-control','id' => 'stripe_publishable_key'))!!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
    {{--<div class="form-group col-md-6">--}}
        {{--<label class="form-control-label" for="stripe_secret_key">{{ __('labels.stripe_secret_key') }}</label>--}}
        {{--{!! Form::text('stripe_secret_key', isset($settings->stripe_secret_key) ? $settings->stripe_secret_key : '', array('placeholder' => 'Stripe Secret Key','class'=> 'form-control','id' => 'stripe_secret_key'))!!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--Rating Settings--}}
<hr>
<div class="row">
    <div class="form-group col-md-9">
        <lable><b>{{__('labels.rating_setting')}}</b></lable>
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="no_of_free_lesson_rating ">{{ __('labels.rating_of_free_lesson') }}</label>
        {!! Form::text('no_of_free_lesson_rating', isset($settings->no_of_free_lesson_rating) ? $settings->no_of_free_lesson_rating : '', array('placeholder' => 'No of Ratings To get Free Lesson','class'=> 'form-control','id' => 'no_of_free_lesson_rating'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="teacher_credits_rate ">{{ __('labels.credit_rate_teacher') }}</label>
        {!! Form::text('teacher_credits_rate', isset($settings->teacher_credits_rate ) ? $settings->teacher_credits_rate  : '', array('placeholder' => 'Credits on Rate Teacher','class'=> 'form-control','id' => 'teacher_credits_rate '))!!}
    </div>
</div>
<hr>
<div class="row">
    <div class="form-group col-md-9">
        <lable><b>{{__('Package Expire Reminder')}}</b></lable>
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="teacher_credits_rate ">{{ __('Remind Before Days') }}</label>
        {!! Form::text('package_expire_reminder_days', isset($settings->package_expire_reminder_days ) ? $settings->package_expire_reminder_days  : '', array('placeholder' => 'Remind Before Days','class'=> 'form-control','id' => 'package_expire_reminder_days'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="teacher_credits_rate ">{{ __('Client Can Book Appointment Up to Month') }}</label>
        {!! Form::select('book_upto_month',
        array('1'=>'1 Month', '2'=>'2 Month','3'=>'3 Month','4'=>'4 Month','5'=>'5 Month','6'=>'6 Month','7'=>'7 Month','8'=>'8 Month','9'=>'9 Month','10'=>'10 Month','11'=>'11 Month','12'=>'12 Month'),
        isset($settings->book_upto_month ) ? $settings->book_upto_month  : '1', array('class'=> 'form-control','id' => 'book_upto_month'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="booking_reminder ">{{ __('admin_labels.booking_reminder_time_before_appointment') }}</label>
        {!! Form::text('booking_reminder', isset($settings->booking_reminder ) ? $settings->booking_reminder  : 2, array('placeholder' => 'Appointment remonder','class'=> 'form-control','id' => 'booking_reminder'))!!}
    </div>
</div>
{{-- package_expire_remember_days --}}
<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/dashboard')."'")) !!}
    </div>
</div>
