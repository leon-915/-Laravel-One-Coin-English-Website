<div class="card-header" id="headingOne">
    <h5 class="mb-0">
        <a class="collapse" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            Student Sessions
        </a>
    </h5>
</div>

<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#one-page-accordion">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive table_custom">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Student</th>
                                <th scope="col">Package</th>
                                <th scope="col">Location</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($teacherLessons))
                                @foreach ($teacherLessons as $key => $booking)
									<?php
									$lesson_date_time = strtotime($booking['lession_date']);
									$current_date = strtotime(date('Y-m-d'));
									$cutten_time = strtotime(date('H:i:s'));
									$taught_on_time = strtotime($booking['lession_time']);
									$lessonEndTime = $taught_on_time + ($booking['lesson_duration'] * 60);
									
									if ($lesson_date_time == $current_date) {
										if ($current_date == $lesson_date_time && ($taught_on_time <= $cutten_time && $lessonEndTime >= $cutten_time)) {
											$class = 'current-lesson';
										} else {
											$class = 'today-lesson';
										}
									} else {
										$class = 'previous_lesson';
									}
									
									$lession_time = substr($booking['lession_time'], 0, 5);
									?>
                                    <tr class="<?php echo $class; ?>">
                                        <td scope="row">{{ ($key+1) }}</td>
                                        <td>{{ $booking['student_name'] }}</td>
                                        <td>{{ $booking['service']}}</td>
                                        <td>{{ $booking['location']}}</td>
                                        <td>{{ $booking['lesson_duration'] }}</td>
                                        <td>{{ $booking['lession_date'] }}</td>
                                        <td>{{ $lession_time }}</td>
                                        <td>
                                            @if ( $booking['status'] == 'booked')    
                                                <a class="btn-start-session" href="javascript:void(0);" data-student_id="{{ $booking['user_id'] }}" data-service_id="{{ $booking['service_id'] }}" data-booking_id="{{ $booking['id'] }}" >
                                                    Start Session
                                                </a>
                                            @elseif($booking['status'] == 'cancel')
                                                <a> Cancelled</a>
                                            @elseif($booking['status'] == 'completed')
                                                <a class="btn-start-session" href="javascript:void(0);" data-student_id="{{ $booking['user_id'] }}" data-service_id="{{ $booking['service_id'] }}" data-booking_id="{{ $booking['id'] }}" >
                                                    View Session
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr style="text-align:  center">
                                    <td colspan="8">No lesson available for today.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
