<?php
    /*$studentLevel = [];
    if(!empty($studentLesson->student_level)){
        $studentLevel = $studentLesson->student_level->toArray();
    }*/
	$display = '';
	$strongrating = [];
	//echo '<pre>';print_r($studentLessonPTI);
?>
<div class="success-alert">
	<div class="std_improve success">
		<div class="row">
			<div class="col-lg-12 col-12">
				<div class="improve_level">
					<ul class="level_inline">
						<li><span>Student level :-</span></li>
						<li><h5>{{$level_detail['name']}}</h5></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="std_improve success">
		<div class="row">
			<div class="col-lg-12 col-12">
				<div class="improve_level">
					<ul class="level_inline">
						<li><span>Level description:-</span></li>
						<li>
							<h5>{{$level_detail['description_en']}}</h5>
							<h5>{{$level_detail['description_ja']}}</h5>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="improve_two_sec" id="student-lesson-point-submit">
    <div class="row">
		<?php
			if(empty($avgRatData['CA']) && isset($strongrating['CA'])) {
				$avgRatData['CA'] = '1.00';
			}
			
			$CA = !empty($booking->ca_rating) ? $booking->ca_rating : '5.00';
			$FP = !empty($booking->fp_rating) ? $booking->fp_rating : '5.00';
			$LC = !empty($booking->lc_rating) ? $booking->lc_rating : '5.00';
			$V = !empty($booking->v_rating) ? $booking->v_rating : '5.00';
			$GA = !empty($booking->ga_rating) ? $booking->ga_rating : '5.00';
			$AVE = number_format(($CA + $FP + $LC + $V + $GA)/ 5, 2);
		?>
		<style type="text/css">
		  .selected_criteria {
			  color: #fff !important;
			  background-color: #002E58 !important;
			}
		</style>
		<div class="average_btn">
			<div class="row">
				<div class="col-12">
					<?php
					$ca_selected = ''; 
					$fp_selected = ''; 
					$lc_selected = ''; 
					$v_selected = ''; 
					$ga_selected = ''; 
					
					if($booking->filter_point_type == "CA") {
						$ca_selected = 'selected_criteria'; 
					} else if($booking->filter_point_type == "FP"){
						$fp_selected = 'selected_criteria'; 
					} else if($booking->filter_point_type == "LC"){
						$lc_selected = 'selected_criteria'; 
					} else if($booking->filter_point_type == "V"){
						$v_selected = 'selected_criteria'; 
					} else if($booking->filter_point_type == "GA"){
						$ga_selected = 'selected_criteria'; 
					}
					?>
					<a href="javascript:void(0);" id="p-AVG-rate">Average : <b><?= $AVE  ?></b></a>
					<a href="javascript:void(0);" class="rating_criteria <?php echo $ca_selected;?>" data-criteria="CA" id="p-CA-rate">CA : <?= $CA ?></a>
					<a href="javascript:void(0);" class="rating_criteria <?php echo $fp_selected;?>" data-criteria="FP" id="p-FP-rate">F&P : <?= $FP ?></a>
					<a href="javascript:void(0);" class="rating_criteria <?php echo $lc_selected;?>" data-criteria="LC" id="p-LC-rate">LC : <?= $LC ?></a>
					<a href="javascript:void(0);" class="rating_criteria <?php echo $v_selected;?>" data-criteria="V" id="p-V-rate">V : <?= $V ?></a>
					<a href="javascript:void(0);" class="rating_criteria <?php echo $ga_selected;?>" data-criteria="GA" id="p-GA-rate">G&A : <?= $GA ?></a>
					<input type="hidden" id="filter_point_type" name="filter_point_type" value="<?php echo $booking->filter_point_type;?>" />
					<input type="hidden" id="ca_rating" value="<?= $CA  ?>">
					<input type="hidden" id="fp_rating" value="<?= $FP ?>">
					<input type="hidden" id="lc_rating" value="<?= $LC ?>">
					<input type="hidden" id="v_rating" value="<?= $V ?>">
					<input type="hidden" id="ga_rating" value="<?= $GA ?>">
				</div>
			</div>
		</div>
		
        <div class="col-lg-6 col-md-6 col-12">
            <div class="improve_box">
                
                <div class="custom_select @if($booking->is_wrapped == 1) hide @endif">
                    <div class="select cust">
					<!--select class="form-control" id="filter_point_type" name="filter_point_type">
                            <option @if(!$booking->filter_point_type) selected @endif value="">All</option>
                            <option @if($booking->filter_point_type == "CA") selected @endif value="CA">CA</option>
                            <option @if($booking->filter_point_type == "FP") selected @endif value="FP">FP</option>
                            <option @if($booking->filter_point_type == "LC") selected @endif value="LC">LC</option>
                            <option @if($booking->filter_point_type == "V") selected @endif value="V">V</option>
                            <option @if($booking->filter_point_type == "GA") selected @endif value="GA">GA</option>
					</select-->
                    </div>
                </div>

                <h4>Points to Improve・のばせるポイント</h4>
                <div id="response_div_points_to_improve" style="height: 400px;overflow-y: scroll;">
                    @foreach ($studentLessonPTI as $key=>$point)
						@if($booking->filter_point_type != $point->point->rating_point) 
							 <div class="pnt_intro" style="display:none;" data-levelid="{{ $point->point->level_id }}" data-type="{{ $point->point->rating_point }}" id="lk-impr-chk-{{$point->id}}">
						@else
							 <div class="pnt_intro" data-levelid="{{ $point->point->level_id }}" data-type="{{ $point->point->rating_point }}" id="lk-impr-chk-{{$point->id}}">
						@endif
                        
                            <div class="frm_check">
                                <div class="form-group">
                                     @if($booking->is_wrapped == 0)
                                        <label class="checkcontainer">
                                            <input type="checkbox" data-type="{{ $point->point->rating_point }}" class="points_to_improve" name="level_point[strong][{{$point->id}}]" value="{{$point->id}}" data-text="{{$point->point->description_en}} {{$point->point->description_ja}}">
                                            <span class="checkmark"></span>
                                        </label>
										<span class="points_to_improve_arraow" data-text="{{$point->point->description_en}} {{$point->point->description_ja}}"><i class="fa fa-plus" aria-hidden="true"></i></span>
										
											
                                    @endif
                                </div>
                            </div>
                            <div class="frm_dstion">
                                <p>{{$point->point->description_en}}</p>
                                <p>{{$point->point->description_ja}}</p>
                                {{-- <a href="#" class="read_more">Read More</a> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($booking->is_wrapped == 0)
                <div class="impv_btn_cent">
                    <a href="javascript:void(0);" id="mv_to_weak">
                        <i class="fas fa-angle-double-left"></i>
                    </a>
                </div>
                <div class="impv_btn_cent right">
                    <a href="javascript:void(0);" id="mv_to_strong">
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <div class="improve_box right">
                <h4>Strong Points・良いポイント</h4>
                <div id="response_div_strong_points" style="height: 400px;overflow-y: scroll;">
                    @foreach ($studentLessonSP as $key=>$point)
						@if($booking->filter_point_type != $point->point->rating_point) 
							 <div class="pnt_intro" style="display:none;" data-levelid="{{ $point->point->level_id }}" data-type="{{ $point->point->rating_point }}" id="lk-impr-chk-{{$point->id}}">
						@else
							 <div class="pnt_intro" data-levelid="{{ $point->point->level_id }}" data-type="{{ $point->point->rating_point }}" id="lk-impr-chk-{{$point->id}}">
						@endif
                        
                            <div class="frm_check">
                                <div class="form-group">
                                    @if($booking->is_wrapped == 0)
                                        <label class="checkcontainer">
                                            <input type="checkbox" data-type="{{ $point->point->rating_point }}" class="strong_points" name="level_point[weak][{{$point->id}}]" value="{{$point->id}}" data-text="{{$point->point->description_en}} {{$point->point->description_ja}}">
                                            <span class="checkmark"></span>											
                                        </label>
										<!--span class="strong_points_arraow" data-text="{{$point->point->description_en}} {{$point->point->description_ja}}">Move</span-->
										<span class="strong_points_arraow" data-text="{{$point->point->description_en}} {{$point->point->description_ja}}"><i class="fa fa-plus" aria-hidden="true"></i></span>
										<?php
										if(isset($strongrating[$point->point->rating_point])) {
											$strongrating[$point->point->rating_point] = $strongrating[$point->point->rating_point] +1;
										} else {
											$strongrating[$point->point->rating_point] = 1;
										}
										?>
                                    @endif
                                </div>
                            </div>
                            <div class="frm_dstion">
                                <p>{{$point->point->description_en}}</p>
                                <p>{{$point->point->description_ja}}</p>
                                {{-- <a href="#" class="read_more">Read More</a> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<?php
	/*if(empty($avgRatData['CA']) && isset($strongrating['CA'])) {
		$avgRatData['CA'] = '1.00';
	}
	
    $CA = !empty($booking->ca_rating) ? $booking->ca_rating : '5.00';
    $FP = !empty($booking->fp_rating) ? $booking->fp_rating : '5.00';
    $LC = !empty($booking->lc_rating) ? $booking->lc_rating : '5.00';
    $V = !empty($booking->v_rating) ? $booking->v_rating : '5.00';
    $GA = !empty($booking->ga_rating) ? $booking->ga_rating : '5.00';
    $AVE = number_format(($CA + $FP + $LC + $V + $GA)/ 5, 2);*/
?>


<input type="hidden" id="auto_save_filter_point" value="{{ route('teachers.dashboard.auto.save.filter.point') }}" />
<input type="hidden" id="auto_save_url" value="{{ route('teachers.dashboard.auto.save') }}" />
<input type="hidden" id="recently_moved_strong_point_item" value="" />
<input type="hidden" id="recently_moved_points_tom_improve_item" value="" />

<input type="hidden" id="tCA" value="<?= !empty($onepage_level_points_cnt['CA']) ? $onepage_level_points_cnt['CA'] : 1 ?>" />
<input type="hidden" id="tFP" value="<?= !empty($onepage_level_points_cnt['FP']) ? $onepage_level_points_cnt['FP'] : 1 ?>" />
<input type="hidden" id="tLC" value="<?= !empty($onepage_level_points_cnt['LC']) ? $onepage_level_points_cnt['LC'] : 1 ?>" />
<input type="hidden" id="tV" value="<?= !empty($onepage_level_points_cnt['V']) ? $onepage_level_points_cnt['V'] : 1 ?>" />
<input type="hidden" id="tGA" value="<?= !empty($onepage_level_points_cnt['GA']) ? $onepage_level_points_cnt['GA'] : 1 ?>" />
<style>
  .improve_box .select.cust {
        width: 70px;
        float: right;
        height: 40px;
        border: 1px solid #e8e8e8;
        top: -10px;
    }
    .improve_box .select.cust select{margin-top: -4px;}

    select#filter_point_type:after{
        top: 1px !important;
        right: -5px !important;
    }

    .improve_box .select::after{top: 0px !important;right: 0;}
</style>

<script>
    var tCA = <?= !empty($totalPoints['CA']) ? $totalPoints['CA'] : 1 ?>;
    var tFP = <?= !empty($totalPoints['FP']) ? $totalPoints['FP'] : 1 ?>;
    var tLC = <?= !empty($totalPoints['LC']) ? $totalPoints['LC'] : 1 ?>;
    var tV  = <?= !empty($totalPoints['V']) ? $totalPoints['V'] : 1 ?>;
    var tGA = <?= !empty($totalPoints['GA']) ? $totalPoints['GA'] : 1 ?>;

	// move text strong points
    $(document).on('click','.strong_points_arraow',function(){
		if($('#strong_points_comment_textarea').val() != '') {
			if(!confirm('Would you like to overwrite the existing comment?')) {
				return false;
			}
		}
		var txt = $(this).attr('data-text');
		$('#strong_points_comment_textarea').val(txt);
		$('#undostrongpoints').show();
		//$('.strong_points_arraow').hide();
	});
	
	// move text points to improve
	$(document).on('click','.points_to_improve_arraow',function(){
		if($('#points_to_improve_comment_textarea').val() != '') {
			if(!confirm('Would you like to overwrite the existing comment?')) {
				return false;
			}
		}
		var txt = $(this).attr('data-text');
		$('#points_to_improve_comment_textarea').val(txt);
		$('#undopointstoimprove').show();
		//$('.points_to_improve_arraow').hide();	
	});	
	
	// undo 
	$("#undopointstoimprove").click(function () {
		var id = $(this).attr('data-id');
		if(id != ''){
			var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
			$('#lk-impr-chk-'+id).unwrap();
			$('#response_div_strong_points').append(chk);
			$('#response_div_points_to_improve #lk-impr-chk-'+id).remove();
		}
		$('#points_to_improve_comment_textarea').val('');
		$('.points_to_improve_arraow').show();													
		$('#undopointstoimprove').hide();
	});
	
	$("#undostrongpoints").click(function () {
		var id = $(this).attr('data-id');
		if(id != ''){
			var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
			$('#lk-impr-chk-'+id).unwrap();
			$('#response_div_points_to_improve').append(chk);
			$('#response_div_strong_points #lk-impr-chk-'+id).remove();
		}	
		$('#strong_points_comment_textarea').val('');
		$('.strong_points_arraow').show();													
		$('#undostrongpoints').hide();
	});
	
	$(document).on('click','#mv_to_weak',function(e){
        e.preventDefault();
        e.stopPropagation();
        var poi = [];
		var strong_ids = [];
		var week_ids = [];
        if($("input:checked.points_to_improve").length > 0 || $("input:checked.strong_points").length > 0){
			if($('#points_to_improve_comment_textarea').val() != '') {
				if(!confirm('Would you like to overwrite the existing comment?')) {
					return false;
				}
			}
			$('#undopointstoimprove').show();
			
            $("input:checked.points_to_improve").each(function () {
				var txt = $(this).attr('data-text');
				$('#points_to_improve_comment_textarea').val(txt);
				var id = $(this).val();
				week_ids.push(id);
                var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
                $('#lk-impr-chk-'+id).unwrap();
                $('#response_div_points_to_improve').append(chk);
                $('#response_div_strong_points #lk-impr-chk-'+id).remove();
				$('#recently_moved_points_to_improve_item').val(id);
				$('#undopointstoimprove').attr('data-id', id);
            });
            $("input:checked.strong_points").each(function () {
				var txt = $(this).attr('data-text');
				$('#points_to_improve_comment_textarea').val(txt);
				
				var id = $(this).val();
				week_ids.push(id);
                var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
                $('#lk-impr-chk-'+id).unwrap();
                $('#response_div_points_to_improve').append(chk);
                $('#response_div_strong_points #lk-impr-chk-'+id).remove();
				$('#recently_moved_points_to_improve_item').val(id);
				$('#undopointstoimprove').attr('data-id', id);
				
            });
			if($('#strong_points_comment_textarea').val() == $('#points_to_improve_comment_textarea').val()) {
				$('#strong_points_comment_textarea').val('');				
				$('#undostrongpoints').attr('data-id', '');
				$('#undostrongpoints').hide();
			}
			updatePoints(strong_ids,week_ids)
            countAvg();
         } else {
             $('#alert-one-strong-points').modal('show');
             return false;
         }
    });

    $(document).on('click','#mv_to_strong',function(e){
        e.preventDefault();
        e.stopPropagation();
		var strong_ids = [];
		var week_ids = [];
		var flag = true;
        if($("input:checked.points_to_improve").length > 0 || $("input:checked.strong_points").length > 0){
			if($('#strong_points_comment_textarea').val() != '') {
				if(!confirm('Would you like to overwrite the existing comment?')) {
					return false;
				}
			}				
			
			$('#undostrongpoints').show();	
			
            $("input:checked.points_to_improve").each(function () {
				var txt = $(this).attr('data-text');			
				$('#strong_points_comment_textarea').val(txt);
				
                var id = $(this).val();
				strong_ids.push(id);
                var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
                $('#lk-impr-chk-'+id).unwrap();
                $('#response_div_strong_points').append(chk);
                $('#response_div_points_to_improve #lk-impr-chk-'+id).remove();
				$('#recently_moved_strong_point_item').val(id);
				$('#undostrongpoints').attr('data-id', id);

            });
			
            $("input:checked.strong_points").each(function () {
				var txt = $(this).attr('data-text');
				$('#strong_points_comment_textarea').val(txt);
				
                var id = $(this).val();
				strong_ids.push(id);
                var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
                $('#lk-impr-chk-'+id).unwrap();
                $('#response_div_strong_points').append(chk);
                $('#response_div_points_to_improve #lk-impr-chk-'+id).remove();
				$('#recently_moved_strong_point_item').val(id);
				$('#undostrongpoints').attr('data-id', id);
            });
	
			if($('#points_to_improve_comment_textarea').val() == $('#strong_points_comment_textarea').val()) {
				$('#points_to_improve_comment_textarea').val('');				
				$('#undopointstoimprove').attr('data-id', '');
				$('#undopointstoimprove').hide();
			}
			
			updatePoints(strong_ids,week_ids);
            countAvg();
         } else {
             $('#alert-one-strong-points').modal('show');
             return false;
         }
    });
	
	function revertStrongPointItem(id) {
		
		//week_ids.push(id);
		var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
		$('#lk-impr-chk-'+id).unwrap();
		$('#response_div_strong_points').append(chk);
		$('#response_div_points_to_improve #lk-impr-chk-'+id).remove();	
	}
	
	
	
	function revertPointsToImproveItem(id) {
		
		//week_ids.push(id);
		var chk = $('#lk-impr-chk-'+id).wrap('<p/>').parent().html();
		$('#lk-impr-chk-'+id).unwrap();
		$('#response_div_points_to_improve').append(chk);
		$('#response_div_strong_points #lk-impr-chk-'+id).remove();	
	}
	
	function updatePoints(strong_ids,week_ids){
		$.ajax({
			url: "{{ route('teachers.dashboard.update.points') }}",
			method: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				strong_ids: strong_ids,
				week_ids: week_ids,
				
				booking_id: $('#editor_textarea').attr('data-booking-id')
			}
		});
	}
	
	
	function check_rating_lie_between(rating_no) {

		var rating = 5 * (parseInt(rating_no) / 100);
		if (rating == 0) {

			rating = 1;
		}
		return rating.toFixed(2);
	}
	
    function countAvg() {
        var levelID = <?php echo  $student->student_level_id; ?>;
        var imCA =  $('#response_div_points_to_improve').find(".pnt_intro[data-type=CA][data-levelid="+levelID+"]").length;
        var imFP =  $('#response_div_points_to_improve').find(".pnt_intro[data-type=FP][data-levelid="+levelID+"]").length;
        var imLC =  $('#response_div_points_to_improve').find(".pnt_intro[data-type=LC][data-levelid="+levelID+"]").length;
        var imV  =  $('#response_div_points_to_improve').find(".pnt_intro[data-type=V][data-levelid="+levelID+"]").length;
        var imGA =  $('#response_div_points_to_improve').find(".pnt_intro[data-type=GA][data-levelid="+levelID+"]").length;
		var mul_by = 100;
		var tCA = $('#tCA').val();
		var tFP = $('#tFP').val();
		var tLC = $('#tLC').val();
		var tV = $('#tV').val();
		var tGA = $('#tGA').val();
        if(imCA){
            if(imCA == tCA){
                avgCA = 5;
            } else {
                /*avgCA = (5*imCA/tCA);
                if(avgCA < 1){
                    avgCA = 1;
                }*/
				avgCA = ((parseInt(imCA) / parseInt(tCA)) * mul_by);				
				avgCA = parseFloat(check_rating_lie_between(avgCA));
				if(avgCA < 1){
                    avgCA = 1;
                }
            }
        } else {
            avgCA = 1;
        }

        if(imFP){
            if(imFP == tFP){
                avgFP = 5;
            } else {
                /*avgFP = (5*imFP/tFP);
                if(avgFP < 1){
                    avgFP = 1;
                }*/
				avgFP = ((parseInt(imFP) / parseInt(tFP)) * mul_by);				
				avgFP = parseFloat(check_rating_lie_between(avgFP));
				if(avgFP < 1){
                    avgFP = 1;
                }
            }
        } else {
            avgFP = 1;
        }

        if(imLC){
            if(imLC == tLC){
                avgLC = 5;
            } else {
                /*avgLC = (5*imLC/tLC);
                if(avgLC < 1){
                    avgLC = 1;
                }*/
				
				avgLC = ((parseInt(imLC) / parseInt(tLC)) * mul_by);				
				avgLC = parseFloat(check_rating_lie_between(avgLC));
				if(avgLC < 1){
                    avgLC = 1;
                }
            }
        } else {
            avgLC = 1;
        }
        if(imV){
            if(imV == tV){
                avgV = 5;
            } else {
                /*avgV = (5*imV/tV);
                if(avgV < 1){
                    avgV = 1;
                }*/
				avgV = ((parseInt(imV) / parseInt(tV)) * mul_by);				
				avgV = parseFloat(check_rating_lie_between(avgV));
				if(avgV < 1){
                    avgV = 1;
                }
            }
        } else {
            avgV = 1;
        }
        if(imGA){
            if(imGA == tGA){
                avgGA = 5;
            } else {
                /*avgGA = (5*imGA/tGA);
                if(avgGA < 1){
                    avgGA = 1;
                }*/
				
				avgGA = ((parseInt(imGA) / parseInt(tGA)) * mul_by);				
				avgGA = parseFloat(check_rating_lie_between(avgGA));
				if(avgGA < 1){
                    avgGA = 1;
                }
            }
        } else {
            avgGA = 1;
        }

        var avgAVG = ((avgCA+avgFP+avgGA+avgLC+avgV)/5);

        $('#p-AVG-rate').html("Average : " + avgAVG.toFixed(2) + "");
        $('#p-CA-rate').html("CA : " + avgCA.toFixed(2) + "");
        $('#p-FP-rate').html("F&P : " + avgFP.toFixed(2) + "");
        $('#p-LC-rate').html("LC : " + avgLC.toFixed(2) + "");
        $('#p-V-rate').html("V : " + avgV.toFixed(2) + "");
        $('#p-GA-rate').html("G&A : " + avgGA.toFixed(2) + "");

        $('#ca_rating').val(avgCA.toFixed(2));
        $('#fp_rating').val(avgFP.toFixed(2));
        $('#lc_rating').val(avgLC.toFixed(2));
        $('#v_rating').val(avgV.toFixed(2));
        $('#ga_rating').val(avgGA.toFixed(2));
    }

    $(document).on('change','#filter_point_type',function(e){
        var value = this.value.toLowerCase().trim();
        if(value){
            $("#response_div_strong_points div.pnt_intro").show().filter(function() {
                return $(this).data('type').toLowerCase().trim().indexOf(value) == -1;
            }).hide();

            $("#response_div_points_to_improve div.pnt_intro").show().filter(function() {
                return $(this).data('type').toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        } else {
            $("#response_div_strong_points div.pnt_intro").show();
            $("#response_div_points_to_improve div.pnt_intro").show();
        }
    });	

    $('.rating_criteria').click(function(e){
        var value = $(this).data('criteria').toLowerCase().trim();
        var orig_value = $(this).data('criteria').trim();
		$('.rating_criteria').removeClass('selected_criteria');
		$(this).addClass('selected_criteria');
		$('#filter_point_type').val(orig_value);
		console.log(value);
        if(value){
            $("#response_div_strong_points div.pnt_intro").show().filter(function() {
                return $(this).data('type').toLowerCase().trim().indexOf(value) == -1;
            }).hide();

            $("#response_div_points_to_improve div.pnt_intro").show().filter(function() {
                return $(this).data('type').toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        } else {
            $("#response_div_strong_points div.pnt_intro").show();
            $("#response_div_points_to_improve div.pnt_intro").show();
        }
		
		var auto_save_filter_point = $("#auto_save_filter_point").val();
		$.ajax({
			data: {
				'filter_point_type' : orig_value,
				'booking_id' : $('#editor_textarea').attr('data-booking-id')
			},
			url: auto_save_filter_point,
			dataType: 'JSON',
			type: 'POST',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function (resp) {
				console.log("success");
			}
		}) 
    });
	
    //setTimeout(function(){ $("select#filter_point_type").change(); }, 1000);
	function open_update_rating_popup() {
		var ca_rating = parseInt($('#ca_rating').val());
		var fp_rating = parseInt($('#fp_rating').val());
		var lc_rating = parseInt($('#lc_rating').val());
		var v_rating  = parseInt($('#v_rating').val());
		var ga_rating = parseInt($('#ga_rating').val());
		if(ca_rating == 1 && (fp_rating == 1) && (lc_rating == 1) && (v_rating == 1) && (ga_rating == 1)) {
			$('#change_rating_popup').show();
			//scrollToAnchor('progress_rating');
		}
	}
	
	function close_update_rating_popup() {
		$('#change_rating_popup').hide();
		//$('#heading-8').addClass('active');
		$('#heading-8').next('a').removeClass('collapsed');
		$('#heading-8').next('div').addClass('show');
		$('html, body').animate({
			scrollTop: $("#heading-8").offset().top
		}, 2000);
	}
	
</script>
<style type="text/css">
    .hide{
        display: none;
    }
</style>
