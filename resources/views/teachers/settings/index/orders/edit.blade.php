@extends('layouts.app',['title'=>'Edit Service'])
@section('title', 'Edit Service')

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12 profile_inner tab_pnle_sec">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="row">
                            <div class="col-12">
                                <div class="plan_header">
                                    <h2>Reschedule Service</h2>
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
                        {!! Form::model('editService', ['method' => 'POST',  'id'=>'editService','route' => ['teacher.settings.lesson.update',$booking->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}

                                 <div class="col-12 col-lg-6 ">
                                    <div class="form-group">
                                        <div class="title_step">
                                            <label>Status</label>
                                        </div>
                                        <div class="custom_select">
                                            <div class="select cust">
                                                <select class="form-control" id="status" name="status">
                                                <option value="">Select Status</option>
                                                @if(!empty($permissions))
                                                    @if(in_array('teanoshow',$permissions))
                                                        <option value="teacher_not_show" {{ $is_teacher_present == 1 ? 'selected' : '' }}>Teacher Not Show</option>
                                                    @endif
                                                    @if(in_array('stunoshow',$permissions))
                                                        <option value="student_not_show" {{ $is_student_present == 1 ? 'selected' : '' }}>Student Not Show</option>
                                                    @endif
                                                    @if(in_array('freelesson',$permissions))
                                                        <option value="free_lesson" {{ $is_free_lesson == 1 ? 'selected' : '' }}>Free Lesson</option>
                                                    @endif
                                                    @if(in_array('scheduled',$permissions))
                                                        <option value="booked" {{ $status == 'booked' ? 'selected' : '' }}>Booked</option>
                                                    @endif
                                                    @if(in_array('completed',$permissions))
                                                        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    @endif
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="row">
                                <div class="col-12 text-right mt-3">
                                    <a href ="/teacher/settings?ref=lessons-recordes" class="btn_custon">Cancel</a>
                                    <button role="menuitem" class="btn_custon">Submit</button>
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
            $(document).ready(function() { 

                let teacher_id = {{$booking->teacher_id }};
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
                        var teachers = '<option value="">Choose Teacher</option>';
                        $.each(result, function (index, value) {
                            teachers += '<option value="' + value.teacher_id + '">' + value.firstname+' '+value.lastname + '</option>';
                        });
                        $("#teacher").html(teachers);
                    }
                });
            });

        </script>
    @endpush
    <style type="text/css">
    </style>
@endsection
