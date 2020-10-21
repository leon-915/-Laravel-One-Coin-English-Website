@extends('layouts.app',['title'=> __('labels.stu_job_post')])
@section('title', __('labels.stu_job_post'))
@section('content')

    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="order_details_sec history_detail">
                            <div class="row">
                                <div class="col-12 col-lg-6 cpl-md-12">
                                    <div class="plan_header">
                                        <h2>{{__('labels.stu_previous_job_details')}}</h2>
                                        <p>{{__('labels.stu_some_details_previous_job_post')}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="tym_table_Details">
                                        <h5>{{__('labels.stu_job_price')}}</h5>
                                        <p>{{$job->price}}</p>
                                    </div>
                                    @if(!empty($job->bid))
                                        <div class="tym_table_Details">

                                            <h5>{{__('labels.stu_bidding_price')}}</h5>
                                            <p>{{$job->bid->bid_price}}</p>
                                        </div>

                                        <div class="tym_table_Details">
                                            <h5> {{__('labels.stu_teacher')}} </h5>
                                            <p> {{$job->bid->teacher->firstname}} {{$job->bid->teacher->lastname}}</p>
                                        </div>
                                    @endif
                                    <div class="tym_table_Details">
                                        <h5> {{__('labels.stu_date')}} </h5>
                                        <p>{{\Carbon\Carbon::parse($job->created_at)->format('Y-m-d')}}</p>
                                    </div>
                                    <div class="tym_table_Details">
                                        <h5> {{__('labels.stu_time')}} </h5>
                                        <p>{{\Carbon\Carbon::parse($job->created_at)->format('H:i')}}</p>
                                    </div>
                                    <div class="tym_table_Details">
                                        <h5> {{__('labels.stu_status')}} </h5>
                                        <p>{{$job->status}}</p>
                                    </div>
                                    @if($job->status == "completed")
                                        <div class="tym_table_Details">
                                            @if(!$job->rating)
                                                <h5> {{__('labels.stu_rate_now')}} </h5>
                                                <input id="input-1-ltr-star-xs" name="input-1-ltr-star-xs"
                                                       class="kv-ltr-theme-svg-star rating-loading"
                                                       value="{{$job->rating ? $job->rating : 0}}" dir="ltr"
                                                       data-size="xs">
                                            @else
                                                <h5> {{__('labels.stu_rating')}} </h5>
                                                {{$job->rating}}
                                            @endif

                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <h5>{{__('labels.stu_subject')}}</h5>
                                    <p>{{$job->subject}} </p>
                                </div>
                            </div>

                            <div class="lesson_materials_task job_translate">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="lesson_inner">
                                            <h4 class="les_title">Orignal Text ・原文</h4>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <textarea><?= nl2br($job->highlights) ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="lesson_inner">
                                            @if($job->status == 'completed')
                                                <h4 class="les_title">Translated Text ・ 翻訳されたテキスト</h4>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            {{--<span class="text-area_part">--}}
                                                            <textarea
                                                                    disabled><?= nl2br($job->translation) ?></textarea>
                                                            {{--</span>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                               {{-- @if($job->status != 'completed' &&   count($job->postJobBid) > 0)
                                    <div class="service_session">
                                        <div class="row">
                                            @foreach($job->postJobBid as $biding)
                                                <div class="col-12 col-md-12 col-lg-6">
                                                    <div class="service_session_details">
                                                        <div class="s-hd">
                                                            <p>Subject </p>
                                                            <h4>{{$job->subject}} </h4>
                                                        </div>
                                                        <div class="serv_details">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-6 col-6">
                                                                    <div class="tym_table_Details">
                                                                        <h6> Job Price</h6>
                                                                        <p>{{$job->price}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-6">
                                                                    <div class="tym_table_Details">
                                                                        <h6>Teacher </h6>
                                                                        <p> {{$biding->teacher->firstname}} {{$biding->teacher->lastname}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-6">
                                                                    <div class="tym_table_Details">
                                                                        <h6> Bidding Price</h6>
                                                                        <p>{{$biding->bid_price}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-6">
                                                                    <div class="tym_table_Details">
                                                                        <h6> Date </h6>
                                                                        <p>{{Carbon\Carbon::parse($biding->date)->format('Y-m-d')}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-6">
                                                                    <div class="tym_table_Details">
                                                                        <h6> Time </h6>
                                                                        <p>{{Carbon\Carbon::parse($biding->date)->format('H:i')}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-6">
                                                                    <div class="tym_table_Details">
                                                                        <h6>Status </h6>
                                                                        <p>{{$biding->status}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="tym_table_Details">
                                                                        <h6> Status </h6>
                                                                        <a href="{{url('student/accept-bid/'.$biding->id)}}"
                                                                           class="accept"><i
                                                                                    class="fa fa-check"></i>Accept</a>
                                                                        <a href="{{url('student/reject-bid/'.$biding->id)}}"
                                                                           class="reject"><i
                                                                                    class="fa fa-times"></i>Reject</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif--}}
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <a href="{{route('students.post.job.history')}}" class="btnsub_arr">{{__('labels.btn_back')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')

        <script src="{{ asset('plugins/star-ratings/js/star-rating.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/star-ratings/themes/krajee-svg/theme.js') }}" type="text/javascript"></script>
        <script>
            $('.kv-ltr-theme-svg-star').rating({
                hoverOnClear: false,
                theme: 'krajee-svg'
            });

            $('.kv-ltr-theme-svg-star').on('rating:change', function (event, value, caption) {
                var data = {
                    rate: value,
                    job_id: '{{$job->id}}'
                };

                $.ajax({
                    url: '{{route('students.post.job.rating')}}',
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        $.toast({
                            heading: 'Success',
                            text: result.message,
                            icon: 'success',
                            position: 'top-right',
                        })
                        // setTimeout(() => {
                        //     window.location.reload();
                        // }, 2000)
                    }
                });
            });

        </script>
        <style>
            .order_details_sec.history_detail {
                display: block;
            }

            .text-area_part {
                height: 300px;
                background: #ffffff;
                display: inline-block;
                padding: 15px;
                overflow-y: auto;
                word-break: break-all;
            }
        </style>

    @endpush
@endsection
