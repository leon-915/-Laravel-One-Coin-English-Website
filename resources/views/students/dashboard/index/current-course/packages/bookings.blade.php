<?php if($studentPackageLessonsBookings) { ?>
    <?php
        $dateTime = (new \DateTime())->modify('-24 hours');
        $date = $dateTime->format('Y-m-d');
        //$date = date('Y-m-d', strtotime($date));
        $button = 0;
        $adminCancelTime = App\Models\Settings::getSettings('cancel_before_time');
        $lessonBookings = $studentPackageLessonsBookings->toArray();

        $fromBooking = $lessonBookings['from'];
        $status = '';

    ?>
    <div class="service_session">
        <div class="row">
            @foreach($studentPackageLessonsBookings as $bid => $booking)

            <?php
                // echo '<pre>';
                // print_r($booking->toArray());
                // echo '</pre>';

                //$lessonDate = $booking['lession_date']->format('d-m-Y');
                $bookingDate = $booking['lession_date'];
                $bookingTime =  $booking['lession_time'];

                $cancelTime = ($booking['teacherDetail']['cancel_before_time'] != 0) ? $booking['teacherDetail']['cancel_before_time'] : $adminCancelTime;

                //$cancelTime = ($adminCancelTime <= $teachrCancelTime) ? $adminCancelTime : $teachrCancelTime;

                //$bookingDate->setTime($bookingTime->format('H'), $bookingTime->format('i'), $bookingTime->format('s'));
                $bookingTD =  $bookingDate.' '.$bookingTime;
                $bookedTime =  date('d-m-Y H:i:s', strtotime($bookingTD));
                $cancelBefore =  date('d-m-Y H:i:s', strtotime($bookingTD) - ($cancelTime * 3600));


                $now = date('d-m-Y H:i:s');

                if((strtotime($cancelBefore)) <= (strtotime($now))){
                    $button = 0;
                }else{
                    $button = 1;
                }
            ?>
                <div class="col-12 col-md-12 col-lg-12 reserv-detail">
                    <div class="service_session_details">
                        <div class="s-hd">
                            <p>
                                <a href="JavaScript:void(0);" data-toggle="tooltip" data-trigger="hover" title="{{$booking['service']['title']}}">{{$booking['service']['title']}}</a>
                            </p>
                            @if(
                                (($booking['status'] == 'booked') && ($button))
                                ||
                                (($booking['status'] == 'cancel') && ($booking['lession_type'] == 'trial'))

                            )
                                <span class="link_option">
                                    @if(($booking['status'] != 'cancel'))
                                        <a href="" data-url="{{route('student.dashboard.update.status', $booking['id'])}}"
                                        id="cancel" class="fa_close">
                                            <img src="{{asset('')}}images/cross_blue.png" class="blue_img">
                                            <img src="{{asset('images/cross_grey.png')}}" class="grey_img">
                                        </a>
                                    @endif
                                    <a href="{{route('student.dashboard.get.current.detail', $booking['id'])}}" class="fa_close">
                                        <img src="{{asset('images/edit_blue.png')}}" class="blue_img">
                                        <img src="{{asset('images/edit_grey.png')}}" class="grey_img">
                                    </a>

                                </span>
                            @endif
                        </div>
                        <input type="hidden" name="booking_id" value="{{$booking['id']}}">
                        <div class="serv_details">
                            <div class="row">
								<div class="col-lg-4 col-md-4 col-4">
									<div class="row">
										<div class="col-lg-5 col-md-5 col-5">
											<div class="tym_table_Details">
												<h6> {{__('labels.stu_lesson_number')}}</h6>
												{{-- <p>{{ ($bid + 1) }}</p> --}}
												<p>{{ $fromBooking }}</p>
											</div>
										</div>
										<div class="col-lg-7 col-md-7 col-7">
											<div class="tym_table_Details">
												<h6>{{__('labels.stu_teacher')}} </h6>
												<p>{{$booking['teacher']['firstname']}} {{$booking['teacher']['lastname']}}</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-8 col-md-8 col-8">
									<div class="row">
										<div class="col-lg-2 col-md-2 col-2">
											<div class="tym_table_Details">
												<h6> {{__('labels.stu_duration')}} </h6>
												<p>{{$booking['service']['length']}} {{$booking['service']['length_type']}}</p>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-2">
											<div class="tym_table_Details">
												<h6>{{__('labels.stu_date')}}  </h6>
												<p>{{$booking['lession_date']}}</p>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-2">
											<div class="tym_table_Details">
												<h6> {{__('labels.stu_time')}} </h6>
												<p>{{ date('H:i',strtotime($booking['lession_time'])) }}</p>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-2">
											<div class="tym_table_Details">
												<h6>{{__('labels.stu_status')}} </h6>
												<p>
													@if ($booking['status']== 'booked')
														<span class="badge badge-success badge-pill">Scheduled</span>
													@elseif ($booking['status'] == 'completed')
														<span class="badge badge-primary badge-pill">Completed</span>
													@elseif ($booking['status'] == 'cancel')
														<?php
															$temp = 'Cancelled';

															if((!empty($booking['lession_date'])) && (!empty($booking['cancelled_at']))){
																$lesson_at = date('Y-m-d',strtotime($booking['lession_date']));
																$cancel_at = date('Y-m-d',strtotime($booking['cancelled_at']));

																if($lesson_at == $cancel_at){
																	$temp = 'CSD';
																}
															}
															if(($booking['is_student_present'] == 1)){
																$temp = 'Snoshow';
															}
															if(($booking['is_teacher_present'] == 1)){
																$temp = 'Tnoshow';
															}
														?>

														<span class="badge badge-danger badge-pill">{{$temp}}</span>
													@elseif($booking['status'] == 'expired')
														<span class="badge badge-secondary badge-pill">Expired</span>
													@endif
												</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-4">
											<div class="tym_table_Details">
												<h6> {{__('labels.stu_location')}}</h6>
												<p>{{$booking['location']['title']}} </p>
											</div>
										</div>
									</div>
								</div>
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php $fromBooking++; ?>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 current-course-pagination" data-package_id="{{ $package->id }}"  id="c-paginator-{{ $package->id }}">
                {{ $studentPackageLessonsBookings->links() }}
            </div>
        </div>
    </div>


    <style>
    .service_session_details .s-hd p{
        display: inline-block;
        width:75%;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }
    </style>

    <script type="text/javascript">
        $(function () {
            $("#number").popover({
                title: "{{__('jsValidate.required.mobile_number')}}",
                content: "{{__('jsValidate.required.enter_10_digit_mobile_number_prefixed_by_country')}}",
                trigger:'hover'
            });
    });
    </script>
<?php } ?>
