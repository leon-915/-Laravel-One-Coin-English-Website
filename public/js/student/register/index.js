
$('#registration').validate({
    ignore: "",
    rules: {
        firstname : {
            required: true,
            pattern : /^[a-zA-Z\s]+$/,
            maxlength: 50,
        },
        lastname:{
            required: true,
            pattern : /^[a-zA-Z\s]+$/,
            maxlength: 50,
        },
		firstname_ja : {
            required: true,
            maxlength: 50,
        },
        lastname_ja:{
            required: true,
            maxlength: 50,
        },
        email:{
            required: true,
            maxlength: 100,
            pattern : /^\b[a-z0-9\._\-]+@[a-z_\-\.]+?\.[a-z]{2,4}\b$/i,
            remote : {
                url : existUrl,
                type : 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data : {
                    email : function () {
                        return $('#email').val();
                    }
                }
            }
        },
        /*password:{
            required: true,
            minlength : 6
        },
        confirm_password:{
            equalTo: '#password'
        },
        contact_no:{
            required: true,
            maxlength: 15,
            minlength: 4,
            digits: true
        },*/
        CaptchaCode:{
            required: true
        },
        terms:{
            required: true
        },
    },
    messages: {
        firstname : {
            required : required.firstname,
            pattern : "Only alphabets are allowed",
            maxlength: "Please enter maximum 50 characters"
        },
        lastname:{
            required: required.lastname,
            pattern : "Only alphabets are allowed",
            maxlength: "Please enter maximum 50 characters"
        },
		firstname_ja : {
            required : required.firstname,
            pattern : "Only japanese is allowed",
            maxlength: "Please enter maximum 50 characters"
        },
        lastname_ja:{
            required: required.lastname,
            pattern : "Only japanese is allowed",
            maxlength: "Please enter maximum 50 characters"
        },
        email:{
            required: required.email,
            pattern : 'Please enter a valid email',
            remote : 'Email already exists',
            maxlength: "Please enter maximum 100 characters"
        },
        /*password:{
            required: required.password
        },
        confirm_password:{
            equalTo: equalTo.confirm_password
        },
        contact_no : {
            required : required.contact_no
        },*/
        CaptchaCode:{
            required: required.CaptchaCode
        },
        terms:{
            required: required.terms
        },
    },
});
