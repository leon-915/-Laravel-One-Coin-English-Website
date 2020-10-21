<div class="card">
    <div class="card-header" id="heading-3">
        <h5 class="mb-0">
            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3"
                aria-expanded="false" aria-controls="collapse-3">
                {{__('labels.stu_currect_incorrect_phrases')}}
            </a>
        </h5>
    </div>
    <div id="collapse-3" class="collapse" data-parent="#accordion" aria-labelledby="heading-3">
        <div class="card-body">

            <!--div class="row">
                <div class="col-12">
                    <div class="plan_header">
                        <h2>{{__('labels.stu_currect_incorrect_phrases')}}</h2>
                    </div>
                </div>
            </div-->
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive stus_tbl">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{__('labels.stu_incorrect_phrases')}}</th>
                                    <th>{{__('labels.stu_currect_phrases')}}</th>
                                    <th>{{__('labels.stu_status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
							@if(!empty($studentLesson->cips))
                                @foreach ($studentLesson->cips as $cip)
                                <tr>
                                    <td>
										<a class="glow" target="_blank" href="https://translate.google.com/#en/ja/{{$cip->incorrect_phrase}}">
												<?php echo $cip->incorrect_phrase;?>
										</a>
									</td>
                                    <td>
										<a class="glow" target="_blank" href="https://translate.google.com/#en/ja/{{$cip->correct_phrase}}">
												<?php echo $cip->correct_phrase;?>
										</a>
									</td>
                                    <td>
                                        @switch($cip->status)
                                            @case(1)
                                                <img src="{{ asset('images/img_1.png') }}">
                                                @break
                                            @case(2)
                                                <img src="{{ asset('images/img_2.png') }}">
                                                @break
                                            @case(3)
                                                <img src="{{ asset('images/img_3.png') }}">
                                                @break
                                            @case(4)
                                                <img src="{{ asset('images/img_4.png') }}">
                                                @break
                                            @case(5)
                                                <img src="{{ asset('images/img_5.png') }}">
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                @endforeach
								@endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
