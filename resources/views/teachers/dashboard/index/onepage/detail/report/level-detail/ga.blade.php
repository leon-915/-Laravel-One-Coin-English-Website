<div class="card">
    <div class="card-header" id="ga-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#ga-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="ga-collapse-{{ $level->id }}">
                [G&A] Grammar & Accuracy・文法/正確さ
            </a>
        </h5>
    </div>
    <div id="ga-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="ga-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="ga_content">
					<?php $lev_cnt_in = 1;?>
                    @foreach ($level->ga as $cakey => $ga)
                        <p>{{ $ga->description_en }}
						<span id="<?php echo 'ga_'.$lev_cnt_in.'_'.$lev_cnt?>" style="display:none"><br>{{ $ga->description_ja }}</span>
                         <a class="<?php echo 'ga_'.$lev_cnt_in.'_'.$lev_cnt?>" style="color:#0a98c0" href="javascript:void(0);" onclick="show_japanes_text('<?php echo 'ga_'.$lev_cnt_in.'_'.$lev_cnt?>')">Read More</a>
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
