<?php
    $birthdate = !empty($teacherDetails->dob) ? $teacherDetails->dob : "";
    $age = 0;
    if($birthdate){
        $today = new \DateTime(date('Y-m-d'));
        $bday = new \DateTime($birthdate); // Your date of birth
        $diff = $today->diff($bday);
        $age = $diff->y;
    }
    $yearExperience = 0;
    if(!empty($teacherDetails->teaching_year_begun)){
        $currentYear =  date("Y");
        $yearExperience = $currentYear - $teacherDetails->teaching_year_begun;
    }
   // $age = \Carbon::parse($teachrDeatils->dob)->age;

    $teaching_category = [];
    if(!empty($teacherDetails->teaching_category)){
        $teaching_category = explode(',',$teacherDetails->teaching_category);
    }

?>
<!--div class="row">
    <div class="col-12">
        <div class="plan_header">
            <h2>{{ucfirst($teacher->firstname)}}'s Profile</h2>
            <p>See some details of {{ucfirst($teacher->firstname)}}</p>
        </div>
    </div>
</div-->



<div class="p_detais" style="margin-top:40px;">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Nickname </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> {{ucfirst($teacher->firstname)}} {{ucfirst($teacher->lastname)}} 
            	@if(Auth::guest())
					<a href="<?php echo url('teacher/profile/favorite/'.$teacher->id.'');?>" class="fa fa-heart">&nbsp;</a>
				@else	
					@if(!empty($favorite) && ($favorite['is_favorite'] == 1))
					<a href="javascript:void(0);" style="color:red;" class="fa fa-heart" onclick="make_teacher_un_fav('{{ $teacher->id }}')">&nbsp;</a>
					@else
						<a href="javascript:void(0);" class="fa fa-heart" onclick="make_teacher_fav('{{ $teacher->id }}')">&nbsp;</a>
					@endif
				@endif	
            </div>
			
			
			
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Age </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=($age != 0) ? $age : '-' ?> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Nationality </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=!empty($teacherDetails->nationality) ? $teacherDetails->nationality : '-' ?> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Qualifications </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=!empty($teacherDetails->highest_education ) ?  strtoupper($teacherDetails->highest_education) : '-' ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Lesson duration able to teach
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=!empty($teacherDetails->lesson_minute_able_to_teach) ? ($teacherDetails->lesson_minute_able_to_teach).' (minutes)' : '-' ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">English teaching experience </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> {{$yearExperience}} years</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Hobbies and interests </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=!empty($teacherDetails->hobby) ? $teacherDetails->hobby : '-' ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Japanese ability</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span>
                @if($teacherDetails->japanese_ability == 'jplt_score')
                    JPLT (Score: <?=!empty($teacherDetails->jplt_score) ? $teacherDetails->jplt_score : '-' ?>)
                @else
                     <?=!empty($teacherDetails->japanese_ability) ? ucfirst($teacherDetails->japanese_ability) : '-' ?>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Message to student </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span>
                @if(!empty($teacherDetails->message_en && $teacherDetails->message_jp))
                    {{$teacherDetails->message_en}}  {{$teacherDetails->message_jp}}
                @else
                    -
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Teaching certification</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=!empty($teacherDetails->teaching_certificate ) ?
            ucfirst($teacherDetails->teaching_certificate) : '-' ?> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Teaching category</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text" id="teaching_category"><span class="dots">:</span>
                @if(!empty($teaching_category))
                    @foreach($teaching_category as $category)
                        {{-- <div class="badge badge-gradient-info">{{$category}}</div> --}}
                       {{--  <option value="Amsterdam">Amsterdam</option> --}}
                       <span class="badge badge-primary">{{ucfirst($category)}}</span>
                    @endforeach
                @else
                    -
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Teaching mode</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?= ($teacherDetails->is_remote_teaching == 1) ? 'Remote' : $teacherDetails->teaching_locations ?> </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Pocket wifi available</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=($teacherDetails->pocket_wifi_available == 1) ? 'Yes' : 'No' ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Interview method</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span> <?=!empty($teacherDetails->preferred_interview_method ) ? ucfirst($teacherDetails->preferred_interview_method) : '-' ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Highest education attained</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span>:</span><?=!empty($teacherDetails->highest_education) ? strtoupper($teacherDetails->highest_education) : '-' ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Courses</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="p_details_text"><span><span>:</span></span>
                <?=!empty($teacherDetails->courses_teach ) ? $teacherDetails->courses_teach : '-' ?>
               {{--  Daily Conversation<br>
                Business English<br>
                Kids LessonsJob Interview<br>
                Travel English<br>
                Showbiz and Entertainment EnglishJobs and Occupation
                English<br>
                Computer English<br>
                Creative Writing<br>
                English for Mass Communication (Media) --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 ">
            <div class="p_details_label">Audio</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8 audio-mobile">
            <div class="p_details_text audi"><span>:</span>
                @if(!empty($teacherDetails->audio_attachment))
                    <audio controls="controls" src="{{asset($teacherDetails->audio_attachment)}}">
                        Your browser does not support the HTML5 Audio element.
                    </audio>
                @else
                    -
                @endif
            </div>
        </div>
    </div>
	
	@if(!empty($teacher->video))
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 ">
				<div class="p_details_label">Video</div>
			</div>
			<div class="col-12 col-md-6 col-lg-8 audio-mobile">
				<div class="p_details_text audi"><span>:</span>
					
						<video width="320" height="240" controls>
							<source src="{{$teacher->video}}" type="video/mp4">
						</video>
				</div>
			</div>
		</div>
	@endif
     <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="p_details_label">Total Ratings</div>
        </div>
        <div class="col-12 col-md-6 col-lg-8 rated">
            <div class="p_details_text"><span>:</span>
                <input id="total-ratings" name="total-ratings" class="kv-ltr-theme-svg-star rating-loading teacher-ratings-avg rated" value="{{$totalRatings}}" dir="ltr" data-size="xs" readonly="true">{{!empty($totalRatings) ? number_format($totalRatings,1) : 0}}/5
                <span class="tech_total_rat">({{$countStudentsRated}})</span>
            </div>
        </div>
    </div>

    @foreach($tratingTypes as $trat)
        <?php
            $rating = $trat;
            $rateTotal = !empty($tratings[$rating['id']]['avg']) ? number_format($tratings[$rating['id']]['avg'],2) : 0;
            $rateCount = !empty($tratings[$rating['id']]['total']) ? $tratings[$rating['id']]['total'] : 0;
        ?>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="p_details_label">{{$rating['title']}}</div>
            </div>
            <div class="col-12 col-md-6 col-lg-8  rated">
                <div class="p_details_text"><span>:</span>
                    <input id="teacher-rating-{{ $rating['id'] }}" name="teacher-rating[{{ $rating['id'] }}]" class="kv-ltr-theme-svg-star rating-loading teacher-ratings-avg" value="{{$rateTotal}}" dir="ltr" data-size="xs" data-rate="{{ $rating['id'] }}" readonly="true">{{!empty($rateTotal) ? number_format($rateTotal,1) : 0}}/5
                </div>
            </div>
        </div>
    @endforeach

</div>
@if(Auth::user() && Auth::user()->user_type == 'student')
    @if(!empty($ratingTypes) && $ratingTypes->toArray() && $booking->is_rated=='no')
        <div class="p_detais">
            <div class="row">
                <div class="col-12">
                    <div class="plan_header">
                        <h2>Rate Teacher</h2>
                        <p>Rate this teacher now</p>
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

                    <!--div class="form-group">
                        <label class="checkcontainer">
                            Is Favorite Teacher?
                            <input type="checkbox" name="is_favorite" value="1" {{(!empty($favorite) && ($favorite['is_favorite'] == 1)) ? 'checked' : ''}}>
                            <span class="checkmark"></span>
                        </label>
                    </div-->

                    <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                    <input type="hidden" name="booking_id" value="{{!empty($booking->id) ? $booking->id : 0}}">

                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="" class="btnsub_arr" id="btn_submit">Submit</a>
                    </div>
                </div>
            </form>

        </div>
    @else
        {{-- <div class="alert alert-warning" role="alert">
            Thank you for taking lessons at Accent. You have already rated this teacher for a lesson taught! You can rate this teacher at the next lesson with them.
        </div> --}}
        <div class="alert alert-warning" role="alert">
            <p>You have already rated this teacher for a lesson taught! You can rate this teacher at the next lesson with them.</p>
            OR
            <p>You have't any completed Lessons.</p>
        </div>
    @endif
@endif
