
<?php
    $studentLevel = [];
    /*if(!empty($studentLesson->student_level)){
        $studentLevel = $studentLesson->student_level->toArray();
    }*/
?>
<div class="success-alert mt-30">
	<div class="std_improve success">
		<div class="row">
			<div class="col-lg-12 col-12">
				<div class="improve_level">
					<ul class="level_inline">
						<li><span>Student level:-</span></li>
						<li>
							<h5> {{$level_detail['name']}}</h5>
						</li>
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
							<h5>
								@if(App::isLocale('en'))
									{{$level_detail['description_en']}}
								@else
									{{$level_detail['description_ja']}}
								@endif
							</h5>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
