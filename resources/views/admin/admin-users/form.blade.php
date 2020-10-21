
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicFirstName">Name<span class="vali">*</span></label>
        {!! Form::text('name', null, array('placeholder' => 'Name','class'=> 'form-control','id' => 'inputBasicFirstName'))!!}
    </div>
    <div class="form-group col-md-6">
        <label class="form-control-label" for="inputBasicEmail">Email<span class="vali">*</span></label>
        {!! Form::text('email', null, array('autocomplete'=>'off', 'placeholder' => 'Email','class' => 'form-control','id' => 'inputBasicEmail')) !!}
    </div>
</div>

@if($formType == 'create')
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-control-label" for="password">Password<span class="vali">*</span></label>
            {!! Form::password('password', array('autocomplete'=>'new-password', 'placeholder' => 'Password','class' => 'form-control','id'=>'password')) !!}
        </div>
        <div class="form-group col-md-6">
            <label class="form-control-label" for="comfirm_password">Confirm Password<span class="vali">*</span></label>
            {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
        </div>
    </div>
@endif

<div class="row">
    @if($formType == 'create')
        <div class="form-group col-md-6">
            <label class="form-control-label" for="status">Status<span class="vali">*</span></label>
            {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'), isset($user->status) ? $user->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
        </div>
    @else
        <div class="form-group col-md-6">
            <label class="form-control-label" for="status">Status<span class="vali">*</span></label>
            {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive', '3' => 'Suspend'), isset($user->status) ? $user->status : '1', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
        </div>
    @endif

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">Role<span class="vali">*</span></label>
        {!! Form::select('roles[]', $roles, !empty($user) ? $user->role : [], array('class' => 'form-control')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/admin-users')."'")) !!}
    </div>
</div>


