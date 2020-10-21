<p class="card-description"> Personal Info </p>
<?php
    $url = "";
    if(!empty($teacher['profile_image'])){
        $url = asset($teacher['profile_image']);
    }

    $highest_education = "";
    if(!empty($teacher['highest_education'])){
        $highest_education = explode(',', $teacher['highest_education']);
    }

    $teaching_certificate = "";
    if(!empty($teacher['teaching_certificate'])){
        $teaching_certificate = explode(',', $teacher['teaching_certificate']);
    }

    $lesson_minute_able_to_teach = "";
    if(!empty($teacher['lesson_minute_able_to_teach'])){
        $lesson_minute_able_to_teach = explode(',', $teacher['lesson_minute_able_to_teach']);
    }

    $teaching_category = "";
    if(!empty($teacher['teaching_category'])){
        $teaching_category = explode(',', $teacher['teaching_category']);
    }

    $teaching_locations = "";
    if(!empty($teacher['teaching_locations'])){
        $teaching_locations = explode(',', $teacher['teaching_locations']);
    }
?>

<div class="row" id="cimage">
    <div class="form-group col-md-12" >
        <label class="form-control-label">{{ __('labels.profile_image')}}</label>

        <div id="upload-demo"></div>

        <label id="croppie-image-upload">
            <input type="file" id="image" name="img" data-default-file="{{ $url }}" style="display: none">
            <div class="input-group col-xs-12">
                <input class="form-control file-upload-info" disabled="" placeholder="Upload Image" type="text">
                <span class="input-group-append">
                    <button class="file-upload-browse btn btn-gradient-primary" type="button">
                        Select Image
                    </button>
                </span>
            </div>
            <label id="image-error" class="error" for="image"></label>
        </label>
    </div>

    <input type="hidden" name="image">
    <input type="hidden" id="url" value="{{$url}}">

</div>

<div class="row">
	<div class="col-md-12 form-group">
		<label>Introductory video</label>
		<div style="text-align:center;">
		<?php
		if(!empty($teacher->video) && $teacher->video !='') { ?>
			<video width="320" height="240" controls>
				<source src="{{$teacher->video}}" type="video/mp4">
			</video> 
		<?php }
		?>
		
		<div class="attachments">
			<div class="file-select">
				<input type="file" name="video" class="custom-file-upload" id="video">
			</div>
		</div>
		<label id="video-attachments-error" class="error" for="video"
			   style="display: none;"></label>
		<p>.mp4 format is allowed. Video should not be more than 5MB in size.</p>
		</div>
	</div>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="firstname">{{ __('labels.first_name')}}<span class="vali">*</span></label>
        {!! Form::text('firstname', null, array('placeholder' => 'First Name','class'=> 'form-control','id' => 'firstname'))!!}
        <label id="firstname-error" class="error" for="firstname"></label>
    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="lastname">{{ __('labels.last_name')}}<span class="vali">*</span></label>
        {!! Form::text('lastname', null, array('placeholder' => 'Last Name','class'=> 'form-control','id' => 'lastname'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="nationality">{{ __('labels.nationality')}}<span class="vali">*</span></label>
        {!!
			Form::select(
				'nationality',
				$countries,
				isset($teacher->nationality) ? $teacher->nationality : '',
				array(
					'class' 		=> 'form-control',
					'placeholder' 	=> 'Select Country',
					"data-plugin" 	=> "selectpicker",
					"id" 			=> "nationality",
					"required" 		=> "true"
				)
			)
        !!}

        <label id="nationality-error" for="nationality" class="error"></label>

    </div>
</div>

<div class="row">
    @if (!empty($teacher) && !empty($teacher->gender))
        <div class="form-group col-md-6">
            <label class="form-control-label" for="Birthdate">{{ __('labels.gender')}}</label>
            <div class="row">
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="male" id="male" name="gender" type="radio"
                            <?= (!empty($teacher) && $teacher->gender == "male") ? 'checked' : '' ?>> Male
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="female" id="female" name="gender" type="radio"
                            <?= (!empty($teacher) && $teacher->gender == "female") ? 'checked' : '' ?>> Female
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="form-group col-md-6">
            <label class="form-control-label" for="Birthdate">{{ __('labels.gender')}}</label>
            <div class="row">
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="male" id="male" name="gender" type="radio"
                            checked> Male
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="female" id="female" name="gender" type="radio"
                            > Female
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="form-group col-md-6">
        <label class="form-control-label" for="dob">{{ __('labels.birthdate')}}<span class="vali">*</span></label>
        <input type="text" placeholder="Select Birthdate" id="datepicker-popup" class="form-control" name="dob" value="<?= isset($teacher->dob) ? $teacher->dob : '' ?>">
    </div>
</div>

@if($form == "create")
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-control-label" for="password">{{ __('labels.password')}}<span class="vali">*</span></label>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password','autocomplete' => 'new-password')) !!}
        </div>
        <div class="form-group col-md-6">
            <label class="form-control-label" for="comfirm_password">{{ __('labels.confirm_password')}}<span class="vali">*</span></label>
            {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
        </div>
    </div>
@else
    <!--div class="row" style="display:none;">
        <div class="form-group col-md-6">
            <label class="form-control-label" for="password">{{ __('labels.password')}}</label>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password','autocomplete' => 'new-password')) !!}
        </div>
        <div class="form-group col-md-6">
            <label class="form-control-label" for="comfirm_password">{{ __('labels.confirm_password')}}</label>
            {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'comfirm_password')) !!}
        </div>
    </div-->

@endif

<div class="row">

    <div class="form-group col-md-6">
        <label class="form-control-label" for="email">{{ __('labels.email')}}<span class="vali">*</span></label>
        @if ($form == 'edit')
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'email','disabled')) !!}
        @else
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'email')) !!}
        @endif

    </div>

    <div class="form-group col-md-6">
        <label class="form-control-label" for="contact_no">{{ __('labels.phone')}}<span class="vali">*</span></label>
        {!! Form::text('contact_no', null, array('placeholder' => 'Phone','class' => 'form-control','id' => 'contact_no', "required" 		=> "true")) !!}
    </div>
</div>

<p class="card-description"> Address </p>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="address_line1">{{ __('labels.address_line')}}<span class="vali">*</span></label>
        {!! Form::text('address_line1', null, array('placeholder' => 'Street Address','class'=> 'form-control','id' => 'address_line1', "required" 		=> "true"))!!}
		
		
    </div>
</div>

<!--div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="address_line2">{{ __('labels.address_line2')}}<span class="vali">*</span></label>
        {!! Form::text('address_line2', null, array('placeholder' => 'Address Line 2','class'=> 'form-control','id' => 'address_line2'))!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="city">{{ __('labels.city')}}<span class="vali">*</span></label>
        {!! Form::text('city', null, array('placeholder' => 'City','class'=> 'form-control','id' => 'city'))!!}
    </div>
    <div class="form-group col-md-6">
        <label class="form-control-label" for="state">{{ __('labels.state')}}<span class="vali">*</span></label>
        {!! Form::text('state', null, array('placeholder' => 'State','class'=> 'form-control','id' => 'state'))!!}
        <label id="state-error" for="state" class="error"></label>
    </div>
</div>


    <div class="form-group col-md-6">
        <label class="form-control-label" for="zipcode">{{ __('labels.zipcode')}}<span class="vali">*</span></label>
        {!! Form::text('zipcode', null, array('placeholder' => 'Zip Code','class'=> 'form-control','id' => 'zipcode'))!!}
    </div-->
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="country">{{ __('labels.country')}}<span class="vali">*</span></label>
        {!!
			Form::select(
				'country',
				$countries,
				isset($teacher->country) ? $teacher->country : '',
				array(
					'class' 		=> 'form-control',
					'placeholder' 	=> 'Select Country',
					"data-plugin" 	=> "selectpicker",
					"id" 			=> "country",
					"required" 		=> "true"
				)
			)
        !!}

        <label id="country-error" for="country" class="error"></label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-control-label" for="status">{{ __('labels.status')}}<span class="vali">*</span></label>
        <?php
            if(isset($teacher) && $teacher->status == 2) //Pending First Step
                $status = array('2' => 'Pending','5' => 'Approve Step 1', '6' => 'Archive');
            else if(isset($teacher) && $teacher->status == 5) //Approved first step
                $status = array('99' => '--Select--', '6' => 'Archive');
			else if(isset($teacher) && $teacher->status == 7) //Approved first step
                $status = array('6' => 'Archive');
            else if(isset($teacher) && $teacher->status == 8) //Pending Second Step
                $status = array('8' => 'Pending', '1' => 'Approve Step 2', '6' => 'Archive');
			else if(isset($teacher) && $teacher->status == 1) //Active
                $status = array('1' => 'Active', '3' => 'Inactive');		
            else
                $status = array('1' => 'Active', '3' => 'Inactive');

        ?>
        <select id="status" class="form-control" name="status" data-plugin="selectpicker">
            @foreach($status as $id => $value)
                @if(isset($teacher->status))
                    <option value="{{ $id }}" {{ ($teacher->status  == $id) ? ' selected' : '' }}>
                    {{ $value }}</option>
                @else
                    <option value="{{ $id }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
        {{-- {!! Form::select('status',
            !empty($teacher) ? array('1' => 'Active', '2' => 'Pending', '3' => 'Inactive', '4' => 'Deleted', '5' => 'Approved'):
            array('1' => 'Active', '2' => 'Pending', '3' => 'Inactive', '4' => 'Deleted', '5' => 'Approved'),
            isset($teacher->status)? $teacher->status : '',
            array(
                'placeholder' => 'Select Status',
                'class' => 'form-control',
                'id' => 'status'
            ))
        !!} --}}
    </div>
</div>

@if($form == "edit")
    <input type="hidden" id="max_global" name="max_global" value="{{$setting['max_globle_lesson_price']}}">
    <input type="hidden" name="max_virtual" id="max_virtual" value="{{$setting['max_vertual_lesson_price_per']}}">
    <input type="hidden" name="max_cafe" id="max_cafe" value="{{$setting['max_cafe_lesson_price_per']}}">
    <input type="hidden" name="max_classroom" id="max_classroom" value="{{$setting['max_classroom_lesson_price_per']}}">
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="hobby">{{ __('labels.hobby')}}<span class="vali">*</span></label>
            {!! Form::text('hobby', null, array('placeholder' => 'Hobby','class' => 'form-control','id' => 'hobby')) !!}
            <small id="tagsHelp" class="form-text text-muted">Please enter hobby (comma separated)</small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="form-group col-12 mb-0">
            <label class="form-control-label">{{ __('labels.highest_education_attained')}}</label>
            <br>
            <div class="row">
                @foreach($degrees as $key => $edu)
                    <div class="col-2">
                        <div class="form-check form-check-info">
                            <label class="form-check-label">
                                <input class="available-size name form-check-input"
                                <?= (!empty($highest_education) && in_array($key,$highest_education)) ?
                                'checked' : '' ?> name="highest_education[]" type="checkbox" value="<?= $key ?>">
                                {{ $edu }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <label id="highest_education-error" for="highest_education[]" class="error"></label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="major_subject">{{ __('labels.major')}}<span class="vali">*</span></label>
            {!! Form::text('major_subject', null, array('placeholder' => 'Major','class' => 'form-control','id' => 'major_subject')) !!}
        </div>
    </div>
    <div class="row mb-2">
        <div class="form-group col-12 mb-0">
            <label class="form-control-label">{{ __('labels.teaching_certification')}}<span class="vali">*</span></label>
            <br>
            <div class="row">
                @foreach($certificates as $key => $certificate)
                    <div class="col-2">
                        <div class="form-check form-check-info">
                            <label class="form-check-label">
                                <input class="available-size name form-check-input" <?= (!empty($teaching_certificate) && in_array($key,$teaching_certificate)) ? 'checked' : '' ?> name="teaching_certificate[]" type="checkbox" value="<?= $key ?>">
                                {{ $certificate }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <label id="teaching_certificate-error" for="teaching_certificate[]" class="error"></label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="teaching_year_begun">{{ __('labels.year_began_teaching')}}<span class="vali">*</span></label>
            {!! Form::text('teaching_year_begun', null, array('placeholder' => 'Year Began Teaching','class' => 'form-control','id' => 'teaching_year_begun')) !!}
        </div>
    </div>
    <div class="row mb-2">
        <div class="form-group col-12 mb-0">
            <label class="form-control-label">{{ __('labels.lesson_duration_able_to_teach')}}<span class="vali">*</span></label>
            <br>
            <div class="row">
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($lesson_minute_able_to_teach) && in_array('15',$lesson_minute_able_to_teach)) ? 'checked' : '' ?> name="lesson_minute_able_to_teach[]" type="checkbox" value="15">
                            15 Min
                        </label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($lesson_minute_able_to_teach) && in_array('25',$lesson_minute_able_to_teach)) ? 'checked' : '' ?> name="lesson_minute_able_to_teach[]" type="checkbox" value="25">
                            25 Min
                        </label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($lesson_minute_able_to_teach) && in_array('50',$lesson_minute_able_to_teach)) ? 'checked' : '' ?> name="lesson_minute_able_to_teach[]" type="checkbox" value="50">
                            50 Min
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <small id="tagsHelp" class="form-text text-muted">Students may book lessons back to back to create longer lesson duration. e.g. 25 + 50 = 75</small>
        </div>
        <div class="col-12">
            <label id="lesson_minute_able_to_teach-error" for="lesson_minute_able_to_teach[]" class="error"></label>
        </div>
    </div>

	<div class="form-group teaching_mode_jp_container d-none">
        <label>{{ __('labels.register_teaching_locations')}} <span class="vali">*</span></label>
        <div class="col-12">
            <div class="form-check form-check-info">
                <label class="form-check-label" id="teaching_mode_jp">
                    <input class="available-size name form-check-input" type="checkbox" name="teaching_locations[]"
                    id="classroom_teaching" value="classroom" <?= (!empty($teaching_locations) && in_array('classroom',$teaching_locations)) ? 'checked' : '' ?>>
                    Classroom
                </label>
            </div>
            <div class="form-check form-check-info">
                <label class="form-check-label" id="teaching_mode_jp">
                    <input class="available-size name form-check-input" type="checkbox" name="teaching_locations[]"
                    id="cafe_teaching" value="cafe" <?= (!empty($teaching_locations) && in_array('cafe',$teaching_locations)) ? 'checked' : '' ?>>
                    Cafe
                </label>
            </div>
            <div class="form-check form-check-info">
                <label class="form-check-label" id="teaching_mode_jp">
                    <input class="available-size name form-check-input" type="checkbox" name="teaching_locations[]"
                    id="online_teaching" value="online" <?= (!empty($teaching_locations) && in_array('online',$teaching_locations)) ? 'checked' : '' ?>>
                    Online
                </label>
            </div>
        </div>
    </div>
	
    <div class="row">
        <!--div class="form-group col-md-12">
            <label class="form-control-label" for="global_lesson_price">{{ __('labels.global_lesson_price')}}<span class="vali">*</span></label>
            <input type="text" class="form-control" name="global_lesson_price" placeholder="Global Lesson Price" id="global_lesson_price" value="{{!empty($teacher->global_lesson_price) ? round($teacher->global_lesson_price,2) : 0}}">
            {{-- {!! Form::text('global_lesson_price', null , array('placeholder' => 'Global Lesson Price','class' => 'form-control','id' => 'global_lesson_price')) !!} --}}
        </div-->
		
		<div class="form-group col-md-12">
			<?php
				$total_experience = date('Y') - $teacher->teaching_year_begun; 
				if($total_experience > 4) {
					$teacher_global_price = $setting['max_price_above_4_year'];
				} else if($total_experience > 2) {
					$teacher_global_price = $setting['max_price_upto_4_year'];
				} else {
					$teacher_global_price = $setting['max_price_upto_2_year'];
				}			
			?>
			<label class="form-control-label" for="global_lesson_price">{{ __('labels.accent_price')}}<span class="vali">*</span></label>
			<div>
				<input type="range" class="range_slide" style="width:100%;" min="0" max="{{$teacher_global_price}}" step="1" value="{{($teacher->global_lesson_price) ? $teacher->global_lesson_price : 0}}" onchange="changePercentageGlobal(this)" id="global_lesson_price" name="global_lesson_price" step="1" value="{{($teacher->global_lesson_price) ? $teacher->global_lesson_price : 0}}">
			</div>
			<div class="value" id="global_lesson_price_val">¥ {{($teacher->global_lesson_price)? $teacher->global_lesson_price : 0}}</div>
		</div>

    </div>
	

    <!--div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="virtual_lesson_percentage">{{ __('labels.virtual_lesson_percentage')}}</label>
            {!! Form::text('virtual_lesson_percentage', null, array('placeholder' => "Virtual Lesson Percentage",'class' => 'form-control','id' => 'virtual_lesson_percentage')) !!}
        </div>
    </div-->
	
	<!--div class="row">
		<div class="form-group  col-md-12">
				<label class="form-control-label" for="virtual_lesson_percentage">{{ __('labels.virtual_lesson_percentage')}}</label>
				<div id="virtual-room-lesson-range" class="ul-slider slider-success"></div>
				<p class="mt-3">Value: <span id="virtual-room-lesson-value"></span> %</p>
				<input type="hidden" name="virtual_lesson_percentage" id="virtual_lesson_percentage">
			
		</div>
	</div-->
    <!--div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="cafe_lesson_percentage">{{ __('labels.cafe_lesson_percentage')}}</label>
            {!! Form::text('cafe_lesson_percentage', null, array('placeholder' => 'Cafe Lesson Percentage','class' => 'form-control','id' => 'cafe_lesson_percentage')) !!}
        </div>
    </div-->
	<!--div class="row">
		<div class="form-group  col-md-12">
				<label class="form-control-label" for="cafe_lesson_percentage">{{ __('labels.cafe_lesson_percentage')}}</label>
				<div id="cafe-room-lesson-range" class="ul-slider slider-success"></div>
				<p class="mt-3">Value: <span id="cafe-room-lesson-value"></span> %</p>
				<input type="hidden" name="cafe_lesson_percentage" id="cafe_lesson_percentage">
			
		</div>
	</div>
	<div class="row">
		<div class="form-group  col-md-12">
				<label class="form-control-label" for="classroom_lesson_percentage">{{ __('labels.classroom_lesson_percentage')}}</label>
				<div id="class-room-lesson-range" class="ul-slider slider-success"></div>
				<p class="mt-3">Value: <span id="class-room-lesson-value"></span> %</p>
				<input type="hidden" name="classroom_lesson_percentage" id="classroom_lesson_percentage">
			
		</div>
	</div-->
	<?php
		$hide = ' d-none';
		if(!empty($teacher->teaching_locations)) {
			$teaching_locations = explode(',', $teacher->teaching_locations);
			if(in_array('classroom', $teaching_locations)) { 
				$hide = '';
			} else {
				$hide = ' d-none';
			}
		}
	?>	
	<div id="kids_lesson_price_div" class="row {{ $hide }}">
	   <div class="form-group col-md-12">
			<label class="form-control-label" for="kids_lesson_price">{{ __('labels.kids_lesson_price')}}</label>
			<div>
				<input type="range" class="range_slide" style="width:100%;" min="0" max="{{$setting['kids_lesson_max_price']}}" step="1" value="{{($teacher->kids_lesson_price) ? $teacher->kids_lesson_price : 0}}" onchange="changePercentageGlobal(this)" id="kids_lesson_price" name="kids_lesson_price" step="1" value="{{($teacher->kids_lesson_price) ? $teacher->kids_lesson_price : 0}}">
			</div>
			<div class="value" id="kids_lesson_price_val">¥ {{($teacher->kids_lesson_price)? $teacher->kids_lesson_price : 0}}</div>
		</div>
	</div>
	
	@if($teacher->id == env('RYAN_USER_ID'))
		<div class="row">
		   <div class="form-group col-md-12">
				<label class="form-control-label" for="aspire_lesson_price">{{ __('labels.aspire_lesson_price')}}</label>
				<div>
					<input type="range" class="range_slide" style="width:100%;" min="0" max="{{$setting['aspire_lesson_max_price']}}" step="1" value="{{($teacher->aspire_lesson_price) ? $teacher->aspire_lesson_price : 0}}" onchange="changePercentageGlobal(this)" id="aspire_lesson_price" name="aspire_lesson_price" step="1" value="{{($teacher->aspire_lesson_price) ? $teacher->aspire_lesson_price : 0}}">
				</div>
				<div class="value" id="aspire_lesson_price_val">¥ {{($teacher->aspire_lesson_price)? $teacher->aspire_lesson_price : 0}}</div>
			</div>
		</div>
	@endif
   <!--<div class="row mb-2 teaching_mode_remote_container">
        <div class="form-group col-12 mb-0">
            <label class="form-control-label" id="teaching_mode_remote">{{-- {{ __('labels.teaching_mode')}} --}}</label>
            <br>
            <div class="row">
                <div class="col-4">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" {{-- <?= $teacher->is_remote_teaching == 1 ? 'checked' : '' ?> --}} name="is_remote_teaching" type="checkbox" value="1">
                            Remote
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label id="is_remote_teaching-error" for="is_remote_teaching" class="error"></label>
        </div>
    </div> -->

    <div class="form-group teaching_mode_remote_container">
        <label>{{ __('labels.teaching_mode')}}</label><br>
        <div class="col-4">
            <div class="form-check form-check-info">
                <label class="form-check-label" id="teaching_mode_remote">
                    <input class="available-size name form-check-input" <?= $teacher->is_remote_teaching == 1 ? 'checked' : '' ?> name="is_remote_teaching" type="checkbox" id="is_remote_teaching" value="1">
                    Remote
                </label>
            </div>
        </div>
       {{--  <label class="form-check-label" id="teaching_mode_remote">
          <input type="checkbox" class="available-size name form-check-input" name="is_remote_teaching" id="remote_teaching" value="1">
         Remote
        </label> --}}
    </div>

    <div class="row d-none" id="skype_container">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="skype_id"> {{ __('labels.skype_id')}}<span class="vali">*</span></label>
            {!! Form::text('skype_id', $teacher->skype_id, array('placeholder' => 'Skype ID','class' => 'form-control','id' => 'skype_id')) !!}
        </div>
    </div>

    <div class="row d-none" id="internet_link_container">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="internet_connection_speed_link">
            {{ __('labels.internet_connection_speed')}}</label>
            {!! Form::text('internet_connection_speed_link', $teacher->internet_connection_speed_link, array('placeholder' => 'Internet Connection Speed','class' => 'form-control','id' => 'internet_connection_speed_link')) !!}
            <small id="tagsHelp" class="form-text text-muted">Use http://www.speedtest.net/, click "Share", choose "Image" then copy and paste the link here.</small>
        </div>
    </div>

    <div class="row mb-2">
        <div class="form-group col-12 mb-0">
            <label class="form-control-label">{{ __('labels.japanese_ability')}}<span class="vali">*</span></label>
            <br>
            <div class="row">
                @foreach($abilities as $key => $ability)
                    <div class="col-2">
                        <div class="form-check form-check-info">
                            <label class="form-check-label">
                                <input class="available-size name form-check-input" <?= ($teacher->japanese_ability == $key) ? 'checked' : '' ?> name="japanese_ability" type="radio" value="<?= $key ?>">
                                {{ $ability }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <label id="japanese_ability-error" for="japanese_ability" class="error"></label>
        </div>
    </div>
    <div class="row">
        <div class="form-group d-none col-md-12" id="jplt_score_container">
            <label class="form-control-label" for="jplt_score">{{ __('labels.jplt_score')}}<span class="vali">*</span></label>
            {!! Form::text('jplt_score', null, array('placeholder' => 'JPLT Score','class' => 'form-control','id' => 'jplt_score')) !!}
        </div>
    </div>

    <div class="row mb-2">
        <div class="form-group col-12 mb-0">
            <label class="form-control-label">{{ __('labels.preferred_interview_method')}}</label>
            <br>
            <div class="row">
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input"  <?= ($teacher->preferred_interview_method == "remote") ? 'checked' : '' ?> name="preferred_interview_method" type="radio" value="remote">
                            Remote
                        </label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= ($teacher->preferred_interview_method == "personal") ? 'checked' : '' ?> name="preferred_interview_method" type="radio" value="personal">
                            Personal
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label id="preferred_interview_method-error" for="preferred_interview_method" class="error"></label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            <label class="form-control-label" for="message_en">{{ __('labels.message_en')}}</label>
            <textarea class="form-control" name="message_en" placeholder="Message to Student" rows="6"
            id="message_en"><?= isset($teacher->message_en) ? $teacher->message_en : '' ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            <label class="form-control-label" for="message_jp">{{ __('labels.message_jp')}}</label>
            <textarea class="form-control" name="message_jp" placeholder="Message to Student in JA" rows="6"
            id="message_jp"><?= isset($teacher->message_jp) ? $teacher->message_jp : '' ?></textarea>
        </div>
    </div>

    <div class="row mb-2">
        <div class="form-group col-12 mb-0">
            <br>
            <div class="row">
                <div class="col-4">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= $teacher->is_ambassador == 1 ? 'checked' : '' ?> name="is_ambassador" type="checkbox" value="1">
                            Is Ambassador?
                        </label>
						<input type="text" name="per_hour_salary" placeholder="Per hour salary" class="form-control <?php if($teacher->is_ambassador == 1){ echo 'd-none';}?>" value="<?php if($teacher->is_ambassador == 1) { echo '0.00';} else { echo $teacher->per_hour_salary; }?>" id="per_hour_salary" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label id="is_ambassador-error" for="is_ambassador" class="error"></label>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-6">
            <label>{{ __('labels.audio_file')}}</label>
            <div class="file-upload">
                <div class="file-select">
                  {{--   <div class="file-select-button" id="fileName">Choose file</div>
                    <div class="file-select-name" id="noFile">Upload your audio here</div> --}}
                    <input type="file" name="audio_attachment" id="audio_attachment">
                </div>
            </div>
            <label id="audio_attachment-error" class="error" for="audio_attachment" style="display: none;"></label>
            {{-- <p>Supported audio formats are .Mp4, .Mp3</p> --}}
        </div>
    </div>
    <p class="card-description"> FreshBooks Client Details </p>

    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="freshbook_user_id">Freshbook User ID</label>
            {!! Form::text('freshbook_user_id', null, array('placeholder' => 'Freshbook User ID','class' => 'form-control','id' => 'freshbook_user_id')) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-control-label" for="onepage_certified">{{ __('labels.is_teacher_verified')}}</label>
            <div class="row">
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="1"  name="is_teacher_verified" type="radio"
                           <?= (!empty($teacher) && $teacher->teacher_verified == 1) ? 'checked' : '' ?>> Yes
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="0" id="no" name="is_teacher_verified" type="radio"
                            <?= (!empty($teacher) && $teacher->teacher_verified == '0') ? 'checked' : '' ?>> No
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-control-label" for="onepage_certified">{{ __('labels.onepage_certified')}}</label>
            <div class="row">
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="1" name="onepage_certified" type="radio"
                           <?= (!empty($teacher) && $teacher->onepage_certified == 1) ? 'checked' : '' ?>> Yes
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="0"  name="onepage_certified" type="radio"
                            <?= (!empty($teacher) && $teacher->onepage_certified == '0') ? 'checked' : '' ?>> No
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-control-label" for="coaching_certified">{{ __('labels.coaching_certified')}}</label>
            <div class="row">
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="1" name="coaching_certified" type="radio"
                           <?= (!empty($teacher) && $teacher->coaching_certified == 1) ? 'checked' : '' ?>> Yes
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="form-check-input" value="0" name="coaching_certified" type="radio"
                            <?= (!empty($teacher) && $teacher->coaching_certified == '0') ? 'checked' : '' ?>> No
                            <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12 mb-0">
            <label class="form-control-label">{{ __('labels.teaching_category')}}</label>
            <br>
            <div class="row">
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($teaching_category) && in_array('basic',$teaching_category)) ? 'checked' : '' ?> name="teaching_category[]" type="checkbox" value="basic">
                            BASIC
                        </label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($teaching_category) && in_array('complete',$teaching_category)) ? 'checked' : '' ?> name="teaching_category[]" type="checkbox" value="complete">
                            COMPLETE
                        </label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($teaching_category) && in_array('pro',$teaching_category)) ? 'checked' : '' ?> name="teaching_category[]" type="checkbox" value="pro">
                            PRO
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12 mt-4">
            <label class="form-control-label" for="freshbook_api_url">
            {{ __('labels.freshbook_api_url')}}</label>
            {!! Form::text('freshbook_api_url', null, array('placeholder' => 'Freshbook API URL','class' => 'form-control','id' => 'freshbook_api_url')) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="freshbook_token">
            {{ __('labels.freshbook_token')}}</label>
            {!! Form::text('freshbook_token', null, array('placeholder' => 'Freshbook API Token','class' => 'form-control','id' => 'freshbook_token')) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="freshbook_task_id">{{ __('labels.freshbook_task_id')}}</label>
            {!! Form::text('freshbook_task_id', null, array('placeholder' => 'Freshbook Task ID','class' => 'form-control','id' => 'freshbook_task_id')) !!}
        </div>
    </div>
     <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="line_token">{{ __('labels.line_token')}}</label>
            {!! Form::text('line_token', null, array('placeholder' => 'Line Token','class' => 'form-control','id' => 'line_token')) !!}
        </div>
    </div>
    {{--<div class="row">--}}
        {{--<div class="form-group col-md-12">--}}
            {{--<label class="form-control-label" for="freshbook_task_id">{{ __('labels.freshbook_task_id')}}</label>--}}
            {{--{!! Form::text('freshbook_task_id', null, array('placeholder' => 'Freshbook User ID','class' => 'form-control','id' => 'freshbook_task_id')) !!}--}}
        {{--</div> --}}
    {{--</div> --}}
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-control-label" for="paypal_email">{{ __('labels.paypal_email')}}</label>
            {!! Form::text('paypal_email', null, array('placeholder' => 'Paypal Email','class' => 'form-control','id' => 'paypal_email')) !!}
        </div>
    </div>
     <div class="row">
        <div class="form-group col-6 mb-0">
            <div class="form-check form-check-info">
                <label class="form-check-label">
                    <input class="available-size name form-check-input"
                    <?= (!empty($teacher) && $teacher->temporarily_unavailable == 1) ? 'checked' : '' ?> name="temporarily_unavailable" type="checkbox" value="1">
                    Temporarily Unavailable
                </label>
            </div>
        </div>
        <div class="form-group col-6 mb-0">
            <div class="form-check form-check-info">
               <label class="form-check-label">
                    <input class="available-size name form-check-input"
                    <?= (!empty($teacher) && $teacher->is_available_in_trial == 1) ? 'checked' : '' ?>
                    name="is_available_in_trial" type="checkbox" value="1">
                     Is Available in Trial?
                </label>
            </div>
        </div>
        {{-- <div class="form-group col-6 mb-0">
            <div class="form-check form-check-info">
                <label class="form-check-label">
                    <input class="available-size name form-check-input"
                    <?//= (!empty($teacher) && $teacher->is_teacher_salary_based) == 1 ? 'checked' : '' ?> name="is_teacher_salary_based" type="checkbox" value="1">
                   Is Teacher Salary Based?
                </label>
            </div>
        </div> --}}
    </div>
    <div class="row ">
        <div class="form-group col-6 mb-4">
            <div class="form-check form-check-info">
                <label class="form-check-label">
                    <input class="available-size name form-check-input"
                    {{(!empty($teacher) && $teacher->publish_profile) == 1 ? 'checked' : '' }} name="publish_profile" type="checkbox" value="1">
                   Publish Profile?
                </label>
            </div>
        </div>
        <div class="form-group col-6 mb-4">
            <div class="form-check form-check-info">
                <label class="form-check-label">
                    <input class="available-size name form-check-input"
                    {{(!empty($teacher) && $teacher->in_training) == 1 ? 'checked' : '' }} name="in_training" type="checkbox" value="1">
                   Under Probation?
                </label>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="form-group col-6 mb-4">
            <div class="form-check form-check-info">
                <label class="form-check-label">
                    <input class="available-size name form-check-input"
                    {{(!empty($teacher) && $teacher->is_training_completed) == 1 ? 'checked' : '' }} name="is_training_completed" type="checkbox" value="1">
						{{ __('admin_labels.is_training_completed') }}
                </label>
            </div>
        </div>
    </div>
@endif
<?php /*
<p class="card-description">  Education  </p>
<div class="row mb-2">
    <div class="form-group col-12 mb-0">
        <label class="form-control-label">Highest Education Attained</label>
        <br>
        <div class="row">
            @foreach($degrees as $key => $edu)
                <div class="col-2">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($candidateIssues) && in_array($key,$candidateIssues)) ? 'checked' : '' ?> name="highest_education[]" type="checkbox" value="<?= $key ?>">
                            {{ $edu }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-12">
        <label id="highest_education-error" for="highest_education[]" class="error"></label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="major_subject">Major<span class="vali">*</span></label>
        {!! Form::text('major_subject', null, array('placeholder' => 'Major','class' => 'form-control','id' => 'major_subject')) !!}
    </div>
</div>

<div class="row mb-2">
    <div class="form-group col-12 mb-0">
        <label class="form-control-label">Teaching Certification<span class="vali">*</span></label>
        <br>
        <div class="row">
            @foreach($certificates as $key => $certificate)
                <div class="col-2">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($candidateIssues) && in_array($key,$candidateIssues)) ? 'checked' : '' ?> name="teaching_certificate[]" type="checkbox" value="<?= $key ?>">
                            {{ $certificate }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-12">
        <label id="teaching_certificate-error" for="teaching_certificate[]" class="error"></label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="teaching_year_begun">Year Began Teaching<span class="vali">*</span></label>
        {!! Form::text('teaching_year_begun', null, array('placeholder' => 'Year Began Teaching','class' => 'form-control','id' => 'teaching_year_begun')) !!}
    </div>
</div>

<div class="row mb-2">
    <div class="form-group col-12 mb-0">
        <label class="form-control-label">Japanese Ability<span class="vali">*</span></label>
        <br>
        <div class="row">
            @foreach($abilities as $key => $ability)
                <div class="col-2">
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            <input class="available-size name form-check-input" <?= (!empty($candidateIssues) && in_array($key,$candidateIssues)) ? 'checked' : '' ?> name="japanese_ability" type="radio" value="<?= $key ?>">
                            {{ $ability }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-12">
        <label id="japanese_ability-error" for="japanese_ability" class="error"></label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="jplt_score">JPLT Score<span class="vali">*</span></label>
        {!! Form::text('jplt_score', null, array('placeholder' => 'JPLT Score','class' => 'form-control','id' => 'jplt_score')) !!}
    </div>
</div>

<div class="row mb-2">
    <div class="form-group col-12 mb-0">
        <label class="form-control-label">Teaching Mode(S)</label>
        <br>
        <div class="row">
            <div class="col-4">
                <div class="form-check form-check-info">
                    <label class="form-check-label">
                        <input class="available-size name form-check-input" <?= (!empty($candidateIssues) && in_array($key,$candidateIssues)) ? 'checked' : '' ?> name="is_remote_teaching" type="checkbox" value="1">
                        Remote
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <label id="japanese_ability-error" for="japanese_ability" class="error"></label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="skype_id">Skype ID<span class="vali">*</span></label>
        {!! Form::text('skype_id', null, array('placeholder' => 'Skype ID','class' => 'form-control','id' => 'skype_id')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="internet_connection_speed_link">Internet Connection Speed<span class="vali">*</span></label>
        {!! Form::text('internet_connection_speed_link', null, array('placeholder' => 'Internet Connection Speed','class' => 'form-control','id' => 'internet_connection_speed_link')) !!}
        <small id="tagsHelp" class="form-text text-muted">Use http://www.speedtest.net/, click "Share", choose "Image" then copy and paste the link here.</small>
    </div>
</div>


<div class="row mb-2">
    <div class="form-group col-12 mb-0">
        <label class="form-control-label">Lesson duration able to teach<span class="vali">*</span></label>
        <br>
        <div class="row">
            <div class="col-3">
                <div class="form-check form-check-info">
                    <label class="form-check-label">
                        <input class="available-size name form-check-input" <?= (!empty($candidateIssues) && in_array($key,$candidateIssues)) ? 'checked' : '' ?> name="lesson_minute_able_to_teach[]" type="checkbox" value="15">
                        15 Min
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check form-check-info">
                    <label class="form-check-label">
                        <input class="available-size name form-check-input" <?= (!empty($candidateIssues) && in_array($key,$candidateIssues)) ? 'checked' : '' ?> name="lesson_minute_able_to_teach[]" type="checkbox" value="25">
                        25 Min
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check form-check-info">
                    <label class="form-check-label">
                        <input class="available-size name form-check-input" <?= (!empty($candidateIssues) && in_array($key,$candidateIssues)) ? 'checked' : '' ?> name="lesson_minute_able_to_teach[]" type="checkbox" value="50">
                        50 Min
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <small id="tagsHelp" class="form-text text-muted">Students may book lessons back to back to create longer lesson duration. e.g. 25 + 50 = 75</small>
    </div>
    <div class="col-12">
        <label id="lesson_minute_able_to_teach-error" for="lesson_minute_able_to_teach[]" class="error"></label>
    </div>
</div>
*/ ?>
{{-- <div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="hobby">Hobby<span class="vali">*</span></label>
        {!! Form::text('hobby', null, array('placeholder' => 'Hobby','class' => 'form-control','id' => 'hobby')) !!}
        <small id="tagsHelp" class="form-text text-muted">Please enter hobby (comma separated)</small>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="globe_lesson_price">Global Lesson Price<span class="vali">*</span></label>
        {!! Form::text('globe_lesson_price', null, array('placeholder' => 'Global Lesson Price','class' => 'form-control','id' => 'globe_lesson_price')) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="virtual_lesson_percentage">Virtual Lesson Percentage (%)</label>
        {!! Form::text('virtual_lesson_percentage', null, array('placeholder' => 'Hobby','class' => 'form-control','id' => 'virtual_lesson_percentage')) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="cafe_lesson_percentage">Cafe Lesson Percentage (%)</label>
        {!! Form::text('cafe_lesson_percentage', null, array('placeholder' => 'Hobby','class' => 'form-control','id' => 'cafe_lesson_percentage')) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-control-label" for="classroom_lesson_percentage">Classroom Lesson Percentage (%)</label>
        {!! Form::text('classroom_lesson_percentage', null, array('placeholder' => 'Hobby','class' => 'form-control','id' => 'classroom_lesson_percentage')) !!}
    </div>
</div> --}}

<div class="row">
    <div class="form-group col-md-2">
        {!! Form::submit('Submit',array('class'=>'btn btn-gradient-primary btn-rounded btn-fw','id' => 'submit_btn')) !!}
    </div>
    <div class="form-group col-md-2">
        {!! Form::button('Cancel',array('class'=>'btn btn-gradient-secondary btn-rounded btn-fw','onclick'=>"window.location.href='".url('admin/teachers')."'")) !!}
    </div>
</div>

<style>
    .dropify-wrapper label.error2 {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
    }

    .dropify-wrapper label.error {
        display: inherit;
        z-index: 2;
        position: relative;
        top: 60px;
    }

    span.text-label {
        padding-right: 5px;
    }

    .form-group label {
        font-size: 14px;
        line-height: 1;
        vertical-align: top;
        margin-bottom: .5rem;
        font-weight: 600;
    }

    .form-group p {
        font-size: 14px;
    }

    .chk-fix-scroll{
        max-height: 200px;
        overflow-y:scroll;
        border: 1px solid;
        border-radius: 5px;
    }

    .chk-fix-scroll.register-locations .form-check, .chk-fix-scroll.register-services .form-check{
        margin: 10px !important;
        display: block !important;;
    }
</style>
@push('scripts')
	<script>
		function changePercentageGlobal(dis) {
			console.log($(dis).val());
			var id = $(dis).attr('id') + '_val';
			var val = $(dis).val();
			console.log(val + ' %');
			$('#'+id).text('￥' + val);
		}
		$(document).ready(function() {
			$('#classroom_teaching').on('click', function(e){
				if($('#classroom_teaching').is(":checked")) {
					$('#kids_lesson_price_div').removeClass('d-none');
				} else {
					$('#kids_lesson_price_div').addClass('d-none');
					$('#kids_lesson_price').val(0);
				}
                
			});
		});
		
		if ($("#class-room-lesson-range").length) {
			var classbigValueSlider = document.getElementById('class-room-lesson-range'),
				classbigValueSpan = document.getElementById('class-room-lesson-value');
			noUiSlider.create(classbigValueSlider, {
				start: {{ !empty($teacher->classroom_lesson_percentage) ? $teacher->classroom_lesson_percentage : 0 }},
				step: 1,
				range: {min: 0, max: 100}
			});
			classbigValueSlider.noUiSlider.on('update', function (values, handle) {
				console.log(Math.floor(values));
				classbigValueSpan.innerHTML = Math.floor(values);
				$('#classroom_lesson_percentage').val(Math.floor(values))
			});
		}
		
		if ($("#cafe-room-lesson-range").length) {
			var cafebigValueSlider = document.getElementById('cafe-room-lesson-range'),
				cafebigValueSpan = document.getElementById('cafe-room-lesson-value');
			noUiSlider.create(cafebigValueSlider, {
				start: {{ !empty($teacher->cafe_lesson_percentage) ? $teacher->cafe_lesson_percentage : 0 }},
				step: 1,
				range: {min: 0, max: 100}
			});
			cafebigValueSlider.noUiSlider.on('update', function (values, handle) {
				console.log(Math.floor(values));
				cafebigValueSpan.innerHTML = Math.floor(values);
				$('#cafe_lesson_percentage').val(Math.floor(values))
			});
		}
		
		
		
		if ($("#virtual-room-lesson-range").length) {
			var virtualbigValueSlider = document.getElementById('virtual-room-lesson-range'),
				virtualbigValueSpan = document.getElementById('virtual-room-lesson-value');
			noUiSlider.create(virtualbigValueSlider, {
				start: {{ !empty($teacher->virtual_lesson_percentage) ? $teacher->virtual_lesson_percentage : 0 }},
				step: 1,
				range: {min: 0, max: 100}
			});
			virtualbigValueSlider.noUiSlider.on('update', function (values, handle) {
				console.log(Math.floor(values));
				virtualbigValueSpan.innerHTML = Math.floor(values);
				$('#virtual_lesson_percentage').val(Math.floor(values))
			});
		}
	</script>
@endpush