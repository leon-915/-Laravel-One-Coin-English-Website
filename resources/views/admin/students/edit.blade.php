@extends('admin.layouts.admin',['title'=>'Edit Student'])

@section('title','Edit Student')

@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title"> {{ __('labels.edit_students') }} </h3>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard') }}</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">{{ __('labels.manage_students') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_students') }}</li>
			</ol>
		</nav>
	</div>
	<div class="row grid-margin">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">{{ __('labels.edit_students') }}</h4>

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


					{!! Form::model($student, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_student','route' => ['admin.students.update', $student->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
						@include('admin.students.form',['form' => 'edit'])
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

	var existUrl = '<?= route('admin.teachers.email.exist') ?>';

	</script>
	<script src="{{ asset('js/admin/student/edit.js') }}"></script>

@endpush
@endsection
