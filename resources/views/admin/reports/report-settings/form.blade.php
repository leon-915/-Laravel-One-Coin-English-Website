

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="ultimate">{{ __('labels.ultimate') }}</label>
        {!! Form::text('ultimate', isset($report_settings->ultimate) ? $report_settings->ultimate : '', array('placeholder' => 'Ultimate','class'=> 'form-control','id' => 'ultimate'))!!}

        <input type="hidden" name="id" value="{{!empty($report_settings->id) ? $report_settings->id : ''}}">
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="ideal">{{ __('labels.ideal') }}</label>
        {!! Form::text('ideal', isset($report_settings->ideal) ? $report_settings->ideal : '', array('placeholder' => 'Ideal','class'=> 'form-control','id' => 'ideal'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="target">{{ __('labels.target') }}</label>
        {!! Form::text('target', isset($report_settings->target) ? $report_settings->target : '', array('placeholder' => 'Target','class'=> 'form-control','id' => 'target'))!!}
    </div>
</div>

<div class="form-group row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="minimum">{{ __('labels.minimum') }}</label>
        {!! Form::text('minimum', isset($report_settings->minimum) ? $report_settings->minimum : '', array('placeholder' => 'Minimum','class'=> 'form-control','id' => 'minimum'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Save Changes',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
</div>
