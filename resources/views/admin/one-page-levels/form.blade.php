
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="name">{{ __('labels.level_name') }}<span class="vali">*</span></label>
        {!! Form::text('name', isset($one_page_levels->name) ? $one_page_levels->name : '', array('placeholder' => 'Level Name','class'=> 'form-control','id' => 'name'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($one_page_levels->status) ? $one_page_levels->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="description_en">{{ __('labels.description_en') }}<span class="vali">*</span></label>
        {!! Form::textarea('description_en', isset($one_page_levels->description_en) ? $one_page_levels->description_en : '', array('placeholder' => 'Description (English)','class'=> 'form-control','id' => 'description_en'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="description_ja">{{ __('labels.description_ja') }}<span class="vali">*</span></label>
        {!! Form::textarea('description_ja', isset($one_page_levels->description_ja) ? $one_page_levels->description_ja : '', array('placeholder' => 'Description (Japanese)','class'=> 'form-control','id' => 'description_ja' ))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/one-page-levels')."'")) !!}
    </div>
</div>