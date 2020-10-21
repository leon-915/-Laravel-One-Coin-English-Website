@extends('admin.layouts.admin',['title'=>'Add student Package'])

@section('title','Add Student Package')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.add_student_package')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.student-packages.index') }}">{{ __('labels.manage_student_packages')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.add_student_package')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.add_student_package')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.student-packages.store','id'=>'create_student_package','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.student-packages.form',['form' => 'create'])
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
                }
            });
            $('#create_student_package').validate({
                ignore: "",
                rules: {
                    user_id: {
                        required: true
                    },
                    package_id : {
                        required: true
                    },
                    start_date: {
                        date: true
                    },
                    expire_date : {
                        date: true
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

            $('#package_id').on('change', function() {
                $('#package_id-error').hide();
            });
            $('#student_autocomplete').on('change', function() {
                $('#user_id-error').hide();
            });

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