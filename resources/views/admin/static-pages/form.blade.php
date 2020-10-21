<div class="row">
    <div class="form-group col-md-4">
        <label class="form-control-label" for="pageName"> {{ __('labels.page_name')}} <span class="vali">*</span></label>
		 {!! Form::select('page_name', array('About us' => 'About us', 'How to use app' => 'How to use app','Privacy policy' => 'Privacy policy', 'Terms & Conditions' => 'Terms & Conditions'),$selectedpage = isset($page->page_name) ? $page->page_name : '', array('placeholder'=>'Select Page','class' => 'form-control','id' => 'Page Name',"data-plugin" => "selectpicker")) !!}
	</div>
	<div class="form-group col-md-4">
        <label class="form-control-label" for="title"> {{ __('labels.title')}} <span class="vali">*</span></label>
        {!! Form::text('title', isset($page->title) ? $page->title : '', array('placeholder' => 'Title','class'=> 'form-control','id' => 'title'))!!}
	</div>
	<div class="form-group col-md-4">
        <label class="form-control-label" for="meta_keyword"> {{ __('labels.meta_keyword')}}<span class="vali">*</span></label>
        {!! Form::text('meta_keyword', isset($page->meta_keyword) ? $page->meta_keyword : '', array('placeholder' => 'Meta Keyword','class'=> 'form-control','id' => 'meta_keyword'))!!}
	</div>

</div>

<div class="row">
	<div class="form-group col-12">
		 <label class="form-control-label" for="title">{{ __('labels.meta_description')}}<span class="vali">*</span></label>
        {!! Form::textarea('meta_description', isset($page->meta_description) ? $page->meta_description : '' , array('placeholder' => 'Meta Description','rows' => 4,'class'=> 'form-control','id' => 'min_user'))!!}
	</div>
</div>

<div class="row">
    <div class="form-group col-12">
        <!-- Panel Standard Editor -->
        <div class="panel">
            <label class="form-control-label" for="title" style="padding-bottom: 10px">{{ __('labels.body')}}<span class="vali">*</span></label>
            {!! Form::textarea('body',isset($page->body) ? $page->body : '' , array('rows' => 4,'class'=> 'form-control ckeditor','id' => 'body'))!!}
            <span id="body-error" class="error2" style="color: red;"></span>
        </div>
        <!-- End Panel Standard Editor -->
    </div>
</div>

<div class="row">
	<div class="form-group col-md-2">
		{!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
	</div>
	<div class="form-group col-md-2">
		{!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".route('admin.static-pages.index')."'")) !!}
	</div>
</div>



<style>
  {{--Body Span Error--}}
    .note-frame{
        margin-bottom:5px !important;
    }
    .panel{
        box-shadow: none;
    }
    {{--End ody Span Error--}}

	span.text-label {
		padding-right: 5px;
	}

    .dropify-wrapper label.error2 {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
        font-size: 0.875rem;
    }

    body {
    font-size: 0.875rem;
	}

    .dropify-wrapper label.error {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
	}


</style>
