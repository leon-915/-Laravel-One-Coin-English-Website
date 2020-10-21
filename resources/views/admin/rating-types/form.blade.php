
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicFirstName">{{ __('labels.title') }}<span class="vali">*</span></label>
        {!! Form::text('title', isset($rating_types->title) ? $rating_types->title : '', array('placeholder' => 'Rating Type Title','class'=> 'form-control','id' => 'inputBasicTitle'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($rating_types->status) ? $rating_types->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class=" form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="description">{{ __('labels.description') }}<span class="vali">*</span></label>
        <textarea name="description" id="description" class="form-control" maxlength="1000" rows="" placeholder="Description has a limit of 1000 chars.">{{isset($rating_types->description) ? $rating_types->description : ''}}</textarea>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="desc_star1">{{ __('labels.desc_star1') }}</label>
        <textarea name="desc_star1" id="desc_star" class="form-control desc_star" maxlength="600" rows="2" placeholder="Desc Star1 has a limit of 600 chars.">{{isset($rating_types->desc_star1) ? $rating_types->desc_star1 : ''}}</textarea>
    </div>
</div>


<div class=" form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="desc_star2">{{ __('labels.desc_star2') }}</label>
        <textarea name="desc_star2" id="desc_star" class="form-control desc_star" maxlength="600" rows="2" placeholder="Desc Star2 has a limit of 600 chars.">{{isset($rating_types->desc_star2) ? $rating_types->desc_star2 : ''}}</textarea>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="desc_star3">{{ __('labels.desc_star3') }}</label>
        <textarea name="desc_star3" id="desc_star" class="form-control desc_star" maxlength="600" rows="2" placeholder="Desc Star3 has a limit of 600 chars.">{{isset($rating_types->desc_star3) ? $rating_types->desc_star3 : ''}}</textarea>
    </div>
</div>


<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="desc_star4">{{ __('labels.desc_star4') }}</label>
        <textarea name="desc_star4" id="desc_star" class="form-control desc_star" maxlength="600" rows="2" placeholder="Desc Star4 has a limit of 600 chars.">{{isset($rating_types->desc_star4) ? $rating_types->desc_star4 : ''}}</textarea>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="desc_star5">{{ __('labels.desc_star5') }}</label>
        <textarea name="desc_star5" id="desc_star" class="form-control desc_star" maxlength="600" rows="2" placeholder="Desc Star5 has a limit of 600 chars.">{{isset($rating_types->desc_star5) ? $rating_types->desc_star5 : ''}}</textarea>
    </div>
</div>


<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/rating-types')."'")) !!}
    </div>
</div>