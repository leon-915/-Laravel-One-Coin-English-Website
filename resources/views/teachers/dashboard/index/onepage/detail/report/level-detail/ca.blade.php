<div class="card">
    <div class="card-header" id="ca-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#ca-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="ca-collapse-{{ $level->id }}">
                [CA] Communicative Ability・コミュニケーション能力
            </a>
        </h5>
    </div>
    <div id="ca-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="ca-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="ca_content">
					<?php $lev_cnt_in = 1;?>
                    @foreach ($level->ca as $cakey => $ca)
                        <p>{{ $ca->description_en }}
						<span id="<?php echo 'ca_'.$lev_cnt_in.'_'.$lev_cnt?>" style="display:none"><br>{{ $ca->description_ja }}</span>
                         <a class="<?php echo 'ca_'.$lev_cnt_in.'_'.$lev_cnt?>" style="color:#0a98c0" href="javascript:void(0);" onclick="show_japanes_text('<?php echo 'ca_'.$lev_cnt_in.'_'.$lev_cnt?>')">Read More</a>
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
