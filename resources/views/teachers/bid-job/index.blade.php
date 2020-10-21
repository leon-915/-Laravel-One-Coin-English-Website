@extends('layouts.app',['title'=> __('labels.teacher_bid_job')])
@section('title', __('labels.teacher_bid_job'))
@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="#newjob" aria-controls="newjob" role="tab"
                                                           data-toggle="tab" class="active"> <span>New Job</span></a>
                                </li>
                                <li role="presentation"><a href="{{route('teachers.job.history')}}"><span>History</span></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpane1" class="tab-pane active" id="newjob">

                                    <div class="current_course">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="plan_header">
                                                    <h2>Recently Added Job Post</h2>
                                                    <p>Recently added jobs</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="service_session tech_job_new">
                                            <div class="row">
                                                @foreach($jobs as $job)
                                                    <div class="col-12 col-md-12 col-lg-6">
                                                        <div class="service_session_details">
                                                            <div class="s-hd">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-6">
                                                                        <div class="tym_table_Details">
                                                                            <h4> Student</h4>
                                                                            <p> {{$job->student->firstname}} {{$job->student->lastname}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-6">
                                                                        <div class="tym_table_Details">
                                                                            <h6>Job Price</h6>
                                                                            <p> {{$job->price}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="serv_details">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="tym_table_Details">
                                                                            <h6> Subject</h6>
                                                                            <p>{{$job->subject}}</p>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-2">
                                                                        <div class="tym_table_Details">
                                                                            <h6> Translation Highlights</h6>
                                                                            <p>{{$job->highlights}} </p>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row mt-2">
                                                                    <div class="col-6">
                                                                        <div class="tym_table_Details">
                                                                            <h6> Date </h6>
                                                                            <p>{{Carbon\Carbon::parse($job->created_at)->format('Y-m-d')}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="tym_table_Details">
                                                                            <h6> Time </h6>
                                                                            <p>{{Carbon\Carbon::parse($job->created_at)->format('H:i')}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-6">
                                                                        <div class="tym_table_Details">
                                                                            <div class="form_dashboard">
                                                                                <div class="job_date">
                                                                                    <div class="form-group from">
                                                                                        @if($job->checkBid($job->id) < 1)
                                                                                            <input type="text"
                                                                                                   class="form-control bid_amount"
                                                                                                   aria-describedby=""
                                                                                                   placeholder="Enter biding amount"
                                                                                                   job_id="{{$job->id}}"
                                                                                                   onkeypress='return isNumberKey(event)'
                                                                                            >

                                                                                            <button class="freetrial_btn bid_job"
                                                                                                    job_id="{{$job->id}}"
                                                                                                    job_amount="{{$job->price}}">
                                                                                                Bid
                                                                                            </button>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 text-right btn">
                                                                        <div class="tym_table_Details">
                                                                            <a href="{{url('teacher/bid_accept/'.$job->id)}}"
                                                                               class="accept"><i
                                                                                        class="fa fa-check"></i>Accept</a>
                                                                            {{--<a href="#" class="reject"><i--}}
                                                                            {{--class="fa fa-times"></i>Reject</a>--}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
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
        <script>
            function isNumberKey(evt) {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }

            $('.bid_job').click(function () {
                var job_id = $(this).attr('job_id');
                var job_amount = $(this).attr('job_amount');
                var amount = 0;
                $('.bid_amount').css('border', 'none');

                $('.job_date').each(function () {
                    if ($(this).find('.bid_amount').attr('job_id') == job_id) {
                        amount = $(this).find('.bid_amount').val();
                        if (amount == '' || amount <= 0) {
                            $(this).find('.bid_amount').css('border', '1px solid red')
                        } else if (amount > 0) {
                            var data = {
                                job_id: job_id,
                                amount: amount
                            }

                            $.ajax({
                                url: '{{route('teachers.make.bid')}}',
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
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 2000)
                                }
                            });
                        }
                    }
                });
            });
        </script>
    @endpush

@endsection



