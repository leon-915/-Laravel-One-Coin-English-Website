<div class="card">
    <div class="card-header" id="fp-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#fp-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="fp-collapse-{{ $level->id }}">
                [F&P] Fluency & Pronunciation・流暢さ&発音
            </a>
        </h5>
    </div>
    <div id="fp-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="fp-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="fp_content">
					<?php $lev_cnt_in = 1;?>
                    @foreach ($level->fp as $cakey => $fp)
                        <p>{{ $fp->description_en }}
						<span id="<?php echo 'fp_'.$lev_cnt_in.'_'.$lev_cnt?>" style="display:none"><br>{{ $fp->description_ja }}</span>
                         <a class="<?php echo 'fp_'.$lev_cnt_in.'_'.$lev_cnt?>" style="color:#0a98c0" href="javascript:void(0);" onclick="show_japanes_text('<?php echo 'fp_'.$lev_cnt_in.'_'.$lev_cnt?>')">Read More</a>
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
