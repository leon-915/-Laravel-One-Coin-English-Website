@extends('layouts.app',['title'=>__('labels.stu_onbreak_plan')])
@section('title',__('labels.stu_onbreak_plan'))
@section('content')
    <div id="content">
        <section class="profile_sec cafe_lesson">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile_inner tab_pnle_sec">
                            <div class="card custome_nav">
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div id="testimonial-slider" class="owl-carousel">
                                            <div class="testimonial">
                                                <div class="pic">
                                                    <img src="images/img-1.jpg" alt="">
                                                </div>
                                                <p class="description">
                                                    Accent is flexible because they customize the lessons according
                                                    to the student’s needs. We practice audio conferencing by
                                                    role-playing, lessons with English articles and discuss news
                                                    from around the world which is what I need while at the same
                                                    time, having fun. Also, their fees are reasonable which makes me
                                                    want to continue for a long time.
                                                </p>

                                                <a href="#next" role="menuitem" class="btn_sub">Read More</a>
                                                <h3 class="testimonial-title">Williamson - Web Developer</h3>
                                            </div>

                                            <div class="testimonial">
                                                <div class="pic">
                                                    <img src="images/img-1.jpg" alt="">
                                                </div>
                                                <p class="description">
                                                    Accent is flexible because they customize the lessons according
                                                    to the student’s needs. We practice audio conferencing by
                                                    role-playing, lessons with English articles and discuss news
                                                    from around the world which is what I need while at the same
                                                    time, having fun. Also, their fees are reasonable which makes me
                                                    want to continue for a long time.
                                                </p>

                                                <a href="#next" role="menuitem" class="btn_sub">Read More</a>
                                                <h3 class="testimonial-title">Williamson - Web Developer</h3>
                                            </div>

                                            <div class="testimonial">
                                                <div class="pic">
                                                    <img src="images/img-1.jpg" alt="">
                                                </div>
                                                <p class="description">
                                                    Accent is flexible because they customize the lessons according
                                                    to the student’s needs. We practice audio conferencing by
                                                    role-playing, lessons with English articles and discuss news
                                                    from around the world which is what I need while at the same
                                                    time, having fun. Also, their fees are reasonable which makes me
                                                    want to continue for a long time.
                                                </p>

                                                <a href="#next" role="menuitem" class="btn_sub">Read More</a>
                                                <h3 class="testimonial-title">Williamson - Web Developer</h3>
                                            </div>

                                            <div class="testimonial">
                                                <div class="pic">
                                                    <img src="images/img-1.jpg" alt="">
                                                </div>
                                                <p class="description">
                                                    Accent is flexible because they customize the lessons according
                                                    to the student’s needs. We practice audio conferencing by
                                                    role-playing, lessons with English articles and discuss news
                                                    from around the world which is what I need while at the same
                                                    time, having fun. Also, their fees are reasonable which makes me
                                                    want to continue for a long time.
                                                </p>

                                                <a href="#next" role="menuitem" class="btn_sub">Read More</a>
                                                <h3 class="testimonial-title">Williamson - Web Developer</h3>
                                            </div>

                                        </div>
                                    </div>
                                </div> --}}

                                <div class="accent_plan">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="accent_title">
                                                <h1>{{__('labels.stu_accent_onbreak_plan')}}</h1>
                                                <p>
                                                    {{__('labels.stu_accent_onbreak_plan_detail')}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accent_pricebox">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="accent_box single">
                                                    <div class="acn_price">
                                                        <h3>OnBreak Plan</h3>
                                                    </div>
                                                    <div class="acnt_minit">
                                                        <p>{{__('labels.stu_150_month')}}</p>
                                                        <p>({{__('labels.stu_excluding_tax')}})</p>

                                                        <input type="hidden" name="plan-name" id="plan-name" value="OnBreak Plan">
                                                        <input type="hidden" name="tax" id="tax" value="<?= (App\Models\Settings::getSettings('tax')) ? App\Models\Settings::getSettings('tax') : 0 ?>">

                                                        <input type="hidden" name="plan-price" id="plan-price" value="150">

                                                        <div class="try_now_btn">
                                                            <?php $url = url('student/add-cart/').'/'.$onbreak->id; ?>
                                                            <a href="<?= $url ?>" id="on-brk-plan" class="try_btn" data-value='purchase'>
                                                                {{__('labels.stu_purchase')}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <style>
        .accent_pricebox .accent_box {
            min-height: 300px;
        }
    </style>
@endsection
