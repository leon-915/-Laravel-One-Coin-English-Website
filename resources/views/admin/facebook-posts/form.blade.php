<?php
    $url = "";
    if(!empty($post->image)){
        $url = asset($post->image);
    }
?>
<div class="row">
    <div class="form-group col-12">
       
        <label class="form-control-label" for="subject">{{ __('labels.post_subject')}}<span class="vali">*</span></label>
        {!!Form::text('subject', isset($post->subject) ? $post->subject : '',array('placeholder' => 'Subject','class' => 'form-control','id' => 'subject',"required"  => "true"))!!}
  
    </div>
</div>

<div class="row">
	<div class="form-group col-12">
		 <label class="form-control-label" for="message">{{ __('labels.message')}}<span class="vali">*</span></label>
        {!! Form::textarea('message', isset($post->message) ? $post->message : '' , array('placeholder' => 'Message','rows' => 4,'class'=> 'form-control','id' => 'message'))!!}
	</div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}</label>
        <?php
            if(isset($post) && !empty($post->status)) //Pending
                $status = array('2' => 'Approve', '3' => 'Not Approve', '4' => 'Archive');
            else
                $status = array('1' => 'Pending', '2' => 'Approve', '3' => 'Not Approve', '4' => 'Archive');

        ?>
        <select id="status" class="form-control" name="status" data-plugin="selectpicker">
            @foreach($status as $id => $value)
                @if(isset($post->status))
                    <option value="{{ $id }}" {{ ($post->status  == $id) ? ' selected' : '' }}>
                    {{ $value }}</option>
                @else
                    <option value="{{ $id }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>

@if(!empty($url))
    <div class="row" id="cimage">
        <div class="form-group col-md-12" >
            <label class="form-control-label">{{  __('labels.attachment')}}</label>

            <label id="croppie-image-upload">
                <img src="{{$url}}"  alt="attachment" width="250" height="200">  
            </label>
        </div>
    </div>
@endif
<div class="row">
	<div class="form-group col-md-2">
		{!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
	</div>
	<div class="form-group col-md-2">
		{!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".route('admin.facebook-posts.index')."'")) !!}
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
