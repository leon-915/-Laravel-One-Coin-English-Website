<?php
$statusNo = $teacher['status'];
$status = "";
if ($statusNo == 1) {
    $status = "Active";
}
if ($statusNo == 2) {
    $status = "Pending";
}
if ($statusNo == 3) {
    $status = "Inactive";
}
if ($statusNo == 4) {
    $status = "Delete";
}
if ($statusNo == 5) {
    $status = "Approved";
}
if ($statusNo == 6) {
    $status = "Archived";
}

$permission = "";
if (!empty($teacherDetails->permission)) {
    $permission = explode(',', $teacherDetails->permission);
}

$teaching_locations = "-";
$teaching_locations_arr = "";
    if(!empty($teacherDetails->teaching_locations)){

        $teaching_locations_arr = explode(',', $teacherDetails->teaching_locations);
        foreach ($teaching_locations_arr as $key => $value) {
           $teaching_locations_arr[$key] = ucfirst($value);
        }

        $teaching_locations = implode(', ', $teaching_locations_arr);
    }

?>
@extends('admin.layouts.admin',['title'=>'Teacher Schedule'])

@section('title','Teacher Schedule')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Teacher Schedule </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Manage Teachers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teacher Schedule</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">


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

                        <div class="row">
                            <div class="form-group col-6">
                                <label class="form-control-label" for="name">Teacher Name</label>
                                <p>{{ ucfirst($teacher['firstname'])}}  {{ ucfirst($teacher['lastname'])}}</p>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="email">Email</label>
                                <p>{{ $teacher['email']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="form-control-label" for="contact_no">Contact Number</label><br>
                                <p>{{ $teacher['contact_no']}}</p>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-control-label" for="status">Status</label>
                                <p>{{ $status}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label class="form-control-label" for="contact_no">What Courses Do Teacher
                                    Teach?</label><br>
                                <p>{{ $teacherDetails['courses_teach'] }}</p>
                            </div>
                        </div>
                      {{--   <div class="row">
                            <div class="form-group col-12">
                                <label class="form-control-label" for="contact_no">Teaching Locations</label><br>
                                <p>{{ $teaching_locations }}</p>
                            </div>
                        </div> --}}


                        {!! Form::open(array('route' => ['admin.teachers.update.schedule', $teacher['id']],'class'=>'cmxform admin', 'id'=>'frm_update_schedule','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Calendar Color</label>
                                    <input type="color" name="calendar_color"
                                           value="{{ !empty($teacherDetails->calendar_color) ? $teacherDetails->calendar_color : '' }}">
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Teacher Schedule</h4>

                        <div class="lesson_record_sec">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table_custom manage">
                                        <table class="table ">
                                            <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                {{--  <th scope="col"></th> --}}
                                                <th scope="col">Mon</th>
                                                <th scope="col">Tue</th>
                                                <th scope="col">Wed</th>
                                                <th scope="col">Thu</th>
                                                <th scope="col">Fri</th>
                                                <th scope="col">Sat</th>
                                                <th scope="col">Sun</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $fromTime = '00:00';
                                                $toTime   = '01:00';
                                            @endphp

                                            @foreach ($teacherSch as $key => $sch)
                                                <tr>
                                                    <td scope="row">{{ $fromTime }}-{{ $toTime }}</td>
                                                    {{--  <td scope="row">{{ date('H:i',strtotime($sch['from_time'])) }}-{{ date('H:i',strtotime($sch['to_time'])) }}</td> --}}
                                                    <td>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                                <input class="available-size name form-check-input"
                                                                       type="checkbox"
                                                                       name="schedule[{{$sch['id']}}][monday]"
                                                                       {{ ($sch['monday'] == 1) ? 'checked' : '' }} value="1">
                                                                {{-- <span class="checkmark"></span> --}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                                <input class="available-size name form-check-input"
                                                                       type="checkbox"
                                                                       name="schedule[{{$sch['id']}}][tuesday]"
                                                                       {{ ($sch['tuesday'] == 1) ? 'checked' : '' }} value="1">
                                                                {{--  <span class="checkmark"></span> --}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                                <input type="checkbox"
                                                                       class="available-size name form-check-input"
                                                                       name="schedule[{{$sch['id']}}][wednesday]"
                                                                       {{ ($sch['wednesday'] == 1) ? 'checked' : '' }} value="1">
                                                                {{-- <span class="checkmark"></span> --}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                                <input type="checkbox"
                                                                       class="available-size name form-check-input"
                                                                       name="schedule[{{$sch['id']}}][thursday]"
                                                                       {{ ($sch['thursday'] == 1) ? 'checked' : '' }} value="1">
                                                                {{-- <span class="checkmark"></span> --}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                                <input type="checkbox"
                                                                       class="available-size name form-check-input"
                                                                       name="schedule[{{$sch['id']}}][friday]"
                                                                       {{ ($sch['friday'] == 1) ? 'checked' : '' }} value="1">
                                                                {{-- <span class="checkmark"></span> --}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                                <input type="checkbox"
                                                                       class="available-size name form-check-input"
                                                                       name="schedule[{{$sch['id']}}][saturday]"
                                                                       {{ ($sch['saturday'] == 1) ? 'checked' : '' }} value="1">
                                                                {{--  <span class="checkmark"></span> --}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                                <input class="available-size name form-check-input"
                                                                       type="checkbox"
                                                                       name="schedule[{{$sch['id']}}][sunday]"
                                                                       {{ ($sch['sunday'] == 1) ? 'checked' : '' }} value="1">
                                                                {{--  <span class="checkmark"></span> --}}
                                                            </label>
                                                        </div>
                                                    </td>

                                                </tr>
                                                @php
                                                    $fromTime =  date('H:i',strtotime($fromTime) + 60*60);
                                                    $toTime =  date('H:i',strtotime($toTime) + 60*60);

                                                    if($fromTime == '24:00') break;
                                                    if($toTime == '25:00') break;
                                                @endphp
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <div class="row mt-4 mb-3">
                                <div class="col-md-8">
                                    <div class="add_excepion date form-group">
                                        <label>Exception</label>
                                        <div class="form-group">
                                            <a style="cursor: pointer;" onclick="exOptionAction.addOption(this);">+ Add
                                                Exception</a>
                                        </div>
                                        <div id="exception_container">
                                            @include('admin.teachers.settings.exceptions')
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Client Can Book Apointment Up to (Hours)</label>
                                        <input type="text" class="form-control" name="book_before_time"
                                               value="{{ !empty($teacherDetails->book_before_time) ? $teacherDetails->book_before_time : 0 }}"
                                               placeholder="Before start time">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Client Can Cancel/Reschedule Apointments (Hours)</label>
                                        <input type="text" class="form-control" name="cancel_before_time"
                                               value="{{ !empty($teacherDetails->cancel_before_time) ? $teacherDetails->cancel_before_time : 0 }}"
                                               placeholder="Before start time">
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="form-group col-6 ">
                                    <div class="form-check form-check-info">
                                        <label class="form-check-label">
                                            <input class="available-size name form-check-input"
                                                   {{(!empty($teacherDetails) && $teacherDetails->can_teacher_update_lesson_record) == 1 ? 'checked' : ''}}
                                                   name="can_teacher_update_lesson_record" type="checkbox" value="1">
                                            Can Teacher Update Lesson Record?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 mb-0">
                                    <label class="form-control-label">{{ __('labels.permission')}}</label>
                                    <br> <br>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input"
                                                           <?= (!empty($permission) && in_array('scheduled', $permission)) ? 'checked' : '' ?> name="permission[]"
                                                           type="checkbox" value="scheduled">
                                                    Scheduled
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input"
                                                           <?= (!empty($permission) && in_array('completed', $permission)) ? 'checked' : '' ?> name="permission[]"
                                                           type="checkbox" value="completed">
                                                    Completed
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input"
                                                           <?= (!empty($permission) && in_array('stunoshow', $permission)) ? 'checked' : '' ?> name="permission[]"
                                                           type="checkbox" value="stunoshow">
                                                    StuNoShow
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input"
                                                           <?= (!empty($permission) && in_array('teanoshow', $permission)) ? 'checked' : '' ?> name="permission[]"
                                                           type="checkbox" value="teanoshow">
                                                    TeaNoShow
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input"
                                                           <?= (!empty($permission) && in_array('csd', $permission)) ? 'checked' : '' ?> name="permission[]"
                                                           type="checkbox" value="csd">
                                                    CSD
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input"
                                                           <?= (!empty($permission) && in_array('freelesson', $permission)) ? 'checked' : '' ?> name="permission[]"
                                                           type="checkbox" value="freelesson">
                                                    Free Lesson
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </br>
                            <div class="ical_cal">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label class="form-control-label" for="google_calender_address">Calendar Address
                                            (iCal)</label>
                                        <span><a href="{{url('generate/ical/'.$teacher->id)}}">{{url('generate/ical/'.$teacher->id)}}</a> </span>
                                    </div>
                                </div>

                                <div class="cal_row">
                                    @include('admin.teachers.settings.ical')
                                </div>
                                <div class="form-group col-12 mt-3">
                                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-fw"
                                            onclick="linkOptionAction.addOption(this);"> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h4 class="card-title">Locations & Services</h4>

                        <div class="row mb-2">
                            <div class="form-group col-12 mb-0">
                                <label class="form-control-label">Locations</label>
                                <br>
                                <input type="text" id="location_search"
                                       placeholder="Type here to search in below locations" class="form-control mb-2">

                                <div class="row chk-fix-scroll register-locations  ml-0 mr-0">
                                    <div class="col-12">
                                        @foreach($locations as $key => $location)
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label"
                                                       data-text="{{ $location }}">{{$location}}
                                                    <input type="checkbox" class="available-size name form-check-input"
                                                           <?= (!empty($teacherLocations) && in_array($key, $teacherLocations)) ? 'checked' : '' ?> name="locations[]"
                                                           value="<?= $key ?>">
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label id="locations-error" for="locations[]" class="error"></label>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-group col-12 mb-0">
                                <label class="form-control-label">Services</label>
                                <br>
                                <input type="text" id="service_search"
                                       placeholder="Type here to search in below services" class="form-control mb-2">

                                <div class="row chk-fix-scroll register-services  ml-0 mr-0">
                                    <div class="col-12">
                                        @foreach($services as $key => $service)
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label" data-text="{{ $service }}">{{$service}}
                                                    <input type="checkbox" class="available-size name form-check-input"
                                                           <?= (!empty($teacherServices) && in_array($key, $teacherServices)) ? 'checked' : '' ?> name="services[]"
                                                           value="<?= $key ?>">
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label id="services-error" for="services[]" class="error"></label>
                            </div>
                        </div>

                    <!-- <div class="row mb-2">
                                <div class="form-group col-12 mb-0">
                                    <br>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    <input class="available-size name form-check-input" {{-- <?=            $teacherDetails['is_available_in_trial'] == 1 ? 'checked' : '' ?>  --}}name="is_available_in_trial" type="checkbox" value="1">
                                                     Is available in trial?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label id="is_available_in_trial-error" for="is_available_in_trial" class="error"></label>
                                </div>
                            </div> -->
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-gradient-primary btn-rounded btn-fw"
                                        id='submit_btn'> Update
                                </button>
                                {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/teachers')."'")) !!}
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style type="text/css">
    span.text-label {
        padding-right: 5px;
    }

    .form-group label {
        font-size: 14px;
        line-height: 1;
        vertical-align: top;
        margin-bottom: .5rem;
        font-weight: 600;
    }

    .form-group p {
        font-size: 14px;
    }

    .chk-fix-scroll {
        max-height: 200px;
        overflow-y: scroll;
        border: 1px solid;
        border-radius: 5px;
    }

    .chk-fix-scroll.register-locations .form-check, .chk-fix-scroll.register-services .form-check {
        margin: 10px !important;
        display: block !important;;
    }

</style>

@push('scripts')
    <script src="{{ asset('plugins/listswap/jquery.listswap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
    <script>
        let cloader = <?= json_encode(View::make('layouts.partials.loader')->render()) ?>;
        let cTab = "schedule";
        let excpHtml = <?= json_encode(View::make('admin.teachers.settings.exception')->render()) ?>;
        let icalHtml = <?= json_encode(View::make('admin.teachers.settings.addical')->render()) ?>;
        let icalI = '{{count($icalLink)}}';
        if (icalI == 0) {
            icalI = 1;
        } else {
            icalI = parseInt(icalI) + 1;
        }

        $(document).on("keyup", "#location_search", function () {
            var value = this.value.toLowerCase().trim();
            $(".register-locations label").show().filter(function () {
                return $(this).data('text').toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });

        $(document).on("keyup", "#service_search", function () {
            var value = this.value.toLowerCase().trim();
            $(".register-services label").show().filter(function () {
                return $(this).data('text').toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });

        $('#frm_update_schedule').validate({
            rules: {
                book_before_time: {
                    required: true,
                    number: true,
                    max: 999,
                },
                cancel_before_time: {
                    required: true,
                    number: true,
                    max: 999,
                },
                'google_calender_link': {
                    // required: true,
                    url: true
                },
            },
            messages: {
                book_before_time: {
                    required: 'Please enter apointment hours',
                    number: 'Please enter numeric value only',
                },
                cancel_before_time: {
                    required: 'Please enter cancel reschedule apointments hours',
                    number: 'Please enter numeric value only',
                },
            }
        });
    </script>

    <script src="{{ asset('js/admin/teacher/settings.js') }}"></script>
@endpush


