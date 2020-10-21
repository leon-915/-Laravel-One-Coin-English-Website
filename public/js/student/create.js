
		$('#input-file-max-fs').dropify();

		$('#create_student').validate({
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
                contact_no:{
                    required: true
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
                    required : required.firstname
                },
                lastname:{
                    required: required.lastname
                },
                email:{
                    required: required.email
                },
                contact_no : {
                    required : required.contact_no
				},
				status : {
					required : required.status
				},
				profile_image :{
					extension : extension.profile_image
				}
			},

		});
