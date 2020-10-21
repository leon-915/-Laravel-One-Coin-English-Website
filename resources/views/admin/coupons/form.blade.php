
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="coupon_code">{{ __('labels.coupon_code') }}<span class="vali">*</span></label>
        {!! Form::text('coupon_code', isset($coupons->coupon_code) ? $coupons->coupon_code : '', array('placeholder' => 'Coupon Code','class'=> 'form-control','id' => 'coupon_code'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($coupons->status) ? $coupons->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="discount_type">{{ __('labels.discount_type')}}</label>
        {!! Form::select('discount_type', array('1' => 'Fixed', '2' => 'Percentage'),isset($coupons->discount_type) ? $coupons->discount_type : '1', array('class' => 'form-control','id' => 'discount_type',"data-plugin" => "selectpicker")) !!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="discount">{{ __('labels.discount') }}<span class="vali">*</span></label>
        {!! Form::text('discount', isset($coupons->discount) ? $coupons->discount : '', array('placeholder' => 'Discount','class'=> 'form-control','id' => 'discount'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="discount_type">{{ __('labels.usage_limit_per_coupon')}}</label>
        {!! Form::text('usage_limit_per_coupon', isset($coupons->usage_limit_per_coupon) ? $coupons->usage_limit_per_coupon : '', array('placeholder' => 'Usage Limit Per Coupon','class'=> 'form-control','id' => 'usage_limit_per_coupon'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="discount">{{ __('labels.usage_limit_per_user') }}</label>
        {!! Form::text('usage_limit_per_user', isset($coupons->usage_limit_per_user) ? $coupons->usage_limit_per_user : '', array('placeholder' => 'Usage Limit Per User','class'=> 'form-control','id' => 'usage_limit_per_user'))!!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="from_date">{{ __('labels.from_date') }}<span class="vali">*</span></label>
        <span class="input-group-addon input-group-append border-left">
            <span class="mdi mdi-calendar input-group-text"></span>
            {!! Form::text('from_date', isset($coupons->from_date) ? $coupons->from_date : '', array('placeholder' => 'From Date','class'=> 'form-control datepicker-popup','id' => 'from_date'))!!}
        </span>
        <label id="from_date-error" class="error" for="from_date"></label>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="to_date">{{ __('labels.to_date') }}<span class="vali">*</span></label>
        <span class="input-group-addon input-group-append border-left">
            <span class="mdi mdi-calendar input-group-text"></span>
            {!! Form::text('to_date', isset($coupons->to_date) ? $coupons->to_date : '', array('placeholder' => 'To Date','class'=> 'form-control datepicker-popup','id' => 'to_date'))!!}
        </span>
        <label id="to_date-error" class="error" for="to_date"></label>
    </div>
</div>



<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/coupons')."'")) !!}
    </div>
</div>