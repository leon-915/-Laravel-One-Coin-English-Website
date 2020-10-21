<div class="card">
    <div class="card-header" id="heading-4">
        <h5 class="mb-0">
            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4"
                aria-expanded="false" aria-controls="collapse-4">
                Lesson Comment レッスンについてのコメント
            </a>
        </h5>
    </div>
    <div id="collapse-4" class="collapse" data-parent="#accordion" aria-labelledby="heading-4">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="improve_point mb-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 style="color: #002e58;">{{__('labels.stu_points_to_improve_comment')}}</h4>
                                <div class="point_text">
                                    @if ($booking->points_to_improve_comment)
                                        <p>{!! nl2br($booking->points_to_improve_comment) !!}</p>
                                    @else
                                        <p>{{__('labels.stu_no_comment')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="improve_point mb-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 style="color: #002e58;">{{__('labels.stu_strong_points_comment')}}</h4>
                                <div class="point_text">
                                    @if ($booking->strong_points_comment)
                                        <p>{!! nl2br($booking->strong_points_comment) !!}</p>
                                    @else
                                        <p>{{__('labels.stu_no_comment')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="improve_point mb-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 style="color: #002e58;">{{__('labels.stu_comment')}}</h4>
                                <div class="point_text">
                                    @if ($booking->booking_comments)
                                        <p>{!! nl2br($booking->booking_comments) !!}</p>
                                    @else
                                        <p>{{__('labels.stu_no_comment')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--div class="improve_point">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4>{{__('labels.stu_poin_to_improve')}}</h4>
                                @foreach ($studentLessonPoints as $key=>$point)
                                    @if ($point->status == 2)
                                        <div class="point_text">
                                            <p>{{$point->point->description_en}}</p><br>
                                            <p>{{$point->point->description_ja}}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-lg-6">
                                <h4 class="strong">{{__('labels.stu_strong_point')}}</h4>
                                @foreach ($studentLessonPoints as $key=>$point)
                                    @if ($point->status == 1)
                                        <div class="point_text">
                                            <p>{{$point->point->description_en}}</p><br>
                                            <p>{{$point->point->description_ja}}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div-->
                </div>
            </div>
        </div>
    </div>
</div>
