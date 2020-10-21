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


		<!--li class="nav-item">
			<a class="nav-link" href="{{ route('admin.dashboard') }}">
				<span class="menu-title">{{ __('labels.dashboard') }}</span>
				<i class="mdi mdi-home menu-icon"></i>
			</a>
        </li-->
		
		<!--li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false"
			   aria-controls="general-pages">
				<span class="menu-title">{{ __('labels.sidebar_users') }}</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-account-multiple menu-icon"></i>
			</a>
			<div class="collapse" id="users">
				<ul class="nav flex-column sub-menu">

					<li class="nav-item {{ request()->is('admin/admin-users*') ? 'active' : '' }}">
						<a class="nav-link" href="{{ route('admin-users.index') }}">
							{{ __('labels.manage_admin') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/teachers*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.teachers.index') }}">
							{{ __('labels.manage_lp') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/last-login-teachers*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.last-login-teachers.index') }}">
							{{ __('labels.last_login_teachers') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/teacher-earnings*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.teacherEarnings') }}">
							{{ __('labels.teacher_earnings') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.students.index') }}">
							{{ __('labels.manage_lerners') }}
						</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#general-orders" aria-expanded="false"
			   aria-controls="general-pages">
				<span class="menu-title">{{ __('labels.sidebar_orders') }}</span>
				<i class="menu-arrow"></i>
				<i class=" mdi mdi-barcode menu-icon"></i>
			</a>
			<div class="collapse" id="general-orders">
				<ul class="nav flex-column sub-menu">

					<li class="nav-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.orders') }}">
							{{ __('labels.manage_order') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/student-packages*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.student-packages.index') }}">
							{{ __('labels.manage_student_packages') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/student-lessons*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.student.lessons.index') }}">
							{{ __('labels.sidebar_student_lessons') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/coupons*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.coupons.index') }}">
							{{ __('labels.manage_coupon') }}
						</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#general-business" aria-expanded="false"
			   aria-controls="general-pages">
				<span class="menu-title">{{ __('labels.sidebar_business') }}</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-crosshairs-gps menu-icon"></i>
			</a>
			<div class="collapse" id="general-business">
				<ul class="nav flex-column sub-menu">

					<li class="nav-item {{ request()->is('admin/location-type*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.location-type.index') }}">
							{{ __('labels.manage_location_type') }}
						</a>
					</li>

					<li class="nav-item {{ request()->is('admin/locations*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.locations.index') }}">
							{{ __('labels.manage_location') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/services*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.services.index') }}">
							{{ __('labels.manage_services') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/packages*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.packages.index') }}">
							{{ __('labels.manage_packages') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.categories.index') }}">
							{{ __('labels.manage_categories') }}
						</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#general-rating" aria-expanded="false"
			   aria-controls="general-pages">
				<span class="menu-title">{{ __('labels.sidebar_rating') }}</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-account-star menu-icon"></i>
			</a>
			<div class="collapse" id="general-rating">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item {{ request()->is('admin/rating-types*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.rating-types.index') }}">
							{{ __('labels.manage_rating_type') }}
						</a>
					</li>

					<li class="nav-item {{ request()->is('admin/teacher-ratings*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.teacher-ratings.index') }}">
							{{ __('labels.manage_teacher_rating') }}
						</a>
					</li>
				</ul>
			</div>
		</li-->
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#general-appointment" aria-expanded="false"
			   aria-controls="general-pages">
				<span class="menu-title">{{ __('labels.sidebar_appointment') }}</span>
				<i class="menu-arrow"></i>
				<i class=" mdi mdi-chart-bar menu-icon"></i>
			</a>
			<div class="collapse" id="general-appointment">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.calender.index') }}">
							{{ __('labels.calender') }}
						</a>
					</li>
					<!--li class="nav-item {{ request()->is('admin/student-lesson-records*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.student.lesson.records.index') }}">
							{{ __('labels.student_lesson_records') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/bookings*') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.bookings.index') }}">
							{{ __('labels.manage_booking') }}
						</a>
					</li-->
				</ul>
			</div>
		</li>
		<!--li class="nav-item {{ request()->is('admin/facebook-posts*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.facebook-posts.index') }}">
				<span class="menu-title">{{ __('labels.manage_facebook_posts') }}</span>
				<i class=" mdi mdi-barcode menu-icon"></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#general-settings" aria-expanded="false"
			   aria-controls="general-pages">
				<span class="menu-title">{{ __('labels.sidebar_settings') }}</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-settings menu-icon"></i>
			</a>
			<div class="collapse" id="general-settings">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
						<a class="nav-link " href="{{ route('admin.settings.index') }}">
							{{ __('labels.settings') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is('admin/holiday-setting') ? 'active' : '' }}" data-url="{{ request()->url() }}">
						<a class="nav-link " href="{{ route('admin.holiday.setting.index') }}">
							{{ __('labels.holiday_settings') }}
						</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ request()->routeIs('admin.one-page*') ? '' : 'collapsed' }}" data-toggle="collapse" href="#general-pages-1" aria-expanded="{{ request()->routeIs('admin.one-page*') ? 'true' : 'false' }}" aria-controls="general-pages-1">
				<span class="menu-title">{{__('labels.manage_one_page')}}</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-numeric-1-box-multiple-outline menu-icon"></i>
			</a>
			<div class="collapse {{ request()->routeIs('admin.one-page*') ? 'show' : '' }}" id="general-pages-1">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item {{ request()->routeIs('admin.one-page-levels.*') ? 'active' : '' }}" > <a class="nav-link {{ request()->routeIs('admin.one-page-levels.*') ? 'active' : '' }}" href="{{ route('admin.one-page-levels.index') }}">{{__('labels.sidebar_level')}}</a></li>

					<li class="nav-item {{ request()->routeIs('admin.one-page-points.*') ? 'active' : '' }}"> <a class="nav-link {{ request()->routeIs('admin.one-page-points.*') ? 'active' : '' }}" href="{{ route('admin.one-page-points.index') }}"> {{__('labels.sidebar_level_point')}}</a></li>
				{{-- 	<li class="nav-item {{ request()->url('admin/one-page-levels*') ? 'active' : '' }}" > <a class="nav-link" href="{{ route('admin.one-page-levels.index') }}">{{__('labels.sidebar_level')}}</a></li>

					<li class="nav-item {{ request()->url('admin/one-page-points*') ? 'active' : '' }}"> <a class="nav-link" href="{{ route('admin.one-page-points.index') }}"> {{__('labels.sidebar_level_point')}}</a></li> --}}
				</ul>
			</div>
		</li-->
		<li class="nav-item">
			<a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false"
			   aria-controls="general-pages">
				<span class="menu-title">{{ __('labels.sidebar_lesson_report_main') }}</span>
				<i class="menu-arrow"></i>
				<i class=" mdi mdi-chart-bar menu-icon"></i>
			</a>
			<div class="collapse" id="general-pages">
				<ul class="nav flex-column sub-menu">

					{{--<li class="nav-item {{ request()->is('admin/lesson-reports/dashboard*') ? 'active' : '' }}">
						<a class="nav-link" href="{{ route('admin.lesson-reports.dashboard')}}">
						{{ __('labels.sidebar_lesson_report_dash') }}</a>
					</li>--}}

					<li class="nav-item {{ request()->is('admin.admin-lessons-report.index*') ? 'active' : '' }}">
						<a class="nav-link" href="{{ route('admin.admin-lessons-report.index') }}">
							{{ __('labels.sidebar_lesson_report_main') }}
						</a>
					</li>

					<li class="nav-item {{ request()->is('admin/reports/amounts*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.amount.index') }}">
                            {{ __('labels.sidebar_lesson_amount_report') }}
                        </a>
					</li>

					<li class="nav-item {{ request()->is('admin/reports/ratings*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index') }}">
                            {{ __('labels.sidebar_lesson_Ratings_report') }}
                        </a>
					</li>

					<li class="nav-item {{ request()->is('admin/reports/cancelled*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.cancelled.index') }}">
                            {{ __('labels.sidebar_lesson_cancelled') }}
                        </a>
                    </li>

					<li class="nav-item {{ request()->routeIs('admin.report.settings.index') ? 'active' : '' }}">
						<a class="nav-link" href="{{ route('admin.report.settings.index') }}">
							{{ __('labels.report_settings') }}
						</a>
					</li>
				</ul>
			</div>
		</li>
		<!--li class="nav-item {{ request()->is('testimonial*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.testimonial.index') }}">
				<span class="menu-title">{{ __('labels.manage_testimonial') }}</span>
				<i class="mdi mdi-account-box-outline menu-icon"></i>
			</a>
		</li>
		<li class="nav-item {{ request()->is('testimonial*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.search-analytics.index') }}">
				<span class="menu-title">{{ __('labels.search_analytics') }}</span>
				<i class="mdi mdi-account-box-outline menu-icon"></i>
			</a>
		</li>
		<li class="nav-item {{ request()->is('contact-us*') ? 'active' : '' }}">
			<a class="nav-link " href="{{ route('admin.contact-us.index') }}">
				<span class="menu-title">{{ __('labels.manage_contact_us') }}</span>
				<i class="mdi mdi-account-box-outline menu-icon"></i>
			</a>
		</li-->		
		
		
		
		
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
