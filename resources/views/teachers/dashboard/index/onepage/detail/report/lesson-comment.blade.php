<?php
    $studentLevel = [];
    if(!empty($studentLesson->student_level)){
        $studentLevel = $studentLesson->student_level->toArray();
    }
?>
<!--div class="card-header" id="heading-7">
    <h5 class="mb-0">
        <a class="collapsed" role="button" data-toggle="collapse"
            href="#collapse-7" aria-expanded="false"
            aria-controls="collapse-7">
            Lesson Comment ・ レッスンについてのコメント
        </a>
    </h5>
</div>

<div id="collapse-7" class="collapse" data-parent="#accordion" aria-labelledby="heading-7"-->
    <div class="card-body">
        <div class="lesson_comment">
            <div class="row">
                <div class="col-12">
                    <!--h3>Lesson Comment・レッスンについてのコメント</h3-->
                    <div class="cmnt_right">
                        <div class="check_round">
                            <div class="form-group">
                                <label class="checkcontainer">Student No Show
                                    <input id="stuNoShow" type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col-12">
                    <h3>Points to Improve・のばせるポイント</h3>
                </div>
            </div>
			<div class="row">
                <div class="col-12">
                    <div class="form-group">
						<a id="undopointstoimprove" style="display:none;" href="javascript:void(0);" data-id="">Undo</a>
                        <textarea id="points_to_improve_comment_textarea" readonly="readonly" class="form-control textarea_custom">{!! $booking->points_to_improve_comment !!}</textarea>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col-12">
                    <h3>Strong Points・良いポイント</h3>
                </div>
            </div>
			<div class="row">
                <div class="col-12">
                    <div class="form-group">
						<a id="undostrongpoints" style="display:none;" href="javascript:void(0);" data-id="">Undo</a>
                        <textarea id="strong_points_comment_textarea" readonly="readonly" class="form-control textarea_custom">{!! $booking->strong_points_comment !!}</textarea>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col-12">
                    <h3>Lesson Comment・レッスンコメント</h3>
                </div>
            </div>
			
			<div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <textarea id="lesson_comment_textarea" class="form-control textarea_custom">{!! $booking->booking_comments !!}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
<!--/div-->
