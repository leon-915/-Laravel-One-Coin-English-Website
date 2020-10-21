
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="title">{{ __('labels.package_title')}}<span class="vali">*</span></label>
        {!! Form::text('title', isset($packages->title) ? $packages->title : '', array('placeholder' => 'Title','class'=> 'form-control','id' => 'title'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="price">{{ __('labels.package_price')}}  (¥)<span class="vali">*</span></label>
        {!! Form::text('price', isset($packages->price) ? $packages->price : '', array('placeholder' => 'Price','class'=> 'form-control','id' => 'price'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="registration_fee">{{ __('labels.register_fee')}}  (¥)<span class="vali">*</span></label>
        {!! Form::text('registration_fee', isset($packages->registration_fee) ? $packages->registration_fee : '', array('placeholder' => 'Registration Fee','class'=> 'form-control','id' => 'registration_fee'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="onepage_fee">{{ __('labels.onepage_fee')}}  (¥)<span class="vali">*</span></label>
        {!! Form::text('onepage_fee', isset($packages->onepage_fee) ? $packages->onepage_fee : '', array('placeholder' => 'One Page Fee','class'=> 'form-control','id' => 'onepage_fee'))!!}
    </div>
</div>


{{--<div class="row">--}}
    {{--<div class="form-group col-md-6">--}}
        {{--<label class="form-control-label" for="no_of_lesson_available">{{ __('labels.available_lesson')}}<span class="vali">*</span></label>--}}
        {{--{!! Form::text('no_of_lesson_available', isset($packages->no_of_lesson_available) ? $packages->no_of_lesson_available : '', array('placeholder' => 'No of Lesson Available','class'=> 'form-control','id' => 'no_of_lesson_available'))!!}--}}
    {{--</div>--}}

    {{--<div class="form-group col-md-6">--}}
        {{--<label class="form-control-label" for="duration_of_lesson">{{ __('labels.duration_lesson_minutes')}}<span class="vali">*</span></label>--}}
        {{--{!! Form::text('duration_of_lesson', isset($packages->duration_of_lesson) ? $packages->duration_of_lesson : '', array('placeholder' => 'Duration of Lesson','class'=> 'form-control','id' => 'duration_of_lesson'))!!}--}}
    {{--</div>--}}
{{--</div>--}}


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="description">{{ __('labels.description')}}<span class="vali">*</span></label>
        <textarea name="description" id="description" class="form-control desc_star" maxlength='1000' rows="5" placeholder="Description has a limit of 1000 chars">{{isset($packages->description) ? $packages->description : ''}}</textarea>
        {{--<span id="rchars">15</span> Character(s) Remaining--}}
    </div>

    <div class="form-group col-md-6">
        {{--<label class="form-control-label" for="reward_point">{{ __('labels.reward_point')}}<span class="vali">*</span></label>--}}
        {{--{!! Form::text('reward_point', isset($packages->reward_point) ? $packages->reward_point : '', array('placeholder' => 'Reward Point','class'=> 'form-control','id' => 'reward_point'))!!}--}}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="roleover_condition">{{ __('labels.roleover_condition')}}<span class="vali">*</span></label>
        {{-- {!! Form::text('roleover_condition', isset($packages->roleover_condition) ? $packages->roleover_condition : '', array('rows'=>3,'placeholder' => 'Roleover Condition','class'=> 'form-control','id' => 'roleover_condition'))!!} --}}

        <input type="range" name="roleover_condition" id="roleover_condition" class="form-control-range" value="{{isset($packages->roleover_condition) ? $packages->roleover_condition : 0}}" min="0" max="100">
        <small id="roleover_value">Value : {{isset($packages->roleover_condition) ? $packages->roleover_condition : 0}} %</small>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1'=>'Active','2'=>'Inactive'),isset($packages->status) ? $packages->status : '', array('placeholder' => 'Select Status','class'=> 'form-control','id' => 'status'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>

    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/packages')."'")) !!}
    </div>
</div>
