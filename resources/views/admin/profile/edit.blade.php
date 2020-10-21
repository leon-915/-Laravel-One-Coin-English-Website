<?php
$url = "";
if(isset($user)){
    if($user->image){
        $url = asset($user->image);
    }
}
?>

@extends('admin.layouts.admin',['title'=>'Edit Profile'])

@section('title','Edit Profile')

@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title"> Edit Profile </h3>
		{{-- <nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit</li>
			</ol>
		</nav> --}}
	</div>
	<div class="row grid-margin">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Edit Profile</h4>

					@if (count($errors) > 0)
						@foreach ($errors->all() as $error)
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							{{ $error }}
						</div>
						@endforeach
					@endif


					{!! Form::model($user, ['method' => 'POST', 'class'=>'cmxform', 'id'=>'edit_profile','route' => ['editprofile'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}

						<div class="row">
							<div class="form-group col-4 m-auto profile-image-upload">
								{{-- <div class="row">
									<label class="col-auto p-auto text-center" for="image">Profile Image</label>
								</div> --}}
								<input type="file" name="image" id="input-file-max-fs" class="dropify"
								data-plugin="dropify"  data-default-file="{{ $url }}"
								data-errors-position="outside" data-show-remove="false"
								data-show-errors="true"
								/>
								<label id="input-file-max-fs-error" class="txt-red error"  for="input-file-max-fs"></label>
								<input type="hidden" name="pimage">
							</div>
						</div>

						<div class="row">
						    <div class="form-group col-md-6">
						        <label class="form-control-label" for="name">Name<span class="vali">*</span></label>
								{!!
									Form::text(
										'name',
										null,
										array(
											'placeholder' => 'name',
											'class' 	=> 'form-control',
											'id'  		=> 'name',
                                            "required" 	=> "true",
                                            "maxlength" => 15
										)
									)
								!!}
							</div>

							<div class="form-group col-md-6">
								<label class="form-control-label" for="email">email<span class="vali">*</span></label>
								{!!
									Form::text(
										'email',
										null,
										array(
											'placeholder' => 'email',
											'class' 	=> 'form-control',
											'id'  		=> 'email',
											"required" 	=> "true"
										)
									)
								!!}
							</div>
						</div>

						<div class="row">
							<div class="form-group col-md-2">
								{!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
							</div>
							<div class="form-group col-md-2">
								{!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".route('admin.dashboard')."'")) !!}
							</div>
						</div>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
	<script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
	@if(Session::has('message'))
        <script>
            $.toast({
                heading: 'Success',
                text: "<?= Session::get('message') ?>",
                icon: 'success',
                position: 'top-right',
            })
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            $.toast({
                heading: 'Error',
                text: "<?= Session::get('error') ?>",
                icon: 'error',
                position: 'top-right',
            })
        </script>
    @endif

	<script>
		$('#input-file-max-fs').dropify();

		$('#edit_profile').validate({ // initialize the plugin
                rules: {
                    name : {
                        required: true
                    },
                    email: {
                        required: true,
                        pattern : /^\b[a-z0-9._]+@[a-z0-9._]+?\.[a-z]{2,3}\b$/i,

                    },

                },
                messages: {
                    name : {
                        required : "Please enter name"
                    },
                    email: {
                        required: "Please enter email",
                        pattern : 'Please enter a valid email'
                    },
                }
            })

		$.validator.addMethod('filesize', function(value, element, param) {
			return this.optional(element) || (element.files[0].size <= param)
		});

		$(document).on('change','#input-file-max-fs', function () {
			// console.log($(this).val());
			$("#input-file-max-fs" ).rules( "add", {
				required : true,
				extension: "jpg,jpeg,png",
				filesize: 2097152,
				messages: {
					required: 'Please select File',
					extension: "Only jpg,jpeg,png file allowed",
					filesize: "The file size is too big (2MB max)",
				}
			});
		});
	</script>
@endpush
@endsection
