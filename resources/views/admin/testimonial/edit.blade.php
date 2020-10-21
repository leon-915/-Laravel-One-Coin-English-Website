
@extends('admin.layouts.admin',['title'=>'Edit Testimonial'])

@section('title','Edit Testimonial')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_testimonial')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.testimonial.index') }}">{{ __('labels.manage_testimonial')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_testimonial')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_testimonial')}}</h4>

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
                        {!! Form::model($testimonial, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_testimonial','route' => ['admin.testimonial.update', $testimonial->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.testimonial.form')
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
            $('#edit_testimonial').validate({
                ignore: "",
                rules: {
                    title: {
                        required: true
                    },
                    description_en: {
                        required: true
                    },
                    /*title_slug: {
                        required: true
                    },*/
                    status: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: 'Please enter title'
                    },
                    description_en: {
                        required: 'Please enter description in english'
                    },
                    /*title_slug: {
                        required: 'Please enter title slug'
                    },*/
                    status: {
                        required: 'Please select status'
                    }
                }
            });
        </script>
    @endpush
@endsection
