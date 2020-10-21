<?php
    $url = asset('images/teacher_profile.png');
    if(!empty($teacher->profile_image)){
        $url = asset($teacher->profile_image);
    }

    $country = $teacherDetails->nationality;
    $countryCode = App\Helpers\AppHelper::getCountryCode($country);
    if(!empty($countryCode)){
        $countryCode = strtolower($countryCode);
    }

    //if($teacher->is_ambassador == 0){
        $global_price = $teacherDetails->global_lesson_price;
		
        $kids_price = $teacherDetails->kids_lesson_price;
        $aspire_price = $teacherDetails->aspire_lesson_price;
		
        /*$vTemp =  round((($global_price * $teacherDetails->virtual_lesson_percentage) / 100),2);
        $virtual_price = $vTemp;
        $cafeTemp =  round((($global_price * $teacherDetails->cafe_lesson_percentage) / 100),2);
        $cafe_price = $cafeTemp;
        $classTemp =  round((($global_price * $teacherDetails->classroom_lesson_percentage) / 100),2);
        $class_price = $classTemp;*/
    //}
?>
<div class="col-12 col-lg-12">
    <div class="title_step">
        <label>{{__('labels.stu_teacher_profile')}}</label>
    </div>
    <div class="form-group tea_main">

        <div class="teacher_profile_sec">
            <div class="profile_container">
                <img src="{{$url}}">
            </div>
            <div class="profile_text">
                <h5 class="pb-2">
                    <a target="_blank" href="{{route('teachers.public.profile', $teacher->id)}}">
                        {{ ucfirst($teacher->firstname) }} {{ ucfirst($teacher->lastname) }}
                    </a>
                    <span>({{__('labels.stu_teacher')}})</span>


                </h5>
                <p></p>
                <div class="pb-2">
                    @if($teacherDetails->teacher_verified == 1)
                        <a href="javascript:;" class="nav__link outline" role="tooltip" aria-label="The teacher's official teaching documents which have been submitted and verified." data-microtip-position="right" data-microtip-size="medium">
                            <img src="{{asset('images/badges/cer-reward.png')}}"  height="30" >
                        </a>
                    @endif

                    @if($teacherHours > 30.00)
                        <a href="javascript:;" class="nav__link outline" role="tooltip" aria-label="The teacher has taught over 30 hours of Accent lessons." data-microtip-position="right" data-microtip-size="medium">
                            <img src="{{asset('images/badges/time-reward.png')}}"  height="30">
                        </a>
                    @endif

                    @if($teacherDetails->in_training == 1)
                        <a href="javascript:;" class="nav__link outline" role="tooltip" aria-label="The teacher is under training." data-microtip-position="right" data-microtip-size="medium">
                            <img src="{{asset('images/badges/under-train.png')}}"  height="30">
                        </a>
                    @endif


                </div>
                <p></p>
                <span>{{__('labels.stu_rate_our_lesson')}}</span>
                <div class="row">
                    <div class="col-md-12">
                       <input id="teacher-rating"
                       class="kv-ltr-theme-svg-star rating-loading teacher-ratings-avg" value="{{!empty($ratings) ? number_format($ratings,1) : 0}}" dir="ltr" data-size="xs" readonly="true">
                        <span class="rating-count">
                            {{!empty($ratings) ? number_format($ratings,1) : 0}}/5 ({{$countStudentsRated}})
                        </span>
                    </div>
                    {{--<div class="col-md-5 text-right">--}}

                    {{--</div>--}}
                </div>
            </div>
        </div>

        <div class="teacher_details">
            <ul class="details_sec">
                @if($teacherDetails->is_ambassador == 1)
                    <li> {{__('labels.stu_global_price')}} : <span>{{$global_price}}</span></li>
					<?php
					if($kids_price > 0) {?>
                    <li> {{__('labels.stu_kids_lesson_price')}} : <span>{{$kids_price}}</span></li>
					<?php
					}
					
					if($aspire_price > 0 && $teacherDetails->user_id == env('RYAN_USER_ID')) { ?>
                    <li> {{__('labels.stu_aspire_lesson_price')}} : <span>{{$aspire_price}}</span></li>
					<?php
					}
					?>
                @endif
                <li> {{__('labels.stu_country')}} : <span>{{$teacherDetails->country}}</span></li>
            </ul>
            <div id="country_flag">
                <i class="flag-icon flag-icon-{{$countryCode}}"></i>
            </div>
        </div>
    </div>
</div>
<style>
.rating-xs {
    padding-top: 3px;
}
</style>
