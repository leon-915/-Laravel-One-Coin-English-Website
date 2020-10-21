<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title"></h4>
        <div class="row">
            <div class="col-12">
				<?php
				for($i = (date('Y') - 6); $i <= date('Y'); $i++) {
						$year_list[$i] = $i;
				}
				//$year_list = range(2010, 2020);
				?>
                {!! Form::open(array('role'=>'form','id'=>'service-search','name'=>"service-search",'autocomplete' => "off")) !!}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="location_title">{{ __('labels.title') }}</label>
                        {!! Form::text('title', null, array('placeholder' => 'Search Service Title','class'=> 'form-control input','id' => 'title'))!!}
                    </div>
					
					<div class="form-group col-md-4">
                        <label class="form-control-label" for="year">{{ __('admin_labels.year') }}</label>
                        {!! Form::select('year', $year_list,'', array('placeholder' => 'Search active services in','class'=> 'form-control select','id' => 'year'))!!}
                    </div>
					
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

