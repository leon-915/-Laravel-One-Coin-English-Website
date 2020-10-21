
<div class="row mt-4">
    <div class="form-group col-md-6 ">
        <label class="form-control-label " for="title">{{ __('labels.title') }}<span class="vali">*</span></label>
        {!! Form::text('title', isset($services->title) ? $services->title : '', array('placeholder' => 'Title','class'=> 'form-control','id' => 'title'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="category_id">{{ __('labels.categories')}}</label>
        @if($form == 'edit')
            <select multiple="multiple" size="7" name="category_id[]" id="category_id" class="form-control multiple-package" style="width: 400px;">
                @foreach($categories as $key => $pack)
                    <?php $selected_package = in_array($key, $service_categories) ? 'selected' : ''; ?>
                    <option value="{{ $key }}" {{ $selected_package }}>{{ $pack }}</option>
                @endforeach
            </select>
            <label id="category_id-error" class="error" for="category_id"></label>
        @else
            <select multiple="multiple" size="7" name="category_id[]" id="category_id" class="form-control multiple-package">
                @foreach($categories as $key => $pack)
                    <option value="{{ $key }}">{{ $pack }}</option>
                @endforeach
            </select>

            <label id="category_id-error" class="error" for="category_id"></label>
        @endif
    </div>
</div>
<div class="row">
	<div class="form-group col-md-12">
        <label class="form-control-label" for="description">{{ __('labels.description')}}</label>
        {!! Form::textarea('description', isset($services->description) ? $services->description : '', array('rows'=>3,'placeholder' => 'Description','class' => 'form-control','id' => 'description')) !!}
    </div>
</div>
<hr>
<div class="row">
    <div class="form-group col-md-6">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" name="is_system_service" value="1" <?= (!empty($services->is_system_service) && $services->is_system_service == 1) ?'checked' : ''?> class="form-check-input" id="is_system_service">
                {{ __('labels.is_system_service') }}
                <i class="input-helper"></i>
            </label>
        </div>
    </div>

    <div class="form-group col-md-6" id="packages-cont">
        <label class="form-control-label" for="package_id">{{ __('labels.package_id')}}</label>
        @if($form == 'edit')
            <select multiple="multiple" size="7" name="package_id[]" id="package_id" class="form-control multiple-package" style="width: 400px;">
                @foreach($packages as $key => $pack)
                    <?php $selected_package = in_array($key, $service_packages) ? 'selected' : ''; ?>
                    <option value="{{ $key }}" {{ $selected_package }}>{{ $pack }}</option>
                @endforeach
            </select>
            <label id="package_id-error" class="error" for="package_id"></label>
        @else
            <select multiple="multiple" size="7" name="package_id[]" id="package_id" class="form-control multiple-package">
                @foreach($packages as $key => $pack)
                    <option value="{{ $key }}">{{ $pack }}</option>
                @endforeach
            </select>

            <label id="package_id-error" class="error" for="package_id"></label>
        @endif
    </div>
</div>

<div class="row d-none" id="receive-credit-cont">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="receive_credit_on_booking_type">{{ __('labels.receive_credit_on_booking_type') }}</label>
        {!! Form::select('receive_credit_on_booking_type', array('1' => 'fixed', '2' => 'percent'),isset($services->receive_credit_on_booking_type) ? $services->receive_credit_on_booking_type : '', array('class' => 'form-control','id' => 'receive_credit_on_booking_type',"data-plugin" => "selectpicker")) !!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="receive_credit_on_booking">{{ __('labels.receive_credit_on_booking')}}</label>
        {!! Form::text('receive_credit_on_booking', isset($services->receive_credit_on_booking) ? $services->receive_credit_on_booking : '', array('placeholder' => 'Receive Credit on Booking','class'=> 'form-control','id' => 'receive_credit_on_booking'))!!}
    </div>
</div>

<hr>

<div class="row">
    <div class="form-group col-md-6" id="no_of_days_container">
        <label class="form-control-label" for="no_of_days">{{ __('labels.no_of_days') }}<span class="vali">*</span></label>
        {!! Form::text('no_of_days', isset($services->no_of_days) ? $services->no_of_days : '', array('placeholder' => 'No of Days','class'=> 'form-control','id' => 'no_of_days'))!!}
    </div>
    <div class="form-group col-md-6" id="available_lessons_container">
        <label class="form-control-label" for="available_lessons">{{ __('labels.available_lessons')}}<span class="vali">*</span></label>
        {!! Form::text('available_lessons',isset($services->available_lessons) ? $services->available_lessons : '', array('placeholder' => 'Available Lessons','class' => 'form-control','id' => 'available_lessons',"data-plugin" => "selectpicker")) !!}
    </div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="length">{{ __('labels.length') }}<span class="vali">*</span></label>
        {!! Form::text('length', isset($services->length) ? $services->length : '', array('placeholder' => 'Length','class'=> 'form-control','id' => 'length'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="length_type">{{ __('labels.length_type')}}</label>
        {!! Form::select('length_type', array('minute' => 'Minute', 'hour' => 'Hour'),isset($services->length_type) ? $services->length_type : 'minute', array('class' => 'form-control','id' => 'length_type',"data-plugin" => "selectpicker")) !!}
    </div>
</div>
<hr>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="padding">{{ __('labels.padding_minutes') }}<span class="vali">*</span></label>
        {!! Form::text('padding_minutes', isset($services->padding_minutes) ? $services->padding_minutes : '', array('placeholder' => 'Padding Minutes','class'=> 'form-control','id' => 'padding_minutes'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="padding_type">{{ __('labels.padding_type')}}</label>
        {!! Form::select('padding_type', array('1' => 'Before', '2' => 'After', '3' => 'Before & After'),isset($services->padding_type) ? $services->padding_type : 1, array('class' => 'form-control','id' => 'padding_type',"data-plugin" => "selectpicker")) !!}
    </div>
</div>
<hr>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="price">{{ __('labels.price') }}  (¥)</label>
        {!! Form::text('price', isset($services->price) ? $services->price : '', array('placeholder' => 'Price (¥)','class'=> 'form-control','id' => 'price'))!!}
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        {!! Form::select('status', array('1' => 'Active', '2' => 'Inactive'),isset($services->status) ? $services->status : '', array('placeholder' => 'Select Status','class' => 'form-control','id' => 'status',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<hr>

<div class="row">
    <div class="form-group col-md-6">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" name="is_flexible_appointment_start_time" value="1" <?= (!empty($services->is_flexible_appointment_start_time) && $services->is_flexible_appointment_start_time == 1) ?'checked' : ''?> class="form-check-input Appointment_chekbox" >
                    {{ __('labels.is_flexible_appointment_start_time') }}
                <i class="input-helper"></i>
            </label>
        </div>
    </div>

    <div class="form-group col-md-6  ">
        <label class="form-control-label" for="flexible_appointment_start_time">{{ __('labels.flexible_appointment_start_time')}}</label>
            {!! Form::select('flexible_appointment_start_time',  $appointment_time,
                             isset($services->flexible_appointment_start_time) ? $services->flexible_appointment_start_time : '',
                             array('placeholder'=>'Select Appointment Time','class' => 'form-control appointment_time','id' => 'flexible_appointment_start_time',"data-plugin" => "selectpicker")) !!}
    </div>
</div>

<div class="row" id="trial-container">
    <div class="form-group col-6 mb-0">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input class="available-size name form-check-input" name="is_available_in_trial"
                <?= isset($services->is_available_in_trial) && $services->is_available_in_trial == 1 ? 'checked' : '' ?>  type="checkbox" value="1">
                 Is Available In Trial?
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-6 mb-0">
        <div class="form-check form-check-primary">
            <label class="form-check-label" for="is_reg_fee_required">
				<input class="available-size name form-check-input" name="is_reg_fee_required"
					<?= isset($services->is_reg_fee_required) && $services->is_reg_fee_required == 1 ? 'checked' : '' ?>  type="checkbox" value="1">
					 Is Registration Fee Required?
			</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-6 mb-0">
        <div class="form-check form-check-primary">
            <label class="form-check-label" for="is_onepage_fee_required">
				<input class="available-size name form-check-input" name="is_onepage_fee_required"
					<?= isset($services->is_onepage_fee_required) && $services->is_onepage_fee_required == 1 ? 'checked' : '' ?>  type="checkbox" value="1">
					 Is OnePage Fee Required?
			</label>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="service_name_en">{{ __('labels.service_name_en') }}<span class="vali">*</span></label>
        {!! Form::text('service_name_en', isset($services->service_name_en) ? $services->service_name_en : '', array('placeholder' => 'Service Name','class'=> 'form-control','id' => 'service_name_en'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="location_id">{{ __('labels.location_id')}}</label>

        @if($form == 'edit')
            <select multiple="multiple" size="7" name="location_id[]" id="location_id" class="form-control multiple-location">
                @foreach($locations as $key => $lock)
                    <?php $selected_location = in_array($key, $service_location) ? 'selected' : ''; ?>
                    <option value="{{ $key }}" {{ $selected_location }}>{{ $lock }}</option>
                @endforeach
            </select>
            <label id="location_id-error" class="error" for="location_id"></label>
        @else
            {!! Form::select('location_id[]',$locations,isset($locations) ? $locations : '', array('class' => 'form-control multiple-location','id' => 'location_id','multiple'=>true)) !!}
            <label id="location_id-error" class="error" for="location_id"></label>
        @endif

    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="teacher_id">{{ __('labels.teacher_id')}}</label>
        @if($form == 'edit')
            <select multiple="multiple" size="7" name="teacher_id[]" id="teacher_id" class="form-control multiple-teacher">
                @foreach($teachers as $key => $teacher)
                    <?php $selected_teacher = in_array($key,  $teacher_service) ? 'selected' : ''; ?>
                    <option value="{{ $key }}" {{ $selected_teacher }}>{{ $teacher }}</option>
                @endforeach
            </select>
            <label id="teacher_id-error" class="error" for="teacher_id"></label>
        @else
            {!! Form::select('teacher_id[]',$teachers,isset($teachers) ? $teachers : '', array('class' => 'form-control multiple-teacher','id' => 'teacher_id','multiple'=>true)) !!}
            <label id="teacher_id-error" class="error" for="teacher_id"></label>
        @endif
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <div class="form-check form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" name="hide_price" value="1" <?= (!empty($services->hide_price) && $services->hide_price == 1) ?'checked' : ''?> class="form-check-input" id="hide_price">
                {{ __('labels.hide_price') }}
                <i class="input-helper"></i>
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/services')."'")) !!}
    </div>
</div>
