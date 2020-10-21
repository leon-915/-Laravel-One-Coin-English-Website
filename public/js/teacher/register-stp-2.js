var resize = $('#upload-demo').croppie({
    enableExif: true,
    enableOrientation: true,
    viewport: { // Default { width: 100, height: 100, type: 'square' }
        width: 180,
        height: 180,
        //type: 'circle' //square
        type: 'square' //square
    },
    boundary: {
        width: 260,
        height: 260
    }
});

$('#image').on('change', function (e) {
    //console.log(this);
    console.log(this.files[0]);

    var ext = $(this).val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png','jpg','jpeg']) == -1){
        console.log('invalid');
        $('#image-error').html('Only jpg,jpeg,png file allowed.').removeClass('d-none');
        return;
    } else {
        $('#image-error').html('').addClass('d-none');
        console.log('valid');
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        resize.croppie('bind',{
            url: e.target.result
        });
    }
    reader.readAsDataURL(this.files[0]);
   //s console.log(this.files[0]['type']);
});

$('.file-upload-browse').on('click', function() {
    //var file = $(this).parent().parent().parent().find('.file-upload-default');
    $('#image').trigger('click');
});
$('#image').on('change', function() {
    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});


$(document).on('submit','#registration_step2', function(e){
    e.preventDefault();
    let image = $('#image').val();
    console.log(image);
    if(image){
        var ext = image.split('.').pop().toLowerCase();
        if ($.inArray(ext, ['png','jpg','jpeg']) == -1){
            console.log('invalid');
            $('#image-error').html('Only jpg,jpeg,png file allowed.').removeClass('d-none');
            return;
        } else {
            $('#image-error').html('').addClass('d-none');
            console.log('valid');
        }
    } else {

        $('#image-error').html('Please select image.').removeClass('d-none').css('display','');
        return;
    }

    resize.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (img) {
        $('input[name=image]').val(img);
        var data = new FormData($('#registration_step2')[0]);
        console.log(data);
        $.ajax({
            url: Url,
            type: "POST",
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('.app-loader').removeClass('d-none');
            },
            success: function (res) {
                if(res.type == 'success'){
                    $('.app-loader').addClass('d-none');
                    window.location.href = res.redirect;
                }
            },
			error: function (jqXhr) {
                    $('.app-loader').addClass('d-none');
                if (jqXhr.status === 422 || jqXhr.status === 413)
                {
					$.toast({
						heading: 'Error',
						text: 'Error in uploading video',
						icon: 'error',
						position: 'top-right',
					})
                }
            }
        });
    });
    e.preventDefault();
});

$('#visa_expirey_date').datepicker({
    dateFormat: "yy-mm-dd",
    minDate: '1d',
    changeMonth: true,
    changeYear: true,
    yearRange: "0:+10",
});

$.validator.addMethod('filesize', function(value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
});


$('#registration_step2').validate({
    rules: {
       /* 'profile_pic' : {
            required : true,
            extension: "jpg,jpeg,png",
            filesize: 2097152,
        },
        'courses_teach[]' : {
            required: true,
        },*/
        'check_terms' : {
            required : true ,
        },

    },
    messages: {
       /* 'profile_pic' : {
            required: 'Please select File',
            extension: "Only jpg,jpeg,png file allowed",
            filesize: "The file size is too big (2MB max)",
        },
        'courses_teach[]' : {
            required : "Please select course type."
        },*/
        'check_terms' : {
            required : "Please accept terms and conditions."
        },
        // 'image' : {

        // }
    }
});

/*$("#image" ).rules( "add", {
    required : true,
    extension: "jpg|jpeg|png",
    messages: {
        required: 'Please select image.',
        extension: "Only jpg,jpeg,png file allowed.",
    }
});*/

/*$(document).on('submit','#registration_step2', function (e) {
   // console.log(123);

});*/

$(document).on('change','#attachments', function () {
    $(this).rules( "add", {
        extension: "pdf|docx|xls|xlsx|jpg|jpeg|gif|png|text|csv",
        messages: {
            extension: "Only pdf, docx, xls, xlsx, jpg, gif, png, text, csv file allowed",
        }
    });
});

$('#video').on('change', function () {
    $(this).rules( "add", {
        extension: "mp4",
        messages: {
            extension: "Only mp4 file allowed.",
        }
    });
});
