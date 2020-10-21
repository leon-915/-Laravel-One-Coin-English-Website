<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title">{{ __('labels.students_filter') }}</h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'student-search','name'=>"student-search",'autocomplete' => "off")) !!}
					<div class="row">
						<div class="form-group col-md-4">
							<label class="form-control-label" for="firstname">{{ __('labels.first_name') }}</label>
							{!! Form::text('firstname', null, array('placeholder' => 'First Name','class'=> 'form-control','id' => 'firstname'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="lastname">{{ __('labels.last_name') }}</label>
							{!! Form::text('lastname', null, array('placeholder' => 'Last Name','class'=> 'form-control','id' => 'lastname'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="email_search">{{ __('labels.email') }}</label>
							{!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'email','autocomplete' => "off")) !!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="status">{{ __('labels.status') }}</label>
							<select class="form-control" name="status">
								<option value="">{{ __('labels.select_status') }}</option>
								<option value="1">Active</option>
								<option value="3">Inactive</option>
								<option value="4">Deleted</option>
							</select>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

