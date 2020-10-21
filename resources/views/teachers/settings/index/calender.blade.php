
<div class="lesson_record_sec calender">
    <div id="teacher-calendar"></div>
    <div class="text-center mt-3">
        <a class="google-calender" target="_blank" href="https://calendar.google.com/calendar/render?tab=mc">
            <i class="fas fa-calendar"></i> click here to view google calender
        </a>
    </div>
</div>
<script>
    var calendarEl = null;
    var calendar = null;
    var calendarData = null;

    calendarEl = document.getElementById('teacher-calendar');

    calendarData = <?= json_encode($teacherLData) ?>;
    var getIcalDataUrl = "{{url('admin/calender/getIcalData')}}";

    calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['interaction', 'dayGrid', 'timeGrid','list'],
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
        events : calendarData,
        eventColor: '#002e58',
        eventTextColor: '#fff',
        eventBorderColor: '#fff',
        eventTimeFormat:{
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'medium'
        },
        scrollTime : "08:00:00",
        lazyFetching:true,
        eventRender: function(info, element, view) {
            //console.log(info.view.type );
            info.el.style.padding = '5px';
            //info.el.style.('font-size', '1.2em');
            if(info.view.type == 'dayGridMonth'){
                info.el.style.width = '130px';
                //info.el.style.height= '6em';
                info.el.style.font.size= '14px';
                info.el.style.font.weight= '500';
            }

            if(info.view.type == 'timeGridWeek'){

               /*  info.el.style.width = '134px';
                info.el.style.top = '335px'; */
                //info.el.style.height= '6em';
            }

            if(info.view.type == 'timeGridDay'){

                /* info.el.style.width = '134px';
                info.el.style.top = '335px'; */
            }
        },
        eventClick: function(info) {
            console.log('Event: ' + info.event.title);
            //console.log('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            //console.log('View: ' + info.view.type);

            // change the border color just for fun
            info.el.style.borderColor = 'red';
        }
    });

	calendar.addEventSource({
		url: getIcalDataUrl,
		method: 'GET',
		dataType: "json",
	});
    calendar.render();
</script>
