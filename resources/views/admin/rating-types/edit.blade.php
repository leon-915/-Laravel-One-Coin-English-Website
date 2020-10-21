@extends('admin.layouts.admin',['title'=>'Edit Rating Type'])

@section('title','Edit Rating Type')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_rating_type')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('admin.rating-types.index') }}">{{ __('labels.manage_rating_type')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_rating_type')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_rating_type')}}</h4>

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
                        {!! Form::model($rating_types, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_rating_type','route' => ['admin.rating-types.update', $rating_types->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.rating-types.form')
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
            $('#edit_rating_types').validate({
                ignore: "",
                rules: {
                    title: {
                        required: true
                    },
                    description: {
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
                    description: {
                        required: 'Please enter description'
                    },
                    status: {
                        required: "Please select status"
                    }
                }
            });

            $('#description').maxlength({
                alwaysShow: true,
                warningClass: "badge mt-1 badge-success",
                limitReachedClass: "badge mt-1 badge-danger"
            });

            $('.desc_star').maxlength({
                alwaysShow: true,
                warningClass: "badge mt-1 badge-success",
                limitReachedClass: "badge mt-1 badge-danger"
            });
        </script>
    @endpush
@endsection
