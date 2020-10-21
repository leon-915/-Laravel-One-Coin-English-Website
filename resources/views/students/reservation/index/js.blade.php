<?php
    $upToMonth = \App\Models\Settings::getSettings('book_upto_month');
    $maxDate = date('Y-m-d', strtotime("+".$upToMonth." months"));
?>
<script type="text/javascript">
    var holidays = [];
    var chooseTeacher = "{{__('labels.stu_choose_teacher')}}";
    var chooseLocation = "{{__('labels.stu_choose_location')}}";

    var datepicker = $('#reserve_date').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "0:+10",
        //maxDate: "<?= $maxDate ?>",
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
            let service_id = $('#service').val();
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
                beforeSend: function () {
                    $('.app-loader').removeClass('d-none');
                },
                success: function (result) {
                    $('.app-loader').addClass('d-none');
                    $('#available_time').html(result);
                }
            });
            $("#reserve_date-error").hide();

            //resources/views/students/reservation/index/teacher_profile.blade.php
        }
    });

    $(document).on("change", "#service", function () {
        let service_id = $(this).val();
        if (service_id == '') {
            return false;
        }
        $.ajax({
            url: '{{ route('student.reservation.changeService') }}',
            type: 'POST',
            data: 'service_id=' + service_id,
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
                var locations = '<option value="">'+chooseLocation+'</option>';
                $.each(result.locations, function (index, value) {
                    locations += '<option value="' + index + '">' + value + '</option>';
                });
                $("#location").html(locations);
                var teachers = '<option value="">'+chooseTeacher+'</option>';
                $.each(result.teachers, function (index, value) {
                   teachers += '<option value="' + index + '">' + value + '</option>';
                });
                $("#teacher").html(teachers);

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
        let service_id = $('#service').val();
        let location_id = $(this).val();

        if (service_id == '') {
            return false;
        }
        $.ajax({
            url: '{{ route('student.reservation.changeLocation') }}',
            type: 'POST',
            data: 'service_id=' + service_id+'&location_id='+location_id,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('.app-loader').removeClass('d-none');
            },
            success: function (result) {
                $('.app-loader').addClass('d-none');
                var teachers = '<option value="">'+chooseTeacher+'</option>';
                $.each(result.teachers, function (index, value) {
                  /*  teachers += '<option value="' + value.teacher_id + '">' + value.firstname+' '+value.lastname + '</option>';*/
                    teachers += '<option value="' + index + '">' + value + '</option>';
                });
                $("#teacher").html(teachers);
                if(result.locationType.length > 0){
                    let lType = result.locationType;
                    //alert(lType);
                    if(lType == 'Classroom'){
                        $('#skype_id_container').addClass('d-none');
                        $('#location_detail_container').addClass('d-none');
                        $("#location_details").rules("remove");
                        $("#skype_id").rules("remove");
                    }else if(lType == 'Skype'){
                        $('#skype_id_container').removeClass('d-none');
                        $('#location_detail_container').addClass('d-none');
                        $("#skype_id").rules("add", {required: true});
                        $("#location_details").rules("remove");
                    }else{
                        $('#location_detail_container').removeClass('d-none');
                        $("#location_details").rules("add", {required: true});
                        $('#skype_id_container').addClass('d-none');
                        $("#skype_id").rules("remove");
                    }
                }
            }
        });
    });

    $(document).on("change",'#teacher', function(e){
        e.preventDefault();
        let teacher_id = $(this).val();
        $.ajax({
            url: "{{ route('students.reservation.booking.teacher.profile') }}",
            type: 'POST',
            data: {
                'teacher_id' : teacher_id
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('.app-loader').removeClass('d-none');
            },
            success: function (res) {
                $('.app-loader').addClass('d-none');
                if(res.type == 'success'){
                    $('#booking_teacher_profile').html(res.html);
                    $('.kv-ltr-theme-svg-star').rating({
                        theme: 'krajee-svg',
                        filledStar: '<span class="krajee-icon krajee-icon-star"></span>',
                        emptyStar: '<span class="krajee-icon krajee-icon-star"></span>',
                        starCaptions: function (rating) {
                            return rating == 1 ? 'One Star' : rating + ' Star';
                        }
                    });
                    $(".clear-rating").hide();
                    $(".caption").hide();

                    $('#reserve_date').val('');
                    $('#available_time').html('');
                }
            }
        });
    })

    window.setTimeout(function () {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
        $(".alert").fadeTo(4000, 2000).slideUp(1000, function(){
            $(".alert").slideUp(1000);
        });
    }, 5000);

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
            location_details: {
                required: true
            }
        },
        messages: {
            teacher: {
                required: "{{__('jsValidate.required.teacher')}}"
            },
            service: {
                required: "{{__('jsValidate.required.service')}}"
            },
            location: {
                required: "{{__('jsValidate.required.location')}}"
            },
            reserve_date: {
                required: "{{__('jsValidate.required.reserve_date')}}"
            },
            time: {
                required: "{{__('jsValidate.required.time')}}"
            },
            location_details: {
                required: "{{__('jsValidate.required.location_details')}}"
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == 'service') {
                error.insertAfter("#select_service");
            }else if (element.attr("name") == 'location') {
                error.insertAfter("#select_location");
            }else if (element.attr("name") == 'teacher') {
                error.insertAfter("#select_teacher");
            }else if (element.attr("name") == 'time') {
                error.insertAfter("#available_time");
            }
            else {
                error.insertAfter(element);
            }
        },
       /* submitHandler: function(form) {
            if(confirm('Do you really want to submit the form?')) {
                return true;
            }
            return false;
        }*/
    });

    $(document).on('click', '.onepage-tabs',function(e){
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
</script>
@if(App::isLocale('jp'))
	<script src="{{ asset('js/calendar_locale/jquery.ui.datepicker-ja.js') }}" type="text/javascript"></script>
@endif