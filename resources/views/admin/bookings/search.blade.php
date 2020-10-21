<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title"></h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'booking-search','name'=>"booking-search",'autocomplete' => "off")) !!}
						<div class="row">
							<div class="form-group col-md-6">
								<label class="form-control-label" for="name">From Date</label>
	                            {!!
	                                Form::text(
	                                    'from',
	                                    null,
	                                    array(
	                                        'placeholder' => 'From Date',
	                                        'class'=> 'form-control',
											'id' => 'from',
	                                    )
	                                )
	                            !!}
							</div>
							<div class="form-group col-md-6">
								<label class="form-control-label" for="name">To Date</label>
	                            {!!
	                                Form::text(
	                                    'to',
	                                    null,
	                                    array(
	                                        'placeholder' => 'To Date',
	                                        'class'=> 'form-control',
											'id' => 'to',
	                                    )
	                                )
	                            !!}
							</div>
							<div class="form-group col-md-6">
								<label class="form-control-label" for="user_name">Student Name</label>
	                            {!!
	                                Form::text(
	                                    'user_name',
	                                    null,
	                                    array(
	                                        'placeholder' => 'User Name',
	                                        'class'=> 'form-control',
											'id' => 'user_name',
	                                    )
	                                )
	                            !!}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6" id="days_filter">
			                    <button class="btn btn-gradient-info btn-rounded btn-sm" id="30">Last 30 Days</button>
			                    <button class="btn btn-gradient-info btn-rounded btn-sm" id="60">Last 60 Days</button>
			                    <button class="btn btn-gradient-info btn-rounded btn-sm" id="90">Last 90 Days</button>
			                </div>
						</div>
						
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

