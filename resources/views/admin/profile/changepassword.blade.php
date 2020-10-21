@extends('admin.layouts.admin',['title'=>'Change Password'])

@section('title','Change Password')

@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title"> Change Password </h3>
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
					<h4 class="card-title">Change Password</h4>

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


					{!! Form::model($user, ['method' => 'POST', 'id'=>'change_password','route' => ['admin-new-password'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}

						<div class="row">
							<div class="form-group col-md-6">
								 <label class="form-control-label" for="current_password">Current Password<span class="vali">*</span></label>
								{!! Form::password('current_password', array('placeholder' => 'Current Password','class' => 'form-control','id'=>'current_password')) !!}
							</div>
						</div>

						<div class="row">
						    <div class="form-group col-md-6">
						        <label class="form-control-label" for="password">New Password <span class="vali">*</span></label>
                                    {!! Form::password('new_password', array('placeholder' => 'New Password','class' => 'form-control','id'=>'new_password')) !!}
							</div>
						</div>

						<div class="row">
						    <div class="form-group col-md-6">
						        <label class="form-control-label" for="comfirm_password">Confirm Password <span class="vali">*</span></label>
                                    {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
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
		$('#change_password').validate({ // initialize the plugin
                rules: {
                    current_password : {
                        required: true,
                        minlength : 6
                    },
                    new_password:{
                        required: true,
                        minlength : 6
                    },
                    confirm_password : {
                        required: true,
                        equalTo : "#new_password"
                    }
                },
                messages: {
                    current_password : {
                        required : "Please enter current password",
                        minlength: "Please enter minimum 6 characters"
                    },
                    new_password: {
                        required : "Please enter new password",
                        minlength: "Please enter minimum 6 characters"
                    },
                    confirm_password:{
                        required : "Please enter confirm password",
                        equalTo: "Enter same as password"
                    }
                }
            })
	</script>
@endpush
@endsection
