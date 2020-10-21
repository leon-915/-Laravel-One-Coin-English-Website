@if (!empty($student_lessons) && $student_lessons->toArray())
    @foreach($student_lessons as $id => $lesson)
        <?php 
		$lessonBookings = $lesson['bookings']->toArray(); 
		$lesson_taught = $completed[$id];
		/*$datetime1 = new DateTime();
		$datetime2 = new DateTime($lesson['expire_date']);
		$interval = $datetime1->diff($datetime2);
		$rdays = $interval->format('%a');*/
		$datediff = strtotime($lesson['expire_date']) - strtotime(date('Y-m-d'));
		$rdays = floor($datediff / (60 * 60 * 24));
							
		
		if ($lesson_taught > 0) {
			$avg_days = ceil($rdays / $lesson_taught);
		} else {
			$service_available_lessons = $lesson['service']['available_lessons'] > 0 ? $lesson['service']['available_lessons'] : 1;
			$avg_days = ceil($rdays / $service_available_lessons);
		}
		
		$rolled_over_lessons =  $lesson['rolled_over_lessons'] > 0 ? $lesson['rolled_over_lessons'] : 0;
		$free_lessons = $lesson['free_lessons'] > 0 ? $lesson['free_lessons'] : 0;
		//echo '<pre>';print_r($lesson['bookings']);exit;
		?>
        <div class="current-course-container">
        	<div class="current-course-inner">
                <div class="current_course">
                    <div class="row">
                        <div class="col-12">
                            <div class="plan_header">
                                <h2> {{$lesson['service']['title']}}</h2>
                                <p>{{__('labels.dash_current_cource_details')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="date_time_tbl">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.dash_start_date')}}</h5>
                                    <p>{{ !empty($lesson['start_date']) ? $lesson['start_date'] : date('Y-m-d', strtotime($lesson['created_at'])) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.dash_end_date')}}</h5>
                                    <?php
                                        $expireDate = null;
                                        if(!empty($lesson['expire_date'])){
                                            $expireDate = $lesson['expire_date'];
                                        } else {
                                            if(!empty($lesson['service']['no_of_days'])){
                                                $expireDate = date('Y-m-d',strtotime("+".$lesson['service']['no_of_days']." Days", strtotime($lesson['created_at'])));
                                            } else {
                                                $expireDate = date('Y-m-d',strtotime("+30 Days", strtotime($lesson['created_at'])));
                                            }
                                        }
                                    ?>
                                    <p>{{$expireDate}}</p>
        
                                </div>
                            </div>
        
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.dash_cource_terms')}}</h5>
                                    <p>{{ $lesson['service']['no_of_days'] + $lesson['days_extend'] }}</p>
                                </div>
                            </div>
        
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.lessons_remaining')}}</h5>
                                    <p>{{$lesson['available_bookings']}} / {{$lesson['service']['available_lessons'] + $free_lessons + $rolled_over_lessons}}</p>
                                </div>
                            </div>
        
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.dash_free_lesson')}}</h5>
                                    <p>{{$free_lessons}}</p>
                                </div>
                            </div>
        
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.dash_lesson_taught')}}</h5>
                                    <p>{{$lesson_taught}}</p>
                                </div>
                            </div>
        
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.dash_days_remain')}}</h5>
                                    <p>{{$rdays}}</p>
                                </div>
                            </div>
        
                            <?php
                                /*$datetime1 = new DateTime($lesson['start_date']);
                                $datetime2 = new DateTime($lesson['expire_date']);
                                $interval = $datetime1->diff($datetime2);
                                $rdays = $interval->format('%a');
                                $days_extended = $rdays - $lesson['service']['no_of_days'];*/
                            ?>
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.dash_days_extends')}}</h5>
                                    <p>{{$lesson['days_extend']}}</p>
                                </div>
                            </div>
        
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.rolled_over_lessons')}}</h5>
                                    <p><?php echo $rolled_over_lessons;?></p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="tym_table_Details">
                                    <h5>{{__('labels.avg_days_btwn_lr')}}</h5>
                                    <p>{{ $avg_days }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="current_course" data-lesson_id="{{ $lesson->id }}" data-service="{{$lesson['service']['id']}}" id="current-booking-container-{{ $lesson->id }}">
                    @include('students.dashboard.index.current-course.lessons.bookings')
                </div>
            </div>
        </div>
    @endforeach
@endif

@if( empty($package) && empty($student_lessons))
    <div class="current_course">
        <div class="row">
            <div class="col-12">
                <div class="plan_header">
                    <p>{{__('labels.dash_no_lesson_available')}}
                        <a href="{{route('students.account.index')}}">
                            {{__('labels.dash_click_here_to_buy')}}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
