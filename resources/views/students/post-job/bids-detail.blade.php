
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

        @if(count($job->postJobBid) > 0)

            <div class="service_session">
                <div class="row">
                    @foreach($job->postJobBid as $bid)
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="service_session_details">
                                <div class="s-hd">
                                    <p>{{__('labels.stu_subject')}} </p>
                                    <h4>{{$job->subject}} </h4>
                                </div>
                                <div class="serv_details">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-6">
                                            <div class="tym_table_Details">
                                                <h6> {{__('labels.stu_job_price')}}</h6>
                                                <p>{{$job->price}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-6">
                                            <div class="tym_table_Details">
                                                <h6>{{__('labels.stu_teacher')}} </h6>
                                                <p> {{$bid->teacher->firstname}} {{$bid->teacher->lastname}}</p>
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
                                                <p>{{Carbon\Carbon::parse($bid->date)->format('Y-m-d')}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-6">
                                            <div class="tym_table_Details">
                                                <h6> {{__('labels.stu_time')}} </h6>
                                                <p>{{Carbon\Carbon::parse($bid->date)->format('H:i')}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-6">
                                            <div class="tym_table_Details">
                                                <h6>{{__('labels.stu_status')}} </h6>
                                                <p>{{$bid->status}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="tym_table_Details">
                                                <h6> {{__('labels.stu_status')}} </h6>
                                                <a href="{{url('student/accept-bid/'.$bid->id)}}" class="accept">
                                                    <i class="fa fa-check"></i>{{__('labels.stu_accept')}}
                                                </a>
                                                <a href="{{url('student/reject-bid/'.$bid->id)}}" class="reject">
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