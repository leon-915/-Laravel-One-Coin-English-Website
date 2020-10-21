<?php
$url = "";
if(isset($user)){
    if($user->image){
        $url = asset('uploads/admin-user/'.$user->image.'');
    }
}
?>
@extends('admin.layouts.list',['title'=>'Change Password'])

@section('title','Change Password')

@section('content')
    <div class="panel-body container-fluid">
        <div class="row row-lg">
            <div class="col-md-12">
                <div class="example-wrap">
                    <div class="example">
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        {!! Form::model('', ['method' => 'POST','id'=>'changepassword','url' => ['admin/admin-users/admin-change-password'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="old_password">Current Password <span class="vali">*</span></label>
                                    {!! Form::password('current_password', array('placeholder' => 'Current Password','class' => 'form-control','id'=>'current_password')) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="password">New Password <span class="vali">*</span></label>
                                    {!! Form::password('new_password', array('placeholder' => 'New Password','class' => 'form-control','id'=>'new_password')) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="comfirm_password">Confirm Password <span class="vali">*</span></label>
                                    {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    {!! Form::submit('Submit',array('class'=>'btn btn-block btn-primary')) !!}
                                </div>
                                <div class="form-group col-md-2">
                                    {!! Form::button('Cancel',array('class'=>'btn btn-block btn-default','onclick'=>"window.location.href='".url('admin/dashboard')."'")) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script type="text/javascript" src="{{ asset('js/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/validation/additional-methods.min.js') }}"></script>
        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success'
                })
            </script>
        @endif
        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error'
                })
            </script>
        @endif
        <script>

            $('#changepassword').validate({ // initialize the plugin
                rules: {
                    current_password : {
                        required: true,
                        minlength : 6
                    },
                    new_password:{
                        required: true,
                        minlength : 6
                    },
                    confirm_password : {
                        required: true,
                        equalTo : "#new_password"
                    }
                },
                messages: {
                    current_password : {
                        required : "Please enter current password",
                        minlength: "Please enter minimum 6 characters"
                    },
                    new_password: {
                        required : "Please enter new password",
                        minlength: "Please enter minimum 6 characters"
                    },
                    confirm_password:{
                        required : "Please enter confirm password",
                        equalTo: "Enter same as password"
                    }
                }
            })
        </script>

    @endpush
    @endsection
