@extends('admin.layouts.admin',['title'=>'Add Admin'])

@section('title','Add Admin')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Admin </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-users.index') }}">{{ __('labels.manage_admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Admin</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Admin</h4>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        {!! Form::open(array('route' => 'admin-users.store','id'=>'create_user','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.admin-users.form')
                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

        <script>

            $('#create_user').validate({ // initialize the plugin
                rules: {
                    name : {
                        required: true
                    },
                    email: {
                        required: true,
                        //email: true
                        pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                    },
                    password:{
                        required: true,
                        minlength : 6
                    },
                    confirm_password : {
                        equalTo : "#password"
                    },
                    status:{
                        required: true
                    }
                },
                messages: {
                    name : {
                        required : "Please enter name"
                    },
                    email: {
                        required: "Please enter email",
                        //email : "Please enter a valid email,"
                        pattern : 'Please enter a valid email',
                    },
                    password: {
                        required: "Please enter password",
                        minlength: "Please enter minimum 6 characters"
                    },
                    confirm_password:{
                        equalTo: "Enter same as password"
                    },
                    status:{
                        required: "Please select status"
                    }
                }
            })


        </script>
    @endpush
@endsection

{{--@extends('admin.layouts.admin',['title'=>'Create Admin User','breadcrumbs'=>'add-admin-user'])--}}

{{--@section('title','Create Admin User')--}}

{{--@section('content')--}}

{{--<div class="panel-body container-fluid">--}}
    {{--<div class="row row-lg">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="example-wrap">--}}
                {{--<div class="example">--}}
                    {{--@if (count($errors) > 0)--}}
                        {{--@foreach ($errors->all() as $error)--}}
                        {{--<div class="alert alert-danger alert-dismissible" role="alert">--}}
                            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                                {{--<span aria-hidden="true">×</span>--}}
                            {{--</button>--}}
                            {{--{{ $error }}--}}
                        {{--</div>--}}
                        {{--@endforeach--}}
                    {{--@endif--}}

                    {{--{!! Form::open(array('route' => 'admin-users.store','id'=>'create_user','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}--}}
                        {{--@include('admin.admin-users.form')--}}
                    {{--{!! Form::close() !!}--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--@push('js')--}}
    {{--<script type="text/javascript" src="{{ asset('js/validation/jquery.validate.min.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('js/validation/additional-methods.min.js') }}"></script>--}}
    {{--<script>--}}
        {{--$.validator.addMethod('filesize', function(value, element, param) {--}}
            {{--return this.optional(element) || (element.files[0].size <= param)--}}
        {{--});--}}

        {{--$(document).ready(function () {--}}
            {{--// jQuery plugin to prevent double submission of forms--}}
            {{--jQuery.fn.preventDoubleSubmission = function () {--}}
                {{--$(this).on('submit', function (e) {--}}
                    {{--var $form = $(this);--}}
                    {{--if ($form.valid()) {--}}
                        {{--if ($form.data('submitted') === true) {--}}
                            {{--// Previously submitted - don't submit again--}}
                            {{--e.preventDefault();--}}
                        {{--} else {--}}
                            {{--// Mark it so that the next submit can be ignored--}}
                            {{--$form.data('submitted', true);--}}
                        {{--}--}}
                    {{--}--}}
                {{--});--}}
                {{--// Keep chainability--}}
                {{--return this;--}}
            {{--};--}}
            {{--$('form').preventDoubleSubmission();--}}
        {{--});--}}

        {{--$('#create_user').validate({ // initialize the plugin--}}
            {{--rules: {--}}
                {{--name : {--}}
                    {{--required: true--}}
                {{--},--}}
                {{--email: {--}}
                    {{--required: true,--}}
                    {{--//email: true--}}
                    {{--pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,--}}
                {{--},--}}
                {{--password:{--}}
                    {{--required: true,--}}
                    {{--minlength : 6--}}
                {{--},--}}
                {{--confirm_password : {--}}
                    {{--equalTo : "#password"--}}
                {{--},--}}
                {{--status:{--}}
                    {{--required: true--}}
                {{--}--}}
            {{--},--}}
            {{--messages: {--}}
                {{--name : {--}}
                    {{--required : "Please enter name"--}}
                {{--},--}}
                {{--email: {--}}
                    {{--required: "Please enter email",--}}
                    {{--//email : "Please enter a valid email,"--}}
                    {{--pattern : 'Please enter a valid email',--}}
                {{--},--}}
                {{--password: {--}}
                    {{--required: "Please enter password",--}}
                    {{--minlength: "Please enter minimum 6 characters"--}}
                {{--},--}}
                {{--confirm_password:{--}}
                    {{--equalTo: "Enter same as password"--}}
                {{--},--}}
                {{--status:{--}}
                    {{--required: "Please select status"--}}
                {{--}--}}
            {{--}--}}
        {{--})--}}


    {{--</script>--}}


{{--@endpush--}}
{{--@endsection--}}
