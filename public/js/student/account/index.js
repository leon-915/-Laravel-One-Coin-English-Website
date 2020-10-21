$(document).ready(function(){
    $('.dash_tab').removeClass('active');
    dis.addClass('active');
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
})