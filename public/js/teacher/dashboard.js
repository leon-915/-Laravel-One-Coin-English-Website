var oTable = '';
$(document).ready(function(){
    let tab = cTab;
    let dis = $('a[aria-controls='+tab+']');
    let curl = dis.data('url');

    $('.setting-tabs').removeClass('active');
    dis.addClass('active');
    $('.tab-pane').removeClass('active').removeClass('show');
    $('#'+tab).addClass('active').addClass('show');

    if(curl){
        $.ajax({
            url : curl,
            dataType : 'JSON',
            type : 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend : function(){
                $('#'+tab).html(cloader);
            },
            success : function(resp) {
                if(resp.type == 'success'){
                    $('#'+tab).html(resp.html);
                    applyTabJs(tab);
                }
            }
        });
    }
});

$(document).on('click','.setting-tabs', function(e){
    e.preventDefault();
    e.stopPropagation();
    let tab = $(this).attr('aria-controls');

    const params = new URLSearchParams(location.search);
    params.set('ref', tab);
    window.history.replaceState({}, '', `${location.pathname}?${params}`);
    $('.setting-tabs').removeClass('active');
    $(this).addClass('active');

    let curl = $(this).data('url');
    if(curl){
        $.ajax({
            url : curl,
            dataType : 'JSON',
            type : 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend : function(){
                $('#'+tab).html(cloader);
            },
            success : function(resp) {
                if(resp.type == 'success'){
                    $('#'+tab).html(resp.html);
                    applyTabJs(tab);
                }
            }
        });
    }
});

$(document).on('submit', '#frm_update_schedule', function(e){
    e.preventDefault();
    e.stopPropagation();

    $('#teacher_locations_ltl').children('option').attr('selected','selected');

    let curl = $(this).attr('action');
    let fdata = $(this).serialize();

    $.ajax({
        url : curl,
        dataType : 'JSON',
        type : 'POST',
        data : fdata,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend : function(){
            $('.app-loader').removeClass('d-none');
        },
        success : function (resp) {
            if(resp.type == 'success'){
                $('#schedule').html(resp.html);
                $.toast({
                    heading: 'Success',
                    text: resp.message,
                    icon: 'success',
                    position: 'top-right',
                })
                $('.app-loader').addClass('d-none');
            }
        }
    });
});

function getDate( element ) {
    var date;
    try {
        date = $.datepicker.parseDate( dateFormat, element.value );
    } catch( error ) {
        date = null;
    }

    return date;
}
//app-loader

$('#frm_update_schedule').validate({
    rules: {
        'lesson_minute_able_to_teach[]' : {
            required: true,
        },

    },
    messages: {
        'lesson_minute_able_to_teach[]' : {
            required : "Please select lesson minute",
        },
    }
});

function applyTabJs(tab) {
    if(tab == 'lessons-recordes') {
         oTable = $('#lessons-table').DataTable({
            dom: "<'row'<'col-sm-12 col-md-9'i><'col-sm-12 col-md-3'l>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-12'p>>",
            processing: true,
            serverSide: true,
            searching: false,
            language: {
                'loadingRecords': '&nbsp;',
                'processing': '<div class="jumping-dots-loader"><span></span><span></span><span></span></div>',
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>",
                }
            },
            ajax: {
                url: lessonListUrl,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: function (d) {
                    d.from = $('input[name=from]').val();
                    d.to = $('input[name=to]').val();
                }
            },
            order: [[2,'ASC']],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'service', name: 'service'},
                {data: 'lession_date', name: 'lession_date'},
                {data: 'lession_time', name: 'lession_time'},
                {data: 'student_name', name: 'student_name'},
                {data: 'location', name: 'location'},
                {data: 'lesson_duration', name: 'lesson_duration'},
                {data: 'status', name: 'status'},
                {data: 'earnings', name: 'earnings'},
                /* {data: 'action', name: 'action',orderable: false, searchable: false} */
            ]
        });
    }

    $('#lesson_from').datepicker({
        dateFormat: 'yy-mm-dd',
        enableOnReadonly: true,
        todayHighlight: true,
    });

    $('#lesson_to').datepicker({
        dateFormat: 'yy-mm-dd',
        enableOnReadonly: true,
        todayHighlight: true,
    });
}

$(document).on('click', '#date_filter', function(e){
    e.preventDefault();
    $( "#lesson_date_filters" ).toggle('slide',{ direction: "right" }, 500);
    //$( "#lesson_date_filters" ).slideToggle( "slow" );
});

$(document).on('click', '#lesson_date_filters', function(e){

    e.preventDefault();
    e.stopPropagation();
    var days = 0;
    if($(e.target).is('#lesson_30')) {
        days = 30;
    }else if($(e.target).is('#lesson_60')) {
        days = 60;
    }else if($(e.target).is('#lesson_90')) {
        days = 90;
    }

    if(days != 0){
        var to = ($.datepicker.formatDate('yy/mm/dd', new Date()));
        var from = new Date(new Date().setDate(new Date().getDate() - days));
        from = ($.datepicker.formatDate('yy/mm/dd', from));

        $('input[name=from]').val(from);
        $('input[name=to]').val(to);


        oTable.draw(true);
    }

   /* e.preventDefault();
    e.stopPropagation();*/


});


$(document).on('click', '#btn-filter-lesson', function(e){
    e.preventDefault();
    e.stopPropagation();

    var from =$('#lesson_from').val();
    var to =$('#lesson_to').val();

    $('input[name=from]').val(from);
    $('input[name=to]').val(to);

    oTable.draw(true);

});



