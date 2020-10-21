<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title"></h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'user-search','name'=>"user-search",'autocomplete' => "off")) !!}
					<div class="row">
						<div class="form-group col-md-4">
							<label class="form-control-label" for="firstname">{{ __('labels.first_name') }}</label>
							{!! Form::text('firstname', null, array('placeholder' => __('labels.first_name'),'class'=> 'form-control','id' => 'firstname'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="first_name">{{ __('labels.last_name') }}</label>
							{!! Form::text('lastname', null, array('placeholder' => __('labels.last_name'),'class'=> 'form-control','id' => 'lastname'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="email_search">{{ __('labels.email') }}</label>
							{!! Form::text('email', null, array('placeholder' => __('labels.email'),'class' => 'form-control','id' => 'email_search')) !!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="status">{{ __('labels.status') }}</label>
							<select class="form-control" name="status">
								<option value="">Select Status</option>
								<option value="1">Active</option>
								<option value="3">Inactive</option>
								<option value="2">Pending</option>
								{{-- <option value="4">Deleted</option> --}}
								<option value="5">Approved</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="step_verified">{{ __('labels.step_verified') }}</label>
							<select class="form-control" name="step_verified">
								<option value="">Select Step</option>
								<option value="1">Pending Approval 1</option>
								<option value="2">Approved 1</option>
								<option value="3">Pending Approval 2</option>
								<option value="4">Archived</option>
							</select>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

