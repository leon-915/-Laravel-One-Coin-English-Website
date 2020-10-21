<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title"></h4>
        <div class="row">
            <div class="col-12">
                {!! Form::open(array('role'=>'form','id'=>'student-lesson-record-search','name'=>"student-lesson-record-search",'autocomplete' => "off")) !!}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="student_name">{{ __('labels.student_name') }}</label>
                        {!! Form::text('student_name', null, array('placeholder' => __('labels.student_name'),'class'=> 'form-control','id' => 'student_name'))!!}
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="from_date">{{ __('labels.email') }}</label>
                        {!! Form::text('email', null, array('placeholder' => __('labels.email'),'class'=> 'form-control input','id' => 'email'))!!}
                    </div>

                    <div class="form-group col-md-4">
                        <a href="{{ route('admin.student.lesson.records.csv') }}"  >
                            Download Financial CSV
                        </a>

                        <br><br>

                        <a href="{{ route('admin.student.lesson.records.active_student_csv') }}" >
                            Download Active Students
                        </a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

