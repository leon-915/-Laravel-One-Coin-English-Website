var oTable = '';
var facebookTable = '';
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
                $('.tab-pane').html('');
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
   // alert(tab)

    let curl = $(this).data('url');
    if(curl){
        $.ajax({
            url : curl,
            dataType : 'JSON',
            type : 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend : function(){
                $('.tab-pane').html('');
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

exOptionAction = {
    inx : 1,
    mchtml : excpHtml,
    addOption : function(){
        $('#exception_container').append(this.mchtml.replace(/{inx}/g, this.inx));
        var dis = this;
        $('#from-'+this.inx).timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            dynamic: false,
            dropdown: true,
            change : function(e){
                let inx = $(this).data('id');

                var time = $(this).val();
                var getTime = time.split(":"); //split time by colon
                var hours = parseInt(getTime[0])+1; //add two hours
                //var newTime = hours+":"+getTime[1];
                var newTime = hours;

                $('#to-'+inx).timepicker( 'option','minHour', newTime );
            }
        });

        $('#to-'+this.inx).timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            dynamic: false,
            dropdown: true,
            change : function(e){
                let inx = $(this).data('id');

                var time = $(this).val();
                var getTime = time.split(":"); //split time by colon
                var hours = parseInt(getTime[0])-1; //add two hours
                //var newTime = hours+":"+getTime[1];
                var newTime = hours;

                $('#from-'+inx).timepicker( 'option','maxHour', newTime );
            }
            //scrollbar: true
        });

        from = $('#from_date-'+this.inx).datepicker({
            dateFormat: "yy-mm-dd",
            //maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            //yearRange: "-150:+0",
            // onClose: function( selectedDate ) {
            //     $( "#to_date-"+dis.inx ).datepicker( "option", "minDate", selectedDate );
            // }
        });

        to = $('#to_date-'+this.inx).datepicker({
            dateFormat: "yy-mm-dd",
            //maxDate: '-1d',
            changeMonth: true,
            changeYear: true,
            //yearRange: "-150:+0",
            // onClose: function( selectedDate ) {
            //     $("#from_date-"+dis.inx  ).datepicker( "option", "maxDate", selectedDate );
            // }
        });

        this.inx++;
    },
    removeOption : function(dis){
        var i = $(dis).data('id');
        $('#teacher-exception-'+i).remove();
    }
}

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

$('#frm_facebook').validate({
    rules: {
        'message' : {
            required: true,
            maxlength: 1000
        },
        'subject' : {
            required: true,
            maxlength: 191
        },
        'image' : {
            extension: "jpg,jpeg,png",
            filesize: 2097152,
        },

    },
    messages: {
        'message' : {
            required : "Please enter message"
        },
        'subject' : {
            required : "Please enter subject"
        },
        'image' : {
            extension: "Only jpg,jpeg,png file allowed",
            filesize: "The file size is too big (2MB max)",
        },

    }
});

/*$('#chooseFile').rules("add", {
    extension: "jpg,jpeg,png",
    filesize: 2097152,
    messages: {
        extension: "Only jpg,jpeg,png file allowed",
        filesize: "The file size is too big (2MB max)",
    }
});*/

/*$(document).on('change','#chooseFile', function () {
    $("#chooseFile" ).rules( "add", {
    //alert("Hii");
        extension: "jpg,jpeg,png",
        filesize: 2097152,
        messages: {
            extension: "Only jpg,jpeg,png file allowed",
            filesize: "The file size is too big (2MB max)",
        }
    });
});
*/
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
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'service', name: 'service'},
                {data: 'lession_date', name: 'lession_date'},
                {data: 'lession_time', name: 'lession_time'},
                {data: 'student_name', name: 'student_name'},
                //{data: 'location', name: 'location'},
                {data: 'lesson_duration', name: 'lesson_duration' ,orderable: false,},
                {data: 'status', name: 'status'},
                {data: 'earnings', name: 'earnings'},
                {data: 'action', name: 'action',orderable: false, searchable: false} 
            ]
        });
    }

    if(tab == 'facebook') {
        facebookTable = $('#facebook-table').DataTable({
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
                url: fbPostListUrl,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: function (d) {
                    d.filter_id = $('input[name=filter_id]').val();
                }
            },
            order: [[2,'ASC']],
            columns: [
                {data: 'subject', name: 'subject'},
                {data: 'message', name: 'message'},
                {data: 'user', name: 'user'},
                {data: 'created_at', name: 'created_at'},
                {data: 'image', name: 'image',orderable: false},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action',orderable: false, searchable: false}
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
});

$(document).on('click', '#filter_post', function(e){

    e.preventDefault();
    e.stopPropagation();
    var pid= '';
    var length = 0;

    if($(e.target).is('#1')) {
        pid = 1;
        length = 1;
    }else if($(e.target).is('#2')) {
        pid = 2;
        length = 1;
    }if($(e.target).is('#3')) {
        pid = 3;
        length = 1;
    }if($(e.target).is('#4')) {
        pid = 4;
        length = 1;
    }

    if(length === 1){
        $('input[name=filter_id]').val(pid);
        facebookTable.draw(true);
    }

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

$(document).on("click",".deletePost",function () {
    let urlDel = $(this).attr('data-url');
    $(".yes_delete").attr('url',urlDel);
    $("#deleteConfimModal").modal('show');
});

$(document).on("click",".yes_delete",function () {
    let post_id = $(this).attr('id');
    let url = $(this).attr('url');

    $.ajax({
        url: url,//"{{ route('teacher.facebook.post.delete') }}",//'{{ URL::to("delete-facebook-post") }}',
        type: 'GET',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            if(res.type == 'success'){
                $('.frm').removeClass('active');
                $('.msgs').addClass('active');
                $('.app-loader').addClass('d-none');
                $("#deleteConfimModal").modal("hide");
                facebookTable.draw();
            }
        }
    });
});

$(document).on("click",".editPost",function () {
    let url = $(this).attr('data-url');

    $.ajax({
        url: url,//"{{ route('teacher.facebook.post.delete') }}",//'{{ URL::to("delete-facebook-post") }}',
        type: 'GET',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            //alert(data);#New
            if(data.type == 'success'){
                $('#fb_subject').val(data.subject);
                $('#fb_message').val(data.message);
                $('#post_id').val(data.id);
                $('.frm-fb-errors').html('');

                $('.msgs').removeClass('active');
                $('.frm').addClass('active');
                $('#message').removeClass('active');
                $('#new_post').addClass('active');
            }
        }
    });
});

$(document).on('click', '#new_post', function(e){
    e.preventDefault();
    $('.frm-fb-errors').html('');
    document.getElementById("frm_facebook").reset();
});

$(document).on('submit', '#frm_facebook', function(e){
    e.preventDefault();
    e.stopPropagation();

    //$('#teacher_locations_ltl').children('option').attr('selected','selected');

    let curl = $(this).attr('action');
    let fdata = new FormData(this);//$(this).serialize();
    //console.log(fdata);

    $.ajax({
        url : curl,
        processData: false,
        contentType: false,
        dataType : 'JSON',
        type : 'POST',
        data : fdata,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend : function(){
            $('.app-loader').removeClass('d-none');
            $('.frm-fb-errors').html('');
        },
        success : function (resp) {
            if(resp.type == 'success'){
                temp = true;
                //location.reload();
                $('.frm').removeClass('active');
                $('.msgs').addClass('active');
                $('#new_post').removeClass('active');
                $('#message').addClass('active');
                $('.app-loader').addClass('d-none');
                facebookTable.draw();
            }/*else{
                $("#errors").html("<ul>"+data.msg+"</ul>");
                $("#errors").css("display","block");
                //clear all fields
                document.getElementById("frm_facebook").reset();
            }
      */
        },
        error: function(error){
            $('.app-loader').addClass('d-none');
            var temp = error.responseJSON.errors;

            $.each(temp, function(i, item) {
                $('#'+i+'-error').html(item[0]);
            });
        }
    });
});




