<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link type="text/css" href="{{ asset('plugins/slick/slick.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('plugins/slick/slick-theme.css') }}" rel="stylesheet">
<style type="text/css">
.slider {margin: 10px auto;}
.slick-prev:before, .slick-next:before {color: black;}
.slick-prev {left: 0px;z-index: 9;height: 100%;width: 60px; background-color:#f2f2f2 }
.slick-next {right: 0px;z-index:9;height: 100%;width: 60px;  background-color:#f2f2f2}
.slick-prev::before {margin: 0 0 0 15px;}
.slick-next::before {margin: 0 15px 0 0;}
.slick-prev:hover, .slick-prev:focus, .slick-next:hover, .slick-next:focus{background: rgba(204,204,204,.8);}
.slick-prev::before, .slick-next::before{color:#000;font-size: 31px;}
.slick-slide {transition: all ease-in-out .3s;opacity: .8;}
.slick-active {opacity: .9;}
.slick-current {opacity: 1;}
.slick-slider .slick-track, .slick-slider .slick-list{}
@media (min-width:768px){
	.slick-slide {margin: 0px 20px;width:auto !important;}
	
}
@media (min-width:1200px){
	.slick-track{padding-left:80px;}
}
@media (min-width:768px) and (max-width:1200px){
	.staff-members .team-member{max-width: 100%;}
	.team-contents{width: 100% !important;}
	.slick-track{min-width:1580px;}
	
}
@media(max-width:767px){
	.slick-prev:hover, 
	.slick-prev:focus, 
	.slick-next:hover, 
	.slick-next:focus{background:transparent !important}
	.slick-prev, .slick-next,
	.slick-dots{width:auto !important;background:transparent !important;display:none !important}
	.slick-prev::before, .slick-next::before {margin: 0 !important;}
	.slick-slider .slick-list{padding:0 !important}
	.slick-track{width:100% !important}
	.slick-initialized .slick-slide {padding: 0 15px;min-width: 280px;width: 100% !important;float: left;}
	.slick-slider .slick-track, .slick-slider .slick-list{transform:none !important}
	
	.team-info{float:none;margin: 0 auto;width:100%;}
	.team-info .single-image.team-plus-icon img{width:100% !important; height:auto !important}
	.team-content{margin:10px auto;max-width:100%;display:none;height:auto !important}
	.contents.open .team-content{display:block}
	.team-entry{width: 100%;}
}
</style>
   <script type="text/javascript">
   
	function show_japanes_text(val)
	{
		$('#' + val).slideToggle('up');
	}
</script>
 <link rel="stylesheet" href="{{asset('css/css_simptip.min.css')}}" type="text/css" media="all" />
<div class="business_sec_new">
    <div class="row">
        <div class="col-12">
            <div class="prvcy_margin text-center">
                <h5>{{__('labels.amazing_language_partners')}}</h5>
            </div>
            <!--==========================      Amazing Language Partners    ============================-->
            <section id="amazing-language-partners">
                <div class="container">
                    <header class="section-header">
                        <h3>Amazing Language Partners</h3>
                    </header>
                    <!--//Modal Start-->
                    <div class="staff-members ">
                        <div class="team-member mobile-only" style="text-align: center;">
                            <div class="team-contents clearfix" style="width: 1320px; display: inline-block;">

								<section class="center slider">
									<?php
										if(!empty($teachers)) {
											$i=1;
											
											foreach ($teachers as $teacher) { ?>
												<article class="scaleRun">
													<div class="contents clearfix">                                         
														<div class="team-info">
															<div class="team-image"> 
																<a class="single-image team-plus-icon" href="javascript:void(0);"> 	
																	<?php
																	$img = str_replace('https://accent-language.com/', '', $teacher->profile_image);
																	if(file_exists($img)) {
																		$image = $teacher->profile_image;
																	} else {
																		$image = url('').'/uploads/users/teachers/default.png';
																	}
																	?>
																	<img src="{{ $image }}" alt="" width="250" height="268"> <span class="curtain"></span>
																</a> 
															</div>
															<hgroup class="team-group">
																<h2 class="team-title"> <span> {{ $teacher->firstname}}
																	<input type="hidden" name="" value="<?php echo $teacher->id;?>">
																	</span> <span>
																	<?php
																	if($teacher->id == env('RYAN_USER_ID')) {
																		echo '( MD / Teacher )';
																	} else {
																		echo 'Teacher';
																	}
																	?>
																	</span> 
																</h2>
																<img title="<?php echo $teacher->nationality;?>" alt="<?php echo $teacher->nationality;?>" src="<?php echo asset('images/flags/'.$teacher->country_code.'.png');?>" class="iclflag" width="18" height="12">
																<h5 class="team-position clearfix"> 
																	<?php
																	if($teacher->onepage_certified == 1) { ?>
																		<span data-tooltip="{{__('labels.teacher_verified')}}" class="time-award simptip-position-top simptip-movable half-arrow simptip-multiline simptip-info"></span> 
																		<?php
																	}
																	
																	if($teacher->teacher_verified == 1) { ?>
																		<span data-tooltip="{{__('labels.onepage_verified')}}" class="cer-award simptip-position-top simptip-movable half-arrow simptip-multiline simptip-info"></span> 
																		<?php
																	}
																	
																	if($teacher->in_training == 1) {
																	?>		
																	<span data-tooltip="{{__('labels.in_training')}}" class="under-train simptip-position-top simptip-movable half-arrow simptip-multiline simptip-info"></span>	
																		<?php
																	}
																	?>																
																</h5>
																<div class="teacher_rating1">
																	<!--span class="rating-result  mr-shortcode rating-result-734">
																		<span class="mr-star-rating"> 
																			<i class="fa fa-star mr-star-full"></i> 
																			<i class="fa fa-star mr-star-full"></i> 
																			<i class="fa fa-star mr-star-full"></i> 
																			<i class="fa fa-star mr-star-full"></i> 
																			<i class="fa fa-star-half-o mr-star-half"></i> 
																		</span> 
																		<span class="star-result"> 4.41/5</span> 
																		<span class="count">(50)</span> </span-->
																	<?php
																	$totalRatings = App\Helpers\AppHelper::getTeacherTotalRatings($teacher->id);
																	
																	$countStudentsRated = App\Helpers\AppHelper::getTeacherRatingsCount($teacher->id);

																	
																	?>	
																	<input id="total-ratings-{{$teacher->id}}" name="total-ratings-{{$teacher->id}}" class="kv-ltr-theme-svg-star rating-loading teacher-ratings-avg rated" value="{{$totalRatings}}" dir="ltr" data-size="xs" readonly="true">{{ $totalRatings }}/5
																	<span class="tech_total_rat">({{$countStudentsRated}})</span>	
																</div>
																<div class="p_details_text audi" style="width: 100%; height: 30px;">
																			<?php
																			
																			
																			if(!empty($teacher->audio_attachment)) { ?>
																			<audio style="width:100%" controls="controls" src="{{asset($teacher->audio_attachment)}}">
																				Your browser does not support the HTML5 Audio element.
																			</audio>
										<?php	}
																			?>
																</div>
																<div class="fav-cal-icons">                                                     
																	<span>
																	
																	
																	<?php
																	if(Auth::guest()){ ?>
																		<a href="<?php echo url('teacher/profile/favorite/'.$teacher->id.'');?>" class="fa fa-heart">&nbsp;</a>
																		<?php 
																	} else { 
																		/*if(!empty($favorite) && ($favorite['is_favorite'] == 1)) { ?>
																			<a href="javascript:void(0);" style="color:red;" class="fa fa-heart" onclick="make_teacher_un_fav('<?php echo $teacher->id;?>')">&nbsp;</a>
																			<?php 
																		} else { ?>
																			<a href="javascript:void(0);" class="fa fa-heart" onclick="make_teacher_fav('<?php echo $teacher->id;?>')">&nbsp;</a>
																			<?php 
																		}*/
																		?>
																		<a href="<?php echo url('teacher/public/profile/'.$teacher->id.'');?>" class="fa fa-heart">&nbsp;</a>
																		<?php 
																	}
																	?>
																	</span> 
																	<span><a class=" fa fa-calendar" href="<?php echo url('teacher/public/profile/'.$teacher->id.'');?>">&nbsp;</a></span> 
																</div>
															</hgroup>
														</div>
														<!--/ .team-info-->
														
														<div class="team-content" style="height: 475.6px;">
															<div class="team-entry staff-profile" style="height: 100%; overflow: auto;">
																<div class="biodata">
																	<p> 
																		<?php
																		
																			if(!empty($teacher->message_en)) { 
																				echo $teacher->message_en;
																			} 
																			
																			if(!empty($teacher->message_jp)) { ?>
																			<span id="japanes_txt<?php echo $i;?>" style="display: none;">
																					<?php echo $teacher->message_jp;?>
																				</span>
																				<?php 
																			} ?>
																	</p>
																	
																	<?php
																	if(!empty($teacher->message_jp)) { ?>
																				<input type="button" value="translate" onclick="show_japanes_text('japanes_txt<?php echo $i;?>')">
																				<?php 
																			} ?>
																</div>
																<div class="interest">
																	<h5>Interest</h5>
																	<span class="hobbies">
																		<?php
																			if(!empty($teacher->hobby)) { 
																				$hobbies = explode(',', $teacher->hobby);
																				foreach($hobbies as $hobby) {
																					echo '<span class="tag">'.$hobby.'</span>';
																				}
																			}
																		?>
																	</span>
																</div>
																<div class="experience_level">
																	<h5>Teaching Experience Level</h5>
																	<div class="staff-dur">
																		<?php
																		if(!empty($teacher->teaching_category)) { ?>
																			<ul class="main-package">
																				<?php
																				$teaching_category = explode(',', $teacher->teaching_category);
																				foreach($teaching_category as $category) {
																					echo '<li class="'.strtolower($category).' package" data-href="'.strtolower($category).'-staff">'.ucfirst($category).'</li>';
																				} ?>
																			</ul>
																			<?php
																		}
																		?>
																	</div>
																</div>
																<div class="teaching_skills">
																	<h5>Teaching skills</h5>
																		<?php
																			if(!empty($teacher->teaching_certificate)) { 
																				$teaching_certificate = explode(',', $teacher->teaching_certificate);
																				foreach($teaching_certificate as $certificate) {
																					echo '<span class="tag">'.strtoupper($certificate).'</span>';
																				}
																			}
																		?>
																</div>
																<div class="lesson-type">
																	<h5>Lesson Type</h5>
																		<?php
																			if(!empty($teacher->global_lesson_price)) {
																				$global_lesson_price = $teacher->global_lesson_price;
																				if($teacher->virtual_lesson_percentage > 0) {
																					$virtual_lesson_rate = round(($global_lesson_price * ($teacher->virtual_lesson_percentage / 100))); ?>
																					<span class="my-phrase-rate tag"><b>Virtual:- </b> <?php echo $virtual_lesson_rate; ?></span>
																					<?php
																				}
																				if($teacher->cafe_lesson_percentage > 0) {
																					$cafe_lesson_rate = round(($global_lesson_price * ($teacher->cafe_lesson_percentage / 100))); ?>
																					<span class="my-phrase-rate tag"><b>Cafe:- </b> <?php echo $cafe_lesson_rate; ?></span>
																					<?php
																				}
																				
																				if($teacher->classroom_lesson_percentage > 0) {
																					$classroom_lesson_rate = round(($global_lesson_price * ($teacher->classroom_lesson_percentage / 100))); ?>
																					<span class="my-phrase-rate tag"><b>Classroom:- </b> <?php echo $classroom_lesson_rate; ?></span>
																					<?php
																				}
																				
																			}
																		?>
																</div>
																<div class="schedule_times">
																	<?php
																	
																	$book_before_time = $teacher->book_before_time > 0 ? $teacher->book_before_time : 24;
																	$cancel_before_time = $teacher->cancel_before_time > 0 ? $teacher->cancel_before_time : 24;
																	
																	?>
																	<p> Book <?php echo $book_before_time;?> hours  before the start time. </p>
																	<p>Cancel/Reschedule <?php echo $cancel_before_time;?>  hours  before the start time.</p>
																</div>
																<div class="schedule_profile_button"> 
																	<a class="schedule_profile_link" href="<?php echo url('teacher/public/profile/'.$teacher->id.'');?>"> Schedule . Profile </a> 
																</div>                                               
															</div>
															<!--/ .team-entry--> 
														</div>
														<!--/ .team-content--> 
														
													</div>
													<!--/ .contents--> 
													
												</article>
											<?php
											$i++;
											}
										}
									?>
									
							</section>

                            </div>
                            <!--/ .team-contents-->
                            
                            <div class="team-nav">
								<a href="#" class="prev" style="display: none;">Previous</a>
								<a href="#" class="next" style="display: none;">Next</a>
							</div>
                        </div>
                        <!--/ .team-member--> 
                    </div>
                    <!-- staff member-->
                    
                    <div class="row">
                        <div id="more_partners" class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s"><a href="{{ url('language_partners') }}">{{ __('labels.home_btn_more')}}</a></div>
                    </div>
                </div>
            </section>
            <!-- #Amazing Language Partners --> 
        </div>
    </div>
</div>
@push('scripts')
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
	
	$('.team-plus-icon').click(function(){
		
		if($(this).parents('div[class^="contents"]').eq(0).hasClass('open')){
			$('.contents').removeClass('open').css('width', '');
		}else {
			$('.contents').removeClass('open').css('width', '');
			$(this).parents('div[class^="contents"]').eq(0).addClass('open').css('width', '660px');
		}
	});	
</script>

<script type="text/javascript" src="{{asset('js/jquery.ui.tooltip.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>

  <script type="text/javascript" src="{{ asset('plugins/slick/slick.js') }}" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).on('ready', function() {
     $('.krajee-icon-clear').removeClass('krajee-icon-clear');
      $(".center").slick({
        dots: true,
        infinite: false,
        centerMode: false,
        slidesToShow: 3,
        slidesToScroll: 1
      });
    });
	
	</script>
	<script type="text/javascript">
    $(document).ready(function(){ 
    $(window).scroll(function(){ 
        if ($(this).scrollTop() > 150) { 
            $('#back-to-top').fadeIn(); 
        } else { 
            $('#back-to-top').fadeOut(); 
        } 
    }); 
    $('#back-to-top').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    }); 
});
</script>


@endpush