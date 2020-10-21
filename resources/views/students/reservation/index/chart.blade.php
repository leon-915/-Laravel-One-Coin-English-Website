
@if($package)
    <div class="row">
        <div class="col-12 col-lg-4 col-md-4 text-center">
        <h4 class="chart_header">{{__('labels.stu_subscription_plan')}} : {{ number_format($credit_balance) }}</h4>
        </div>
        <div class="col-12 col-lg-4 col-md-4 text-center">
            <h4 class="chart_header">{{__('labels.dash_total')}} : {{ number_format($total_balance) }}</h4>
        </div>
        <div class="col-12 col-lg-4 col-md-4 text-center">
            <h4 class="chart_header">{{__('labels.stu_reward_points')}} : {{ number_format($reward_balance) }}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 col-md-6">
            <canvas id="subscription-point-chart" height="180"></canvas>
        </div>
        <div class="col-12 col-lg-6 col-md-6">
            <canvas id="reward-point-chart" height="180"></canvas>
        </div>
        <div class="col-12">
            <div class="days_progress">
                <?php
                    $now  = \Carbon\Carbon::now();
                    $end  = $package->start_date;

                    $dayConsume = $now->diffInDays($end);
                    $per = $dayConsume * 100 / 30;
                ?>
                <div class="bar_text">
                    <span>{{__('labels.stu_days_consumed')}}</span>
                    <span class="days_bar">{{ $dayConsume }}/30</span>
                </div>
                <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{$per}}%" aria-valuenow="25"aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="bar_text">
                    <span class="days_bar">
						<?php
						$expiry_date = \App\Helpers\AppHelper::format_date_FjY($package->end_date);
						?>
                        {{__('labels.stu_lesson_expiry_date')}} : {{ $expiry_date }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <hr>
@elseif(!empty($individualServices) && $individualServices->toArray())
    <div class="row">
        @foreach ($individualServices as $ser)
            <?php
                $totalLessons = ($ser->service->available_lessons + $ser->free_lessons);
                $usedLessons = $totalLessons - $ser->available_bookings;
                if($ser->service->is_available_in_trial != 1){
            ?>
            <div class="col-12 col-lg-6 col-md-6 m-auto">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="chart_header top">{{ $ser->service->title }}</h3>
                    </div>
                    <div class="col-12 text-center">
                        <h5 class="chart_header">{{__('labels.stu_total_lessons')}} : {{ $totalLessons }}</h5>
                    </div>

                    <div class="col-12">
                        <canvas id="lesson-used-chart-{{ $ser->id }}" height="180"></canvas>
                    </div>

                    <div class="col-12">
                        <div class="days_progress">
                            <?php
                                $serNow  = \Carbon\Carbon::now();
                                $serSt   = $ser->start_date;

                                if($ser->expire_date){
                                    $serEnd  = \Carbon\Carbon::parse($ser->expire_date);
                                } else {
                                    $serEnd  = \Carbon\Carbon::parse(date('Y-m-d',strtotime('+'.$ser->service->no_of_days.' Days')));
                                }

                                if($serSt){
                                    $serTotalDays = $serEnd->diffInDays($serSt);
                                } else {
                                    $serTotalDays = $serEnd->diffInDays(date('Y-m-d'));
                                }
								$serTotalDays = $serTotalDays > 0 ? $serTotalDays : 1;
                                $serdayConsume = $serNow->diffInDays($serSt);
                                $serper = $serdayConsume * 100 / $serTotalDays;

                                //echo $ser->service->available_lessons;
                            ?>
                            <div class="bar_text">
                                <span>{{__('labels.stu_days_consumed')}}</span>
                                <span class="days_bar">{{ $serdayConsume }}/{{ $serTotalDays }}</span>
                            </div>
                            <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$serper}}%" aria-valuenow="25"aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="bar_text">
                                <span class="days_bar">
                                    @if($ser->expire_date)
										<?php
										$expiry_date = App\Helpers\AppHelper::format_date_FjY(date('Y-m-d', strtotime($ser->expire_date)));
										?>
                                        {{__('labels.stu_lesson_expiry_date')}} : {{ $expiry_date }}
                                    @else
										<?php
										$expiry_date = App\Helpers\AppHelper::format_date_FjY(date('Y-m-d', strtotime('+'.$ser->service->no_of_days.' Days')));
										?>
                                        {{__('labels.stu_lesson_expiry_date')}} : {{ $expiry_date }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        @endforeach
    </div>
@else
    <div class="alert-danger show" role="alert" style="border: 1px solid;border-radius: 5px;padding: .75rem 1.25rem;
	margin-bottom: 1rem;">
		{{__('labels.stu_you_do_not_active_lesson_record')}} <a href="{{ route('pricing.index') }}">{{__('labels.here')}}</a>.
	</div>
@endif

