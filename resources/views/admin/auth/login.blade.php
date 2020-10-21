@extends('admin.layouts.auth')
@section('content')
<div class="content-wrapper d-flex align-items-center auth">
	<div class="row w-100">
		<div class="col-lg-4 mx-auto">
			<div class="auth-form-light text-left p-5">
				<div class="brand-logo">
					<img src="{{ asset('assets/admin/images/logo_80x80.png') }}">
				</div>
				<h4>Hello! let's get started</h4>
				<h6 class="font-weight-light">Sign in to continue.</h6>
				<form method="POST" action="{{ route('admin.login') }}" class="pt-3">
					@csrf

					<div class="form-group">
						<input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control form-control-lg" id="password"name="password" required autocomplete="current-password" placeholder="Password">
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
						<input type="hidden" name="referer" value="<?php echo $redirect_to;?>" />
						<button class="btn btn-block btn-gradient-info btn-lg font-weight-medium auth-form-btn" type="submit" >SIGN IN</button>
					</div>

					<div class="my-2 d-flex justify-content-between align-items-center">
						<div class="form-check form-check-info">
							<label class="form-check-label text-muted">
								<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="form-check-input">
								Keep me signed in
							</label>
						</div>
						@if (Route::has('admin.password.request'))
						<a class="auth-link text-black" href="{{ route('admin.password.request') }}">
							{{ __('Forgot Password?') }}
						</a>
						@endif
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- content-wrapper ends -->
<?php /*
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Login') }}</div>
				<div class="card-body">
					<form method="POST" action="{{ route('login') }}">
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
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
							<div class="col-md-6">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
								@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6 offset-md-4">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
									<label class="form-check-label" for="remember">
										{{ __('Remember Me') }}
									</label>
								</div>
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
								{{ __('Login') }}
								</button>
								@if (Route::has('password.request'))
								<a class="btn btn-link" href="{{ route('password.request') }}">
									{{ __('Forgot Your Password?') }}
								</a>
								@endif
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> */ ?>
@endsection
