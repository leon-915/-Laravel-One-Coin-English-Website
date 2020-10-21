
<h4>{{ __('Accent Website Profile') }}</h4>

{!! Form::model('profile', ['method' => 'POST',  'id'=>'profile','route' => ['teachers.profile.save'],'autocomplete' => "off","enctype"=>"multipart/form-data",'class' => 'form_field']) !!}

    <div class="row">
        <div class="col-12">
            <div class="form-group half">
                <label>{{ __('labels.message_en')}}<span>*</span></label>
                <textarea name="message_en" placeholder="If you leave it blank, it will be translated in JA automatically.">{{ !empty($teacherDetails->message_en) ? $teacherDetails->message_en : ''}}</textarea>
            </div>

            <div class="form-group half padd">
                <label>{{ __('labels.message_jp')}}</label>
                <textarea name="message_jp">{{ !empty($teacherDetails->message_jp) ? $teacherDetails->message_jp : ''}}</textarea>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group half">
                <label>{{ __('labels.hobby')}}<span>*</span></label>
                <input type="text" class="form-control" name="hobby" required="" value="{{ !empty($teacherDetails->hobby) ? $teacherDetails->hobby : ''}}">
            </div>


            <div class="form-group half padd">
                <label>{{ __('labels.year_started_teaching')}}<span>*</span></label>
                <!--input type="text" class="form-control" name="teaching_year_begun" required="" value="{{ !empty($teacherDetails->teaching_year_begun) ? $teacherDetails->teaching_year_begun : ''}}" disabled-->
				<div class="form-control" style="padding-top:2.5%;">{{ !empty($teacherDetails->teaching_year_begun) ? $teacherDetails->teaching_year_begun : ''}}</div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group full">
                <label>{{ __('labels.teaching_certification')}}</label>
                @foreach($certificates as $ckey => $certificate)
                    @php
                        $checkedC = in_array($ckey, explode(',', $teacherDetails->teaching_certificate)) ? 'checked' : '';
                    @endphp
                    <label class="checkcontainer">
                        {{ $certificate }}
                        <input type="checkbox" name="teaching_certificate[]" {{ $checkedC }}  value="<?= $ckey ?>">
                        <span class="checkmark"></span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <div class="form-group full">
                <label>{{ __('labels.japanese_ability')}}<span>*</span></label>
                @foreach($abilities as $key => $ability)
                    @php
                        $checkedA = ($key == $teacherDetails->japanese_ability) ? 'checked' : '';
                    @endphp
                    <label class="checkcontainer">
                    <input type="radio" name="japanese_ability" {{ $checkedA }} value="<?= $key ?>">
                        {{ $ability }}
                        <span class="radiobtn"></span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            @if (!empty($teacherDetails->japanese_ability) && $teacherDetails->japanese_ability == 'jplt_score')
                <div class="form-group" id="jplt_score_container">
                    <label>{{ __('labels.jplt_score')}}<span>*</span></label>
                <input type="text" name="jplt_score" value="{{$teacherDetails->jplt_score}}" class="form-control" id="jplt_score">
                </div>
            @else
                <div class="form-group d-none" id="jplt_score_container">
                    <label>{{ __('labels.jplt_score')}}<span>*</span></label>
                    <input type="text" name="jplt_score" value="" class="form-control" id="jplt_score">
                </div>
            @endif
        </div>

        <div class="col-12">
            <div class="form-group full">
                <label>{{ __('labels.highest_education_attained')}}</label>
                @foreach($degrees as $ekey => $edu)
                <?php
                    $checkedE = in_array($ekey, explode(',', $teacherDetails->highest_education)) ? 'checked' : '';
                ?>
                <label class="checkcontainer">
                        {{ $edu }}
                    <input type="checkbox" name="highest_education[]" {{$checkedE}} value="<?= $ekey ?>">
                    <span class="checkmark"></span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <div class="profile_full">
                <div class="form-group half">
                    <label>{{ __('labels.major')}}</label>
                    <input type="text" class="form-control" name="major_subject" value="{{$teacherDetails->major_subject}}" placeholder="Marketing and finance">
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="profile_full">
                <div class="form-group half">
                    <label>{{ __('labels.what_courses_do_you_teach')}}<span>*</span></label>
                    <select multiple="multiple" size="7" name="courses_teach[]" id="courses_teach" class="form-control">
                        @foreach($courses_teach as $teach)
                            <?php
                                $checkedT = in_array($teach, explode(',', $teacherDetails->courses_teach)) ? 'selected' : '';
                            ?>
                            <option value="{{ $teach }}" {{ $checkedT }}>{{ $teach }}</option>
                        @endforeach
                    </select>
                    <p>Use CTRL + Mouse to select option</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group half">
                <label>{{ __('labels.types_of_visa')}}</label>
                <select name="visa_type" class="form-control" id="visa_type">
                    <option value="">Select Visa Type</option>
                    @foreach($visa_type as $vtype)
                        <?php
                            $checkedT = ($vtype == $teacherDetails->visa_type) ? 'selected' : '';
                        ?>
                        <option value="{{ $vtype }}" {{ $checkedT }}>{{ $vtype }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group half">
                <label>{{ __('labels.date_of_expiration')}}</label>
                <input type="text" class="form-control" name="visa_expiry_date" id="visa_expirey_date" value="{{$teacherDetails->visa_expiry_date}}">
            </div>
        </div>

        <div class="col-12 pr-4">
            <div class="submit_register">
                <div class="submit_btn">
                    <button type="submit"  class="btnsub_arr">Submit</button>
                </div>
            </div>
        </div>
    </div>

{!! Form::close() !!}
