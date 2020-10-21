$(document).on('click', 'a.btn-start-session', function (e) {
    e.preventDefault();
    $.ajax({
        data: $(this).data(),
        url: startSessionUrl,
        dataType: 'JSON',
        type: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function () {
            $('.app-loader').removeClass('d-none');
        },
        success: function (resp) {
            if (resp.type == 'success') {
                $('#one-page-canvas-container').html(resp.html);
                $('#onepage-session-canvas').collapse('show');
                $('.app-loader').addClass('d-none');
            }
        }
    })
});

$(document).on('change','#filter_point_type',function(e){
	var auto_save_filter_point = $("#auto_save_filter_point").val();
    $.ajax({
        data: {
            'filter_point_type' : $(this).val(),
            'booking_id' : $('#editor_textarea').attr('data-booking-id')
        },
        url: auto_save_filter_point,
        dataType: 'JSON',
        type: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (resp) {
            console.log("success");
        }
    })    
});



