@extends('layouts.app',['title'=>__('labels.stu_my_account')])
@section('title',__('labels.stu_my_account'))
@section('content')
    <div id="content" class="clearfix">
        <section class="profile_sec clearfix">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="profile_inner tab_pnle_sec">
                            <div class="card custome_nav acc-student">
                                

                                <!-- Tab panes -->
                                <div class="tab-content table-container">
									<div id="timer">
									  <div id="days"></div>
									  <div id="hours"></div>
									  <div id="minutes"></div>
									  <div id="seconds"></div>
									</div>

                                    <div role="tabpane2" class="" id="accent">
                                        
											
												<?php 
												if(!empty(Auth::id())) { ?>
													<script>
														var chat_appid = '53942';
														var chat_auth = '16ac5390fca20dcbfc28aebc5effcc79';
													</script>
													<script>
														var chat_id = "<?php echo Auth::id(); ?>";
														var chat_name = "<?php echo isset(Auth::user()->firstname) ? Auth::user()->firstname : Auth::user()->email; ?>"; 
														var chat_link = ""; 
														var chat_avatar = ""; 
														var chat_role = "<?php echo $role?>"; 
														//var chat_friends = '<?php //echo $teacher_id;?>'; // eg: 14,16,20 in case if friends feature is enabled.
													</script>
													
												<script>
												var chat_height = '600px';
												var chat_width = '100%';

												document.write('<div id="cometchat_embed_synergy_container" style="width:'+chat_width+';height:'+chat_height+';max-width:100%;border:1px solid #CCCCCC;border-radius:5px;overflow:hidden;"></div>');

												var chat_js = document.createElement('script'); 
												chat_js.type = 'text/javascript'; 
												chat_js.src = 'https://fast.cometondemand.net/'+chat_appid+'x_xchatx_xcorex_xembedcode.js';

												chat_js.onload = function() {
													var chat_iframe = {};
													chat_iframe.module="synergy";
													chat_iframe.style="min-height:"+chat_height+";min-width:"+chat_width+";";chat_iframe.width=chat_width.replace('px','');
													chat_iframe.height=chat_height.replace('px','');
													chat_iframe.src='https://'+chat_appid+'.cometondemand.net/cometchat_embedded.php'; 
													if(typeof(addEmbedIframe)=="function"){
														addEmbedIframe(chat_iframe);
													}
												}

												var chat_script = document.getElementsByTagName('script')[0]; chat_script.parentNode.insertBefore(chat_js, chat_script);


												
												</script>
												
											<?php } ?>
                                    </div>
									<div class="row" id="booking_listing">
										
									</div>
									<div class="row">
										 <div class="col-sm-12 col-md-12 col-lg-12 text-center">
											<input type="button" id="load_more_button" value="{{ __('labels.view_more') }}" class="button">
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<input type="hidden" id="booking_id" name="booking_id" value="<?php echo $booking_id?>" />
<div class="" style="display:none;" id="extend_end_div">
    <div class="">
        <div class="">
            <div class="clearfix">
                <div class="text-center mb-3">
						<h4>Current Session is about to complete.</h4>
                        Extend session before it is completed.<br />                    
                </div>
                <div class="text-center">
                    <button type="button" id="extend_lesson" onclick="extend_lesson();" class="freetrial_btn">
                        Extend.
                    </button>
                    <button type="button" id="end_lesson" onclick="show_rate_teacher_div();" class="freetrial_btn">
                        End.
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty($ratingTypes))
	<div id="rating_div" class="p_detais d-none">
		<div class="row">
			<div class="col-12">
				<div class="plan_header">
					<h2>Rate Language Partner</h2>
				</div>
			</div>
		</div>	
	
		<form action="" id="teacher_rate">
			<div id="teacher-star-ratings">
				@foreach($ratingTypes as $ratts)
					<?php $ratt = $ratts['rating']; ?>
					<div class="row">
						<div class="col-12 col-md-6 col-lg-4">
							<div class="p_details_label">{{$ratt['title']}}</div>
						</div>
						<div class="col-12 col-md-6 col-lg-8">
							<div class="p_details_text"><span>:</span>
								<input id="rating-{{ $ratt['id'] }}" name="rating[{{ $ratt['id'] }}]" class="kv-ltr-theme-svg-star rating-loading" value="{{(!empty($teacherRatings) && isset($teacherRatings[$ratt['id']]) && !empty($teacherRatings[$ratt['id']])) ? $teacherRatings[$ratt['id']] : 0}}" dir="ltr" data-size="xs" data-rate="{{ $ratt['id'] }}">
							</div>
						</div>
					</div>
				@endforeach
				<div class="form-group">
					<label class="form-control-label" for="status">Comments</label>
					<textarea class="form-control" name="comments" placeholder="Comments" rows="4" id="comments"></textarea>
				</div>

				<input type="hidden" name="teacherid_to_rate" value="{{!empty($teacherid_to_rate) ? $teacherid_to_rate : 0}}">
				<input type="hidden" id="bookingid_to_rate" name="bookingid_to_rate" value="{{!empty($bookingid_to_rate) ? $bookingid_to_rate : 0}}">
			</div>
			<div class="row">
				<div class="col-12 text-right">
					<a href="" class="btnsub_arr" id="btn_submit">Submit</a>
				</div>
			</div>
		</form>	
	</div>	
@endif	


		
<?php
$lession_date_time_str = '';
if($booking_id > 0) {
	$lession_date_time = strtotime($booking->lession_date.' '.$booking->lession_time) + ($booking->lesson_duration * 60);
	$lession_date_time_str = date('d F Y H:i:s', $lession_date_time).' GMT+09:00';
	
}
?>

    @push('scripts')
        
        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter : 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif
		
		<script type="text/javascript">
			var interval = null;
			var date_str = '<?php echo $lession_date_time_str;?>';
			var track_page = 1; //track user click as page number, right now page number is 1
			load_bookings(track_page, '<?php echo $user->id; ?>'); //load content
			$("#load_more_button").prop("disabled", false);
			$(document).on('click', "#load_more_button", function (e) { //user clicks on button
				track_page++; //page number increment everytime user clicks load button
				load_bookings(track_page, '<?php echo $user->id; ?>'); //load content
			});

			//Ajax load function
			function load_bookings(track_page, student_id) {
				$.ajax({
					url: "<?php echo route('student.sessions.getbookings')?>",
					method: "post",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data:{
						page: track_page,
						student_id: student_id,
					},
					success: function (result) {
						if (result.trim().length == 0) {
							//display text and disable load button if nothing to load
							$("#load_more_button").val("No more records!").prop("disabled", true);
						}
						$("#booking_listing").append(result); //append data into #results element
						
					}
				});
			}
			
			function updateLessonStatus() {
				$.ajax({
					url: "<?php echo route('student.sessions.updatelessonstatus')?>",
					method: "post",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data:{
						student_id: <?php echo $user->id;?>,
						booking_id: <?php echo $booking_id;?>,
					},
					success: function (result) {
						if (result.type == 'success') {
							//location.reload();
						} else {
							$.toast({
                                heading: 'Success',
                                text: 'Error.',
                                position: 'top-right',
                                icon: 'success'
                            });
						}
					}
				});
			}
			
			function extend_lesson() {
				$.ajax({
					url: "<?php echo route('student.sessions.extendlesson')?>",
					method: "post",
					dataType: 'JSON',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data:{
						student_id: <?php echo $user->id;?>,
						booking_id: <?php echo $booking_id;?>,
					},
					success: function (result) {
						if (result.type == 'success') {
							$.toast({
                                heading: 'Success',
                                text: result.message,
                                position: 'top-right',
                                icon: 'success',
								afterHidden: function () {
									clearInterval(interval); 
									//var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");	
									
									date_str = result.new_date_str;
									interval = setInterval(function() { makeTimer(date_str); }, 1000);
									$('#extend_end_div').hide();
									//location.reload();
								}
                            });
						} else {
							$.toast({
                                heading: 'Success',
                                text: result.message,
                                position: 'top-right',
                                icon: 'success'
                            });
						}
					}
				});
			}
			
			var xmlHttp;
			function srvTime(){
				try {
					//FF, Opera, Safari, Chrome
					xmlHttp = new XMLHttpRequest();
				}
				catch (err1) {
					//IE
					try {
						xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
					}
					catch (err2) {
						try {
							xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
						}
						catch (eerr3) {
							//AJAX not supported, use CPU time.
							alert("AJAX not supported");
						}
					}
				}
				xmlHttp.open('HEAD',window.location.href.toString(),false);
				xmlHttp.setRequestHeader("Content-Type", "text/html");
				xmlHttp.send('');
				return xmlHttp.getResponseHeader("Date");
			}
			
			function makeTimer(date_str) {
				
				/*var st = srvTime();
				var today = new Date(st);

				var months    = ['January','February','March','April','May','June','July','August','September','October','November','December'];
				//var today = new Date();
				var thisMonth = months[today.getMonth()];
				var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
				var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
				var date_str = today.getDate()+' '+thisMonth+' '+today.getFullYear()+' '+time+' GMT+09:00';
				console.log(date_str);*/
				//var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");	
				var endTime = new Date(date_str);			
					endTime = (Date.parse(endTime) / 1000);

					var now = new Date();
					now = (Date.parse(now) / 1000);

					var timeLeft = endTime - now;

					var days = Math.floor(timeLeft / 86400); 
					var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
					var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
					var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
		  
					if (hours < "10") { hours = "0" + hours; }
					if (minutes < "10") { minutes = "0" + minutes; }
					if (seconds < "10") { seconds = "0" + seconds; }
					
					
						$("#days").html(days + "<span>Days</span>");
						$("#hours").html(hours + "<span>Hours</span>");
						$("#minutes").html(minutes + "<span>Minutes</span>");
						$("#seconds").html(seconds + "<span>Seconds</span>");	
					if(days == 0 && hours == 0 && minutes == 0 && seconds == 0){
						clearInterval(interval); 
						$('#extend_end_div').hide();
						show_rate_teacher_div();
					}
					if(days == 0 && hours == 0 && minutes == 0 && seconds == 30){
						$('#extend_end_div').show();
					}

			}
			
			
		</script>
	<script src="{{ asset('plugins/star-ratings/js/star-rating.js') }}" type="text/javascript"></script>
	<script src="{{ asset('plugins/star-ratings/themes/krajee-svg/theme.js') }}" type="text/javascript"></script>
	<script>
		@foreach($ratingTypes as $ratt)
            $('#rating-{{ $ratt['rating']['id'] }}').rating({
                theme: 'krajee-svg',
                filledStar: '<span class="krajee-icon krajee-icon-star"></span>',
                emptyStar: '<span class="krajee-icon krajee-icon-star"></span>',
                starCaptions: function (rating) {
                    var cap = '';
                    if(rating >=1 && rating < 2)
                        cap = '{{$ratt['desc_star1']}}';
                    else if(rating >=2 && rating < 3)
                        cap = '{{$ratt['desc_star2']}}';
                    else if(rating >=3 && rating < 4)
                        cap = '{{$ratt['desc_star3']}}';
                    else if(rating >=4 && rating < 5)
                        cap = '{{$ratt['desc_star4']}}';
                    else if(rating == 5)
                        cap = '{{$ratt['desc_star5']}}';

                    return cap;
                    //return rating == 1 ? 'One Star' : rating + ' Star';
                }
            });
            @endforeach

            $(".clear-rating").hide();
            $(".rated .caption").hide();
			
			$('#btn_submit').click(function(e){
                e.preventDefault();
                e.stopPropagation();

                //var starData = $('#teacher-star-ratings input').serialize();
                var starData = $('#teacher_rate').serialize();
                $.ajax({
                    url: '{{route('student.ocerating')}}',
                    type: "POST",
                    dataType: "json",
                    data: starData,
                    //contentType: false,
                    cache: false,
                    //processData:false,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        $('.app-loader').removeClass('d-none');
                    },
                    success : function(res){
                        // localtion.reload();
                        $('.app-loader').addClass('d-none');
                        if(res.type == 'success'){
							location.reload();
                            /*setTimeout(function(){// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1000);
                            $.toast({
                                heading: 'Success',
                                text: res.message,
                                position: 'top-right',
                                icon: 'success'
                            });*/
							
							//updateLessonStatus();
                        }
                    }
                });
            });
			
			function show_rate_teacher_div() {
				clearInterval(interval); 
				$('#rating_div').removeClass('d-none');
				updateLessonStatus();
			}			
			
			
			function startTimer() {
				var booking_id = $("#booking_id").val();
				$.ajax({
                    url: '{{route('currentservertime')}}',
                    type: "POST",
                    dataType: "json",
                    data: {booking_id: booking_id},					
                    cache: false,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        //$('.app-loader').removeClass('d-none');
                    },
                    success : function(res){
                        if(res.type == 'success'){
                            interval = setInterval(function() { makeTimer(res.date_str); }, 1000);
                        }
                    }
                });
			}
			
			function hidechat_callOptions() {
				$('#cometchat_videochaticon').css('display','none');
					$('#cometchat_audiochaticon').css('display','none');
				  
			}
			
			window.onAudioVideoCallInit = function(){
				console.log("Audio Video Call Initialise");
				startTimer();
			}

			window.onAudioVideoCallEnd = function(){
				console.log("Audio Video Call End");
				if(confirm('Do you want to end session?')) {
					clearInterval(interval); 
					show_rate_teacher_div();
				}	
				//hidechat_callOptions();				
			}

			window.onAudioCallInit = function(){
				console.log("Audio Call Initialise");
				startTimer();
			}

			window.onAudioCallEnd = function(){
				console.log("Audio Call End");		
				//hidechat_callOptions();		
				if(confirm('Do you want to end session?')) {
					clearInterval(interval); 
					show_rate_teacher_div();
				}		
			}
			
			<?php
			if(isset($booking->teacher_id) && $booking->teacher_id > 0) { ?>
				var setTime = setInterval(function(){
					if(typeof CometChathasBeenRun != undefined){
						console.log("call")
						var teacher_id = $('#teacherid_to_rate').val();
						if($("#cometchat_avchat_container").length == 0){
							jqcc.cometchat.audiocall('<?php echo $booking->teacher_id;?>',1);
							clearInterval(setTime);
						}
					}
				},3000);
				<?php
			} ?>
	</script>	
    @endpush

@endsection
