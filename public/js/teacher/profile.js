var counter = 0;
var resize2 = $('#upload-demo').croppie({
    url:  $("#url").val(),
    enableExif: true,
    enableOrientation: true,
    viewport: { // Default { width: 100, height: 100, type: 'square' }
        width: 170,
        height: 170,
        //type: 'circle' //square
        type: 'circle' //square
    },
    boundary: {
        width: 170,
        height: 170
    },
    update: function() {
        if(counter==0){
            counter++;
            jQuery('#upload-demo').croppie('setZoom', 0);
        }
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
        resize2.croppie('bind',{
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

$(document).on('submit','#personal-info', function(e){
    var isImg = '';
    e.preventDefault();

    let image = $('#image').val();
    console.log(image);
    if(image.length > 0){
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
        isImg = 1;
        $('input[name=image]').val('');
        /*$('#image-error').html('Please select image.').removeClass('d-none').css('display','');
        return;*/
    }
	
	if($('#saved_audio_attachment').val() == '' && $('#audio_attachment').val() == '') {
		$('#audio_attachment-error').html('This field is required.').show();
		$.toast({
			heading: 'Error',
			text: 'Audio file is mandatory.',
			icon: 'error',
			position: 'top-right',
		});
		return;
	}
    resize2.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (img) {
        if(isImg.length === 0){
            $('input[name=image]').val(img);
        }
        var data = new FormData($('#personal-info')[0]);
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
            success: function (res) {
                if(res.type == 'success'){
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

$('#dob').datepicker({
    dateFormat: "yy-mm-dd",
    maxDate: '-1d',
    changeMonth: true,
    changeYear: true,
    yearRange: "-150:+0",
});

$.validator.addMethod("zipcode", function(value, element) {
    return this.optional(element) || /(^\d{6}$)|(^\d{6}-\d{6}$)/.test(value);
    }, "Please provide a valid zip code."
);

$('#profile').validate({
    rules: {
        'message_en' : {
            required: true,
        },
        'hobby' : {
            required: true,
        },
        'teaching_year_begun': {
            required: true,
            pattern : /^[0-9]{4}$/,
        },
        'teaching_certificate[]' : {
            required: true,
        },
        'japanese_ability':{
            required: true
        },
         'global_lesson_price':{
            required: true,
            min: 1,
        },
       /* 'highest_education[]' : {
            required: true
        },*/
        'courses_teach[]' : {
            required: true
        }
    },
    messages: {
        message_en : {
            required : "Please enter message",
        },
        hobby : {
            required : "Please enter hobby",
        },
        teaching_year_begun: {
            required: "Please enter year started teaching",
            pattern : 'Please enter a valid year',
        },
        'teaching_certificate[]':{
            required: "Please select teaching certificates"
        },
        japanese_ability: {
            required: "Please select japanese ability",
        },
        'highest_education[]':{
            required: "Please select highest education",
        },
        'courses_teach[]':{
            required: "Please select course do you teach"
        },
        global_lesson_price:{
            required: "Please select global lesson price",
            min: "Please select global lesson price",
        }
    }
});

$('#personal-info').validate({
    rules: {
        'firstname' : {
            required: true,
            pattern : /^[a-zA-Z\s]+$/,
        },
        'lastname' : {
            required: true,
            pattern : /^[a-zA-Z\s]+$/,
        },
       'image' : {
		   required: true,
           extension: "jpg,jpeg,png",
           filesize: 2097152,
        },
        address_line1 : {
            required : true
        },
        own_realstate_in_japan : {
            required : true
        },
        nationality : {
            required : true
        },
        paypal_email : {
            pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
        },
		'message_to_student' : {
            required: true,
        },
		'japanese_resident' : {
            required: true,
        },
        dob : {
            required : true
        },
    },
    messages: {
        'image' : {
            required: 'Please select File',
            extension: "Only jpg,jpeg,png file allowed",
            filesize: "The file size is too big (2MB max)",
        },
        address_line1 : {
            required : "Please enter address"
        },
        nationality : {
            required : "Please select nationality"
        },
        paypal_email : {
            pattern : 'Please enter a valid email',
        },
		message_to_student : {
            required : "Please enter message",
        },
        dob : {
            required : "Please enter birth date"
        },
    }
});

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

$(document).on('change', 'input[name=japanese_resident]', function(e){
    e.preventDefault();
    let checked =  $(this).val();
    console.log(checked);
    if(checked == '1'){
        $('#address_line_div').addClass('d-none');
        $("#address_line1").rules( "remove" );
    } else {
        $('#address_line_div').removeClass('d-none');
        $("#address_line1").rules( "add", { required: true });
    }
});

$(document).on('change', '#remote_teaching', function(e){
    e.preventDefault();
    let checked =  $(this).prop("checked");
    if(checked){
        $('.remote-required').removeClass('d-none');
        $( "#skype_id" ).rules( "add", {
            required: true
        });
    } else {
        $('.remote-required').addClass('d-none');
        $( "#skype_id" ).rules("remove");
    }
    console.log(checked);
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

$(document).on('change','#profile_image', function () {
    $("#profile_image" ).rules( "add", {
        extension: "jpg,jpeg,png",
        filesize: 2097152,
        messages: {
            extension: "Only jpg,jpeg,png file allowed",
            filesize: "The file size is too big (2MB max)",
        }
    });
});

$(document).on('change','#attachments', function () {
    $("#attachments" ).rules( "add", {
        extension: "pdf|docx|xls|xlsx|jpg|jpeg|gif|png|txt|csv|doc",
        messages: {
            extension: "Only pdf, docx, xls, xlsx, jpg, gif, png, text, csv file allowed",
        }
    });
});

$(document).on('change','#audio_attachment', function () {
    $("#audio_attachment" ).rules( "add", {
        extension: "mp4|mp3",
        messages: {
            extension: "Only Mp4, Mp3 file allowed",
        }
    });
});

$(document).on('click', '#delete_account', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var url = $('#delete_teacher').data('url');
    swal({
        title: "Are you sure to delete the account?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes",
        closeOnConfirm: true
    },
    function(isConfirm){
        console.log(isConfirm);
        if (isConfirm) {
             $.ajax({
                url: url,
                dataType: 'JSON',
                type: 'GET',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend:function(){
                    $('.app-loader').removeClass('d-none');
                },
                success: function (res) {
                    $("#exampleModalPrimary").modal('hide');
                    window.location.href = res.redirect;
                    //$('.app-loader').addClass('d-none');
                }
            });
        }});
   
});

function changePercentage(dis) {
    console.log($(dis).val());
    var id = $(dis).attr('id') + '_val';
    var val = $(dis).val();
    console.log(val + ' %');
    $('#'+id).text(val + ' %');
}

function changePercentageGlobal(dis) {
    console.log($(dis).val());
    var id = $(dis).attr('id') + '_val';
    var val = $(dis).val();
    console.log(val + ' %');
    $('#'+id).text('￥' + val);
}

$('#video').on('change', function () {
    $(this).rules( "add", {
        extension: "mp4",
        messages: {
            extension: "Only mp4 file allowed.",
        }
    });
});
