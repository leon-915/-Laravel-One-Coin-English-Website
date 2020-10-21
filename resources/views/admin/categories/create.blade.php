@extends('admin.layouts.admin',['title'=>'Add Categories'])

@section('title','Add Categories')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.add_category')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('admin.categories.index') }}">{{ __('labels.manage_categories')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.add_category')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.add_category')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.categories.store','id'=>'create_category','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.categories.form',['form' => 'create'])
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

            $('#create_category').validate({
                ignore: "",
                rules: {
                    title: {
                        required: true,
                        maxlength: 191
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
