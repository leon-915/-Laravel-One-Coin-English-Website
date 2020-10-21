
<h4>Basic Profile</h4>

{!! Form::model('personal-info', ['method' => 'POST','name'=>'personal-info',  'id'=>'personal-info','route' => ['teachers.profile.info.save'],'autocomplete' => "off","enctype"=>"multipart/form-data",'class' => 'form_field']) !!}
<div class="row">

    <div class="col-12">
        <div class="form-group">
            <label>{{ __('labels.first_name')}}<span>*</span></label>
            <input type="text" class="form-control" name="firstname" id="firstname" value="{{$teacher->firstname}}">
        </div>
	</div>
	<div class="col-12">
        <div class="form-group">
            <label>{{ __('labels.last_name')}}<span>*</span></label>
            <input type="text" class="form-control" name="lastname" id="lastname" value="{{$teacher->lastname}}">
        </div>
    </div>
	
	<div class="col-12">
        <div class="form-group">
			<label>{{ __('labels.gender')}}<span>*</span></label>
			<label class="checkcontainer">
				<input type="radio" {{$teacherDetails->gender == '' || $teacherDetails->gender == 'male' ? 'checked' : ''}} name="gender" value="male">
				Male
				<span class="radiobtn"></span>
			</label>
			<label class="checkcontainer">
				<input type="radio" {{$teacherDetails->gender == 'female' ? 'checked' : ''}} name="gender" value="female">
				Female
				<span class="radiobtn"></span>
			</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-group">
			<label>{{ __('labels.birthdate')}}<span>*</span></label>
			<input type="text" class="form-control" id="dob" name="dob" value="{{$teacherDetails->dob}}">
		</div>	
	</div>

    <div class="row ml-2" id="cimage">
        <div class="form-group col-md-12" >
            <label class="form-control-label" for="image">{{ __('labels.profile_image')}}</label>
           <?php
                $image = asset('images/default.png');
                if(!empty($teacher->profile_image)){
                    $image = asset($teacher->profile_image);
                }

            ?>
            <div id="upload-demo"></div>
            <label id="croppie-image-upload">
                <input type="file" id="image"  data-default-file="{{ $image }}" style="display: none">
                <div class="input-group col-xs-12">
                    <input class="form-control file-upload-info" disabled="" placeholder="Upload Image" type="text">
                    <span class="input-group-append file-upload-browse">
                        <button class="freetrial_btn" type="button">Select Image</button>
                    </span>
                </div>
                <label id="image-error" class="error d-none" for="image"></label>
            </label>
        </div>

        <input type="hidden" name="image">
        <input type="hidden" id="url" value="{{$image}}">
    </div>
	
	<div class="col-12">
        <div class="form-group">
            <label>{{ __('labels.nationality')}}<span>*</span></label>
            {!!
                Form::select(
                    'nationality',
                    $countries,
                    $teacherDetails->nationality,
                    array(
                        'class' 		=> 'form-control',
                        'placeholder' 	=> 'Select Country',
                        "data-plugin" 	=> "selectpicker",
                        "id" 			=> "nationality",
                        "required" 		=> "true"
                    )
                )
            !!}
        </div>
    </div>
	
	<div class="col-12">
		<div class="form-group">
			<label>{{ __('labels.do_you_reside_in_japan')}}<span>*</span></label>
				@foreach($japanese_resident as $key => $resident)
                    @php
                        $checkedA = ($key == $teacherDetails->japanese_resident) ? 'checked' : '';
                    @endphp
                    <label class="checkcontainer">
                    <input type="radio" name="japanese_resident" {{ $checkedA }} value="<?= $key ?>">
                        {{ $resident }}
                        <span class="radiobtn"></span>
                    </label>
                @endforeach
			<label id="japanese_resident-error" class="error" for="japanese_resident"  style="display: none;"></label>
		</div>
	</div>
	
	<div id="address_line_div" class="col-12 d-none">
		<div class="form-group">
            <label>{{ __('labels.address_line')}}<span>*</span></label>
			<input type="text" name="address_line1" value="{{$teacherDetails->address_line1}}" id="autocomplete" class="form-control" required="">
        </div>
	</div>
	
	<div class="col-12">
		<div class="form-group">
			<label>{{ __('labels.own_realstate_in_japan')}}<span>*</span></label>
			@foreach($own_realstate_in_japan as $key => $resident)
				@php
					$checkedA = ($key == $teacherDetails->own_realstate_in_japan) ? 'checked' : '';
				@endphp
				<label class="checkcontainer">
				<input type="radio" name="own_realstate_in_japan" {{ $checkedA }} value="<?= $key ?>">
					{{ $resident }}
					<span class="radiobtn"></span>
				</label>
			@endforeach
				
			<label id="own_realstate_in_japan-error" class="error" for="own_realstate_in_japan"  style="display: none;"></label>
		</div>
	</div>
	
	<div class="col-12">
        <div class="form-group">
            <label>{{ __('labels.occupation')}}<span>*</span></label>
            <input type="text" class="form-control" name="occupation" id="occupation" value="{{$teacherDetails->occupation}}">
        </div>
    </div>	

	<div class="col-12">
		<div class="form-group">
			<label>{{ __('labels.conversation_topic')}}</label>
			@foreach($conversation_topic as $ckey => $topic)
				@php
					$checkedC = in_array($ckey, explode(',', $teacherDetails->conversation_topic)) ? 'checked' : '';
				@endphp
				<label class="checkcontainer">
					{{ $topic }}
					<input type="checkbox" name="conversation_topic[]" {{ $checkedC }}  value="<?= $ckey ?>">
					<span class="checkmark"></span>
				</label>
			@endforeach
		</div>
	</div>
	
	<div class="col-12">
		<div class="form-group">
                <label>{{ __('labels.message_en')}}<span>*</span></label>
                <textarea name="message_en" placeholder="">{{ !empty($teacherDetails->message_en) ? $teacherDetails->message_en : ''}}</textarea>
            </div>
	</div>
	
	<div class="col-12">
        <div class="form-group">
            <label>{{ __('labels.audio_file')}}</label>
			<?php
			if($teacherDetails->audio_attachment !='') { ?>
				 <audio controls>
				  <source src="{{ url($teacherDetails->audio_attachment)}}" type="audio/mp3">
				Your browser does not support the audio element.
				</audio> 
			<?php }
			?>
            <div class="file-upload">
                <div class="file-select">
                    <div class="file-select-button" id="fileName">Choose file</div>
                    <div class="file-select-name" id="noFile">Upload your audio here</div>
                    <input type="file" name="audio_attachment" class="custom-file-upload" id="audio_attachment">
                </div>
            </div>
            <label id="audio_attachment-error" class="error" for="audio_attachment"  style="display: none;"></label>
			<input type="hidden" name="saved_audio_attachment" id="saved_audio_attachment" value="<?php echo $teacherDetails->audio_attachment;?>">
            {{-- <p>Supported audio formats are .Mp4, .Mp3</p> --}}
        </div>
	</div>	

	<div class="col-12 form-group">
		<label>Introductory video</label>
		<?php
		if($teacher->video !='') { ?>
			<video width="320" height="240" controls>
				<source src="{{$teacher->video}}" type="video/mp4">
			</video> 
		<?php }
		?>
		
		<div class="attachments">
			<div class="file-select">
				<div class="file-select-button">Update Video</div>
				<input type="file" name="video" class="custom-file-upload" id="video">
			</div>
		</div>
		<label id="video-attachments-error" class="error" for="video"
			   style="display: none;"></label>
		<p>.mp4 format is allowed. Video should not be more than 5MB in size.</p>
	</div>
	
	<div class="col-12">
		<div class="form-group">
			<label>{{ __('labels.english_language_specialization')}}</label>
			@foreach($english_language_specialization as $ckey => $specialization)
				@php
					$checkedC = in_array($ckey, explode(',', $teacherDetails->english_language_specialization)) ? 'checked' : '';
				@endphp
				<label class="checkcontainer">
					{{ $specialization }}
					<input type="checkbox" name="english_language_specialization[]" {{ $checkedC }}  value="<?= $ckey ?>">
					<span class="checkmark"></span>
				</label>
			@endforeach
		</div>
	</div>
	
    
	
	<div class="col-12">
		<div class="form-group">
			<label>{{ __('labels.teaching_english_in')}}</label>
			@foreach($teaching_english_in as $ckey => $values)
				@php
					$checkedC = in_array($ckey, explode(',', $teacherDetails->teaching_english_in)) ? 'checked' : '';
				@endphp
				<label class="checkcontainer">
					{{ $values }}
					<input type="checkbox" name="teaching_english_in[]" {{ $checkedC }}  value="<?= $ckey ?>">
					<span class="checkmark"></span>
				</label>
			@endforeach
		</div>
	</div>
	
	<div class="col-12 mt-3">
		<h4>Availability</h4>
	</div>

	<div class="col-12">
		<div class="form-group">
			<label>{{ __('labels.available')}}<span>*</span></label>
				@foreach($is_available as $key => $value)
                    @php
                        $checkedA = ($key == $teacherDetails->is_available) ? 'checked' : '';
                    @endphp
                    <label class="checkcontainer">
                    <input type="radio" name="is_available" {{ $checkedA }} value="<?= $key ?>">
                        {{ $value }}
                        <span class="radiobtn"></span>
                    </label>
                @endforeach
			<label id="is_available-error" class="error" for="is_available"  style="display: none;"></label>
		</div>
	</div>


    <div class="col-12 mt-3">
        <h4>Api Settings</h4>
    </div>

	
    <div class="col-12">
        <div class="form-group half">
            <label for="paypal_email">{{ __('Paypal Email Id')}}</label>
            {!! Form::text('paypal_email', $teacher->paypal_email, array('placeholder' => __('Paypal Email'),'class'=> 'form-control','id' => 'paypal_email'))!!}
        </div>
    </div>
	
    <div class="col-12">
        <div class="form-group half">
            <label for="line_reply_token">{{ __('labels.line_token')}}</label>
            {!! Form::text('line_reply_token', $teacher->line_reply_token, array('placeholder' => __('labels.line_reply_token'),'class'=> 'form-control','id' => 'line_reply_token'))!!}
        </div>
    </div>
	
	
	@if($teacher->send_line_notifications == 1)
	<div class="col-12">
		<div class="form-group half">
			<label class="checkcontainer">
				{{ __('labels.optin_here_to_enable_line_qr_code_popup') }}
				<input type="checkbox" name="disable_lineNotification" id="disable_lineNotification" value="{{Auth::id()}}">
				<span class="checkmark"></span>
			</label>

		</div>
	</div>
	@endif

    <div class="col-12">
        <div class="profile_full">
            <div class="submit_register change_pass">
                <div class="submit_btn">
                    <button type="submit" class="btnsub_arr">Submit</button>
                </div>
                <div class="submit_btn chnage_pass float-left">
                    <a href="{{ route('teachers.profile.change.password') }}" class="btnsub_arr">Change Password</a>
                </div>
            </div>
        </div>
    </div>
	
	<div class="col-12">
            <div class="profile_full">
                <div class="submit_register delete_account">
                    <div class="submit_btn  float-right" id="delete_account">
                        <a href="{{ route('teachers.profile.delete.account') }}" id="delete_teacher" style="background:#F00;" class="btnsub_arr" data-url="{{ route('teachers.profile.delete.account') }}">Delete Account</a>
                    </div>
                </div>
            </div>
        </div>

</div>

<style>
/*.cr-slider {
    -webkit-appearance: none !important;
    width: 300px !important;
    max-width: 100% !important;
    padding-top: 8px !important;
    padding-bottom: 8px !important;
    background-color: transparent !important;
}*/

.profile_form.pro_information input[type="range"] {
  display: block;
  -webkit-appearance: none;
  background-color: #f5f5f5;
  width: 100%;
  height: 5px;
  border-radius: 5px;
  margin: 0 auto;
  outline: 0;
}
.cr-slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  background-color: #043a6b;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  border: 2px solid white;
  cursor: pointer;
  transition: .3s ease-in-out;
}
.profile_form.pro_information .cr-slider::-webkit-slider-thumb{background-color: #043a6b;margin-top: -10px;}

.profile_form.pro_information .cr-slider::-webkit-slider-thumb:hover {

    border: 1px solid #fff;
  }
.profile_form.pro_information input[type="range"]::-webkit-slider-thumb:active {
    transform: scale(1.2);
}

</style>
<script type="text/javascript">
		var placeSearch, autocomplete;

		function initAutocomplete() {
		  // Create the autocomplete object, restricting the search predictions to
		  // geographical location types.
		  autocomplete = new google.maps.places.Autocomplete(
			  document.getElementById('autocomplete'), {types: ['geocode']});

		}


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqxjEfLVCgHXTLHfwcbEqSjk3cmzqc6ME&libraries=places&callback=initAutocomplete" async defer></script>

{!! Form::close() !!}
