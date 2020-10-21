
<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="title">{{ __('labels.title')}}<span class="vali">*</span></label>
        {!! Form::text('title',isset($testimonial->title) ? $testimonial->title : '', array('placeholder' => 'Title','class' => 'form-control','id' => 'title')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="title_ja">{{ __('labels.title_ja')}}<span class="vali">*</span></label>
        {!! Form::text('title_ja',isset($testimonial->title_ja) ? $testimonial->title_ja : '', array('placeholder' => 'Title JA','class' => 'form-control','id' => 'title_ja')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="excerpt">{{ __('labels.excerpt')}}</label>
        {!! Form::text('excerpt',isset($testimonial->excerpt) ? $testimonial->excerpt : '', array('placeholder' => 'Excerpt','class' => 'form-control','id' => 'excerpt')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="excerpt_ja">{{ __('labels.excerpt_ja')}}</label>
        {!! Form::text('excerpt_ja',isset($testimonial->excerpt_ja) ? $testimonial->excerpt_ja : '', array('placeholder' => 'Excerpt JA','class' => 'form-control','id' => 'excerpt_ja')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="position">{{ __('labels.position')}}</label>
        {!! Form::text('position',isset($testimonial->position) ? $testimonial->position : '', array('placeholder' => 'Position','class' => 'form-control','id' => 'position')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="position_ja">{{ __('labels.position_ja')}}</label>
        {!! Form::text('position_ja',isset($testimonial->position_ja) ? $testimonial->position_ja : '', array('placeholder' => 'Position JA','class' => 'form-control','id' => 'position_ja')) !!}
    </div>
</div>

<!--div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label mt-4" for="title_slug">{{ __('labels.title_slug')}}<span class="vali">*</span></label>
        {!! Form::text('title_slug',isset($testimonial->title_slug) ? $testimonial->title_slug : '', array('placeholder' => 'Title Slug','class' => 'form-control','id' => 'title_slug')) !!}
    </div>
</div-->

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="status">{{ __('labels.status') }}<span class="vali">*</span></label>
         {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($testimonial->status) ? $testimonial->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="description_en">{{ __('labels.description_en') }}<span class="vali">*</span></label>
        {!! Form::textarea('description_en',isset($testimonial->description_en) ? $testimonial->description_en : '', array('placeholder' => 'Enter description (English)','class' => 'form-control','id' => 'description_en')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="description_ja">{{ __('labels.description_ja') }}</label>
        {!! Form::textarea('description_ja',isset($testimonial->description_ja) ? $testimonial->description_ja : '', array('placeholder' => 'Enter description (Japanies)','class' => 'form-control','id' => 'description_ja')) !!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>

    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/testimonial')."'")) !!}
    </div>
</div>