@extends('admin.layouts.admin',['title'=>'Add Booking'])

@section('title','Add Booking')

@section('content')
    <?php
        $upToMonth = \App\Models\Settings::getSettings('book_upto_month');
        $maxDate = date('Y-m-d', strtotime("+".$upToMonth." months"));

        // echo '<pre>';
        // print_r($maxDate);
        // echo '</pre>';

    ?>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.add_booking')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">{{ __('labels.manage_booking')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('labels.add_booking')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.add_booking')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.bookings.store','id'=>'create_booking','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.bookings.form',['form' => 'create'])
                        </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        label.grey {
            display: block;
        }


        .checkcontainer {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            float: left;
        }

        .checkcontainer input {position: absolute;opacity: 0;cursor: pointer;}
        input:checked ~ .radiobtn {background-color: #002e58;border: 0px;}

        .checkcontainer .radiobtn {
            position: absolute;
            top: -2px;
            left: 10px;
            height: 20px;
            width: 20px;
            background-color: transparent;
            border-radius: 50%;
            border: 2px solid #cccccc;
        }

        .checkcontainer input:checked ~ .radiobtn:after {
            display: block;
        }
        .checkcontainer .radiobtn:after {
            top: 3px;
            left: 3px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .checkcontainer .radiobtn:after {
            content: "";
            position: absolute;
            display: none;
        }


        .checkcontainer input:checked ~ .checkmark {
            background-color: #002e58;
            border: 0px;
        }
        .checkcontainer .checkmark {
            position: absolute;
            top: 6px;
            left: 0;
            height: 20px;
            width: 20px;
            border: 2px solid #cccccc;
            border-radius: 2px;
        }
        .checkcontainer input:checked ~ .checkmark:after {
            display: block;
        }
        .checkcontainer .checkmark:after {
            left: 7px;
            top: 2px;
            width: 7px;
            height: 12px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        .checkcontainer .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
    </style>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('js/jquery.timepicker.js') }}"></script>

        <script>
            $('#create_booking').validate({
                ignore: "",
                rules: {
                    service_id: {
                        required: true
                    },
                    teacher_id: {
                        required: true
                    },
                    location_id: {
                        required: true
                    },
                    user_id: {
                        required: true
                    },
                    lession_date: {
                        required: true
                    },
                    lession_time: {
                        required: true
                    },
                    /*lesson_duration: {
                        required: true
                    },*/
                    status: {
                        required: true
                    }
                },
                messages: {
                    service_id: {
                        required: 'Please select service'
                    },
                    teacher_id: {
                        required: 'Please select teacher'
                    },
                    location_id: {
                        required: 'please select location'
                    },
                    user_id: {
                        required: 'Please enter and select student name'
                    },
                    lession_date: {
                        required: 'Please select lesson date'
                    },
                    lession_time: {
                        required: 'Please select lesson time'
                    },
                    lesson_duration: {
                        required: 'Please select lesson duration'
                    },
                    status: {
                        required: 'Please select status'
                    }
                }
            });


           /* $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });*/

            var holidays = [];

	
            var datepicker = $('#lession_date').datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                yearRange: "0:+10",
                //maxDate: "<?= $maxDate ?>",
                beforeShowDay:function(date){
                    //console.log(holidays);
                    if(holidays.length > 0){
                        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                        //console.log(holidays.indexOf(string));
                        return [ holidays.indexOf(string) == -1 ,"", "Holiday"];
                    } else {
                        return [true, "","Available"];
                    }
                },
                onSelect: function (date, inst) {
                    let teacher_id = $('#teacher_id').val();
                    let service_id = $('#service_id').val();
                    $.ajax({
                        url: "{{ route('admin.bookings.setDatepicker') }}",
                        type: 'POST',
                        data: {
                            'date'       : date,
                            'teacher_id' : teacher_id,
                            'service_id' : service_id,
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('.el-loading').removeClass('d-none');
                        },
                        success: function (result) {
                            $('.el-loading').addClass('d-none');
                            $('#available_time').html(result);
                        }
                    });
                    $("#reserve_date-error").hide();

                    //resources/views/students/reservation/index/teacher_profile.blade.php
                }
            });

            $(document).on("change", "#service_id", function () {
                let service_id = $('#service_id').val();
                let user_id = $('#user_id').val();
                $.ajax({
                    url: '{{ route('admin.bookings.changeService')}}',
                    type: 'POST',
                    data: {
                        'service_id': service_id,
                        'user_id': user_id,
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

                        if(res.holidays.length > 0){
                            $.each(res.holidays, function (index, value) {
                               holidays.push(value);
                            });
                        }
                        if (res.teachers) {
                            console.log(res.teachers.length);
                            var thtml = '<option value="">Choose a Teacher</option>';
                            $.each(res.teachers, function (tindex, tvalue) {
                                thtml += '<option value="' + tindex + '">' + tvalue + '</option>';
                            });
                            $("#teacher_id").html(thtml);
                        }

                        if (res.locations) {

                            console.log(res.locations.length);
                            var lhtml = '<option value="">Choose a Location</option>';
                            $.each(res.locations, function (lindex, lvalue) {
                                lhtml += '<option value="' + lindex + '">' + lvalue + '</option>';
                            });
                            $("#location_id").html(lhtml);
                        }

                        if(res.maxDate != '1970-01-01'){
                            $('#lession_date').datepicker('option','maxDate',res.maxDate);
                        }

                        if(res.minDate){
                            $('#lession_date').datepicker('option','minDate',res.minDate);
                        }

                        var maxDate = $('#lession_date').datepicker('option','maxDate');
                        var minDate = $('#lession_date').datepicker('option','minDate');

                        console.log(maxDate);
                        console.log(minDate);

                        $('#lession_date').datepicker('refresh');
                    }
                });
            });

            $(document).on("change", "#location_id", function () {
                let service_id = $('#service_id').val();
                let location_id = $('#location_id').val();
                $.ajax({
                    url: '{{ route('admin.bookings.getTeachers')}}',
                    type: 'POST',
                    data: {
                        'service_id': service_id,
                        'location_id': location_id,
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
                        if (res.teachers) {
                            var lhtml = '<option value="">Choose a Teacher</option>';
                            $.each(res.teachers, function (lindex, lvalue) {
                                lhtml += '<option value="' + lindex + '">' + lvalue + '</option>';
                            });
                            $("#teacher_id").html(lhtml);
                        }

                    }
                });
            });

            $("#student_autocomplete").autocomplete({
                source: '{{ route('admin.bookings.get.student') }}',
                minLength: 1,
                select: function (event, ui) {
                    $('input[type=hidden]#user_id').val(ui.item.id);

                    // "Selected: " + ui.item.value + " aka " + ui.item.id;
                    let user_id = $('#user_id').val();
                    $.ajax({
                        url: '{{ route('admin.bookings.getServices')}}',
                        type: 'POST',
                        data: {
                            'student_id': user_id,
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

            $(document).on('submit','#create_booking',function(e){
                e.preventDefault();
                var data = $(this).serialize();
                var action = $(this).attr('action');
                var form = $(this);
                var redirectUrl = '<?= route('admin.bookings.index') ?>';

                $.ajax({
                    url : action,
                    data : data,
                    dataType: 'JSON',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend: function () {
                       $('.el-loading').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.el-loading').addClass('d-none');

                        if (result.type == 'success') {

                            $.toast({
                                heading: 'Success',
                                text: result.message,
                                icon: 'success',
                                position: 'top-right',
                                afterHidden: function () {
                                    window.location.href = redirectUrl;
                                }
                            });

                        } else {
                            $.toast({
                                heading: 'Error',
                                text: result.message,
                                icon: 'error',
                                position: 'top-right',
                            })
                        }
                    },
                    error :function(res){
                        $('.app-loader').addClass('d-none');
                        $.each(res.responseJSON.errors,function(key, value){
                            $.toast({
                                heading: 'Error',
                                text: value,
                                icon: 'error',
                                position: 'top-right',
                            })
                        });
                    }
                });
            });

           /* $('.desc_star').maxlength({
                alwaysShow: true,
                warningClass: "badge mt-1 badge-success",
                limitReachedClass: "badge mt-1 badge-danger"
            });*/


        </script>

    @endpush
@endsection
