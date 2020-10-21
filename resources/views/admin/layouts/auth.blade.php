<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>{{ env('APP_NAME') }}</title>
		<!-- plugins:css -->
		<link rel="stylesheet" href="{{ asset('assets/admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/admin/vendors/css/vendor.bundle.base.css') }}">
		<!-- endinject -->
		<!-- plugin css for this page -->
		<!-- End plugin css for this page -->
		<!-- inject:css -->
		<link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
		<!-- endinject -->
		<link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.png') }}" />
	</head>
	<body>
		<div class="container-scroller">
			<div class="container-fluid page-body-wrapper full-page-wrapper">
				@yield('content')
			</div>
			<!-- page-body-wrapper ends -->
		</div>
		<!-- container-scroller -->
		<!-- plugins:js -->
		<script src="{{ asset('assets/admin/vendors/js/vendor.bundle.base.js') }}"></script>
		<script src="{{ asset('assets/admin/vendors/js/vendor.bundle.addons.js') }}"></script>
		<!-- endinject -->
		<!-- inject:js -->
		<script src="{{ asset('assets/admin/js/off-canvas.js') }}"></script>
		<script src="{{ asset('assets/admin/js/misc.js') }}"></script>
		<!-- endinject -->
	</body>
</html>
