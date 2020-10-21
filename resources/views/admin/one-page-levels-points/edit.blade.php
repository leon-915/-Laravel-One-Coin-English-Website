@extends('admin.layouts.admin',['title'=>'Edit One Page Levels Point'])

@section('title','Edit One Page Levels Point')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_one_page_levels_point')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.one-page-points.index') }}">{{ __('labels.manage_one_page_levels_points')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_one_page_levels_point')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit One Page Levels Point</h4>

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
                        {!! Form::model($levels_points, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_one_page_levels_point','route' => ['admin.one-page-points.update', $levels_points->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.one-page-levels-points.form')
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
            $('#edit_one_page_levels_point').validate({
                ignore: "",
                rules: {
                    level_id : {
                        required: true
                    },
                    rating_point : {
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
                    level_id : {
                        required: 'Please select level'
                    },
                    rating_point : {
                        required: 'Please Select rating point'
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
