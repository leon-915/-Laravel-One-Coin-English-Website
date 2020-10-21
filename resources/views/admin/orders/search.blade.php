<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title"></h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'order-search','name'=>"order-search",'autocomplete' => "off")) !!}
					<div class="row">
						<div class="form-group col-md-4">
							<label class="form-control-label" for="student">Student</label>
							{!! Form::text('student', null, array('placeholder' =>'Student','class'=> 'form-control','id' => 'student'))!!}
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label" for="status">{{ __('labels.status') }}</label>
							<select class="form-control" name="status">
								<option value="">Select Status</option>
								<option value="pending">Pending</option>
								<option value="succeeded">Success</option>
								<option value="failed">Fail</option>
							</select>
						</div>
						{{-- <div class="form-group col-md-4">
							<label class="form-control-label" for="product">Product</label>
							{!! Form::text('product', null, array('placeholder' =>'product','class'=> 'form-control','id' => 'product'))!!}
						</div> --}}
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

