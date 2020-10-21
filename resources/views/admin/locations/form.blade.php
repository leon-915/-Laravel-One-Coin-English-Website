
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicLocationTitle"> {{ __('labels.location_title')}} <span class="vali">*</span></label>
        {!! Form::text('title', isset($locations->title) ? $locations->title : '', array('placeholder' => 'Location Title','class'=> 'form-control','id' => 'title', 'maxlength' => 100))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicLocationName"> {{ __('labels.location_name_ja')}} <span class="vali">*</span></label>
        {!! Form::text('title_jp', isset($locations->title_jp) ? $locations->title_jp : '', array('placeholder' => 'Location Name(JA)','class'=> 'form-control','id' => 'title_jp','maxlength' => 100))!!}
    </div>
</div>


<div class="row">
   {{--  <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicSeatsAvailable"> {{ __('labels.seats_available')}} <span class="vali">*</span></label>
        {!! Form::select('seats_available',array('1' => '1', '2' => '2'), isset($locations->seats_available) ? $locations->seats_available : '', array('placeholder' => 'Select Available Seats','class' => 'form-control','id' => 'seats_available',"data-plugin" => "selectpicker")) !!}
    </div> --}}

    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicPhoneNumber"> {{ __('labels.phone_number')}}</label>
        {!! Form::text('phone_no',isset($locations->phone_no) ? $locations->phone_no : '', array('placeholder' => 'Phone Number','class'=> 'form-control','id' => 'phone_no'))!!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicAddress"> {{ __('labels.address')}}</label>
        {!! Form::textarea('address',isset($locations->address) ? $locations->address : '', array( 'rows' => 3,'placeholder' => 'Address','class'=> 'form-control','id' => 'address'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicCountry"> {{ __('labels.country')}}</label>
        {!! Form::select('country',$country_list,isset($locations->country) ? $locations->country : '', array('placeholder' => 'Select Country','class' => 'form-control select2','id' => 'country')) !!}
        <label id="country-error" class="error" for="country"></label>
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicState"> {{ __('labels.state_province')}}</label>
        @if($form == 'edit')
            {!! Form::select('state',$state_list,isset($locations->state) ? $locations->state : '', array('placeholder' => 'Select State','class' => 'form-control select2','id' => 'state')) !!}
            <label id="state-error" class="error" for="state"></label>
        @else
            {!! Form::select('state',array(),'', array('placeholder' => 'Select State','class' => 'form-control select2','id' => 'state')) !!}
            <label id="state-error" class="error" for="state"></label>
        @endIf
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicCity"> {{ __('labels.city')}}</label>
        @if($form == 'edit')
            {!! Form::select('city',$city_list,isset($locations->city) ? $locations->city : '', array('placeholder' => 'Select City','class' => 'form-control select2','id' => 'city')) !!}
            <label id="city-error" class="error" for="city"></label>
        @else
            {!! Form::select('city',array(),'', array('placeholder' => 'Select City','class' => 'form-control select2','id' => 'city')) !!}
            <label id="city-error" class="error" for="city"></label>
        @endIf
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicZipCode"> {{ __('labels.zipcode')}}</label>
        {!! Form::text('zipcode', isset($locations->zipcode) ? $locations->zipcode : '', array('placeholder' => 'ZipCode','class'=> 'form-control','id' => 'zipcode'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicLocationType"> {{ __('labels.location_type')}} <span class="vali">*</span></label>
        {!! Form::select('location_type',$location_type_list,isset($locations->location_type) ? $locations->location_type : '', array('placeholder' => 'Select Location','class' => 'form-control select2','id' => 'location_type')) !!}
        <label id="location_type-error" class="error" for="location_type"></label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicStatus"> {{ __('labels.status')}} <span class="vali">*</span></label>
        {!! Form::select('status', array('1'=>'Active','2'=>'Inactive'),isset($locations->status) ? $locations->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/locations')."'")) !!}
    </div>
</div>
