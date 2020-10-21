<!--div class="card-header" id="heading-1">
    <h5 class="mb-0">
        <a role="button" class="collapsed" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
            Accent Progress Level and Rating Description ・レベルと評価の説明
        </a>
    </h5>
</div>
<div id="collapse-1" class="collapse" data-parent="#accordion" aria-labelledby="heading-1"-->
    <div class="card-body">

        <div id="accordion-one-page-levels">
			<?php
			$lev_cnt = 1;
			?>
            @foreach ($levels as $key => $level)
                <div class="card">
                    <div class="card-header" id="level-header-{{$level->id}}">
                        <h5 class="mb-0">
						@if($student->student_level_id == $level->id)
							<a class="collapsed" role="button"
                                data-toggle="collapse" href="#onepage-levels-collapse-{{$level->id}}"
                                aria-expanded="false"
                                aria-controls="onepage-levels-collapse-{{$level->id}}" style="background-color: #002e58; color:#FFF;">
						@else
							<a class="collapsed" role="button"
                                data-toggle="collapse" href="#onepage-levels-collapse-{{$level->id}}"
                                aria-expanded="false"
                                aria-controls="onepage-levels-collapse-{{$level->id}}">
						@endif
                                {{$level->name}}
                            </a>
                        </h5>
                    </div>

                    <div id="onepage-levels-collapse-{{$level->id}}" class="collapse"
                        data-parent="#accordion-one-page-levels"
                        aria-labelledby="level-header-{{$level->id}}">
						
						<div class="row" style="margin-left: 10px;margin-top: 10px;">
							<div class="ca_content">
								<p class="success">
									<?php echo $level->description_en; ?>
									<br>
									<span id="progress_level_<?php echo $lev_cnt; ?>" style="display:none">	
										<?php echo $level->description_ja; ?><br>
									</span>
									<a style="color:#0a98c0" href="javascript:void(0);" class="read-more-btn txt-green progress_level_<?php echo $lev_cnt; ?>" onclick="show_japanes_text('progress_level_<?php echo $lev_cnt; ?>')">Read More</a>
								</p>
							</div>
						</div>
							
                        <div class="card-body">
                            <div id="accordion-one-page-level-{{$level->id}}">
                                @include('teachers.dashboard.index.onepage.detail.report.level-detail.ca')
                                @include('teachers.dashboard.index.onepage.detail.report.level-detail.fp')
                                @include('teachers.dashboard.index.onepage.detail.report.level-detail.lc')
                                @include('teachers.dashboard.index.onepage.detail.report.level-detail.v')
                                @include('teachers.dashboard.index.onepage.detail.report.level-detail.ga')
                            </div>
                        </div>
                    </div>
                </div>
				
				<?php
				$lev_cnt++;
				?>
            @endforeach
        </div>
    </div>
</div>
