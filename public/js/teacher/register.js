$('#dob').datepicker({
    dateFormat: "yy-mm-dd",
    maxDate: '-1d',
    changeMonth: true,
    changeYear: true,
    yearRange: "-150:+0",
});

$.validator.addMethod("phone", function(value, element) {
    return  this.optional(element) || /^\+(?:[0-9] ?){6,14}[0-9]$/.test(value);
    }, "Please provide a valid phone number."
);

// jQuery.validator.addMethod("birthdate", function(value, element) {
//     return value.match(/^dddd?-dd?-dd$/);
// });

$('#teacher-register').validate({
    rules: {
        /*'firstname' : {
            required: true,
            pattern : /^[a-zA-Z\s]+$/,
        },
        'lastname' : {
            required: true,
            pattern : /^[a-zA-Z\s]+$/,
        },*/
        'email': {
            required: true,
            pattern : /^\b[a-z0-9.\-_]+@[a-z_.\-]+?\.[a-z]{2,4}\b$/i,
            remote : {
                url : emailExistUrl,
                type : 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data : {
                    email : function () {
                        return $('#email').val();
                    }
                }
            }
        },
    },
    messages: {
        /*firstname : {
            required : "Please enter firstname",
            pattern : "Only alphabets are allowed"
        },
        lastname : {
            required : "Please enter lastname",
            pattern : "Only alphabets are allowed"
        },*/
        email: {
            required: "Please enter email",
            pattern : 'Please enter a valid email',
            remote : 'Email already exists'
        },
    }
});

$('#from-0').timepicker({
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
$('#to-0').timepicker({
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
});

optionAction = {
    inx : 1,
    mchtml : schHtml,
    addOption : function(){
        $('#day-schedules').append(this.mchtml.replace(/{inx}/g, this.inx));
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

        this.inx++;
    },
    removeOption : function(dis){
        var i = $(dis).data('id');
        console.log(i);
        $('#teacher-schedule-'+i).remove();
        //this.inx--;
    }
}

$(document).on('change', 'input[name=japanese_ability]', function(e){
    e.preventDefault();
    let checked =  $(this).val();
    console.log(checked);
    if(checked == 'jplt_score'){
        $('#jplt_score_container').removeClass('d-none');
        $("#jplt_score").rules( "add", { required: true });
    } else {
        $('#jplt_score_container').addClass('d-none');
        $("#jplt_score").rules( "remove" );
    }
});

$(document).on('change','select#country',function(e){
    e.preventDefault();
    if($(this).val().toLowerCase() == 'japan'){
        $('.teaching_mode_jp_container').removeClass('d-none');
        $('.teaching_mode_remote_container').addClass('d-none');
        $('#teaching_mode_remote').children('input[type=checkbox]').prop("checked",false);
        $( "input[name='teaching_locations[]']" ).rules( "add", {
            required: true
        });
		
		$('#remote_teaching').prop("checked",false);
        $('.remote-required').addClass('d-none');		
        $( "#skype_id" ).rules("remove");
        $( "#internet_connection_speed_link" ).rules("remove");
		
        $( "input[name='teaching_mode']" ).rules("remove");
		
    } else {
        $('.teaching_mode_remote_container').removeClass('d-none');
        $('.teaching_mode_jp_container').addClass('d-none');
        $('.teaching_mode_jp').children('input[type=checkbox]').prop("checked",false);
        $('input[type=checkbox].teacher_locations').prop("checked",false);
        $('#cafe-locations').addClass('d-none');
        $( "input[name='teaching_locations[]']" ).rules("remove");
		
		$('#remote_teaching').prop("checked",true);
        $('.remote-required').removeClass('d-none');
		$( "input[name='teaching_mode']" ).rules( "add", {
            required: true
        });
		
		$( "#skype_id" ).rules( "add", {
            required: true
        });
        $( "#internet_connection_speed_link" ).rules( "add", {
            url: true
        });
    }
});

$(document).on("keyup", "#myInput",function() {
    var value = this.value.toLowerCase().trim();
    $(".register-locations label").show().filter(function() {
        return $(this).data('text').toLowerCase().trim().indexOf(value) == -1;
    }).hide();
});

$(document).on('change', '#remote_teaching', function(e){
    e.preventDefault();
    let checked =  $(this).prop("checked");
    if(checked){
        $('.remote-required').removeClass('d-none');
        $( "#skype_id" ).rules( "add", {
            required: true
        });
        $( "#internet_connection_speed_link" ).rules( "add", {
            url: true
        });
    } else {
        $('.remote-required').addClass('d-none');
        $( "#skype_id" ).rules("remove");
        $( "#internet_connection_speed_link" ).rules("remove");
    }
});

$(document).on('change', '#cafe_teaching', function(e){
    e.preventDefault();
    let checked =  $(this).prop("checked");
    if(checked){
        $('#cafe-locations').removeClass('d-none');
    } else {
        $('input[type=checkbox].teacher_locations').prop("checked",false);
        $('#cafe-locations').addClass('d-none');
    }
});

$('#online_teaching').change(function(e){
    e.preventDefault();
    let checked =  $(this).prop("checked");
    if(checked){
        $('.remote-required').removeClass('d-none');
        $( "#skype_id" ).rules( "add", {
            required: true
        });
        $( "#internet_connection_speed_link" ).rules( "add", {
            url: true
        });
    } else {
        $('.remote-required').addClass('d-none');
        $( "#skype_id" ).rules("remove");
        $( "#internet_connection_speed_link" ).rules("remove");
    }
});

function changePercentage(dis) {
    console.log($(dis).val());
    var id = $(dis).attr('id') + '_val';
    var val = $(dis).val();
    console.log(val + ' %');
    $('#'+id).text(val + ' %');
}

function changePercentageGlobal(dis) {
    if($(dis).val() > 0){
        $('#global_lesson_price-error').addClass('d-none');
    }
    console.log($(dis).val());
    var id = $(dis).attr('id') + '_val';
    var val = $(dis).val();
    $('#'+id).text(val + ' ¥');
}

