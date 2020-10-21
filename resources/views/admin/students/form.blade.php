<div class="row">
	<div class="form-group col-12 col-md-6 col-lg-6">
        <label class="form-control-label" for="firstname">{{ __('labels.first_name') }}<span class="vali">*</span></label>
        {!! Form::text('firstname', isset($student->firstname) ? $student->firstname : '', array('placeholder' => 'First Name','class'=> 'form-control','id' => 'firstname'))!!}
    </div>
    <div class="form-group col-12 col-md-6 col-lg-6">
        <label class="form-control-label" for="lastname">{{ __('labels.last_name') }}<span class="vali">*</span></label>
        {!! Form::text('lastname', isset($student->lastname) ? $student->lastname : '', array('placeholder' => 'Last Name','class'=> 'form-control','id' => 'lastname'))!!}
    </div>
</div>

<div class="row">
	<div class="form-group col-12 col-md-6 col-lg-6">
        <label class="form-control-label" for="email">{{ __('labels.email') }}<span class="vali">*</span></label>
        @if ($form == 'edit')
        {!! Form::text('email', isset($student->email) ? $student->email : '', array('placeholder' => 'E-mail','class'=> 'form-control','id' => 'email', 'disabled'))!!}
        @else
        {!! Form::text('email', isset($student->email) ? $student->email : '', array('placeholder' => 'E-mail','class'=> 'form-control','id' => 'email'))!!}
	    @endif
    </div>

	<div class="form-group col-12 col-md-6 col-lg-6">
        <label class="form-control-label" for="contact_no">{{ __('labels.contact_no') }}<span class="vali">*</span></label>
        {!! Form::text('contact_no', isset($student->contact_no) ? $student->contact_no : '', array('placeholder' => 'Contact Number','class'=> 'form-control','id' => 'contact_no'))!!}
    </div>
</div>
@if($form == "create")
    <div class="row">
        <div class="form-group col-12 col-md-6 col-lg-6">
            <label class="form-control-label" for="password">{{ __('labels.password') }} <span class="vali">*</span></label>
            {!! Form::password('password', array('placeholder' => 'Password','class'=> 'form-control','id' => 'password'))!!}
        </div>

        <div class="form-group col-12 col-md-6 col-lg-6">
            <label class="form-control-label" for="comfirm_password">{{ __('labels.confirm_password')}}  <span class="vali">*</span></label>
            {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
        </div>
    </div>
@endif

<div class="row">
    <div class="form-group col-12 col-md-6 col-lg-6">
        <label class="form-control-label" for="student_level_id">{{ __('labels.student_level') }}<span class="vali">*</span></label>
        {!! Form::select('student_level_id', array( 1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5', 6=>'6', 7=>'7', 8=>'8', 9=>'9'),$selectedpage = isset($student->student_level_id) ? $student->student_level_id : '', array('placeholder'=>'Select level','class' => 'form-control','id' => 'student_level_id')) !!}
    </div>
	
	<div class="form-group col-12 col-md-6 col-lg-6">
        <label class="form-control-label" for="status">{{ __('labels.status') }}<span class="vali">*</span></label>
        {!! Form::select('status', array( 1=>'Active', 3=>'Inactive'),$selectedpage = isset($student->status) ? $student->status : '', array('placeholder'=>'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" name="hide_price" value="1" <?= (!empty($studentDetail->hide_price) && $studentDetail->hide_price == 1) ?'checked' : ''?> class="form-check-input" id="hide_price">
                {{ __('labels.hide_price') }}
                <i class="input-helper"></i>
            </label>
        </div>
    </div>
</div>
{{-- @if($form != 'create')
<div class="row">
	<div class="form-group col-12 col-md-6 col-lg-6">
        <label class="form-control-label" for="profile_image">{{ __('labels.profile_image') }}</label>
        <img src='{{ url("uploads/profile/default.png") }}'>
        {!! Form:: file('profile_image',array('id'=>'profile_image'))!!}

	</div>
</div>
@endif --}}



<div class="row">
	<div class="form-group col-md-2">
		{!! Form::submit(__('labels.submit') ,array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
	</div>
	<div class="form-group col-md-2">
		{!! Form::button(__('labels.cancel') ,array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/students')."'")) !!}
	</div>
</div>



<style>
  {{--Body Span Error--}}
    .note-frame{
        margin-bottom:5px !important;
    }
    .panel{
        box-shadow: none;
    }
    {{--End ody Span Error--}}

	span.text-label {
		padding-right: 5px;
	}

    .dropify-wrapper label.error2 {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
        font-size: 0.875rem;
    }

    body {
    font-size: 0.875rem;
	}

    .dropify-wrapper label.error {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
	}


</style>
