@extends('admin.layouts.admin',['title'=>'Add Package'])

@section('title','Add Package')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.add_package')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> {{ __('labels.dashboard')}} </a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}"> {{ __('labels.manage_packages')}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.add_package')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.add_package')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.packages.store','id'=>'create_package','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.packages.form')
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
            $('#create_package').validate({
                ignore: "",
                rules: {
                    title : {
                        required: true,
                        maxlength:191
                    },
                    price : {
                        required: true,
                        number:true,
                        maxlength:10
                    },
                    registration_fee : {
                        required: true,
                        number:true,
                        maxlength:10
                    },
                    onepage_fee : {
                        required: true,
                        number:true,
                        maxlength:10
                    },
                    no_of_lesson_available : {
                        required: true,
                        number:true
                    },
                    duration_of_lesson : {
                        required: true,
                        number:true,
                        maxlength:2
                    },
                    description : {
                        required: true,
                        maxlength:900
                    },
                    roleover_condition : {
                        required: true,
                        number:true
                    },
                    status:{
                        required: true
                    }
                },
                messages: {
                    title : {
                        required : "Please enter title"
                    },
                    price : {
                        required: "Please enter price",
                        number:"Please enter numeric value only",
                        maxlength:'Please enter value maximum 10 digits'
                    },
                    registration_fee : {
                        required: "Please enter registration fee",
                        number:"Please enter numeric value only",
                        maxlength:'Please enter value maximum 10 digits'

                    },
                    onepage_fee : {
                        required: "Please enter onepage fee",
                        number:"Please enter numeric value only",
                        maxlength:'Please enter value maximum 10 digits'
                    },
                    no_of_lesson_available : {
                        required: "Please enter no of lesson available",
                        number:"Please enter numeric value only"
                    },
                    duration_of_lesson : {
                        required: "Please enter duration of lesson",
                        number:"Please enter numeric value only",
                        maxlength:'Please enter maximum 2 digits of minute'
                    },
                    description : {
                        required: "Please enter description",

                    },
                    roleover_condition : {
                        required: "Please enter roleover condition",
                        number:"Please enter numeric value only"
                    },
                    status:{
                        required: "Please select status"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "body") {
                        error.insertAfter(".panel");
                    }
                    else{
                        error.insertAfter(element);
                    }
                }
            });

            $(document).on('change','#roleover_condition',function(e){
                $('#roleover_value').html('Value : ' + $(this).val() + ' %');
            });

            $('.desc_star').maxlength({
                alwaysShow: true,
                warningClass: "badge mt-1 badge-success",
                limitReachedClass: "badge mt-1 badge-danger"
            });
        </script>
    @endpush
@endsection
