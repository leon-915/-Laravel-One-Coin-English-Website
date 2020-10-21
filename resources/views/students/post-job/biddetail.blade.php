@extends('layouts.app',['title'=> __('labels.stu_job_post')])
@section('title', __('labels.stu_job_post'))
@section('content')

<section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="{{route('students.post.job.index')}}">
                                        <span>{{__('labels.stu_new_job')}}</span></a>
                                </li>
                                <li role="presentation"><a href="{{route('students.post.job.form')}}">
                                        <span>{{__('labels.stu_create_job')}}</span></a>
                                </li>
                                <li role="presentation"><a href="#history" aria-controls="history" role="tab"
                                                           data-toggle="tab" class="active"><span>{{__('labels.stu_history')}}</span></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpane1" class="tab-pane active" id="history">
								
									@if(!empty($job))
										<div class="current_course">
											<div class="row">
												<div class="col-12">
													<div class="plan_header">
														<h2>{{__('labels.stu_bidding_receive_for_this_job')}}</h2>
														<p>{{__('labels.stu_see_all_bidding_offer_from_teacher')}}</p>
													</div>
												</div>
											</div>

											@if(count($job) > 0)

												<div class="service_session">
													<div class="row">
														@foreach($job as $bid)
															<div class="col-12 col-md-12 col-lg-6">
																<div class="service_session_details">
																	<div class="s-hd">
																		<p>{{__('labels.stu_subject')}} </p>
																		<h4>{{$bid->subject}} </h4>
																	</div>
																	<div class="serv_details">
																		<div class="row">
																			<div class="col-lg-4 col-md-6 col-6">
																				<div class="tym_table_Details">
																					<h6> {{__('labels.stu_job_price')}}</h6>
																					<p>{{$bid->price}}</p>
																				</div>
																			</div>
																			<div class="col-lg-4 col-md-6 col-6">
																				<div class="tym_table_Details">
																					<h6>{{__('labels.stu_teacher')}} </h6>
																					<p> {{$bid->teacher_name}}</p>
																				</div>
																			</div>
																			<div class="col-lg-4 col-md-6 col-6">
																				<div class="tym_table_Details">
																					<h6> {{__('labels.stu_bidding_price')}}</h6>
																					<p>{{$bid->bid_price}}</p>
																				</div>
																			</div>
																			<div class="col-lg-4 col-md-6 col-6">
																				<div class="tym_table_Details">
																					<h6> {{__('labels.stu_date')}} </h6>
																					<p>{{Carbon\Carbon::parse($bid->created_at)->format('Y-m-d')}}</p>
																				</div>
																			</div>
																			<div class="col-lg-4 col-md-6 col-6">
																				<div class="tym_table_Details">
																					<h6> {{__('labels.stu_time')}} </h6>
																					<p>{{Carbon\Carbon::parse($bid->created_at)->format('H:i')}}</p>
																				</div>
																			</div>
																			<div class="col-lg-4 col-md-6 col-6">
																				<div class="tym_table_Details">
																					<h6>{{__('labels.stu_status')}} </h6>
																					<p>{{$bid->bid_status}}</p>
																				</div>
																			</div>
																			<div class="col-12">
																				<div class="tym_table_Details">
																					<!--h6> {{__('labels.stu_status')}} </h6-->
																					<a href="{{url('student/accept-bid/'.$bid->bid_id)}}" class="accept">
																						<i class="fa fa-check"></i>{{__('labels.stu_accept')}}
																					</a>
																					<a href="{{url('student/reject-bid/'.$bid->bid_id)}}" class="reject">
																						<i class="fa fa-times"></i>{{__('labels.stu_reject')}}
																					</a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														@endforeach
													</div>
												</div>
											@else
												<p><strong>{{__('labels.stu_no_bidding_received')}}</strong></p>
											@endif
										</div>

									@endif
									</div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	@push('scripts')

        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter : 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif
	@endpush
@endsection