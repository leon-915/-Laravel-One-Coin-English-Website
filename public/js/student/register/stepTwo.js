var holidays = [];

var datepicker = $('#reserve_date').datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    yearRange: "0:+10",
    maxDate: vmaxDate,
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
        let service_id = $("input[name='service']:checked").val();
        $.ajax({
            url: setDatePickerUrl,
            type: 'POST',
            data: {
                'date'       : date,
                'teacher_id' : teacher_id,
                'service_id' : service_id,
            },
            headers: {
                'X-CSRF-Token': csrfToken
            },
            beforeSend: function () {
                $('.app-loader').removeClass('d-none');
            },
            success: function (result) {
                //console.log(result);
                $('.app-loader').addClass('d-none');
                $('#available_time').html(result);
            }
        });
    }
});

$('#stepTwo').validate({
    ignore: "",
    rules: {
        teacher: {
            required: true
        },
        service: {
            required: true
        },
        location: {
            required: true
        },
        reserve_date: {
            required: true
        },
        time: {
            required: true
        },
        firstname: {
            required: true
        },
        lastname: {
            required: true
        },
        email: {
            required: true
        },
        location_details: {
            required: true
        }
    },
    messages: {
        teacher: {
            required: required.teacher
        },
        service: {
            required: required.service
        },
        location: {
            required: required.location
        },
        reserve_date: {
            required: required.reserve_date
        },
        time: {
            required: required.time
        },
        firstname: {
            required: required.firstname
        },
        lastname: {
            required: required.lastname
        },
        email: {
            required: required.email
        },
        location_details: {
            required: required.location_details
        }
    },
    errorPlacement: function(error, element) {
        if (element.attr("name") == 'service') {
            error.insertAfter("#services");
        }
        else {
            error.insertAfter(element);
        }
    },
    submitHandler: function(form) {
        if(confirm(submitLables)) {
            return true;
        }
        return false;
    }
});


/*$(document).on("change", "#teacher", function () {
    let teacher_id = $(this).val();
    let service_id = $("input[name='service']:checked").val();
    if (teacher_id == '' || service_id == '') {
        return false;
    }
    $.ajax({
        url: getLocationUrl,
        type: 'POST',
        data: {'teacher_id': teacher_id, 'service_id' : service_id},
        headers: {
            'X-CSRF-Token': csrfToken
        },
        success: function (result) {
            var html = '<option value="">Choose Location</option>';
            $.each(result, function (index, value) {
                html += '<option value="' + index + '">' + value + '</option>';
            });
            $("#location").html(html);
        }
    });

    datepicker.show();

});*/



 $(document).on("change", "input[type=radio][name=service]", function () {
    let service_id = $("input[name='service']:checked").val();
    $.ajax({
        url: getLocationUrl,
        type: 'POST',
        data: {
            'service_id': service_id,
        },
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (res.type == 'success') {
                 if(res.holidays.length > 0){
                    $.each(res.holidays, function (index, value) {
                       holidays.push(value);
                    });
                }
                if (res.teachers) {
                    var thtml = '<option value="">'+chooseTeacher+'</option>';
                    $.each(res.teachers, function (tindex, tvalue) {
                        thtml += '<option value="' + tindex + '">' + tvalue + '</option>';
                    });
                    $("#teacher").html(thtml);
                }

                if (res.locations) {
                    var lhtml = '<option value="">'+selectLocation+'</option>';
                    $.each(res.locations, function (lindex, lvalue) {
                        lhtml += '<option value="' + lindex + '">' + lvalue + '</option>';
                    });
                    $("#location").html(lhtml);
                }

                if(res.maxDate != '1970-01-01'){
                    $('#reserve_date').datepicker('option','maxDate',res.maxDate);
                }

                if(res.minDate){
                    $('#reserve_date').datepicker('option','minDate',res.minDate);
                }
            }
        }
    });
});

$(document).on("change", "#teacher", function () {
    let teacher_id = $(this).val();
    let service_id = $("input[name='service']:checked").val();
    if (teacher_id == '' || service_id == '') {
        return false;
    }
    $.ajax({
        url: getLocationUrl,
        type: 'POST',
        data: {
            'service_id': service_id,
            'teacher_id': teacher_id,
        },
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': csrfToken
        },
        success: function (res) {
            if (res.type == 'success') {
                if (res.locations) {
                    var lhtml = '<option value="">'+selectLocation+'</option>';
                    $.each(res.locations, function (lindex, lvalue) {
                        lhtml += '<option value="' + lindex + '">' + lvalue + '</option>';
                    });
                    $("#location").html(lhtml);
                }
            }
        }
    });

    datepicker.show();
});

$(document).on('change', '#location', function(e){
    e.preventDefault();
    //let location =  $("#location option:selected").text().toLowerCase();
    let location =  $("#location").val();
	let skype_location_id = $("#skype_location_id").val();
	let studio_location_id = $("#studio_location_id").val();
    //alert(location);
    if(location == skype_location_id){
        $('#skype-id-container').removeClass('d-none');
        $("#skype_id").rules( "add", { required: true });
		
		$('#location-details-container').addClass('d-none');
        $("#location_details").rules( "remove" );
    } else if (location != studio_location_id) {
        $('#skype-id-container').addClass('d-none');
        $("#skype_id").rules( "remove" );
		
		$('#location-details-container').removeClass('d-none');
        $("#location_details").rules( "add", { required: true } );
    }
});



/*$('#stepTwo').on('submit', function() {

    if(confirm('Do you really want to submit the form?')) {
        return true;
    }
    return false;
});
*/
