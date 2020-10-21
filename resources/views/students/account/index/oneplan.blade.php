<div class="accent_plan">
    <div class="row">
        <div class="col-md-12">
            <div class="accent_title">
                <h1>{{__('labels.stu_accent_oneplan')}}</h1>
                <p>
                    {{__('labels.stu_purchase_point_with')}}
                </p>
                <div id="payment-request-button" class="try_btn">
                    {{__('labels.btn_try_now')}}
                </div>
            </div>
        </div>
    </div>

    <div class="accent_pricebox">
        <div class="row">
            <?php
                /* echo '<pre>';
                 print_r($studentPackage->toArray());
                 echo '</pre>';*/

            ?>
        </div>
        <div class="row">

            @foreach($packages as $key=>$package)
				<?php
				if($package->id == 31) {
					continue;
				}
				?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="accent_box">
                        <div class="acn_price">
                            <h3>{{$package->title}}</h3>
                            <h4>{{$package->price}}<span>{{__('labels.stu_month_excluding_tax')}}</span>
                            </h4>
                        </div>
                        <div class="acnt_minit">
                            <p>{{__('labels.stu_min_lesson_available')}}</p>
                            <p>{{__('labels.stu_virtual_lesson_with_teacher')}}</p>
                            <p>{{__('labels.stu_cafe_office_classroom')}}</p>
                            <p>{{__('labels.stu_onepage_fee_include')}}
                                {{ number_format($package->onepage_fee)}} {{__('labels.stu_point_month')}}
                            </p>

                            <p>¥{{ number_format($package->registration_fee) }} {{__('labels.stu_registration_fee')}} </p>

                            <p>{{__('labels.stu_you_will_get')}} {{$package->reward_point}} {{__('labels.stu_reward_point_for_each_lesson')}}</p>

                            <p>{{__('labels.stu_purchase_a_mor_or_less')}}.</p>

                            <div class="try_now_btn">
                                <form method="POST" action="{{route('students.account.payment')}}">
                                    <input type="hidden"
                                           name="plan-name-{{$key}}"
                                           id="plan-name-{{$key}}"
                                           value="{{$package->title}}">
                                    <input type="hidden"
                                           name="plan-description-{{$key}}"
                                           id="plan-description-{{$key}}"
                                           value="{{$package->description}}">
                                    <input type="hidden"
                                           name="plan-price-{{$key}}"
                                           id="plan-price-{{$key}}"
                                           value="{{($package->price)}}">



                                    @if(!empty($studentPackage))
                                        @if ($studentPackage->package_id == $package->id)
                                            @if (
                                                (strtotime($studentPackage->start_date) < time()) &&
                                                (strtotime($studentPackage->end_date) > time())
                                                )
                                                <button type='button' class="try_btn active">
                                                    {{__('labels.btn_subscribed')}}
                                                </button>
                                            @elseif((time() - strtotime($studentPackage->end_date)) > 0)
                                                <button type='button' id="plan-{{$key}}"
                                                        class="try_btn buy_package"
                                                        data-package-id="{{$package->id}}"
                                                        data-value='purchase' data-id="{{$key}}">
                                                    {{__('labels.btn_try_now')}}
                                                </button>
                                            @else
                                                <span type='button' class="try_btn active">
                                                    {{__('labels.btn_subscribed')}}
                                                </span>
                                            @endif
                                        @else
											<button type='button' id="plan-{{$key}}"
													class="try_btn buy_package"
													data-package-id="{{$package->id}}"
													data-value='purchase' data-id="{{$key}}">
												{{__('labels.btn_try_now')}}
											</button>
										@endif
                                    @else
                                        <button type='button' id="plan-{{$key}}"
                                                class="try_btn buy_package"
                                                data-package-id="{{$package->id}}"
                                                data-value='purchase' data-id="{{$key}}">
                                            {{__('labels.btn_try_now')}}
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="price_point">
        <div class="row">
            <div class="col-12">
                <p>*{{__('labels.stu_one_plan_p1')}}</p>

                <p>*{{__('labels.stu_one_plan_p2')}}</p>

                <p>*{{__('labels.stu_one_plan_p3')}}</p>
                <p>*{{__('labels.stu_one_plan_p4')}}</p>
                <p>*{{__('labels.stu_one_plan_the')}}
                    <a href="{{ route('students.account.onbreak') }}" style="color: blue;font-weight: 600;">
                        {{__('labels.stu_accent_onbreak_plan')}}
                    </a>
                    {{__('labels.stu_one_plan_p5')}}
                </p>
            </div>
        </div>
    </div>
</div>
