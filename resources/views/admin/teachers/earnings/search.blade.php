<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title"></h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'earning-search','name'=>"earning-search",'autocomplete' => "off")) !!}
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
						</div>
						<input type="hidden" name="teacher_id" id="teacher_id" value="{{$teacher_id}}">
					
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

