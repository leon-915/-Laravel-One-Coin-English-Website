@extends('admin.layouts.admin',['title'=>'Points To Student'])

@section('title','Points To Student')

@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title"> {{ __('labels.points_to_student') }} </h3>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard') }}</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">{{ __('labels.manage_students') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">{{ __('labels.points_to_student') }}</li>
			</ol>
		</nav>
	</div>
	<div class="row grid-margin">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">{{ __('labels.points_to_student') }}</h4>

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


					{!! Form::model($student, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'points_to_student','route' => ['admin.students.update.points', $student->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}


						<div class="row">
							<div class="form-group col-12 col-md-6 col-lg-6">
						        <label class="form-control-label" for="reward_points">{{ __('labels.reward_points') }}</label>
						        {!! Form::text('reward_points', isset($student->reward_balance) ? $student->reward_balance : '', array('placeholder' => 'Reward Points','class'=> 'form-control','id' => 'reward_points'))!!}
						    </div>
						</div>

						<div class="row">
							<div class="form-group col-md-2">
								{!! Form::submit(__('labels.submit') ,array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
							</div>
							<div class="form-group col-md-2">
								{!! Form::button(__('labels.cancel') ,array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/students')."'")) !!}
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
	<script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
	<script type="text/javascript">

	$('#points_to_student').validate({
			ignore: "",
			rules: {
				reward_points : {
                   number: true,
                }
			},
			messages: {
				reward_points : {
                    number : "Please enter digits."
                }
			}
		});
	</script>>

@endpush
@endsection
