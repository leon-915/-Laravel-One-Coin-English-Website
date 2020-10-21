
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="level_id">{{ __('labels.level_id')}}<span class="vali">*</span></label>
        {!! Form::select('level_id',$levels,isset($levels_points->level_id) ? $levels_points->level_id : '', array('placeholder' => 'Select Level','class' => 'form-control','id' => 'level_id',"data-plugin" => "selectpicker")) !!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="rating_point">{{ __('labels.rating_point')}}<span class="vali">*</span></label>
        {!! Form::select('rating_point', $rating_point,isset($levels_points->rating_point) ? $levels_points->rating_point : '', array('placeholder' => 'Select Rating Point','class' => 'form-control','id' => 'rating_point',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="description_en">{{ __('labels.description_en') }}<span class="vali">*</span></label>
        {!! Form::textarea('description_en', isset($levels_points->description_en) ? $levels_points->description_en : '', array('placeholder' => 'Description (English)','class'=> 'form-control','id' => 'description_en'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="description_ja">{{ __('labels.description_ja') }}<span class="vali">*</span></label>
        {!! Form::textarea('description_ja', isset($levels_points->description_ja) ? $levels_points->description_ja : '', array('placeholder' => 'Description (Japanies)','class'=> 'form-control','id' => 'description_ja' ))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($levels_points->status) ? $levels_points->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/one-page-points')."'")) !!}
    </div>
</div>