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
				<form method="POST" action="{{ route('admin.password.update') }}">
					@csrf
					<input type="hidden" name="token" value="{{ $token }}">

					<div class="form-group">
						<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Address">
					</div>

					<div class="form-group">
						<input id="password" type="password" class="form-control form-control-lg" name="password" required autocomplete="new-password" placeholder="New Password">
					</div>

					<div class="form-group">
						<input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password"  placeholder="Confirm Password">
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
						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>

					<div class="mt-3">
						<button class="btn btn-block btn-gradient-info btn-lg font-weight-medium auth-form-btn" type="submit" >Reset Password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
