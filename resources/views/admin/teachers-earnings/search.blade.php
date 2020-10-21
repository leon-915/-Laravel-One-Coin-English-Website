<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title"></h4>
        <div class="row">
            <div class="col-12">
                {!! Form::open(array('role'=>'form','id'=>'teacher-earning-search','name'=>"teacher-earning-search",'autocomplete' => "off")) !!}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="teacher_name">{{ __('labels.teacher_id') }}</label>
                        {!! Form::text('teacher_name', null, array('placeholder' => __('labels.teacher_id'),'class'=> 'form-control','id' => 'teacher_name'))!!}
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="from_date">{{ __('labels.from_date') }}</label>
                        {!! Form::text('from_date', null, array('placeholder' => __('labels.from_date'),'class'=> 'form-control input','id' => 'from_date'))!!}
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="to_date">{{ __('labels.to_date') }}</label>
                        {!! Form::text('to_date', null, array('placeholder' => __('labels.to_date'),'class'=> 'form-control input','id' => 'to_date'))!!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

