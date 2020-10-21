@extends('admin.layouts.admin',['title'=>'Edit Facebook Post'])

@section('title','Edit Facebook Post')

@section('content')
	<div class="content-wrapper">
		<div class="page-header">
			<h3 class="page-title"> Edit Facebook Post </h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.facebook-posts.index') }}">Manage Facebook Posts</a></li>
					{{-- <li class="breadcrumb-item active" aria-current="page">Create Facebook Post</li> --}}
				</ol>
			</nav>
		</div>
		<div class="row grid-margin">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Edit Facebook Post</h4>

						@if (count($errors) > 0)
							@foreach ($errors->all() as $error)
							<div class="alert alert-danger" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
								{{ $error }}
							</div>
							@endforeach
						@endif

						
						{!! Form::model($post, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_facebook_posts','route' => ['admin.facebook-posts.update', $post->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
						@include('admin.facebook-posts.form')
						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		<script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
		
		<script>
            var required = [];
            var extension = [];
            required.subject = '{{ __("jsValidate.required.subject") }}';
            required.message = '{{ __("jsValidate.required.message") }}';
            extension.image = '{{ __("jsValidate.extension.image") }}';

			$('#edit_facebook_posts').validate({
				ignore: "",
				rules: {
					message : {
	                    required: true,
	                    maxlength : 1000
	                },
	                subject:{
	                    required: true,
	                    maxlength : 191
	                }
				},
				messages: {
					message : {
	                    required : required.message,
	                    maxlength: "Please enter less than 1000 characters"
	                },
	                subject:{
	                    required: required.subject,
	                    maxlength: "Please enter less than 191 characters"
	                }
				},

			});

        </script>
	@endpush
@endsection
