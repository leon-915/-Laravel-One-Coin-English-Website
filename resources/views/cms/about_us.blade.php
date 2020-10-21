@extends('layouts.app',['title'=>'about_us'])
@section('title', 'about_us')
@section('content')

    <section class="sub_page_padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="sub_page_header">{{__('labels.home_about_us')}}</h4>
                </div>
            </div>
            <div class="aboutus_detail_box">
                <div class="row">
                    <div class="col-12 col-lg-5 col-md-12">
                        <div class="abt_image_container">
                            <img src="images/slider2_img.png">
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 col-md-12">
                        <div class="abt_header">
                            <h5>{{__('labels.about_head')}}</h5>
                            <p> {{__('labels.about_head_detail')}} </p>
                        </div>
                        <div class="abt_details">
                            <p>{{__('labels.about_project_description')}}</p><br>
                            <p>{{__('labels.about_project_description_2')}}</p><br>
                            <p>{{__('labels.about_project_description_3')}}</p><br>
                            <p>{{__('labels.about_project_description_4')}}</p><br>
                            <p>{{__('labels.about_project_description_5')}}</p><br>
                            <p>{{__('labels.about_project_description_6')}}</p><br>
                            <p>{{__('labels.about_project_description_7')}}</p><br>
                            <p>{{__('labels.about_project_description_8')}}</p><br>
                            <p>{{__('labels.about_project_description_9')}}</p><br>
                        </div>
                        <div class="history_sec">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <p class="history_val"><span>{{__('labels.about_date_found')}}</span>{{__('labels.about_date_found_detail')}}</p>
                                </div>
                                <div class="col-lg-5 col-md-4 col-12">
                                    <p class="history_val"><span>{{__('labels.about_managing_director_head')}}</span>
                                        {{__('labels.about_managing_director_detail')}}
                                    </p>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12">
                                    <p class="history_val"><span>{{__('labels.about_capital')}}</span>{{__('labels.about_capital_detail')}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="history_val"><span>{{__('labels.about_telephone')}}</span>{{__('labels.about_telephone_detail')}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="history_val"><span>{{__('labels.about_location')}}</span>{{__('labels.about_location_detail')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')

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
            $('#videoLink')
                .magnificPopup({
                    type: 'inline',
                    midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
                })

        </script>

    @endpush

@endsection
