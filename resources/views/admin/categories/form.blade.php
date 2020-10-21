
<div class="row mt-4">
    <div class="form-group col-md-6 ">
        <label class="form-control-label " for="title_en">{{ __('labels.title_en') }}<span class="vali">*</span></label>
        {!! Form::text('title_en', isset($categories->title_en) ? $categories->title_en : '', array('placeholder' => 'Category Name EN','class'=> 'form-control','id' => 'title_en'))!!}
    </div>
</div>



<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="title_ja">{{ __('labels.title_ja') }}<span class="vali">*</span></label>
        {!! Form::text('title_ja', isset($categories->title_ja) ? $categories->title_ja : '', array('placeholder' => 'Category Name JA','class'=> 'form-control','id' => 'title_ja'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($categories->status) ? $categories->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/categories')."'")) !!}
    </div>
</div>
