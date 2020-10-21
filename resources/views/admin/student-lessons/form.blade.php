<div class="row mt-4">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="student_id">{{ __('labels.student_name') }}</label>
        {!! Form::text('user_id', isset($student_lessons->user_id) ? $student_name : '', array('class'=> 'form-control','disabled' => 'disabled'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="service_id">{{ __('labels.service') }}</label>
        {!! Form::text('service_id', isset($student_lessons->service_id) ? $service_name : '', array('class'=> 'form-control','disabled' => 'disabled'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="available_bookings">{{ __('labels.available_bookings') }}</label>
        {!! Form::text('available_bookings', isset($student_lessons->available_bookings) ? $student_lessons->available_bookings : '', array('class'=> 'form-control','disabled' => 'disabled'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="service_id">{{ __('labels.price') }}</label>
        {!! Form::text('price', isset($student_lessons->price) ? $student_lessons->price : '', array('class'=> 'form-control','disabled' => 'disabled'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="student_level_id">{{ __('labels.student_level') }}</label>
        {!! Form::text('student_level_id', isset($user->student_level_id) ? $level_name : '', array('class'=> 'form-control','disabled' => 'disabled'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="free_lessons">{{ __('labels.free_lessons') }}</label>
        {!! Form::text('free_lessons_2', isset($student_lessons->free_lessons_2) ? $student_lessons->free_lessons_2 : 0, array('placeholder' => 'Free lessons','class'=> 'form-control','id'=>'free_lessons_2'))!!}
		<span><small>Already given free lessons {{ isset($student_lessons->free_lessons) ? $student_lessons->free_lessons : 0 }}</small></span>
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label " for="start_date">{{ __('labels.start_date') }}</label>
        {!! Form::text('start_date', isset($student_lessons->start_date) ? $student_lessons->start_date : '', array('placeholder' => 'Start Date','class'=> 'form-control datepicker-popup','id' => 'start_date'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="expire_date">{{ __('labels.expire_date') }}</label>
        {!! Form::text('expire_date', isset($student_lessons->expire_date) ? $student_lessons->expire_date : '', array('placeholder' => 'Expire Date','class'=> 'form-control datepicker-popup','id' => 'expire_date'))!!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="payment_status">{{ __('labels.payment_status') }}<span class="vali">*</span></label>
        {!! Form::select('payment_status',array('pending'=>'Pending', 'succeeded'=> 'Paid'),isset($payment_status) ? $payment_status : '', array('placeholder' => 'Select Payment Status','class'=> 'form-control','id' => 'payment_status'))!!}
         <label id="payment_status-error" class="error" for="payment_status"></label>
    </div>
	<div class="form-group col-md-6">
        <label class="form-control-label" for="payment_status">{{ __('labels.days_extend') }}</label>
        {!! Form::text('days_extended2', isset($student_lessons->days_extended2) ? $student_lessons->days_extended2 : '', array('placeholder' => 'Course Extension','class'=> 'form-control','id' => 'days_extended2'))!!}
		<span><small>Already extended days {{ isset($student_lessons->days_extend) ? $student_lessons->days_extend : 0 }}</small></span>
    </div>
</div>

<div class="row">

	<div class="form-group col-md-6">
        <label class="form-control-label" for="payment_status">{{ __('labels.admin_rolled_over_lessons') }}</label>
        {!! Form::text('rolled_over_lessons2', isset($student_lessons->rolled_over_lessons2) ? $student_lessons->rolled_over_lessons2 : '', array('placeholder' => 'Rolled Over lessons','class'=> 'form-control','id' => 'rolled_over_lessons2'))!!}
		<span><small>Already rolled over lessons {{ isset($student_lessons->rolled_over_lessons) ? $student_lessons->rolled_over_lessons : 0 }}</small></span>
    </div>
	
    <!--div class="form-group col-md-6">
        <label class="form-control-label" for="service_id">{{ __('labels.status') }}<span class="vali">*</span></label>
        {!! Form::select('status',array(0=>'Inactive',1=>'Active'),isset($student_lessons->status) ? $student_lessons->status : '', array('placeholder' => 'Select Status','class'=> 'form-control','id' => 'status'))!!}
        <label id="status-error" class="error" for="status"></label>
    </div-->
</div>

<div class="row">

	<div class="form-group col-md-6">
        <label class="form-control-label" for="connected_order">{{ __('labels.admin_connected_order') }}</label>
        {!! Form::text('connected_order', isset($student_lessons->connected_order) ? $student_lessons->connected_order : '', array('placeholder' => 'Connected order id','class'=> 'form-control','id' => 'connected_order'))!!}
    </div>
	
    <div class="form-group col-md-6">
        <label class="form-control-label" for="invoice_action">{{ __('labels.admin_invoice_action') }}</label>
        {!! Form::select('invoice_action',array(1=>'Create & Send Invoice',2=>'Create Draft Invoice'), '', array('placeholder' => 'Select Invoice Action','class'=> 'form-control','id' => 'invoice_action'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>

    <div class="form-group col-md-2">
        @if (!empty($ref) && $ref == 'lessonrecord' && !empty($user_id))
            <a href="{{ route('admin.student.lesson.records.package',['id'=>$user_id]) }}" class="btn btn-gradient-secondary btn-rounded btn-fw">Cancel</a>
        @else
            <a href="{{ url('admin/student-lessons') }}" class="btn btn-gradient-secondary btn-rounded btn-fw">Cancel</a>
        @endif
    </div>

</div>