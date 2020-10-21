
@extends('admin.layouts.admin',['title'=>'Edit Contact Us'])

@section('title','Edit Contact Us')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_contact_us')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.contact-us.index') }}">{{ __('labels.manage_contact_us')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_contact_us')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_contact_us')}}</h4>

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
                        {!! Form::model($contact_us, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_contact_us','route' => ['admin.contact-us.update', $contact_us->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.contact-us.form')
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
            $('#edit_contact_us').validate({
                ignore: "",
                rules: {
                    name : {
                        required: true
                    },
                    email : {
                        required: true
                    },
                    subject:{
                        required: true
                    },
                    message:{
                        required: true
                    }
                },
                messages: {
                    name : {
                        required: 'Please enter your name'
                    },
                    email : {
                        required:  'Please enter your email'
                    },
                    subject:{
                        required: 'Please enter subject '
                    },
                    message:{
                        required: 'please enter message'
                    }
                }
            });
        </script>
    @endpush
@endsection
