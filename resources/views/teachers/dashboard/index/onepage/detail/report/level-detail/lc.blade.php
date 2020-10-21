<div class="card">
    <div class="card-header" id="lc-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#lc-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="lc-collapse-{{ $level->id }}">
                [LC] Listening Comprehension・リスニングの理解力
            </a>
        </h5>
    </div>
    <div id="lc-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="lc-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="lc_content">
					<?php $lev_cnt_in = 1;?>
                    @foreach ($level->lc as $cakey => $lc)
                        <p>{{ $lc->description_en }}
						<span id="<?php echo 'lc_'.$lev_cnt_in.'_'.$lev_cnt?>" style="display:none"><br>{{ $lc->description_ja }}</span>
                         <a class="<?php echo 'lc_'.$lev_cnt_in.'_'.$lev_cnt?>" style="color:#0a98c0" href="javascript:void(0);" onclick="show_japanes_text('<?php echo 'lc_'.$lev_cnt_in.'_'.$lev_cnt?>')">Read More</a>
						 </p>
						 <?php
						 $lev_cnt_in++;
						 ?>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
