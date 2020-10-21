<!-- partial:../../partials/_sidebar.html -->
<?php
	$profileUrl = asset('assets/admin/images/faces/face1.jpg');
$profileUrl = asset('assets/admin/images/faces/face1.jpg');
if(!empty(Auth::guard('admin')->user()->image)){
    $profileUrl = asset(Auth::guard('admin')->user()->image);
}
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">

		<li class="nav-item nav-profile">
			<a href="#" class="nav-link">
				<div class="nav-profile-image">
					<img src="{{ $profileUrl }}" alt="profile">
					<span class="login-status online"></span> <!--change to offline or busy as needed-->
				</div>
				<div class="nav-profile-text d-flex flex-column">
					<span class="font-weight-bold mb-2">{{ !empty(Auth::guard('admin')->user()->name) ? Auth::guard('admin')->user()->name : 'John Doe' }}</span>
				</div>
				<i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
			</a>
        </li>


		<li class="nav-item">
			<a class="nav-link" href="{{ route('admin.dashboard') }}">
				<span class="menu-title">{{ __('labels.dashboard') }}</span>
				<i class="mdi mdi-home menu-icon"></i>
			</a>
        </li>

        <li class="nav-item {{ request()->is('admin/teachers*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.teachers.index') }}">
				<span class="menu-title">{{ __('labels.manage_teachers') }}</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.students.index') }}">
				<span class="menu-title">{{ __('labels.manage_students') }}</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/location-type*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.location-type.index') }}">
				<span class="menu-title">{{ __('labels.manage_location_type') }}</span>
				<i class="mdi mdi-crosshairs-gps menu-icon"></i>
			</a>
        </li>

		<li class="nav-item {{ request()->is('admin/locations*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.locations.index') }}">
				<span class="menu-title">{{ __('labels.manage_location') }}</span>
				<i class="mdi mdi-crosshairs-gps menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/static-pages*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.static-pages.index') }}">
				<span class="menu-title">{{ __('labels.manage_static_pages') }}</span>
				<i class="mdi mdi-book-open-page-variant menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/packages*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.packages.index') }}">
				<span class="menu-title">{{ __('labels.manage_packages') }}</span>
				<i class="mdi mdi-package  menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/services*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.services.index') }}">
				<span class="menu-title">{{ __('labels.manage_services') }}</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>


		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
				<span class="menu-title">{{__('labels.manage_one_page')}}</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-medical-bag menu-icon"></i>
			</a>
			<div class="collapse" id="general-pages">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item"> <a class="nav-link" href="{{ route('admin.one-page-levels.index') }}">{{__('labels.sidebar_level')}}</a></li>

					<li class="nav-item"> <a class="nav-link" href="{{ route('admin.one-page-levels-points.index') }}"> {{__('labels.sidebar_level_point')}}</a></li>
				</ul>
			</div>
		</li>

		<li class="nav-item {{ request()->is('admin/badges*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.badges.index') }}">
				<span class="menu-title">{{ __('labels.manage_badges') }}</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/rating-types*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.rating-types.index') }}">
				<span class="menu-title">{{ __('labels.manage_rating_type') }}</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/teacher-ratings*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.teacher-ratings.index') }}">
				<span class="menu-title">{{ __('labels.manage_teacher_rating') }}</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/coupons*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.coupons.index') }}">
				<span class="menu-title">{{ __('labels.manage_coupon') }}</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.orders.index') }}">
				<span class="menu-title">{{ __('labels.manage_order') }}</span>
				<i class="mdi mdi-book-open-page-variant menu-icon"></i>
			</a>
		</li>


		{{--<li class="nav-item {{ request()->is('admin/one-page-levels*') ? 'active' : '' }}">--}}
		{{--<a class="nav-link " href="{{ route('admin.one-page-levels.index') }}">--}}
		{{--<span class="menu-title">{{ __('labels.manage_one_page_levels') }}</span>--}}
		{{--<i class="mdi mdi-package  menu-icon"></i>--}}
		{{--</a>--}}
		{{--</li>--}}

		{{--<li class="nav-item {{ request()->is('admin/one-page-levels-points*') ? 'active' : '' }}">--}}
		{{--<a class="nav-link " href="{{ route('admin.one-page-levels-points.index') }}">--}}
		{{--<span class="menu-title">{{ __('labels.manage_one_page_levels_points') }}</span>--}}
		{{--<i class="mdi mdi-package  menu-icon"></i>--}}
		{{--</a>--}}
		{{--</li>--}}


		{{-- <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('users.index') }}">
				<span class="menu-title">Manage Users</span>
				<i class="mdi mdi-account menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('parties*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('parties.index') }}">
				<span class="menu-title">Manage Parties</span>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('key-issues*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('key-issues.index') }}">
				<span class="menu-title">Manage Key Issues</span>
				<i class="mdi mdi-lightbulb menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('candidates*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('candidates.index') }}">
				<span class="menu-title">Manage Candidates</span>
				<i class="mdi mdi-account-box menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('products*') ? 'active' : '' }}" id="nav-products">
			<a class="nav-link " href="{{ route('products.index') }}">
				<span class="menu-title">Manage Products</span>
				<i class="mdi mdi-shopping menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('posts*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('posts.index') }}">
				<span class="menu-title">Manage Posts</span>
				<i class="mdi mdi-comment-account menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('static-pages*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('static-pages.index') }}">
				<span class="menu-title">Manage Static Pages</span>
				<i class="mdi mdi-view-day menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('events*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('events.index') }}">
				<span class="menu-title">Manage Events</span>
				<i class="mdi mdi-playlist-check menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('questions*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('questions.index') }}">
				<span class="menu-title">Manage Questions</span>
				<i class="mdi mdi-comment-question-outline menu-icon"></i>
			</a>
		</li>

		<li class="nav-item {{ request()->is('correspondence-emails*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('correspondence-emails.index') }}">
				<span class="menu-title" title="Manage Correspondence Email Feeds">Manage Co-Emails</span>
				<i class="mdi mdi-email menu-icon"></i>
			</a>
		</li> --}}
	</ul>
</nav>
<!-- partial -->
<style>
	.sidebar .nav .nav-item .nav-link i.menu-icon {
		color: rgba(25, 138, 227, 0.5);
		line-height: 13px;
	}

	.sidebar .nav .nav-item.active > .nav-link i,
	.sidebar .nav .nav-item.active > .nav-link .menu-title {
		color: #0a7cc4;
	}
</style>
