@extends('admin.layouts.admin',['title'=>'Edit Location Type'])

@section('title','Edit Location Type')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_location_type')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.location-type.index') }}">{{ __('labels.manage_location_type')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_location_type')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_location_type')}}</h4>

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
                        {!! Form::model($location_types, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_location_type','route' => ['admin.location-type.update', $location_types->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                            <fieldset>
                                @include('admin.location-type.form')
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
            $('#edit_location_type').validate({
                ignore: "",
                rules: {
                    title: {
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
        </script>
    @endpush
@endsection
