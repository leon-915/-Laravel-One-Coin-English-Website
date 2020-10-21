@if($booking->status=='booked')
<div class="status-options-wrapper">	
	<div class="active_button">
		<div class="row">
			<div class="col-12">
				<a class="act_btn color1 op-change-status op-arp-change-status" style="cursor: pointer;" data-status="1">
					<img src="{{asset('images/canvas_close.png')}}">
				</a>
				<a class="act_btn color2 op-change-status op-arp-change-status" style="cursor: pointer;" data-status="2">
					<img src="{{asset('images/canvas_round.png')}}">
				</a>
				<a class="act_btn color3 op-change-status op-arp-change-status" style="cursor: pointer;" data-status="3">
					<img src="{{asset('images/canvas_polygon.png')}}">
				</a>
				<a class="act_btn color4 op-change-status op-arp-change-status" style="cursor: pointer;" data-status="4">
					<img src="{{asset('images/canvas_rectangle.png')}}">
				</a>
				<a class="act_btn color5 op-change-status op-arp-change-status" style="cursor: pointer;" data-status="5">
					<img src="{{asset('images/canvas_refresh.png')}}">
				</a>
			</div>
		</div>
	</div>
</div>
@endif

<div class="active_recall_pair" id="arp-chk-container">
    <div class="onepage_sub_title">
        <div class="row">
            <div class="col-lg-9">
                <h4>Active Recall Pair・アクティブリコールペアの復習</h4>
            </div>
            <div class="col-lg-3">
                <div class="recall_btn">
                    <span>status</span>
                </div>
            </div>
        </div>
    </div>
	<?php
	$keywords_array = [];
	if(!empty($booking->keywords)) {
		foreach($booking->keywords as $keywords) {
			$keywords_array[] = $keywords->keyword;
		}
	}
	?>
    @foreach ($booking->arps as $arp)
            <div class="active_main_row single-arp single-item" id="arp-{{$arp->id}}">
            <form action="{{ route('teachers.dashboard.edit.item') }}" method="post" class="ajax_form item-form-{{$arp->id}}">
            {{ csrf_field() }}
                <div class="row">
                
                <input type="hidden" value="{{$arp->id}}" name="id" />
                <input type="hidden" value="arp" name="type" />
                    <div class="col-lg-10">
                        <div class="topic_inner_ro">
                            <div class="tpc_single">
                                <p class="item-text line_1">
									<?php 
										//echo $arp->line_1; 	
										echo App\Helpers\AppHelper::check_keyword_in_string($keywords_array, $arp->line_1);				
									?>							
								</p>
                                <input type="text" name="line_1" value="{{ $arp->line_1 }}" class="item-edit hide form-control" />
                                 
                            </div>
    
                            <div class="tpc_single">
                                <p class="item-text line_2">
									<?php 
										//echo $arp->line_2; 
										echo App\Helpers\AppHelper::check_keyword_in_string($keywords_array, $arp->line_2);
									?>
								</p>
                                <input type="text" name="line_2" value="{{ $arp->line_2 }}" class="item-edit hide form-control" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="status_right">
                        <i href="#" class="icon edit-item"><i class="fas fa-pen"></i></i> 
                        <button type="submit" class="item-edit-submit hide" ><i href="#" class="icon"><i class="fas fa-check"></i></i>  </button>
                        <a  class="item-edit-cancel hide" ><i  class="icon"><i class="fas fa-times"></i></i>  </a>
                            @if($booking->status=='booked')
                            <label class="checkcontainer">
                                <input type="checkbox" name="status[{{$arp->id}}]" value="{{$arp->id}}">
                                <span class="checkmark"></span>
                            </label>
                            @endif
                            @switch($arp->status)
                                @case(1)
                                    <a class="act_btn color1">
                                        <img src="{{asset('images/canvas_close.png')}}">
                                    </a>
                                    @break
                                @case(2)
                                    <a class="act_btn color2">
                                        <img src="{{asset('images/canvas_round.png')}}">
                                    </a>
                                    @break
                                @case(3)
                                    <a class="act_btn color3">
                                        <img src="{{asset('images/canvas_polygon.png')}}">
                                    </a>
                                    @break
                                @case(4)
                                    <a class="act_btn color4">
                                        <img src="{{asset('images/canvas_rectangle.png')}}">
                                    </a>
                                    @break
                                @case(5)
                                    <a class="act_btn color5">
                                        <img src="{{asset('images/canvas_refresh.png')}}">
                                    </a>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    
                </div>
                </form>
            </div>
    @endforeach
</div>

<script>
function hideForm(data){
	$(data.selector).find("p.item-text").show(100);
	$(data.selector).find("input.item-edit").hide(100);
    $(data.selector).find(".item-edit-submit").hide(100);
	$(data.selector).find(".item-edit-cancel").hide(100);
	$(data.selector).find(".edit-item").show(100);
	$(data.selector).find(data.line_1_selector).html(data.line_1);
	$(data.selector).find(data.line_2_selector).html(data.line_2);
}
$(document).on('click','.edit-item',function(e){
	$(this).closest(".single-item").find("p.item-text").hide(100);
	$(this).closest(".single-item").find("input.item-edit").show(100);
    $(this).closest(".single-item").find(".item-edit-submit").show(100);
	$(this).closest(".single-item").find(".item-edit-cancel").show(100);
	$(this).hide(100);
	
});
$(document).on('click','.item-edit-cancel',function(e){
    $(this).closest(".single-item").find("p.item-text").show(100);
    $(this).closest(".single-item").find("input.item-edit").hide(100);
    $(this).closest(".single-item").find(".item-edit-submit").hide(100);
    $(this).closest(".single-item").find(".edit-item").show(100);
    $(this).hide(100);
    
});

$(document).on('click','#filter_point_type',function(e){
    
});
    $('.op-arp-change-status').on('click',function(e){
        e.preventDefault();
        var status = $(this).data('status');
        var updateData = [];

        if($('#arp-chk-container :checked').length <= 0){
            $('#alert-one-strong-points').modal('show');
            return;
        }

        $('#arp-chk-container :checked').each(function (i, e) {
            if ($(this).val() != '') {
                updateData.push($(this).val());
            }
        });

        $.ajax({
            url : '<?=  route('teachers.dashboard.onepage.update.status.data') ?>',
            data : {
                'type'      : 'arps',
                'ids'       : updateData,
                'status'    : status,
                'booking_id': '<?= $booking_id ?>',
                'service_id' : '<?= $studentLesson->service_id ?>',
            },
            dataType : 'JSON',
            type : 'POST',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                $('.app-loader').removeClass('d-none');
            },
            success : function(res){
                $('.app-loader').addClass('d-none');
                if(res.type == 'success'){
                    $.toast({
                        heading: res.message.header,
                        text: res.message.msg,
                        position: 'top-right',
                        icon: 'success'
                    });
                    $('#'+res.replace).html(res.html);
					if(res.replace2 != ''){
						$('#'+res.replace2).html(res.html2);
					}
                }
            }
        })
    });
</script>
<style>
.hide{
	display:none;
}
</style>