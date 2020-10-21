<?php
$url = "";
if(isset($user)){
    if($user->image){
        $url = asset('uploads/admin-user/'.$user->image.'');
    }
}
?>
@extends('admin.layouts.list',['title'=>'Edit Profile'])

@section('title','Edit Profile')

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
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        {!! Form::model($user, ['method' => 'POST','id'=>'editprofile','url' => ['admin/editprofile'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="inputBasicFirstName">Name <span class="vali">*</span></label>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class'=> 'form-control','id' => 'inputBasicFirstName'))!!}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="inputBasicEmail">Email <span class="vali">*</span></label>
                                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'inputBasicEmail')) !!}
                                </div>

                            </div>
                           {{-- <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="password">Password <span class="vali">*</span></label>
                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password')) !!}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="comfirm_password">Confirm Password<span class="vali">*</span></label>
                                    {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
                                </div>
                            </div>
--}}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="image">Image</label><br>
                                    <input type="file" name="image" id="input-file-max-fs" class="dropify" data-plugin="dropify"
                                           data-max-file-size="2M" data-default-file="{{$url}}"
                                           data-errors-position="outside" data-allowed-file-extensions="jpg jpeg png" data-show-remove="false"/>
                                    <span id="image-error"></span>
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
        <script>
             $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
             });

             var drEvent = $('.dropify').dropify();

             drEvent.on('dropify.errors', function(event, element){
                 $('#input-file-max-fs').rules("add" , {
                     required: true,
                     messages: {
                         required: '',
                     }
                 });
             });

             $('#editprofile').validate({ // initialize the plugin
                rules: {
                    name : {
                        required: true
                    },
                    email: {
                        required: true,
                        //email: true,
                        pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                        // pattern : /^\[a-z0-9_.]+@[a-z_]+?\.[a-z]{2,3}$/
                    },
                  /*  password:{
                        minlength : 5
                    },
                    confirm_password : {
                        equalTo : "#password"
                    }*/
                },
                messages: {
                    name : {
                        required : "Please enter name"
                    },
                    email: {
                        required: "Please enter email",
                        // email : "Please enter a valid email",
                        pattern : 'Please enter a valid email'
                    },
                   /* password: {
                        minlength: "Please enter minimum 5 characters"
                    },
                    confirm_password:{
                        equalTo: "Enter same as password"
                    }*/
                }
            })


        </script>
    @endpush

    <style>
        .dropify-wrapper label.error2 {
            display: inherit;
            z-index: 2;
            position: relative;
            top: 60px;
            text-transform: capitalize;
        }
    </style>

    <style>
        .dropify-wrapper label.error {
            display: inherit;
            z-index: 2;
            position: relative;
            top: 60px;
            text-transform: capitalize;
        }
    </style>

    @endsection
