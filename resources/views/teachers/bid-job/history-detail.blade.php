@extends('layouts.app',['title'=> __('labels.teacher_bid_job')])
@section('title', __('labels.teacher_bid_job'))
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
                                        <h2>Previous Job Details</h2>
                                        <p>Some details of your previous job post</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="tym_table_Details">
                                        <h5>Job Price</h5>
                                        <p>{{$postJobBid->job->price}}</p>
                                    </div>

                                    <div class="tym_table_Details">
                                        <h5> Student </h5>
                                        <p> {{$postJobBid->job->student->firstname}} {{$postJobBid->job->student->lastname}}</p>
                                    </div>
                                    <div class="tym_table_Details">
                                        <h5> Date </h5>
                                        <p>{{\Carbon\Carbon::parse($postJobBid->job->created_at)->format('Y-m-d')}}</p>
                                    </div>
                                    <div class="tym_table_Details">
                                        <h5> Time </h5>
                                        <p>{{\Carbon\Carbon::parse($postJobBid->job->created_at)->format('H:i')}}</p>
                                    </div>
                                    <div class="tym_table_Details">
                                        <h5> Status </h5>
                                        <p>{{$postJobBid->status}}</p>
                                    </div>
                                    @if($postJobBid->status == 'completed')
                                        <div class="tym_table_Details">
                                            <h5> Rating </h5>
                                            {{$postJobBid->job->rating}}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <h5>Subject</h5>
                                    <p>{{$postJobBid->job->subject}} </p>
                                </div>
                            </div>

                            <div class="lesson_materials_task job_translate">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="lesson_inner">
                                            <h4 class="les_title">Original Text ・原文</h4>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <textarea><?= nl2br($postJobBid->job->highlights) ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="lesson_inner">
                                            <h4 class="les_title">Translated Text ・ 翻訳されたテキスト</h4>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        @if($postJobBid->status == 'accepted')
                                                            <textarea name="test" class="trans_text"></textarea>
                                                        @elseif($postJobBid->status == 'completed')
                                                            <textarea name="test" class="trans_text"
                                                                      disabled><?= nl2br($postJobBid->job->translation) ?></textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right">
                                        @if($postJobBid->status == 'accepted')
                                        <button class="btnsub_arr" id="submit_trans">Submit</button>
                                        @endif
                                        <button class="btnsub_arr" id="cancel_trans" onclick="window.history.back();">Cancel</button>
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
        @push('scripts')
            <style>
                .order_details_sec.history_detail {
                    display: block;
                }
            </style>

        @endpush
        <script>
            $('#submit_trans').click(function () {
                var trans_text = $('.trans_text').val();

                if ($.trim(trans_text) == '') {
                    $.toast({
                        heading: 'Fail',
                        text: "Please add translation!",
                        icon: 'error',
                        position: 'top-right',
                    })

                    return false;
                } else {
                    var data = {
                        text: trans_text,
                        id: '{{$postJobBid->job->id}}',
                        bid_id: '{{$postJobBid->id}}'
                    }

                    $.ajax({
                        url: '{{route('teachers.add.translation')}}',
                        data: data,
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (resp) {
                            if (resp.type == 'success') {
                                $.toast({
                                    heading: 'Successs',
                                    text: "Post added successfully!",
                                    icon: 'success',
                                    position: 'top-right',
                                })

                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000)
                            } else {
                                $.toast({
                                    heading: 'Fail',
                                    text: "Something went wrong.!",
                                    icon: 'error',
                                    position: 'top-right',
                                })
                            }
                        }
                    })
                }
            });
        </script>
    @endpush
@endsection

