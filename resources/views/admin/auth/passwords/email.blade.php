@extends('admin.layouts.auth')
@section('content')
<div class="content-wrapper d-flex align-items-center auth">
	<div class="row w-100">
		<div class="col-lg-4 mx-auto">
			<div class="auth-form-light text-left p-5">
				<div class="brand-logo">
					<img src="{{ asset('assets/admin/images/logo.png') }}">
				</div>
				<h4>Reset Password</h4>
				<h6 class="font-weight-light"></h6>
				<form method="POST" action="{{ route('admin.password.email') }}">
					@csrf
					<div class="form-group">
						<input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Address">
						@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<?php $errs = $errors->all(); ?>
						<?php if($errs) { ?>
						<span class="invalid-feedback" role="alert">
							<strong><?= current($errs) ?></strong>
						</span>
						<div class="alert alert-danger" role="alert">
							<strong><?= current($errs) ?></strong>
						</div>
						<?php } ?>
						@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}
						</div>
						@endif
					</div>
					<div class="mt-3">
						<button class="btn btn-block btn-gradient-info btn-lg font-weight-medium auth-form-btn" type="submit" >{{ __('Send Password Reset Link') }}</button>
					<a class="btn btn-block btn-link btn-lg font-weight-medium auth-form-btn" href="{{ route('admin.login') }}"  >Back to Login</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php /*
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Reset Password') }}</div>
				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif
					<form method="POST" action="{{ route('password.email') }}">
						@csrf
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
								@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-primary">
								{{ __('Send Password Reset Link') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> */ ?>
@endsection
