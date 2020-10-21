@if($booking->status=='booked')
<div class="active_button">
    <div class="row">
        <div class="col-12">
            <a href="#" class="act_btn color1 op-change-status op-keyword-change-status" data-status="1">
                <img src="{{asset('images/canvas_close.png')}}"></a>
            <a href="#" class="act_btn color2 op-change-status op-keyword-change-status" data-status="2">
                <img src="{{asset('images/canvas_round.png')}}"></a>
            <a href="#" class="act_btn color3 op-change-status op-keyword-change-status" data-status="3">
                <img src="{{asset('images/canvas_polygon.png')}}"></a>
            <a href="#" class="act_btn color4 op-change-status op-keyword-change-status" data-status="4">
                <img src="{{asset('images/canvas_rectangle.png')}}">
            </a>
        </div>
    </div>
</div>
@endif

<div class="active_recall_pair" id="keywords-chk-container">
    <div class="onepage_sub_title">
        <div class="row">
            <div class="col-lg-9">
                <h4> Keywords and phrases・キーワードとフレーズの復習 </h4>
            </div>
            <div class="col-lg-3">
                <div class="recall_btn">
                    <span>status</span>
                </div>
            </div>
        </div>
    </div>
    @foreach ($booking->keywords as $keyword)
            <div class="active_main_row single single-item">
            <form action="{{ route('teachers.dashboard.edit.item') }}" method="post" class="ajax_form item-form-{{$keyword->id}}">
            {{ csrf_field() }}
                <div class="row">
                <input type="hidden" value="{{$keyword->id}}" name="id" />
                <input type="hidden" value="keyword" name="type" />
                    <div class="col-lg-10">
                        <div class="topic_inner_ro">
                            <div class="tpc_single">
                                <p class="line_1 item-text"><?php echo $keyword->keyword; ?></p>
                                <input type="text" name="line_1" value="{{ $keyword->keyword }}" class="item-edit hide form-control" />
                                {{-- <i href="#" class="icon"><i class="fas fa-pen"></i></i> --}}
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
                                    <input type="checkbox" name="status[{{$keyword->id}}]" value="{{$keyword->id}}">
                                    <span class="checkmark"></span>
                                </label>
                            @endif
                            @switch($keyword->status)
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
    $('.op-keyword-change-status').on('click',function(e){
        e.preventDefault();
        var status = $(this).data('status');
        var updateData = [];

        if($('#keywords-chk-container :checked').length <= 0){
            $('#alert-one-strong-points').modal('show');
            return;
        }

        $('#keywords-chk-container :checked').each(function (i, e) {
            if ($(this).val() != '') {
                updateData.push($(this).val());
            }
        });

        $.ajax({
            url : '<?=  route('teachers.dashboard.onepage.update.status.data') ?>',
            data : {
                'type'      : 'keywords',
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
                }
            }
        })
    });
</script>
