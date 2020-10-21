<?php
$url = url('');

	if (Auth::guard('admin')->user()->role == 'sub_admin') {
		$url = url('/admin/lesson-reports/admin-lessons-report');
	} else {
		$url = url('/admin/dashboard');
	}

?>

<!-- partial:../../partials/_navbar.html -->
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ $url }}">
            <img alt="logo" src="{{ asset('assets/admin/images/android-icon-48x48.png') }}"/>
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ $url }}">
            <img alt="logo" src="{{ asset('assets/admin/images/logo/logo_mini.png') }}"/>
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
    	<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        	<span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
			{{--<li class="nav-item d-none d-lg-block full-screen-link">--}}
                {{--<a class="nav-link" href="{{ url('locale/en') }}">--}}
                    {{--<div class="{{ (App::isLocale('en')) ? 'badge badge-outline-info' : '' }}">--}}
                        {{--<i class="flag-icon flag-icon-us"></i> &nbsp; EN--}}
                    {{--</div>--}}
				{{--</a>--}}
            {{--</li>--}}

			{{--<li class="nav-item d-none d-lg-block full-screen-link">--}}
                {{--<a  class="nav-link" href="{{ url('locale/jp') }}" >--}}
                    {{--<div class="{{ (App::isLocale('jp')) ? 'badge badge-outline-info' : '' }}">--}}
                        {{--<i class="flag-icon flag-icon-jp"></i> &nbsp; JP--}}
                    {{--</div>--}}
                {{--</a>--}}
            {{--</li>--}}

			{{--<li class="nav-item d-none d-lg-block full-screen-link">--}}
				{{--<a class="nav-link">--}}
					{{--<i class="mdi mdi-fullscreen" id="fullscreen-button">--}}
					{{--</i>--}}
				{{--</a>--}}
			{{--</li>--}}

			<li class="nav-item nav-profile dropdown">
                <a aria-expanded="false" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="profileDropdown">
                    <div class="nav-profile-img">
						<?php
                        $profileUrl = asset('assets/admin/images/faces/face1.jpg');
                        if(!empty(Auth::guard('admin')->user()->image)){
                            $profileUrl = asset(Auth::guard('admin')->user()->image);
                        }
						?>
                        <img alt="image" src="{{ $profileUrl }}">
                            <span class="availability-status online">
                            </span>
                        </img>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">
                            {{ !empty(Auth::guard('admin')->user()->name) ? Auth::guard('admin')->user()->name : 'John Doe' }}
                        </p>
                    </div>
                </a>
                <div aria-labelledby="profileDropdown" class="dropdown-menu navbar-dropdown">
                    <a class="dropdown-item" href="{{ route('admin-profile') }}">
                        <i class="mdi mdi-account-circle mr-2 text-success">
                        </i>
						Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('admin-change-password') }}">
                        <i class="mdi mdi-cached mr-2 text-success">
                        </i>
						Change Password
                    </a>
                    <div class="dropdown-divider">
                    </div>

					<a class="dropdown-item" href="{{ route('admin.logout') }}"
						onclick="event.preventDefault();document.getElementById('logout-form').submit();">
						<i class="mdi mdi-logout mr-2 text-primary">
						</i>
						{{ __('Logout') }}
					</a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" data-toggle="offcanvas" type="button">
            <span class="mdi mdi-menu">
            </span>
        </button>
    </div>
</nav>
<style>
	.navbar.default-layout-navbar .navbar-brand-wrapper .brand-logo-mini img {
		width: calc(70px - 35px);
	}
    .navbar.default-layout-navbar .navbar-menu-wrapper .navbar-nav .nav-item .nav-link i {
        font-size: 0.75rem;
    }
</style>

<!-- partial -->
