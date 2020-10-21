<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <?php
            $siteTitle = \App\Models\Settings::getSettings('site_title');
        ?>
        <title>{{ ($siteTitle) ? ($siteTitle) : 'Lokalingo' }} | @yield('title')</title>

		<!-- plugins:css -->
		{{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/datetimepicker.css') }}"> --}}
		<link rel="stylesheet" href="{{ asset('assets/admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/admin/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/admin/vendors/iconfonts/font-awesome/css/font-awesome.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/admin/vendors/css/vendor.bundle.base.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/admin/vendors/css/vendor.bundle.addons.css') }}">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<!-- endinject -->
		<!-- plugin css for this page -->
		<!-- End plugin css for this page -->
		<!-- inject:css -->
		<link rel="stylesheet" href="{{ asset('assets/admin/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/jquery-textext/css/textext.core.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/jquery-textext/css/textext.plugin.autocomplete.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/jquery-textext/css/textext.plugin.tags.css') }}">
		<link href="{{ asset('css/jquery.timepicker.css') }}" rel="stylesheet">

		<link href='{{ asset('plugins/fullcalendar/packages/core/main.css') }}' rel='stylesheet' />
		<link href='{{ asset('plugins/fullcalendar/packages/daygrid/main.css') }}' rel='stylesheet' />
		<link href='{{ asset('plugins/fullcalendar/packages/timegrid/main.css') }}' rel='stylesheet' />
		<link href='{{ asset('plugins/fullcalendar/packages/list/main.css') }}' rel='stylesheet' />
		

		<link href='{{ asset('plugins/star-ratings/css/star-rating.css') }}' rel='stylesheet' />
		<link href='{{ asset('plugins/star-ratings/themes/krajee-svg/theme.css') }}' rel='stylesheet' />

		{{-- <link rel="stylesheet" href="{{ asset('assets/tags/jquery.tagsinput.min.css') }}"> --}}
		<link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">


		<link rel="stylesheet" href="{{ asset('assets/croppie/croppie.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/magnific-popup/magnific-popup.css') }}">

		<!-- endinject -->
		<link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.png') }}" />
	</head>
	<body>
		<div class="container-scroller">

			@include('admin.layouts.partials.header')

			<div class="container-fluid page-body-wrapper">
				<?php
				if (Auth::guard('admin')->user()->role == 'sub_admin') { ?>
					@include('admin.layouts.partials.affiliate_sidebar')
					<?php
				} else { ?>
					@include('admin.layouts.partials.sidebar')
					<?php
				} ?>

				@include('admin.layouts.partials.setting')

				<div class="main-panel">

					@yield('content')

					@include('admin.layouts.partials.footer')

				</div>
				<!-- main-panel ends -->
			</div>
			<!-- page-body-wrapper ends -->
			<div class="el-loading d-none">
				<div class="jumping-dots-loader">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
		</div>

		<script src="{{ asset('assets/admin/vendors/js/vendor.bundle.base.js') }}"></script>
		<script src="{{ asset('assets/admin/vendors/js/vendor.bundle.addons.js') }}"></script>
        {{-- <script src="{{ asset('assets/admin/js/tooltips.js') }}"></script> --}}

		<script src="{{ asset('js/delete-all.js') }}"></script>

		<script src="{{ asset('assets/admin/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/admin/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('assets/admin/js/misc.js') }}"></script>
        <script src="{{ asset('assets/admin/js/settings.js') }}"></script>
        <script src="{{ asset('assets/admin/js/todolist.js') }}"></script>
        <script src="{{ asset('assets/admin/js/popover.js') }}"></script>
        <script src="{{ asset('assets/croppie/croppie.js')}}"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
				integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
				crossorigin="anonymous"></script>
        <script src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
		<script src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
		<script>
            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

            $(document).ready(function () {
                // jQuery plugin to prevent double submission of forms
                jQuery.fn.preventDoubleSubmission = function () {
                    $(this).on('submit', function (e) {
                        var $form = $(this);
                        if ($form.valid()) {
                            if ($form.data('submitted') === true) {
                                // Previously submitted - don't submit again
                                e.preventDefault();
                            } else {
                                // Mark it so that the next submit can be ignored
                                $form.data('submitted', true);
                            }
                        }
                    });
                    // Keep chainability
                    return this;
                };
                $('form').preventDoubleSubmission();
            });

//  expired session to login page and disable DataTables error prompt

            $(document).ajaxError(function(event, jqxhr, settings, exception) {
                if (exception == 'Unauthorized') {

                    // Prompt user if they'd like to be redirected to the login page
                    bootbox.confirm("Your session has expired. Would you like to be redirected to the login page?", function(result) {
                        if (result) {
                            window.location = '/admin/login';
                        }
                    });
                }
            });

            // disable datatables error prompt
            $.fn.dataTable.ext.errMode = 'none';

//expired session to login page and disable DataTables error prompt

        </script>
		@stack('scripts')
	</body>
</html>
