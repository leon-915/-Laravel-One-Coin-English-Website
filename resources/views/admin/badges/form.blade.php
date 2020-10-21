<?php
$url = "";
if(isset($badges)){
    if($badges->image){
        $url = asset($badges->image);
    }
}
?>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="title">{{ __('labels.title') }}<span class="vali">*</span></label>
        {!! Form::text('title', isset($badges->title) ? $badges->title : '', array('placeholder' => 'Badge Title','class'=> 'form-control','id' => 'title'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($badges->status) ? $badges->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="description">{{ __('labels.description') }}<span class="vali">*</span></label>
        {!! Form::textarea('description', isset($badges->description) ? $badges->description : '', array('rows'=>2,'placeholder' => 'Badge Description','class'=> 'form-control','id' => 'description'))!!}
    </div>

    <div class="form-group col-md-4">
        <label class="form-control-label" for="image">{{ __('labels.badges_image') }}<span class="vali">*</span></label><br>
        <input type="file" name="image" id="input-file-max-fs" class="dropify" data-plugin="dropify"
               data-max-file-size="2M" data-default-file="{{$url}}"
               data-errors-position="outside" data-allowed-file-extensions="jpg jpeg png" data-show-remove="false"/>
        <span id="image-error"></span>
    </div>

</div>


<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/badges')."'")) !!}
    </div>
</div>