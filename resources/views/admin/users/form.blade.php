<?php
//    $url = "";
//    $logourl = "";
//
//    if(isset($user)){
//        if($user->image){
//            $url = asset('uploads/user/'.$user->image.'');
//        }
//        if($user->logo){
//            $logourl = asset('uploads/logo/'.$user->logo.'');
//        }
//    }
//?>
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicName">Name<span class="vali">*</span></label>
        {!! Form::text('name', null, array('placeholder' => 'Name','class'=> 'form-control','id' => 'name'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="Birthdate">Birthdate<span class="vali">*</span></label>
        <div id="datepicker-popup" class="input-group date datepicker">
            <input type="text" placeholder = "Select Birthdate"class="form-control" name="birth_date" value="<?= isset($user->birth_date) ? $user->birth_date : '' ?>">
            <span class="input-group-addon input-group-append border-left">
				<span class="mdi mdi-calendar input-group-text"></span>
			</span>
        </div>
    </div>

</div>
@if($form == "create")
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="password">Password<span class="vali">*</span></label>
        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password','autocomplete' => 'new-password')) !!}
    </div>
    <div class="form-group col-md-6">
        <label class="form-control-label" for="comfirm_password">Confirm Password<span class="vali">*</span></label>
        {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
    </div>
</div>
@endif
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="email">Email<span class="vali">*</span></label>
        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'email')) !!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">Status<span class="vali">*</span></label>
        {!! Form::select('status',
            !empty($user)? array('active' => 'Active', 'inactive' => 'Inactive'):
            array('1' => 'Active', '2' => 'Inactive'),
            isset($user->status)? $user->status : '',
            array(
                'placeholder' => 'Select Status',
                'class' => 'form-control',
                'id' => 'status'
            ))
        !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="state">State<span class="vali">*</span></label>
        <select id="state" class="form-control" name="state" data-plugin="selectpicker" onchange="setStateField(this)">
            @if ($states->count())
                <option></option>
                @foreach($states as $id => $state)
                    @if(isset($user->state))
                        <option value="{{ $id }}" {{ ($user->state  == $state) ? ' selected' : '' }}>{{ $state }}</option>
                    @else
                        <option value="{{ $id }}">{{ $state }}</option>
                    @endif
                @endforeach
            @endif
          </select>
        <input id="state_name" type = "hidden" name = "state_name" value = "@if(isset($user->state)) {{$user->state}} @endif" />

{{-- {!! Form::select('state', $states, isset($user->state) ? $user->state : '', array('placeholder' => 'Please select state','class' => 'form-control','id' => 'state',"data-plugin" => "selectpicker", 'onchange' => 'setStateField(this)')) !!}--}}

    </div>


    <div class="form-group col-md-6" id="city-container">
        @if($form == 'edit')
            @include('admin.users.cities',['ucity' => $user->city, 'cities' => $cities])
        @endif
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicZipCode">Zip Code<span class="vali">*</span></label>
        {!! Form::text('zip_code', null, array('placeholder' => 'Zip Code','class'=> 'form-control','id' => 'zip_code'))!!}
    </div>
</div>

<div class="row">

    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('users')."'")) !!}
    </div>
</div>

<style>

    .dropify-wrapper label.error2 {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
    }
</style>

<style>
    .dropify-wrapper label.error {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
    }
</style>
