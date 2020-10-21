@extends('admin.layouts.admin',['title'=>'Edit Category'])

@section('title','Edit Category')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.edit_category')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}"> {{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('admin.categories.index') }}">{{ __('labels.manage_categorys')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_category')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_category')}}</h4>

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

                        {!! Form::model($categories, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_category','route' => ['admin.categories.update', $categories->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.categories.form',['form' => 'edit'])
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

            jQuery.validator.addMethod("requiredTags", function (value, element) {
                if (value.length) {
                    return true;
                } else {
                    return false;
                }
            }, '');

            $('#edit_category').validate({
                ignore: "",
                rules: {
                    title_en: {
                        required: true,
                        maxlength: 300
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
                }
            });

        </script>
    @endpush
@endsection
