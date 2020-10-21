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

$('#profile').validate({
    ignore: "",
    rules: {
        firstname : {
            required: true
        },
        lastname:{
            required: true
        },
        confirm_password:{
            equalTo: '#password'
        },
        contact_no:{
            required: true
        },
    },
    messages: {
        firstname : {
            required : required.firstname
        },
        lastname:{
            required: required.lastname
        },
        confirm_password:{
            equalTo: equalTo.confirm_password
        },
        contact_no : {
            required : required.contact_no
        },
    },

});

$(document).on('submit','#profile', function(e){
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
	
	/*if($('#saved_audio_attachment').val() == '' && $('#audio_attachment').val() == '') {
		$('#audio_attachment-error').html('This field is required.').show();
		$.toast({
			heading: 'Error',
			text: 'Audio file is mandatory.',
			icon: 'error',
			position: 'top-right',
		});
		return;
	}*/
    resize2.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (img) {
        if(isImg.length === 0){
            $('input[name=image]').val(img);
        }
        var data = new FormData($('#profile')[0]);
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
