@extends('admin.layouts.admin',['title'=>'Calendar'])
@section('title', 'Calendar')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.calender')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.calender')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title"></h4>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="form-control-label" for="status">{{ __('Select Teacher') }}</label>
                                <select class="form-control" name="teacher" id="teacher">
                                    <option value="">Select Teacher</option>
                                    @foreach ($teachers as $key=>$teacher)
                                        <option value="{{$key}}">{{$teacher}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-control-label"
                                       for="step_verified">{{ __('Select Location') }}</label>
                                <select class="form-control" name="location" id="location">
                                    <option value="">Select Location</option>
                                    @foreach ($locations as $lkey=>$location)
                                        <option value="{{$lkey}}">{{$location}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="lesson_record_sec calender">
                    <div id='teacher-calendar'></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('plugins/fullcalendar/packages/core/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/interaction/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/daygrid/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/timegrid/main.js') }}"></script>
        <script src="{{ asset('plugins/fullcalendar/packages/list/main.js') }}"></script>

        <script>
            var calendarEl = null;
            var calendar = null;
            var calendarData = null;
            var getIcalDataUrl = "{{url('admin/calender/getIcalData')}}";

            calendarEl = document.getElementById('teacher-calendar');
            //calendarData = <?//= json_encode($teacherLData) ?>;
            calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    //right: 'dayGridMonth,timeGridWeek,timeGridDay,listDay,listWeek'
                },
                views: {
                    // listDay: { buttonText: 'list day' },
                    // listWeek: { buttonText: 'list week' },
                    dayGridMonth: {
                        eventLimit: 3 // adjust to 6 only for timeGridWeek/timeGridDay
                    },
                    timeGridWeek: {
                        eventLimit: 1 // adjust to 6 only for timeGridWeek/timeGridDay
                    }
                },
                //defaultDate: '2019-06-12',
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectMirror: false,
                defaultView: 'timeGridWeek',
                displayEventEnd: true,
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: {
                    url: '{{ url('admin/calender/get') }}',
                    method: 'GET',
                    dataType: "json",
                },
                // events: calendarData,
                eventColor: '#002e58',
                eventTextColor: '#fff',
                eventBorderColor: '#fff',
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'medium'
                },
                //slotDuration: '00:15:00',
                //slotLabelInterval: 15,
                //slotMinutes: 15,
                //slotDuration: '00:15:00',
                //slotLabelInterval : "00:15:00",
                scrollTime: "08:00:00",
                eventRender: function (info, element, view) {
                    info.el.style.padding = '5px';

                    if (info.view.type == 'dayGridMonth') {
                        info.el.style.width = '110px';
                        info.el.style.height = '5em';
                        info.el.style.font.size = '14px';
                        info.el.style.font.weight = '500';
                    }
                    if (info.view.type == 'timeGridWeek') {
                        /*  info.el.style.width = '134px';
                            info.el.style.top = '335px'; */
                    }
                    if (info.view.type == 'timeGridDay') {
                        /* info.el.style.width = '134px';
                        info.el.style.top = '335px'; */
                    }

                    var lesson = info.event.extendedProps.data;
                    var tooltipT = lesson.location + '-' + lesson.service + '-' + lesson.student_name;
                    $(info.el).attr('title', tooltipT);
                }
            });
            calendar.addEventSource({
                url: getIcalDataUrl,
                method: 'GET',
                dataType: "json",
            });
            calendar.render();

            $(document).on('change', '#location', function (e) {
                e.preventDefault();
                console.log(calendar);
                var teacher_id = $('#teacher').val();
                var location_id = $(this).val();

                var surl = '{{ url('admin/calender/get') }}';
                if (location_id) {
                    if (teacher_id) {
                        surl += '?teacher_id=' + teacher_id + '&location_id=' + location_id;
                    } else {
                        surl += '?location_id=' + location_id;
                    }
                } else {
                    if (teacher_id) {
                        surl += '?teacher_id=' + teacher_id;
                    }
                }

                console.log(surl);
                calendar.getEventSources()[0].remove();
                calendar.addEventSource({
                    url: surl,
                    method: 'GET',
                    dataType: "json",
                })
                //calendar.refetchEvents()


            });

            $(document).on('change', '#teacher', function (e) {
                e.preventDefault();
                var teacher_id = $(this).val();
                var location_id = $('#location').val();

                var surl = '{{ url('admin/calender/get') }}';
                if (location_id) {
                    if (teacher_id) {
                        surl += '?teacher_id=' + teacher_id + '&location_id=' + location_id;
                    } else {
                        surl += '?location_id=' + location_id;
                    }
                } else {
                    if (teacher_id) {
                        surl += '?teacher_id=' + teacher_id;
                    }
                }
                //var surl = '{{ url('admin/calender/get') }}' + '?teacher_id='+teacher_id+'&location_id='+location_id;
                //calendar.getEventSources();
                console.log(calendar.getEventSources());
                calendar.getEventSources()[0].remove();
                calendar.addEventSource({
                    url: surl,
                    method: 'GET',
                    dataType: "json",
                })
                //calendar.refetchEvents()
            });
        </script>
    @endpush
@endsection
