
<div class="row mt-4">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="student_id">{{ __('labels.student_id') }}</label>
        @if ($form == 'create')
            {!! Form::text('','', array('placeholder' => 'Search Student Name','class'=> 'form-control','id' => 'student_autocomplete'))!!}
            <input type="hidden" name="user_id" id="user_id" value="">
            <label id="user_id-error" class="error" for="user_id"></label>
        @elseif ($form == 'edit')
            {!! Form::text('user_id',isset($student_packages->user_id) ? $student_name : '', array('placeholder' => 'Search Student Name','class'=> 'form-control','id' => 'user_id','disabled'))!!}
        @endif
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="package_id">{{ __('labels.package_id') }}</label>
        {!! Form::select('package_id',$packages,isset($student_packages->package_id) ? $student_packages->package_id : '' , array('placeholder' => 'Select package','class'=> 'form-control select2','id' => 'package_id'))!!}
        <label id="package_id-error" class="error" for="package_id"></label>
    </div>
</div>
{{-- @if ($form == 'edit') --}}
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-control-label " for="start_date">{{ __('labels.start_date') }}</label>
            <input type="text" name="start_date" class="form-control datepicker-popup" value="{{isset($student_packages->start_date) ? date('Y-m-d', strtotime($student_packages->start_date)) : ''}}">
            <label id="start_date-error" class="error" for="start_date"></label>
            {{-- {!! Form::text('start_date',isset($student_packages->start_date) ? date('Y-m-d', strtotime($student_packages->start_date)) : '', array('placeholder' => 'Start Date','class'=> 'form-control datepicker-popup','id' => 'start_date'))!!} --}}
        </div>

        <div class="form-group col-md-6">
            <label class="form-control-label" for="expire_date">{{ __('labels.expire_date') }}</label>
            <input type="text" name="expire_date" class="form-control datepicker-popup" value="{{isset($student_packages->end_date) ? date('Y-m-d', strtotime($student_packages->end_date)) : ''}}" >
            <label id="expire_date-error" class="error" for="expire_date"></label>
           {{--  {!! Form::text('expire_date',isset($student_packages->end_date) ? date('Y-m-d', strtotime($student_packages->end_date)) : '', array('placeholder' => 'Expire Date','class'=> 'form-control datepicker-popup','id' => 'expire_date'))!!} --}}
        </div>
    </div>
{{-- @endif --}}

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="payment_status">{{ __('labels.payment_status') }}<span class="vali">*</span></label>
        {!! Form::select('payment_status',array('pending'=>'Pending', 'succeeded'=> 'Paid'),isset($payment_status) ? $payment_status : '', array('placeholder' => 'Select Payment Status','class'=> 'form-control','id' => 'payment_status'))!!}
            <label id="payment_status-error" class="error" for="payment_status"></label>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="service_id">{{ __('labels.status') }}<span class="vali">*</span></label>
        {!! Form::select('status',array('inactive'=>'Inactive','active'=>'Active'),isset($student_packages->status) ? $student_packages->status : '', array('placeholder' => 'Select Status','class'=> 'form-control','id' => 'status'))!!}
        <label id="status-error" class="error" for="status"></label>
    </div>
</div>

<div class="row">

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
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/student-packages')."'")) !!}
    </div>
</div>
