<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title"></h4>
        <div class="row">
            <div class="col-12">
                {!! Form::open(array('role'=>'form','id'=>'location-search','name'=>"location-search",'autocomplete' => "off")) !!}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="location_title">{{ __('labels.location_title') }}</label>
                        {!! Form::text('title', null, array('placeholder' => 'Search Location Title','class'=> 'form-control input','id' => 'title'))!!}
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="location_type">{{ __('labels.location_type') }}</label>
                        {!! Form::select('location_type', $location_type_list,'', array('placeholder' => 'Search Location Type','class'=> 'form-control select','id' => 'location_type'))!!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

