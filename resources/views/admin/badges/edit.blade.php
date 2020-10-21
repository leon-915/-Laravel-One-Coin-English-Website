
@extends('admin.layouts.admin',['title'=>'Edit Badges'])

@section('title','Edit Badges')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_badges')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.badges.index') }}">{{ __('labels.manage_badges')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_badges')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_badges')}}</h4>

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
                        {!! Form::model($badges, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_badges','route' => ['admin.badges.update', $badges->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.badges.form')
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
            $('#edit_badges').validate({
                ignore: "",
                rules: {
                    title: {
                        required: true
                    },
                    description : {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter title"
                    },
                    description : {
                        required: 'Please enter description'
                    },
                    status: {
                        required: "Please select status"
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "body") {
                        error.insertAfter(".panel");
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });


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
        </script>

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
    @endpush
@endsection
