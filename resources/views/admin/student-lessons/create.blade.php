@extends('admin.layouts.admin',['title'=>'Add student Lesson'])

@section('title','Add Student Lesson')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.add_student_lessons')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.student.lessons.index') }}">{{ __('labels.manage_student_lessons')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.add_student_lessons')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.add_student_lessons')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.student.lessons.create','id'=>'create_student_lesson','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.student-lessons.create_form')
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

            $(".select2").select2({
                allowClear: false
            });
            $("#student_autocomplete").autocomplete({
                source: '{{ route('admin.bookings.get.student') }}',
                minLength: 1,
                select: function (event, ui) {
                    $('input[type=hidden]#user_id').val(ui.item.id);

                    "Selected: " + ui.item.value + " aka " + ui.item.id;
                     $('#user_id-error').hide();

                     $.ajax({
                        url: '{{ route('admin.student.lessons.getServices')}}',
                        type: 'POST',
                        data: {
                            'student_id': ui.item.id,
                            },
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                         beforeSend: function () {
                            $('.el-loading').removeClass('d-none');
                        },
                        success: function (res) {
                            $('.el-loading').addClass('d-none');
                            if (res.type == 'success') {
                                if (res.services) {
                                    console.log(res.services.length);
                                    var shtml = '<option value="">Choose a Service</option>';
                                    $.each(res.services, function (sindex, svalue) {
                                        shtml += '<option value="' + sindex + '">' + svalue + '</option>';
                                    });
                                    $("#service_id").html(shtml);
                                }
                            }
                        }
                    });
                }
            });
            $('#create_student_lesson').validate({
                ignore: "",
                rules: {
                    service_id : {
                        required: true
                    },
                    user_id:{
                        required: true
                    },
                    /*status:{
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
                    service_id : {
                        required: 'Please select service'
                    },
                    user_id:{
                        required: 'Please search select student'
                    },
                    /*status:{
                        required: 'Please select status'
                    },*/
                    payment_status:{
                        required: 'Please select payment status'
                    }
                }
            });

            $('#service_id').on('change', function() {
                $('#service_id-error').hide();
            });
         /*   $('#student_autocomplete').on('change', function() {
                $('#user_id-error').hide();
            });*/

           
            $('.datepicker-popup').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: '0d',
                autoclose: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "0:+10",
                dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            });


        </script>
        <style>
            .ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}
        </style>
    @endpush
@endsection