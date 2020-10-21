<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title"></h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'rating-search','name'=>"rating-search",'autocomplete' => "off")) !!}
					<div class = "row">
						<div class="form-group col-md-4">
							<label class="form-control-label" for="teacher">{{ __('labels.teacher_name')}}</label>
							{!! Form::text('teacher', null, array('placeholder' =>'Teacher Name','class'=> 'form-control','id' => 'teacher'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="student">{{ __('labels.student_name')}}</label>
							{!! Form::text('student', null, array('placeholder' =>'Student Name','class'=> 'form-control','id' => 'student'))!!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

