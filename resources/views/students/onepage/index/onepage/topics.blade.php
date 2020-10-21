<?php
    $currentTopic = [];
    if(!empty($booking->topics)){
        foreach ($booking->topics as $ckey => $ctopic) {
            $currentTopic[] = $ctopic->title;
        }
    }
    $previousTopic = [];
    if(!empty($previousBooking->topics)){
        foreach ($previousBooking->topics as $tkey => $topic) {
            $previousTopic[] = $topic->title;
        }
    }
?>
<div class="row">
    <div class="col-12">
        <div class="plan_header">
            <h2>{{__('labels.stu_lesson_topics')}}</h2>
        </div>
    </div>
    <div class="col-12">
        <div class="p_detais">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p_details_label">Previous 前回 </div>
                </div>
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="p_details_text">
                        <span>:</span>
                        {{ !empty($previousTopic) ? implode(',', $previousTopic) : '' }}
                    </div>
                </div>
            </div>
			
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p_details_label">Current 今回 </div>
                </div>
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="p_details_text">
                        <span>:</span>
                        {{ !empty($currentTopic) ? implode(',', $currentTopic) : '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
