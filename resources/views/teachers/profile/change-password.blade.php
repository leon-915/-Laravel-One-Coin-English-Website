@extends('layouts.app',['title'=>'Change Password'])
@section('title', 'Change Password')

@section('content')
    <section class="register_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto">
                    {!! Form::model('change-password', ['method' => 'POST',  'id'=>'change-password','route' => ['teachers.profile.update.password'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <div class="register_inner">
                            <h3>Change Password</h3>
                            <p>Fill below field and update password</p>
                            @if(Session::has('message'))
                                <div class="col-12">
                                    <div class="alert alert-success" role="alert">
                                        <strong>{{ Session::get('message') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if (count($errors) > 0)
                                <div class="col-12">
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="password">{{ __('labels.password')}}</label>
                                        {!! Form::password('password', array('placeholder' =>  __('labels.password'),'class'=> 'form-control','id' => 'password'))!!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="confirm_password">{{ __('labels.confirm_password')}}</label>
                                        {!! Form::password('confirm_password',  array('placeholder' => __('labels.confirm_password'),'class'=> 'form-control','id' => 'confirm_password'))!!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('teachers.profile.index') }}" class="btnsub_arr">Cancel</a>
                                    <button type="submit" class="btnsub_arr">Update</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('#change-password').validate({
                ignore: "",
                rules: {
                    password:{
                        required: true,
                        minlength: 6
                    },
                    confirm_password:{
                        equalTo: '#password'
                    }
                },
                messages: {
                    password:{
                        required: '{{ __("jsValidate.required.password") }}'
                    },
                    confirm_password:{
                        equalTo: '{{ __("jsValidate.equalTo.confirm_password") }}'
                    },
                },
            });
        </script>
    @endpush
@endsection
