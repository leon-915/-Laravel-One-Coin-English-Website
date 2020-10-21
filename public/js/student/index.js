		$('#registration').validate({
			ignore: "",
			rules: {
				firstname : {
                    required: true
                },
                lastname:{
                    required: true
                },
                email:{
                    required: true
                },
                password:{
                    required: true
                },
                confirm_password:{
                    equalTo: '#password'
                },
                contact_no:{
                    required: true
				},
				CaptchaCode:{
                    required: true
				},
				terms:{
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
                email:{
                    required: required.email
                },
                password:{
                    required: required.password
                },
                confirm_password:{
                    equalTo: equalTo.confirm_password
                },
                contact_no : {
                    required : required.contact_no
                },
                CaptchaCode:{
                    required: required.CaptchaCode
                },
                terms:{
                    required: required.terms
				},
				
				
			},
			
		});