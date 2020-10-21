
		$('#input-file-max-fs').dropify();

		$('#edit_student').validate({
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
                password:{
                    required: true,
                    minlength : 6
                },
                confirm_password : {
                    equalTo : "#password"
                },
                contact_no:{
                    required: true,
                    maxlength: 15,
                    digits: true
				},
				status:{
					required : true
				},
				profile_image : {
					extension : ['jpg','png','jpeg']
				}
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
                email:{
                    required: required.email,
                    pattern : 'Please enter a valid email',
                    remote : 'Email already exists',
                    maxlength: "Please enter maximum 100 characters"
                },
                password: {
                    required: "Please enter password",
                    minlength: "Please enter minimum 6 characters"
                },
                confirm_password:{
                    equalTo: "Confirm password is not matched with password"
                },
                contact_no : {
                    required : required.contact_no,
                    maxlength: "Please enter maximum 15 digits"
				},
				status : {
					required : required.status
				},
				profile_image :{
					extension : extension.profile_image
				}
			},

		});
