<div class="card">
    <div class="card-header" id="heading-2">
        <h5 class="mb-0">
            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2"
                aria-expanded="false" aria-controls="collapse-2">
                Key Words and Phrases キーワードとフレーズの復習
            </a>
        </h5>
    </div>
    <div id="collapse-2" class="collapse" data-parent="#accordion" aria-labelledby="heading-2">
        <div class="card-body">

            <!--div class="row">
                <div class="col-12">
                    <div class="plan_header">
                        <h2>{{__('labels.stu_keyword_and_phrases')}}</h2>
                    </div>
                </div>
            </div-->
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive stus_tbl">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{__('labels.stu_title')}}</th>
                                    <th>{{__('labels.stu_status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
							@if(!empty($studentLesson->keywords))
                                @foreach ($studentLesson->keywords as $keyword)
                                <tr>
                                    <td>
										<a class="glow" target="_blank" href="https://translate.google.com/#en/ja/{{$keyword->keyword}}">
											<?php echo $keyword->keyword;?>
										</a>
									</td>
                                    <td>
                                        @switch($keyword->status)
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
                                {{-- <tr>
                                    <td>Mario Maker 2</td>
                                    <td><img src="{{ asset('images/img_1.png') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>stadium</td>
                                    <td><img src="{{ asset('images/img_3.png') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>museum</td>
                                    <td><img src="{{ asset('images/img_3.png') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>I play with other
                                        people that make
                                        courses too.</td>
                                    <td><img src="{{ asset('images/img_2.png') }}">
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
