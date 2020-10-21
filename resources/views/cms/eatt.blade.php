@extends('layouts.app',['title'=>'Eatt'])
@section('title', 'Eatt')
@section('content')

    <section class="sub_page_padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="sub_page_header"><img src="{{asset('images/ett_logo.png')}}">EATT</h4>
                </div>
            </div>
            <div class="aboutus_detail_box">
                <div class="row">
                    <div class="col-12">
                            <h1 style="text-align: center"><b>{{__('labels.Eatt_concept')}}</b></h1><br>
                        <div class="prvcy_margin">
                            <p>{{__('labels.Eatt_head_p1')}}</p>
                        </div>
                        <div class="prvcy_margin">
                            <p>{{__('labels.Eatt_head_p2')}}</p>
                        </div>
                    </div>
                </div>

                <div class="ett1">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-4 col-md-12 mb-3">
                            <img src="{{asset('images/eett_img.png')}}">
                        </div>
                        <div class="col-12 col-lg-8 col-md-12">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.Eatt_why_english')}}</h5>
                                <p>{{__('labels.Eatt_why_english_detail_1')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_why_english_detail_2')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_why_english_detail_3')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ett1">
                    <div class="row align-items-center">

                        <div class="col-12 col-lg-8 col-md-12">
                            <div class="prvcy_margin">
                                <h5>{{__('labels.Eatt_ryan_ahamer')}}</h5>
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_1')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_2')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_3')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_4')}}</p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-12 mb-3">
                            <img src="{{asset('images/ett2.png')}}">
                        </div>
                        <div class="col-12">
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_5')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_6')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_7')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_8')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <p>{{__('labels.Eatt_ryan_ahamer_detail_9')}}</p>
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
            $("#content").css("padding-bottom", $("footer").outerHeight()+'px');
            $("#content").css("padding-top", $("header").outerHeight()+'px');

            $(document).ready(function() {

                $(".sliderrot").owlCarousel();
                $('#client_logo_slide').owlCarousel();
            });

            // project slider
            $('.sliderrot').owlCarousel({
                loop:true,
                margin:20,
                nav:true,
                autoplay:true,
                dots:true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:1
                    },
                    1000:{
                        items:1
                    }
                }
            });

            /*clinet-logo slider*/
            $('#client_logo_slide').owlCarousel({
                loop:true,
                margin:20,
                nav:false,
                autoplay:true,
                items:4,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:1
                    },
                    1000:{
                        items:4
                    }
                }
            });
            $('#videoLink')
                .magnificPopup({
                    type:'inline',
                    midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
                })

        </script>

    @endpush



@endsection