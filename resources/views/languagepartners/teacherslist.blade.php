<?php
$n = 0;
?>
		@if(!empty($teachers))
			@foreach($teachers as $teacher)
				<?php
				$n++;
				?>
				<div class="list-cell">
			<div class="row">
				<div class="photo-column pr-0 align-center">
					<div class="photo">
						<?php
							$img = str_replace('https://accent-language.com/', '', $teacher->profile_image);
							if(file_exists($img)) {
								$image = $teacher->profile_image;
							} else {
								$image = url('images/teacher_profile.png');
							}
							?>
							<img src="{{ $image }}" alt="" width="" height="">
					</div>
					
					<?php
					$totalRatings = App\Helpers\AppHelper::getTeacherTotalRatings($teacher->id);
					
					$countStudentsRated = App\Helpers\AppHelper::getTeacherRatingsCount($teacher->id);														
					?>	
					<input id="total-ratings-{{$teacher->id}}" name="total-ratings-{{$teacher->id}}" class="kv-ltr-theme-svg-star rating-loading teacher-ratings-avg rated" value="{{$totalRatings}}" dir="ltr" data-size="xs" readonly="true">

					<div class="summary"><img src="{{ asset('images/list_lp/One-Coin-English-Japanese-NewButton.png') }}"></div>
				</div>

				<div class="right">
					<div class="row">
						<div class="left">
							<div class="availability">
								<?php
								if($teacher->is_available == 1){ ?>
									<span class="online"></span>
									<?php
								} else { ?>
									<span class="offline"></span>
									<?php
								}
								?>
								<label>Availability</label>
							</div>

							<div class="space mt-7"></div>
							
							<div class="name">
								<i class="flag-icon flag-icon-<?php echo $teacher->country_code;?>"></i>
								<span>
									<?php 
										if(!empty($teacher->nickname)) {
											echo $teacher->nickname;
										} else {
											echo $teacher->firstname;
										}
									?>
								</span>
							</div>

							<div class="space mt-7"></div>

							<div class="teaches">
								<label>Teaches</label>	
								<?php
								if($teacher->conversation_topic != ''){
									$conversation_topic = explode(',', $teacher->conversation_topic);
									foreach($conversation_topic as $topic) { ?>
										<label class="background-fill"><?php echo $topic;?></label>
										<?php
									}
								}?>
								<label>English</label>	
							</div>

							<div class="space mt-7"></div>

							<div class="occupation">
								<label>Occupation</label>	
								<?php
								if($teacher->occupation != '') { ?>
									<label class="background-fill"><?php echo $teacher->occupation;?></label>
									<?php 
								}
								?>								
							</div>

							<div class="space mt-7"></div>

							<div class="speaks">
								<span>Speaks</span>
								<?php
								if(!empty($teacher->teaching_english_in)) {
									$teaching_english_in = explode(',', $teacher->teaching_english_in);
									foreach($teaching_english_in as $teaching_in) { ?>
										<i class="flag-icon flag-icon-<?php echo $teaching_in;?>"></i>				
										<?php 
									}
								}
								?>
								<!--i class="flag-icon flag-icon-jp"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorInt.png') }}" class="level">
								<i class="flag-icon flag-icon-us"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorHigh.png') }}" class="level">
								<i class="flag-icon flag-icon-us"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorLow.png') }}"  class="level"-->
							</div>
						</div>

						<div class="right table-row">
							<div class="table-cell favourite-column">
								<div class="favourite">
									<?php
									if(Auth::guest()){ ?>
										<a href="javascript:void(0);" onclick="alert('Please login first.');">
											<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Thumb-Off.png') }}">
										</a>
										<?php 
									} else { 
										if(!empty($fav_teachers) && (in_array($teacher->id, $fav_teachers))) { ?>
											<a href="javascript:void(0);" onclick="make_teacher_un_fav('<?php echo $teacher->id;?>')">
												<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Thumb-On.png') }}">
											</a>
											<?php 
										} else { ?>
											<a href="javascript:void(0);" onclick="make_teacher_fav('<?php echo $teacher->id;?>')">
												<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Thumb-Off.png') }}">
											</a>
											<?php 
										}
									}
									?>
									<span>Favourite</span>
								</div>

								<div class="space mt-15"></div>

								<div class="verified">
									<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Verified.png') }}">
									<span>Verified</span>
								</div>

								<div class="space mt-15"></div>

								<div class="teaches-beginners">
									<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LP-for-Beginner.png') }}">
									<span>Teaches Beginners</span>
								</div>
							</div>

							<div class="table-cell">
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Share.png') }}" class="share">
								<?php 
								if(Auth::guest()){ ?>
									<a href="{{ url('login/startsession') }}" id="trynow">
										<img src="{{ asset('images/list_lp/oce-j-speak-now.png') }}" class="speak-now">
									</a>
									<?php 
								} else { 
									if(!empty($fav_teachers) && (in_array($teacher->id, $fav_teachers))) { ?>
										<a href="javascript:void(0);" data-tid="<?php echo $teacher->id;?>" class="trynow_loggedin">
											<img src="{{ asset('images/list_lp/oce-j-speak-now.png') }}" class="speak-now">
										</a>
										<?php 
									} else { ?>
										<a href="javascript:void(0);" onclick="alert('Please favorite this language partner first.');">
											<img src="{{ asset('images/list_lp/oce-j-speak-now.png') }}" class="speak-now">
										</a>
										<?php 
									}
								} ?>
								<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" onclick="openIntro('intro<?php echo $n;?>');" class="plus">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="intro-with-audio d-none" id="intro<?php echo $n;?>">
			<div class="inner-content">
				<div class="row mb-20">
					<div class="col-6 align-center"><b>Intro With Audio</b></div>

					<div class="col-6 align-center">Video</div>
				</div>

				<div class="row">
					<p><?php echo $teacher->message_en;?></p>
				</div>

				<div class="row align-right audio-button">
					<?php					
					if(!empty($teacher->audio_attachment)) { ?>
						<audio style="width:100%" controls="controls" src="{{asset($teacher->audio_attachment)}}">
							Your browser does not support the HTML5 Audio element.
						</audio>
						<?php	
					}
					?>
				</div>
			</div>
		</div>
		
		
				@if(!empty($teacher->video))																	
					<video width="320" height="240" controls>
						<source src="{{$teacher->video}}" type="video/mp4">
					</video>
				@endif
												
				
			@endforeach
		@endif	

    

<script src="{{ asset('plugins/star-ratings/js/star-rating.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/star-ratings/themes/krajee-svg/theme.js') }}" type="text/javascript"></script>
	
<script>
	$('.teacher-ratings-avg').rating({
		theme: 'krajee-svg',
		filledStar: '<span class="krajee-icon krajee-icon-star"></span>',
		emptyStar: '<span class="krajee-icon krajee-icon-star"></span>',
		starCaptions: function (rating) {
			return rating == 1 ? 'One Star' : rating + ' Star';
		}
	});
	
	$('.krajee-icon-clear').removeClass('krajee-icon-clear');
	$('.caption').addClass('d-none');
	
	
	
		//getTeacherList();
		//var myVar = setInterval(getTeacherList, 30000);				
	
	$('.trynow_loggedin').click(function() {
		var teacher_id = $(this).attr('data-tid');
		$('#teacher_id').val('');
		$('#time').val('');
		$('#payment-form').addClass('d-none'); 
		checkTeacherAvailability(teacher_id);
	});

	function clear_Interval(myVar) {
		clearInterval(myVar);
	}
	
	function openIntro(div) {
		if($( "#"+div ).hasClass( "d-none" )) {
			$('#'+div).removeClass('d-none');
		} else {
			$('#'+div).addClass('d-none');
		}
	}
</script>
				
