<?php
    $credit_balance = $studentDetails->credit_balance;
    $reward_balance = ($studentDetails->reward_balance) ? $studentDetails->reward_balance : 0;

    $usedPoints = $package->total_credits - $credit_balance;
    if($usedPoints < 0){
        $usedPoints = 0;
    }
?>
@if (!empty($package))
    <?php //$lessonBookings = $lesson['bookings']->toArray(); ?>
    <div class="current-course-container">
    	<div class="current-course-inner">
            <div class="current_course">
                <div class="row">
                    <div class="col-12">
                        <div class="plan_header">
                            <h2> {{ $package->package->title }}</h2>
                            {{-- <p>Your current course details you can see here</p> --}}
                        </div>
                    </div>
                </div>
                <div class="date_time_tbl">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_start_date')}}</h5>
                                <p>{{ date('Y-m-d', strtotime($package->start_date)) }}</p>
                            </div>
                        </div>
        
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_end_date')}}</h5>
                                <p>{{ date('Y-m-d', strtotime($package->end_date)) }}</p>
                            </div>
                        </div>
        
                        <?php
                            $start_date = new DateTime($package->start_date);
                            $end_date = new DateTime($package->end_date);
                            $tinterval = $start_date->diff($end_date);
                            $termDays = $tinterval->format('%a');
                        ?>
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_cource_terms')}}</h5>
                                <p>{{$termDays}}</p>
                            </div>
                        </div>
        
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_remain_credit')}}</h5>
                                <p>{{ number_format($credit_balance) }}</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_point')}}</h5>
                                <p>{{ number_format($reward_balance) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
        
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_lesson_taught')}}</h5>
                                <p>{{ $spCompleted }}</p>
                            </div>
                        </div>
        
                        <?php
                            $datediff = strtotime($package->end_date) - strtotime(date('Y-m-d'));
                            $rdays = floor($datediff / (60 * 60 * 24));
                        ?>
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_days_remain')}}</h5>
                                <p>{{ !empty($rdays) ? $rdays : 0 }}</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{ __('labels.rolledover_credits') }}</h5>
                                <p>{{ $package->rolledover_credits }}</p>
                            </div>
                        </div>
        
                        
        
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.dash_used_credits')}}</h5>
                                <p>{{ $usedPoints }}</p>
                            </div>
                        </div>
        
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="tym_table_Details">
                                <h5>{{__('labels.returned_lesson_credits')}}</h5>
                                <p>{{ $tnoshowcnt }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="current_course" data-package_id="{{ $package->id }}"  id="current-package-booking-container-{{ $package->id }}">
                @include('students.dashboard.index.current-course.packages.bookings')
            </div>
        <div class="current-course-inner">
    </div>
@endif
