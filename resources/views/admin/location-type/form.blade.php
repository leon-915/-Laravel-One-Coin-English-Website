
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicFirstName">{{ __('labels.location_title') }}<span class="vali">*</span></label>
        {!! Form::text('title', isset($location_types->title) ? $location_types->title : '', array('placeholder' => 'Location Title','class'=> 'form-control','id' => 'inputBasicTitle'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($location_types->status) ? $location_types->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/location-type')."'")) !!}
    </div>
</div>