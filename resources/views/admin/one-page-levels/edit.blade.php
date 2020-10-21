@extends('admin.layouts.admin',['title'=>'Edit One Page Level'])

@section('title','Edit One Page Level')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_one_page_level')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.one-page-levels.index') }}">{{ __('labels.manage_one_page_levels')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_one_page_level')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_one_page_level')}}</h4>

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
                        {!! Form::model($one_page_levels, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_one_page_level','route' => ['admin.one-page-levels.update', $one_page_levels->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.one-page-levels.form')
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
            $('#edit_one_page_level').validate({
                ignore: "",
                rules: {
                    name : {
                        required: true
                    },
                    description_en : {
                        required: true
                    },
                    description_ja : {
                        required: true
                    },
                    status:{
                        required: true
                    }
                },
                messages: {
                    name : {
                        required: 'Please enter level name'
                    },
                    description_en : {
                        required: 'Please enter description_en'
                    },
                    description_ja : {
                        required: 'Please enter description_ja'
                    },
                    status:{
                        required: "Please select status"
                    }
                }
            });
        </script>
    @endpush
@endsection
