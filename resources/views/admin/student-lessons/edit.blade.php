@extends('admin.layouts.admin',['title'=>'Edit Student Lesson'])

@section('title','Edit Student Lesson')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_student_lessons')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.student.lessons.index') }}">{{ __('labels.manage_student_lessons')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_student_lessons')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_student_lessons')}}</h4>

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
                        {!! Form::model($student_lessons, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_student_lesson','route' => ['admin.student.lessons.update', $student_lessons->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                        <fieldset>
                            @include('admin.student-lessons.form')
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
            $('#edit_student_lesson').validate({
                ignore: "",
                rules: {
                    title: {
                        required: true
                    },
                    description : {
                        required: true
                    },
                    /*status: {
                        required: true
                    },*/
                    payment_status:{
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
                    }
                },
                messages: {
                    title: {
                        required: "Please enter title"
                    },
                    description : {
                        required: 'Please enter description'
                    },
                    /*status: {
                        required: "Please select status"
                    },*/
                    payment_status:{
                        required: 'Please select payment status'
                    }
                },
            });

            $('.datepicker-popup').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: '{{isset($student_lessons->start_date) ? date('Y-m-d', strtotime($student_lessons->start_date)) : '0d'}}',
                autoclose: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "0:+10",
                dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            });
        </script>

    @endpush
@endsection
