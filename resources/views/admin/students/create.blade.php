@extends('admin.layouts.admin',['title'=>'Create Student'])

@section('title','Create Student')

@section('content')
	<div class="content-wrapper">
		<div class="page-header">
			<h3 class="page-title"> Create Student </h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Manage Students</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create Student</li>
				</ol>
			</nav>
		</div>
		<div class="row grid-margin">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Create Student</h4>

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

						{!! Form::open(array('route' => 'admin.students.store','class'=>'cmxform', 'id'=>'create_student','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
							<fieldset>
								@include('admin.students.form',['form' => 'create'])
							</fieldset>
						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		<script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

		<script>
            var required = [];
            var extension = [];
            required.firstname = '{{ __("jsValidate.required.firstname") }}';
            required.lastname = '{{ __("jsValidate.required.lastname") }}';
            required.email = '{{ __("jsValidate.required.email") }}';
            required.contact_no = '{{ __("jsValidate.required.contact_no") }}';
            required.status = '{{ __("jsValidate.required.status") }}';
            extension.profile_image = '{{ __("jsValidate.extension.profile_image") }}';

            var existUrl = '<?= route('admin.teachers.email.exist') ?>';
        </script>
        <script src="{{ asset('js/admin/student/create.js') }}"></script>

	@endpush
@endsection
