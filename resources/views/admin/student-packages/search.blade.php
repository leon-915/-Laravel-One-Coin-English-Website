<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title"></h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'package-search','name'=>"package-search",'autocomplete' => "off")) !!}
					<div class="row">
						<div class="form-group col-md-4">
							<label class="form-control-label" for="student">{{ __('labels.student_id') }}</label>
							{!! Form::text('student', null, array('placeholder' =>'student','class'=> 'form-control','id' => 'student'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="package">{{ __('labels.package_id') }}</label>
							{!! Form::text('package', null, array('placeholder' =>'package','class'=> 'form-control','id' => 'package'))!!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

