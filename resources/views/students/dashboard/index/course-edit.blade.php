@extends('layouts.app',['title'=>__('labels.stu_edit_service')])
@section('title', __('labels.stu_edit_service'))

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12 profile_inner tab_pnle_sec">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="row">
                            <div class="col-12">
                                <div class="plan_header">
                                    <h2>{{__('labels.stu_reschedule_service')}}</h2>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            @php
                                $errs = $errors->all();
                            @endphp
                            @if($errs)
                                @foreach ($errs as $key=>$err)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $err }}</strong>
                                </div>
                                @endforeach
                            @endif

                            @if(Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    <strong>{{ Session::get('message') }}</strong>
                                </div>
                            @endif
                        </div>
                        {!! Form::model('editService', ['method' => 'POST',  'id'=>'editService','route' => ['students.dashboard.update.service',$booking->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}

                            <input type="hidden" name="service" value="{{$booking->service_id}}">

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="title_step">
                                            <label>{{__('labels.stu_location')}}<span class="astric">*</span></label>
                                        </div>
                                        <div class="custom_select">
                                            <div class="select cust">
                                               <select class="form-control" id="location" name="location">
                                                    <option value="">{{__('labels.stu_select_location')}}</option>
                                                    @foreach($locations as $location)
                                                    <option value="{{$location['location_id']}}" {{ $booking->location_id == $location['location_id'] ? 'selected' : '' }}>{{$location['title']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-12 col-lg-6 ">
                                    <div class="form-group">
                                        <div class="title_step">
                                            <label>Teacher<span class="astric">*</span></label>
                                        </div>
                                        <div class="custom_select">
                                            <div class="select cust">
                                                <select class="form-control" id="teacher" name="teacher">
                                                    <option value="">{{__('labels.stu_select_teacher')}}</option>
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{$teacher['teacher_id']}}" {{ $booking->teacher_id == $teacher['teacher_id'] ? 'selected' : '' }}>{{$teacher['firstname']}}  {{$teacher['lastname']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="title_step">
                                            <label>{{__('labels.stu_date')}}<span class="astric">*</span></label>
                                        </div>
                                        <input type="text" class="form-control reserve_date" name="reserve_date" id="reserve_date" value = "{{$booking->lession_date}}" placeholder="Select Date">
                                    </div>
                                </div>
                            </div>

                          
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mt-3" id="available_time">
                                        <label for="exampleInputEmail1" class="">{{__('labels.stu_time')}}<span
                                                    class="astric">*</span></label>
                                        <label class="checkcontainer"><input type="radio" name="time" value="{{$booking->lession_time}}" checked="checked">{{$booking->lession_time}}<span class="radiobtn"></span></label>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right mt-3">
                                    <a href ="{{route('students.dashboard.index')}}" class="btn_custon">{{__('labels.btn_cancel')}}</a>
                                    <button role="menuitem" class="btn_custon">{{__('labels.btn_submit')}}</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">

            var holidays = [];
            var chooseTeacher = "{{__('labels.stu_step_2_detail')}}";


            var datepicker = $('#reserve_date').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: '0d',
                changeMonth: true,
                changeYear: true,
                yearRange: "0:+10",
                beforeShowDay:function(date){
                    if(holidays.length > 0){
                        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                        return [ holidays.indexOf(string) == -1 ,"", "Holiday"];
                    } else {
                        return [true, "","Available"];
                    }
                },
                onSelect: function (date, inst) {
                    let teacher_id = $('#teacher').val();
                    let service_id = {{$booking->service_id }};
                    $.ajax({
                        url: "{{ route('student.register.setDatepicker') }}",
                        type: 'POST',
                        data: {
                            'date'       : date,
                            'teacher_id' : teacher_id,
                            'service_id' : service_id,
                        },
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            console.log(result);
                            $('#available_time').html(result);
                        }
                    });
                }
            });

            $(document).ready(function() { 

                let teacher_id = {{$booking->teacher_id }};
                let service_id = {{$booking->service_id }};
                let booking_id = {{$booking->id }};
                $.ajax({
                    url: "{{ route('student.dashboard.changeTeacher') }}",
                    type: 'POST',
                    data: {
                        'teacher_id' : teacher_id,
                        'service_id' : service_id,
                        'booking_id' : booking_id,
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.app-loader').addClass('d-none');

                        if(result.holidays.length > 0){
                            $.each(result.holidays, function (index, value) {
                               holidays.push(value);
                            });
                        }

                         if(result.maxDate != '1970-01-01'){
                            $('#reserve_date').datepicker('option','maxDate',result.maxDate);
                        }

                        if(result.minDate){
                            $('#reserve_date').datepicker('option','minDate',result.minDate);
                        }

                        var maxDate = $('#reserve_date').datepicker('option','maxDate');
                        var minDate = $('#reserve_date').datepicker('option','minDate');

                        console.log(maxDate);
                        console.log(minDate);

                        $('#reserve_date').datepicker('refresh');
                    }
                });
            });

            $(document).on("change", "#location", function () {
                //let service_id = $('#service').val();
                let location_id = $(this).val();

                $.ajax({
                    url: '{{ route('student.dashboard.changeLocation', $booking->service_id) }}',
                    type: 'POST',
                    data: 'service_id=' + {{$booking->service_id }}+'&location_id='+location_id,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        var teachers = '<option value="">'+chooseTeacher+'</option>';
                        $.each(result, function (index, value) {
                            teachers += '<option value="' + value.teacher_id + '">' + value.firstname+' '+value.lastname + '</option>';
                        });
                        $("#teacher").html(teachers);
                    }
                });
            });

           /* $(document).on("change",'#teacher', function(e){
                e.preventDefault();
                let teacher_id = $(this).val();
                let service_id = {{$booking->service_id }};
                $.ajax({
                    url: "{{ route('student.dashboard.changeTeacher') }}",
                    type: 'POST',
                    data: {
                        'teacher_id' : teacher_id,
                        'service_id' : service_id
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.app-loader').addClass('d-none');

                        if(result.holidays.length > 0){
                            $.each(result.holidays, function (index, value) {
                               holidays.push(value);
                            });
                        }

                         if(result.maxDate != '1970-01-01'){
                            $('#reserve_date').datepicker('option','maxDate',result.maxDate);
                        }

                        if(result.minDate){
                            $('#reserve_date').datepicker('option','minDate',result.minDate);
                        }

                        var maxDate = $('#reserve_date').datepicker('option','maxDate');
                        var minDate = $('#reserve_date').datepicker('option','minDate');

                        console.log(maxDate);
                        console.log(minDate);

                        $('#reserve_date').datepicker('refresh');
                    }
                });
            });*/

        </script>
    @endpush
@endsection
