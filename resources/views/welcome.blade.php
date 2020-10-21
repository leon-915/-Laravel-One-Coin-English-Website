<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta content="Pwap" name="keywords">
	<meta content="Pwap" name="description">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>Lokalingo | @yield('title')</title> --}}

    <?php
        $siteTitle = \App\Models\Settings::getSettings('site_title');
    ?>
    <title>{{ ($siteTitle) ? ($siteTitle) : {{ env('APP_NAME') }} }} | @yield('title')</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}


    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- ex02 font -->
    <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet">
    {{-- < link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">

	<link href="{{ asset('css/jquery.steps.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery.timepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/toast/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/magnific-popup.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
	<!-- home css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
	<!-- custom styles-->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}

	<link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.png') }}" />
	{{-- <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet"> --}}
</head>

<body>
    <div id="wrapper">
        @include('layouts.partials.header')

        <div id="content">
            <section>
                <div class="slider_section">
                    <!-- <div class="image_container">
                        <img src="images/home_slide.png">
                    </div> -->
                    <div class="container">
                        <div class="slider_text">

                            <h4 class="title_slider">{{ env('APP_NAME') }}</h4>

                            <h5 class="tag_line">{{__('labels.home_main_detail')}}</h5>

                            <p>{{__('labels.home_main_detail_delevering')}}</p>

                            @if(Auth::guest())
                                <a class="btn btn_custon transpernt_btn" href="{{ route('students.register.index') }}" >{{__('labels.home_free_trial')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- slider over -->
            <!-- about us start -->
            <section>
                <div class="container">
                    <div class="home_about_us_sec">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-12 pr-lg-0 pl-lg-0">
                                <div class="abt_sec1">
                                    <div class="title_sec">
                                        <img src="images/accent.png">
                                        <span>accent</span>
                                    </div>
                                    <h4 class="sub_title">{{__('labels.home_image_detail_head')}}</h4>
                                    <p>{{__('labels.home_home_image_detail')}}</p>
                                    <a href="#"><div class="img_sec"><span></span></div></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 pr-lg-0 pl-lg-0">
                                <div class="abt_sec1">

                                    <div class="title_sec">
                                        <img src="images/aspire.png">
                                        <span>aspire</span>
                                    </div>
                                    <h4 class="sub_title">{{__('labels.home_image_detail_head')}}</h4>
                                    <p>{{__('labels.home_home_image_detail')}}</p>
                                    <a href="#"><div class="img_sec"><span></span></div></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 pr-lg-0 pl-lg-0">
                                <div class="abt_sec1">

                                    <div class="title_sec">
                                        <img src="images/accent.png">
                                        <span>kids</span>
                                    </div>
                                    <h4 class="sub_title">{{__('labels.home_image_detail_head')}}</h4>
                                    <p>{{__('labels.home_home_image_detail')}}</p>
                                    <a href="#"><div class="img_sec"><span></span></div></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 pr-lg-0 pl-lg-0">
                                <div class="abt_sec1">

                                    <div class="title_sec">
                                        <img src="images/tt-eatt.png">
                                        <span>eatt</span>
                                    </div>
                                    <h4 class="sub_title">{{__('labels.home_image_detail_head')}}</h4>
                                    <p>{{__('labels.home_home_image_detail')}}</p>
                                    <a href="#"><div class="img_sec"><span></span></div></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- abtus over -->
            <!-- video start -->
            <section>
                <div class="container">
                    <div class="video_section">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-12">
                                <div class="video_text">
                                    <h4 class="page_header">{{__('labels.home_watch_now')}}</h4>
                                    <p>{{__('labels.home_watch_now_details')}}</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-12">
                                <div class="embed-responsive embed-responsive-16by9" id="#myModal" data-toggle="modal">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                                    <div class="content">
                                        <a href="#videoStory" class="button more" id="videoLink"></a>
                                        <div id="videoStory" class="mfp-hide">
                                            <iframe class="popvideo"  src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" frameborder="0" allowfullscreen>
                                                <button title="Close (Esc)" type="button" class="mfp-close">×</button>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- video over -->
            <!-- project start -->
            <section class="gray_bg">
                <div class="container">
                    <div class="project_slider">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="header_pink">{{__('labels.home_projects')}}</h4>
                                {{--<span>P</span>rojects--}}
                            </div>
                        </div>
                        <div class="sliderrot owl-carousel">
                            <div class="projct_section ">
                                <div class="slider_im"><img src="images/slider2_img.png"></div>
                                <div class="row">
                                    <div class="col-12 col-lg-5 col-md-12">
                                        <div class="slider_img_mobile"><img src="images/slider2_img.png"></div>
                                    </div>
                                    <div class="col-12 col-lg-7 col-md-12">
                                        <div class="project_text">
                                            <h4 class="page_header">{{__('labels.home_one_page')}}</h4>
                                            <p>{{__('labels.home_watch_now_details')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="projct_section ">
                                <div class="slider_im"><img src="images/slider2_img.png"></div>
                                <div class="row">
                                    <div class="col-12 col-lg-5 col-md-12">
                                        <div class="slider_img_mobile"><img src="images/slider2_img.png"></div>
                                    </div>
                                    <div class="col-12 col-lg-7 col-md-12">
                                        <div class="project_text">
                                            <h4 class="page_header">{{__('labels.home_one_page')}}</h4>
                                            <p>{{__('labels.home_watch_now_details')}}</p>                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- project start -->

            <!-- mission start -->
            <section>
                <div class="container">
                    <div class="mission_section">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="header_green">
                                    {{--<span>M</span>ission & Values--}}
                                    {{__('labels.home_mission_and_values')}}
                                </h4>
                            </div>
                        </div>
                        <div class="row align-items-center mb-30">
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="mission_img"><img src="images/mission1.png"></div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <h4 class="page_header one">{{__('labels.home_mission')}}<span>01</span></h4>
                                <div class="mission_content">
                                    <p>{{__('labels.home_mission_and_values_details')}}</p>
                                </div>

                            </div>
                        </div>
                        <div class="row align-items-center mb-30">

                            <div class="col-12 col-lg-6 col-md-6 dis-xs">
                                <h4 class="page_header">{{__('labels.home_value')}}<span>02</span></h4>
                                <div class="mission_content">
                                    <p>{{__('labels.home_value_details')}}</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="mission_img"><img src="images/mission2.png"></div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6 dis_xs_block">
                                <h4 class="page_header two">{{__('labels.home_value')}}<span>02</span></h4>
                                <div class="mission_content">
                                    <p>{{__('labels.home_value_details')}}</p>
                                </div>
                            </div>

                        </div>
                        <div class="row align-items-center mb-30">
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="mission_img"><img src="images/mission4.png"></div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <h4 class="page_header three">{{__('labels.home_quality')}}<span>03</span></h4>
                                <div class="mission_content">
                                    <p>{{__('labels.home_quality_details')}}</p>
                                </div>

                            </div>
                        </div>
                        <div class="row align-items-center mb-30">

                            <div class="col-12 col-lg-6 col-md-6 dis-xs">
                                <h4 class="page_header four">{{__('labels.home_utility')}}<span>04</span></h4>
                                <div class="mission_content">
                                    <p>{{__('labels.home_utility_details')}}</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="mission_img"><img src="images/mission3.png"></div>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6 dis_xs_block">
                                <h4 class="page_header">{{__('labels.home_utility')}}<span>04</span></h4>
                                <div class="mission_content">
                                    <p>{{__('labels.home_utility_details')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- mission over -->
            <!-- clinet start -->
            <section class="gray_bg footer_upper">
                <div class="container">
                    <div class="clinet_section">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="header_green span_orange">
                                    {{--<span>C</span>orporate Clients</h4>--}}
                                   {{__('labels.home_corporate_client')}}
                                </h4>
                                <p>{{__('labels.home_corporate_client_details')}}</p>
                            </div>
                        </div>
                        <div class="clint_logos " >
                            <div class=" owl-carousel" id="client_logo_slide">
                                <div class="clinet_logo_container"><img src="">ExxonMobil</div>
                                <div class="clinet_logo_container"><img src="">Novartis</div>
                                <div class="clinet_logo_container"><img src="">Symantec</div>
                                <div class="clinet_logo_container"><img src="">Accent Style</div>
                                <div class="clinet_logo_container"><img src="">ExxonMobil</div>
                                <div class="clinet_logo_container"><img src="">Novartis</div>
                                <div class="clinet_logo_container"><img src="">Symantec</div>
                                <div class="clinet_logo_container"><img src="">Accent Style</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- clinet over -->
        </div>

        <footer class="footer height_custom" id="footer">
            <div class="container">
                <div class="main_footer">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="footer_hd">
                                <img src="images/logo.png">
                            </div>
                            <div class="abt_comny_footer">
                                <p>{{__('labels.home_corporate_client_details')}}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="footer_hd">
                                {{__('labels.home_classroom_hour')}}
                            </div>
                            <div class="abt_comny_footer">
                                <p>{{__('labels.home_classroom_hour_detail')}}</p>
                                <p>{{__('labels.home_classroom_hour_detail_1')}}</p>
                                <p>{{__('labels.home_classroom_hour_detail_2')}}</p>
                                <p>{{__('labels.home_classroom_hour_detail_3')}}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="footer_hd">
                                {{__('labels.home_office_hours')}}
                            </div>
                            <div class="abt_comny_footer">
                                <p>{{__('labels.home_office_hours_details')}}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="footer_hd">
                                {{__('labels.home_holidays')}}
                            </div>
                            <div class="abt_comny_footer">
                                <p>
                                    <strong>{{__('labels.home_holidays_details')}}</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="copy_right_section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <ul class="social_foot">
                                <li><a href="{{ url('/privacy-policy') }}">{{__('labels.home_privacy_policy')}}</a></li>
                                <li><a href="{{ url('/terms-of-use') }}">{{__('labels.home_terms_of_use')}}</a> </li>
                            </ul>

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <p>Copyright © 2019. Accent Language Inc. All rights reserved</p>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <ul class="foot_social cf">
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    {{-- <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
	 <script src="{{ asset('js/menu.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery.steps.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toast/jquery.toast.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>



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

    <script type="text/javascript">
		//set content bottom padding
		$("#content").css("padding-bottom", $("footer").outerHeight() + 'px');
		$("#content").css("padding-top", $("header").outerHeight() + 'px');

		$(document).ready(function () {
			$(".sliderrot").owlCarousel();
			$('#client_logo_slide').owlCarousel();
		});

		// project slider
		$('.sliderrot').owlCarousel({
			loop: true,
			margin: 20,
			nav: true,
			autoplay: true,
			dots: true,

            navText: ["<i class=\"fas fa-arrow-left\"></i>", "<i class=\"fas fa-arrow-right\"></i>"],
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		});

		/*clinet-logo slider*/
		$('#client_logo_slide').owlCarousel({
			loop: true,
			margin: 20,
			nav: false,
			autoplay: true,
			items: 4,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 4
				}
			}
		});
		// $('#videoLink')
		// 	.magnificPopup({
		// 		type: 'inline',
		// 		midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		// 	});

        jQuery('#videoLink').magnificPopup({
            type: 'inline',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: true,
            midClick: true
        });
	</script>
    @stack('scripts')
</body>
</html>
