<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title"></h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'lesson-search','name'=>"lesson-search",'autocomplete' => "off")) !!}
					<div class="row">
						<div class="form-group col-md-4">
							<label class="form-control-label" for="student">Student</label>
							{!! Form::text('student', null, array('placeholder' =>'Student','class'=> 'form-control','id' => 'student'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="service">Service</label>
							{!! Form::text('service', null, array('placeholder' =>'Service','class'=> 'form-control','id' => 'service'))!!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

