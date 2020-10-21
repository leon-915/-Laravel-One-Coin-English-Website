@extends('admin.layouts.admin',['title'=>'Student Bookings'])
@section('title', 'Student Bookings')
@section('content')
<?php

$credit_balance = $studentDetails->credit_balance;
$reward_balance = ($studentDetails->reward_balance) ? $studentDetails->reward_balance : 0;

$usedPoints = ($package->package->price - env('SUBSCRIPTION_FEE')) - $credit_balance;
if($usedPoints < 0){
	$usedPoints = 0;
}


$rolled_over_lessons =  $package['rolled_over_lessons'] > 0 ? $package['rolled_over_lessons'] : 0;
$free_lessons =  $package['free_lessons'] > 0 ? $package['free_lessons'] : 0;

?>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.student_bookings')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.student_bookings')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="text-align:center;">
                    <h2>
                        {{$package['student']['firstname']}} {{$package['student']['lastname']}}
                    </h2>
                </div>
                <form action="" method="POST" name="student_lesson_record" id="student_lesson_record">
                    <table cellpadding="4" cellspacing="0" width="1200"
                           class="table-responsive lesson-record-table booking-tbl-data" style="margin:0 auto" border="1">
                        <tbody>
                        <tr align="center" style="font-weight:bold">
                            <td style="background-color:#6fa8dc; color:#000" align="right">Course Start Date:</td>
                            <td align="left">{{ date('d M Y', strtotime($package['start_date'])) }}</td>
                            <td align="right" style="background-color:#e06666; color:#000;">Expiry Date:</td>
                            <?php
                            $expireDate = null;
                            if (!empty($package['end_date'])) {
                                $expireDate = date('d M Y', strtotime($package['end_date']));
                            }
                            ?>
                            <td align="left">{{ $expireDate }}</td>
                        </tr>
                        <tr align="center" style="font-weight:bold">
                            <td style="background-color:#9fc5e8; color:#000" align="right">Course Term (Days):</td>
                            <td align="left">
								<?php
								$start_date = new DateTime($package->start_date);
								$end_date = new DateTime($package->end_date);
								$tinterval = $start_date->diff($end_date);
								$termDays = $tinterval->format('%a');
								?>
								{{$termDays}}
							</td>
                            <td align="right" style="background-color:#ea9999; color:#000;">Remaining Credits:</td>
                            <td align="left">{{ number_format($credit_balance) }}</td>
                        </tr>
                        <tr align="center" style="font-weight:bold">
                            <td style="background-color:#cfe2f3; color:#000" align="right">Points:</td>
                            <td align="left">{{ number_format($reward_balance) }}</td>
                            
                            <td align="right" style="background-color:#f4cccc; color:#000;">Days Remaining (DR):</td>
                            <td align="left">
								<?php
								$datediff = strtotime($package->end_date) - strtotime(date('Y-m-d'));
								$rdays = floor($datediff / (60 * 60 * 24));
								?>
								{{ !empty($rdays) ? $rdays : 0 }}
							</td>
                        </tr>
                        <tr align="center" style="font-weight:bold">

                            <td style="background-color:#fefefe; color:#000" align="right">Lesson Taught:</td>
                            <td align="left" class="editable" id="rolledover_lession">{{ $spCompleted }}</td>
                            <td align="right" style="background-color:#fceded; color:#000;">Used Credits:</td>
                            <td align="left">{{ $usedPoints }}</td>
                        </tr>
                        <tr align="center" style="font-weight:bold">
                            <td id="free_lesson_field" style="background-color:#fefefe; color:#000" align="right">
                                Rolled Over Credits:
                            </td>
                            <td align="left" class="editable" id="free_lesson">{{ $package->rolledover_credits }}</td>
                            <td id="course_extension_field" align="right"
                                style="background-color:#fceded; color:#000;">Avg. Days between (LR):</td>
                            <td align="left" class="editable" id="course_extension">
								<?php
								if ($spCompleted > 0) {
									$avg_days = ceil($rdays / $spCompleted);
								} else {
									$avg_days = ceil($rdays / 1);
								}
								?>
								{{ $avg_days }}
							</td>
                        </tr>
                        <tr align="center" style="font-weight:bold">
                            <td id="free_lesson_field" style="background-color:#fefefe; color:#000" align="right">
                                Returned Credit Lesson(s):
                            </td>
                            <td align="left" class="editable" id="free_lesson">{{$free_lessons}}</td>
                            <td id="course_extension_field" align="right"
                                style="background-color:#fceded; color:#000;">Course Extension:</td>
                            <td align="left" class="editable" id="course_extension">{{$package['days_extend']}}</td>
                        </tr>
                        <tr align="center" style="font-weight:bold">
                            <td id="free_lesson_field" style="background-color:#fefefe; color:#000" align="right">
                                Free Points:
                            </td>
                            <td align="left" class="editable" id="free_lesson">{{$free_lessons}}</td>
                            <td id="course_extension_field" align="right"
                                style="background-color:#fceded; color:#000;"></td>
                            <td align="left" class="editable" id="course_extension"></td>
                        </tr>
                        </tbody>
                    </table>
                    <table cellpadding="4" cellspacing="0" width="1200"
                           class="table-responsive lesson-record-table booking-tbl-data" style="margin:0 auto" border="1">
                        <tbody>
                        <tr style="color:#000; background-color:#d9d9d9; padding:5px 5px">
                            {{--<th>chek</th>--}}
                            <th>Sr No.</th>
                            <th>Service</th>
                            <th>Time</th>
                            <th>Lesson Date</th>
                            <th>Location</th>
                            <th>Teacher</th>
                            <th>Credits</th>
                            <th>Points Earned</th>
                            <th>Duration</th>
                            <th>Status / IP</th>
                            {{--<th>&nbsp;</th>--}}
                        </tr>
						<?php
						$n = count($bookings);
						$i = 1;
						?>
                        @foreach($bookings as $key => $booking)
							<?php
							$bgcolor = '';
							if (strtotime($booking['lession_date'] . ' ' . $booking['lession_time']) > time() && $booking['status'] == 'booked') {
								$bgcolor = 'background-color:#77ED7E;';
							}
							
							if ((($i) < count($bookings) && strtotime($bookings[$i]['lession_date'] . ' ' . $bookings[$i]['lession_time']) < time() && (strtotime($booking['lession_date'] . ' ' . $booking['lession_time']) > time()) && $booking['status'] == 'booked') || ($i == count($bookings) && (strtotime($booking['lession_date'] . ' ' . $booking['lession_time']) > time()) && ($booking['status'] == 'booked'))) {
								$bgcolor = 'background-color:#46DB50;';
							}
							?>
                            <tr align="center" style="color:#000; <?php echo $bgcolor;?> ">
                                {{--<td><input type="checkbox" name="record_id[]" class="record_id" value="5100"></td>--}}
                                <td style="font-weight:bold;">{{$n}}</td>
                                <td>{{$booking['service']['title']}}</td>
                                <td>{{substr($booking['lession_time'], 0, 5)}}</td>
                                <td>{{$booking['lession_date']}}</td>
                                <td>{{$booking['location']['title']}}</td>
                                <td>{{ $booking['teacher']['email'] }}</td>
                                <td>{{ number_format($booking['total_earnings']) }}</td>
                                <td>{{$booking['points_on_rating']}}</td>
                                <td>{{ $booking['lesson_duration'] }}</td>
                                <td class="capitalize" data-id="{{ $booking['id'] }}">
                                    @if ($booking['status']== 'booked')
                                        <span class="badge badge-success badge-pill">Scheduled</span>
                                    @elseif ($booking['status'] == 'completed')
                                        <span class="badge badge-primary badge-pill">Completed</span>
                                    @elseif ($booking['status'] == 'csd')
                                        <span class="badge badge-danger badge-pill">CSD</span>
                                    @elseif ($booking['status'] == 'teacher_not_show')
                                        <span class="badge badge-danger badge-pill">Tnoshow</span>
                                    @elseif ($booking['status'] == 'student_not_show')
                                        <span class="badge badge-danger badge-pill">Snoshow</span>
                                    @elseif ($booking['status'] == 'cancel')
                                        <span class="badge badge-danger badge-pill">Cancelled</span>
                                    @elseif($booking['status'] == 'expired')
                                        <span class="badge badge-secondary badge-pill">Expired</span>
                                    @endif
									<span class="badge badge-secondary badge-pill" style="margin-top:5px;">{{ $booking['booking_ip'] }}</span>
                                </td>
                            </tr>
							<?php
							$n--;
							$i++;
							?>
                        @endforeach
                        {{--<tr>--}}
                        {{--<td colspan="10">--}}
                        {{--<input type="submit" name="Delete" value="Delete" onclick="return confirmDelete()">--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        </tbody>
                    </table>
                    <input type="hidden" name="page_name" value="delete_lesson_record">
                </form>
            </div>
        </div>
    </div>
@endsection