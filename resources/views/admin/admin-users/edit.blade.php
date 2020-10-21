@extends('admin.layouts.admin',['title'=>'Edit Admin'])

@section('title','Edit Admin User')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Admin </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-users.index') }}">{{ __('labels.manage_admin')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Admin</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Admin</h4>
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

                        {!! Form::model($user, ['method' => 'PATCH','id'=>'edit_user','route' => ['admin-users.update', $user->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        @include('admin.admin-users.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            });
            $('#edit_user').validate({ // initialize the plugin
                rules: {
                    name : {
                        required: true
                    },
                    email: {
                        required: true,
                        //email: true,
                        pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
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
                        //email : "Please enter a valid email",
                        pattern : 'Please enter a valid email',
                    },
                    status:{
                        required: "Please select status"
                    }
                }
            })
        </script>
    @endpush
@endsection
