@extends('admin.layouts.admin',['title'=>'Edit Student Package'])

@section('title','Edit Student Package')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_student_package')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.student-packages.index') }}">{{ __('labels.manage_student_packages')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_student_package')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_student_package')}}</h4>

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
                        {!! Form::model($student_packages, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_student_package','route' => ['admin.student-packages.update', $student_packages->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.student-packages.form',['form' => 'edit'])
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

        var re =  /(\d{4})-(\d{2})-(\d{2})/;
        $.validator.addMethod(
             "DateFormat",
            function(value, element) {
                 return  value.match(/^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/);
             },
             "Please enter date in yyyy-mm-dd format."
         );

            $('#edit_student_package').validate({
                ignore: "",
                rules: {
                    user_id: {
                        required: true
                    },
                    package_id : {
                        required: true
                    },
                    start_date: {
                        //required: true
                        date: true,
                        //DateFormat:true
                    },
                    expire_date : {
                        //required: true
                        date: true,
                        //DateFormat:true
                    },
                    payment_status : {
                        required: true
                    },
                    status : {
                        required: true
                    }
                },
                messages: {
                    user_id: {
                        required: "Please enter and select student"
                    },
                    package_id : {
                        required: 'Please select package'
                    },
                    start_date: {
                        required: "Please select start date"
                    },
                    expire_date: {
                        required: "Please select expire date"
                    },
                    payment_status: {
                        required: "Please select payment status"
                    },
                    status: {
                        required: "Please select status"
                    }
                }
            });

            $('.datepicker-popup').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: '{{isset($student_packages->start_date) ? date('Y-m-d', strtotime($student_packages->start_date)) : '0d'}}',
                autoclose: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "0:+10",
                dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            });
        </script>

    @endpush
@endsection
