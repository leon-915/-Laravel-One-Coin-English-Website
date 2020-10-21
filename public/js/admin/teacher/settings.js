$(document).ready(function () {
    let tab = cTab;
    let dis = $('a[aria-controls=' + tab + ']');
    let curl = dis.data('url');

    $('.setting-tabs').parent('li').removeClass('active');
    dis.parent('li').addClass('active');
    $('.tab-pane').removeClass('active').removeClass('show');
    $('#' + tab).addClass('active').addClass('show');

    if (curl) {
        $.ajax({
            url: curl,
            dataType: 'JSON',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function () {
                $('#' + tab).html(cloader);
            },
            success: function (resp) {
                if (resp.type == 'success') {
                    $('#' + tab).html(resp.html);
                }
            }
        });
    }
});


$(document).on('click', '.setting-tabs', function (e) {
    e.preventDefault();
    e.stopPropagation();
    let tab = $(this).attr('aria-controls');

    const params = new URLSearchParams(location.search);
    params.set('ref', tab);
    window.history.replaceState({}, '', `${location.pathname}?${params}`);
    $('.setting-tabs').parent('li').removeClass('active');
    $(this).parent('li').addClass('active');

    let curl = $(this).data('url');
    if (curl) {
        $.ajax({
            url: curl,
            dataType: 'JSON',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function () {
                $('#' + tab).html(cloader);
            },
            success: function (resp) {
                if (resp.type == 'success') {
                    $('#' + tab).html(resp.html);
                }
            }
        });
    }
});

$(document).on('submit', '#frm_update_schedule', function (e) {
    e.preventDefault();
    e.stopPropagation();

    $('#teacher_locations_ltl').children('option').attr('selected', 'selected');

    let curl = $(this).attr('action');
    let fdata = $(this).serialize();

    $.ajax({
        url: curl,
        dataType: 'JSON',
        type: 'POST',
        data: fdata,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function () {
            $('.app-loader').removeClass('d-none');
        },
        success: function (resp) {
            if (resp.type == 'success') {
                //$('#schedule').html(resp.html);
                window.location.href = resp.redirect;
                /* $.toast({
                     heading: 'Success',
                     text: resp.message,
                     icon: 'success',
                     position: 'top-right',
                 })
                 $('.app-loader').addClass('d-none');*/
            }
        }
    });
});

console.log(icalHtml);
linkOptionAction = {
    inx: parseInt(icalI),
    mchtml: icalHtml,
    addOption: function () {
        $('.cal_row').append(this.mchtml.replace(/{inx}/g, this.inx));
        this.inx++;
    },
    removeOption: function (dis) {
        var i = $(dis).data('id');
        $('#calendar_url_' + i).remove();
    }
};

exOptionAction = {
    inx: 1,
    mchtml: excpHtml,
    addOption: function () {
        console.log(this.mchtml);
        $('#exception_container').append(this.mchtml.replace(/{inx}/g, this.inx));
        var dis = this;
        $('#from-' + this.inx).timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            dynamic: false,
            dropdown: true,
            change: function (e) {
                let inx = $(this).data('id');

                var time = $(this).val();
                var getTime = time.split(":"); //split time by colon
                var hours = parseInt(getTime[0]) + 1; //add two hours
                //var newTime = hours+":"+getTime[1];
                var newTime = hours;

                $('#to-' + inx).timepicker('option', 'minHour', newTime);
            }
        });

        $('#to-' + this.inx).timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            dynamic: false,
            dropdown: true,
            change: function (e) {
                let inx = $(this).data('id');

                var time = $(this).val();
                var getTime = time.split(":"); //split time by colon
                var hours = parseInt(getTime[0]) - 1; //add two hours
                //var newTime = hours+":"+getTime[1];
                var newTime = hours;

                $('#from-' + inx).timepicker('option', 'maxHour', newTime);
            }
            //scrollbar: true
        });

        $('#from_date-' + this.inx).datepicker({
            dateFormat: "yy-mm-dd",
            enableOnReadonly: true,
            todayHighlight: true,
            minDate: '0d',
            changeMonth: true,
            changeYear: true,
            onClose: function (selectedDate) {
                $("#to_date-" + dis.inx).datepicker("option", "minDate", selectedDate);
                var date2 = $('#from_date-' + dis.inx).datepicker('getDate', '+1d');
                date2.setDate(date2.getDate() + 1);
                $('#to_date-' + dis.inx).datepicker('setDate', date2);
            }
        });

        $('#to_date-' + this.inx).datepicker({
            dateFormat: "yy-mm-dd",
            enableOnReadonly: true,
            todayHighlight: true,
            minDate: '0d',
            changeMonth: true,
            changeYear: true,
            onClose: function (selectedDate) {
                $("#from_date-" + dis.inx).datepicker("option", "maxDate", selectedDate);
            }
        });

        this.inx++;
    },
    removeOption: function (dis) {
        var i = $(dis).data('id');
        $('#teacher-exception-' + i).remove();
    }
}

function getDate(element) {
    var date;
    try {
        date = $.datepicker.parseDate(dateFormat, element.value);
    } catch (error) {
        date = null;
    }

    return date;
}

//app-loader

$('#frm_update_schedule').validate({
    rules: {
        'lesson_minute_able_to_teach[]': {
            required: true,
        },

    },
    messages: {
        'lesson_minute_able_to_teach[]': {
            required: "Please select lesson minute",
        },
    }
});


