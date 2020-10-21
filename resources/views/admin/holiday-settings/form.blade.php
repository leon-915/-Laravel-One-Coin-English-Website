<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label " for="start_date">{{ __('labels.holiday_message_display_start_date') }}</label>

        <input type="hidden" name="id" value="{{!empty($holiday_settings->id) ? $holiday_settings->id : ''}}" >
        {!! Form::text('holiday_message_display_start_date', isset($holiday_settings->holiday_message_display_start_date) ? $holiday_settings->holiday_message_display_start_date : '', array('placeholder' => 'Start Date','class'=> 'form-control datepicker-popup','id' => 'start_date'))!!}

    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label " for="start_date">{{ __('labels.start_date') }}</label>

        <input type="hidden" name="id" value="{{!empty($holiday_settings->id) ? $holiday_settings->id : ''}}" >
        {!! Form::text('start_date', isset($holiday_settings->start_date) ? $holiday_settings->start_date : '', array('placeholder' => 'Start Date','class'=> 'form-control datepicker-popup','id' => 'start_date'))!!}

    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label " for="start_time">{{ __('labels.start_time') }}</label>
        {!! Form::text('start_time', isset($holiday_settings->start_time) ? $holiday_settings->start_time : '', array('placeholder' => 'Start Time','class'=> 'form-control timepicker','id' => 'start_time'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="end_date">{{ __('labels.end_date') }}</label>
        {!! Form::text('end_date', isset($holiday_settings->end_date) ? $holiday_settings->end_date : '', array('placeholder' => 'End Date','class'=> 'form-control datepicker-popup','id' => 'end_date'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="end_time">{{ __('labels.end_time') }}</label>
        {!! Form::text('end_time', isset($holiday_settings->end_time) ? $holiday_settings->end_time : '', array('placeholder' => 'End Time','class'=> 'form-control timepicker','id' => 'end_time'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="message_en">{{ __('labels.setting_message_en') }}</label>
        <textarea name="message_en" id="message_en" class="form-control desc_star" maxlength="1000" rows="3" placeholder="Message has a limit of 1000 chars.">{{isset($holiday_settings->message_en) ? $holiday_settings->message_en : ''}}</textarea>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="message_ja">{{ __('labels.setting_message_ja') }}</label>
        <textarea name="message_ja" id="message_ja" class="form-control desc_star" maxlength="1000" rows="3" placeholder="Message has a limit of 600 chars.">{{isset($holiday_settings->message_ja) ? $holiday_settings->message_ja : ''}}</textarea>
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/dashboard')."'")) !!}
    </div>
</div>
