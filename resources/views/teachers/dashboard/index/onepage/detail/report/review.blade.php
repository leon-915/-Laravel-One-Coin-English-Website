<div class="card-header" id="heading-5">
    <h5 class="mb-0">
        <a class="collapsed" role="button" data-toggle="collapse"
            href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
            Review ・ 復習
        </a>
    </h5>
</div>
<div id="collapse-5" class="collapse" data-parent="#accordion" aria-labelledby="heading-5">
    <div class="card-body">
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
        <div class="lesson_topic review-container">
			<div class="lesson-topic-wrapper">
				<div class="onepage_sub_title clearfix">
					<h4 class="lesson_title"> Lesson Topics</h4>
				</div>
				<div class="topic_inner_ro clearfix">
					<span>Previous・前回</span>
					<span>{{ !empty($previousTopic) ? implode(',', $previousTopic) : '' }}</span>
					{{-- <i href="#" class="icon"><i class="fas fa-pen"></i></i> --}}
				</div>
				<div class="topic_inner_ro clearfix">
					<span>Current・今回</span>
					<span class="current_lesson_topic">{{ !empty($currentTopic) ? implode(',', $currentTopic) : '' }}</span>
					{{-- <i href="#" class="icon"><i class="fas fa-pen"></i></i> --}}
				</div>
			</div>	
			
			<div id="lk-onepage-arp-container" class="clearfix">
				@include('teachers.dashboard.index.onepage.detail.report.review.arp')
			</div>
			
			
            <div id="lk-onepage-keywords-container">
                @include('teachers.dashboard.index.onepage.detail.report.review.keywords')
            </div>

            <div id="lk-onepage-cips-container">
                @include('teachers.dashboard.index.onepage.detail.report.review.cips')
            </div>
        </div>
    </div>
</div>

<style>
    .op-change-status{
        cursor: pointer;
    }
</style>
