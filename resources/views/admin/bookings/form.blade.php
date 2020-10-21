<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="user_id">{{ __('labels.booking_student_id')}}<span class="vali">*</span></label>
        @if($form == 'edit')
            <input type="text" id="student_autocomplete" value="{{isset($student_name) ? $student_name : ''}}" placeholder= 'Search Student' class= 'form-control' {{ 'readonly' }}>
        @else
            <input type="text" id="student_autocomplete" value="{{isset($student_name) ? $student_name : ''}}" placeholder= 'Search Student' class= 'form-control'>
        @endif
        <input type="hidden" name="user_id" id="user_id" value="{{isset($booking->user_id) ? $booking->user_id : ''}}">
        <label id="user_id-error" class="error" for="user_id"></label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="service_id">{{ __('labels.booking_service_id')}}<span class="vali">*</span></label>
        {{-- {!! Form::select('service_id',$services,isset($booking->service_id) ? $booking->service_id : '', array('placeholder' => 'Select Service','class' => 'form-control','id' => 'service_id',"data-plugin" => "selectpicker")) !!} --}}
        @if($form == 'edit')
            {!! Form::select('service_id', $services, isset($booking->service_id) ? $booking->service_id : '', array('placeholder' => 'Select Service','class' => 'form-control','id' => 'service_id',"data-plugin" => "selectpicker", 'readonly')) !!}
        @else
            {!! Form::select('service_id',[], '', array('placeholder' => 'Select Service','class' => 'form-control','id' => 'service_id',"data-plugin" => "selectpicker")) !!}
        @endif
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="location_id">{{ __('labels.booking_location_id')}}<span class="vali">*</span></label>
        @if($form == 'edit')
            {!! Form::select('location_id', $location, isset($booking->location_id) ? $booking->location_id : '', array('placeholder' => 'Select Location','class' => 'form-control','id' => 'location_id',"data-plugin" => "selectpicker", ($booking->status == 'completed') ? 'readonly' : '' ))!!}
        @else
            {!! Form::select('location_id',[], '', array('placeholder' => 'Select Location','class' => 'form-control','id' => 'location_id',"data-plugin" => "selectpicker")) !!}
        @endif
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="teacher_id">{{ __('labels.booking_teacher_id')}}<span class="vali">*</span></label>
        @if($form == 'edit')
            {!! Form::select('teacher_id',$teacher,isset($booking->teacher_id) ? $booking->teacher_id : '', array('placeholder' => 'Select Teacher','class' => 'form-control','id' => 'teacher_id',"data-plugin" => "selectpicker", ($booking->status == 'completed') ? 'readonly' : '')) !!}
        @else
            {!! Form::select('teacher_id',[], isset($booking->teacher_id) ? $booking->teacher_id : '', array('placeholder' => 'Select Teacher','class' => 'form-control','id' => 'teacher_id',"data-plugin" => "selectpicker")) !!}
        @endif
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="lession_date">{{ __('labels.lession_date')}}<span class="vali">*</span></label>
        @if($form == 'edit')
            {!! Form::text('lession_date',isset($booking->lession_date) ? $booking->lession_date : '', array('placeholder' => 'Select Lesson Date','class' => 'form-control datepicker-popup','id' => 'lession_date', ($booking->status == 'completed') ? 'disabled' : '')) !!}
        @else
           {!! Form::text('lession_date',isset($booking->lession_date) ? $booking->lession_date : '', array('placeholder' => 'Select Lesson Date','class' => 'form-control datepicker-popup','id' => 'lession_date')) !!}
        @endif
    </div>
</div>

{{-- <div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="lession_time">{{ __('labels.lession_time')}}<span class="vali">*</span></label>
        {!! Form::text('lession_time',isset($booking->lession_time) ? $booking->lession_time : '', array('placeholder' => 'Select Lesson Time','class' => 'form-control timepicker','id' => 'lession_time')) !!}
    </div>
</div> --}}

<div class="row">
    <div class=" form-group col-md-12">
        <div class="form-group mt-3" id="available_time">
            <label for="exampleInputEmail1" class="">Time<span class="vali">*</span></label><br>
            @if(isset($booking->lession_time))
                <label class="checkcontainer"><input type="radio" name="time" value="{{$booking->lession_time}}" checked="checked" {{ ($booking->status == 'completed') ? 'disabled' : ''}}>{{$booking->lession_time}}<span class="radiobtn"></span></label>
            @endif
        </div>
    </div>
</div>


{{-- <div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="lesson_duration">{{ __('labels.lesson_duration') }}<span class="vali">*</span></label>
        {!! Form::select('lesson_duration',array('15'=>'15 Min','25'=>'25 Min','50'=>'50 Min',),isset($booking->lesson_duration) ? $booking->lesson_duration : '', array('placeholder' => 'Lesson Duration','class'=> 'form-control','id' => 'lesson_duration'))!!}
    </div>
</div> --}}
{{--<div class="row">--}}
    {{--<div class="form-group col-md-6">--}}
        {{--<label class="form-control-label" for="lession_type">{{ __('labels.lesson_type')}}<span class="vali">*</span></label>--}}
        {{--{!! Form::text('lession_type',isset($booking->lession_type) ? $booking->lession_type : '', array('placeholder' => 'Select Lesson Type','class' => 'form-control','id' => 'lession_type')) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="row">--}}
    {{--<div class="form-group col-md-6">--}}
        {{--<label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>--}}
        {{--{!! Form::select('status',array('1'=>'Active','2'=>'Inactive'),isset($booking->status) ? $booking->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="student_skype_id">{{ __('labels.student_skype_id') }}</label>
        @if($form == 'edit')
            {!! Form::text('student_skype_id', ((isset($booking)) && (!empty($booking->student_skype_id))) ? $booking->student_skype_id : '', array('placeholder' => 'Student Skype Id','class'=> 'form-control','id' => 'student_skype_id', ($booking->status == 'completed') ? 'disabled' : ''))!!}
        @else
            {!! Form::text('student_skype_id', ((isset($booking)) && (!empty($booking->student_skype_id))) ? $booking->student_skype_id : '', array('placeholder' => 'Student Skype Id','class'=> 'form-control','id' => 'student_skype_id'))!!}
        @endif
    </div>
</div>


<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="additionl_info_teacher">{{ __('labels.additionl_info_teacher') }}</label>
        @if($form == 'edit')
            <textarea name="additional_info_teacher" id="additional_info_teacher" class="form-control desc_star" maxlength="1000" rows="5" placeholder="Additional info teacher has a limit of 1000 chars."
            {{($booking->status == 'completed') ? 'disabled' : ''}}>{{isset($booking->additional_info_teacher) ? $booking->additional_info_teacher : ''}}</textarea>
        @else
            <textarea name="additional_info_teacher" id="additional_info_teacher" class="form-control desc_star" maxlength="1000" rows="5" placeholder="Additional info teacher has a limit of 1000 chars.">{{isset($booking->additional_info_teacher) ? $booking->additional_info_teacher : ''}}</textarea>
        @endif
    </div>
</div>

<div class="row">
    <div class="form-group col-md-9">
        <label class="form-control-label" for="location_details">{{ __('labels.location_detail') }}</label>
        @if($form == 'edit')
            <textarea name="location_detail" id="location_details" class="form-control desc_star" maxlength="1000" rows="5" placeholder="Location details has a limit of 1000 chars." {{($booking->status == 'completed') ? 'disabled' : ''}}>{{isset($booking->location_detail) ? $booking->location_detail : ''}}</textarea>
        @else
            <textarea name="location_detail" id="location_details" class="form-control desc_star" maxlength="1000" rows="5" placeholder="Location details has a limit of 1000 chars.">{{isset($booking->location_detail) ? $booking->location_detail : ''}}</textarea>
        @endif
    </div>
</div>

<!--<div class="row mb-2">
    <div class="form-group col-12 mb-0">
        <br>
        <div class="row">
            <div class="col-4">
                <div class="form-check form-check-info">
                    <label class="form-check-label">
                        <input class="available-size name form-check-input" 
                       {{--  <?= ((isset($booking->is_teacher_present)) && ($booking->is_teacher_present == 0)) ? 'checked' : '' ?>  --}}
                        name="teacher_not_show" type="checkbox" value="1">
                         Teacher not show?
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <label id="teacher_not_show-error" for="teacher_not_show" class="error"></label>
    </div>
</div> -->
@if($form == 'edit')
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-control-label" for="status">{{ __('labels.status') }}<span class="vali">*</span></label>
            {!! Form::select('status',array('booked'=>'Booked',
                                            'completed'=>'Completed',
                                            'cancel'=>'Cancel',
                                            'teacher_not_show'=>'Teacher No Show',
                                            'student_not_show'=>'Student No Show',
                                            'free_lesson'=>'Free Lesson',
                                            'deleted'=>'Deleted',
                                        ),isset($booking->status) ? $booking->status : '', array('placeholder' => 'Select Status','class'=> 'form-control','id' => 'status',($booking->status == 'completed') ? 'disabled' : ''))!!}
        </div>
    </div>
@endif


<div class="row">
    <div class="form-group col-md-2">
        @if($form == 'edit')
            {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn',($booking->status == 'completed') ? 'disabled' : '')) !!}
        @else
            {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
        @endif
    </div>

    <div class="form-group col-md-2">
        @if (!empty($ref) && $ref == 'calender')
            {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/calender')."'")) !!}
        @else
            {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/bookings')."'")) !!}
        @endif
    </div>
</div>