<div class="card">
    <div class="card-header" id="heading-arps">
        <h5 class="mb-0">
            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-arps"
                aria-expanded="false" aria-controls="collapse-arps">
                Active Recall Pair・アクティブリコールペアの復習
            </a>
        </h5>
    </div>
    <div id="collapse-arps" class="collapse" data-parent="#accordion" aria-labelledby="heading-arps">
        <div class="card-body">

            <!--div class="row">
                <div class="col-12">
                    <div class="plan_header">
                        <h2>Active Recall Pair・アクティブリコールペアの復習</h2>
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
								<?php
								$keywords_array = [];
								if(!empty($booking->keywords)) {
									foreach($booking->keywords as $keywords) {
										$keywords_array[] = $keywords->keyword;
									}
								}
								?>
								@if(!empty($booking->arps))
                                @foreach ($booking->arps as $arp)
                                <tr>
                                    <td>
                                        <p>
											<a class="glow" target="_blank" href="https://translate.google.com/#en/ja/{{ $arp->line_1 }}">
												<?php 
													//echo $arp->line_2; 
													echo App\Helpers\AppHelper::check_keyword_in_string($keywords_array, $arp->line_1);
												?>
											</a>
										</p>
                                        <p>
											<a class="glow" target="_blank" href="https://translate.google.com/#en/ja/{{ $arp->line_2 }}">
												<?php 
													//echo $arp->line_2; 
													echo App\Helpers\AppHelper::check_keyword_in_string($keywords_array, $arp->line_2);
												?>
											</a>
										</p>
                                    </td>
                                    <td>
                                        @switch($arp->status)
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
