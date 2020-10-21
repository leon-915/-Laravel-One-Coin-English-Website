@extends('layouts.app',['title'=>'Teacher Registration Step 2'])
@section('title', 'Teacher Registration Step 2')

@section('content')
    <section class="techregister_two register_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto">
                    <div class="register_inner">
                        <h3>Teacher Recruitment Form II</h3>
                        <p>* Denotes required fields</p>

                        {!! Form::model('registration', ['method' => 'POST',  'id'=>'registration_step2','route' => ['teachers.register.step2.confirm'],'autocomplete' => "off","enctype"=>"multipart/form-data",'class' => 'form_field']) !!}
                        <input type="hidden" name="token"
                               value="{{ !empty($user->step2_verification_token) ? $user->step2_verification_token : ''}}">

                        <div class="row" id="cimage">
                            <div class="form-group col-md-12">
                                <label class="form-control-label" for="image">{{ __('labels.photo_upload')}}
                                    <span>*</span></label>

                                <div id="upload-demo"></div>
                                <label id="croppie-image-upload ">
                                    <input type="file" id="image" style="display: none">
                                    <div class="input-group col-xs-12">
                                        <input class="form-control file-upload-info img-upload" disabled=""
                                               placeholder="Upload Image" type="text">
                                        <span class="input-group-append file-upload-browse">
                                                <button class="freetrial_btn image-btn"
                                                        type="button">Select Image</button>
                                            </span>
                                    </div>
                                    <label id="image-error" class="error d-none" for="image"></label>
                                </label>
                            </div>

                            <input type="hidden" name="image">
                            <input type="hidden" id="url">
                        </div>

                        <!--div class="form-group full">
                            <label>{{ __('labels.official_document_upload')}}</label>
                            <div class="attachments">
                                <div class="file-select">
                                    <div class="file-select-name" id="noFile">Drop your files here or</div>
                                    <div class="file-select-button" id="fileName">SELECT FILE</div>
                                    <input type="file" name="attachments[]" class="custom-file-upload" id="attachments"
                                           multiple>
                                </div>
                            </div>
                            <label id="attachments-error" class="error" for="attachments"
                                   style="display: none;"></label>
                            <p>teaching certificate, visa, CV, bank details. Only pdf, docx, xls, xlsx, jpg, gif, png,
                                text, csv formats are allowed.</p>
                        </div-->

                        <div class="form-group full">
                            <label>Introductory video</label>
                            <div class="attachments">
                                <div class="file-select">
                                    <div class="file-select-button">Select Video</div>
                                    <input type="file" name="video" class="custom-file-upload" id="video">
                                </div>
                            </div>
                            <label id="video-attachments-error" class="error" for="video"
                                   style="display: none;"></label>
                            <p>.mp4 format is allowed. Video should not be more than 5MB in size.</p>
                        </div>

                        <!--div class="form-group full">
                            <label>{{ __('labels.what_courses_do_you_teach')}}<span>*</span></label>
                            <div class="cust">
                                <select multiple="multiple" size="7" name="courses_teach[]" id="courses_teach" class="">
                                    <option value="Daily Conversation">Daily Conversation</option>
                                    <option value="Business English">Business English</option>
                                    <option value="TOEIC">TOEIC</option>
                                    <option value="IELTS">IELTS</option>
                                    <option value="Kids Lessons">Kids Lessons</option>
                                    <option value="Job Interview">Job Interview</option>
                                    <option value="Medical English">Medical English</option>
                                    <option value="Olympic English">Olympic English</option>
                                    <option value="Eloquent English">Eloquent English</option>
                                    <option value="Travel English">Travel English</option>
                                    <option value="English for Fashion Industry">English for Fashion Industry</option>
                                    <option value="Showbiz and Entertainment English">Showbiz and Entertainment
                                        English
                                    </option>
                                    <option value="Hotel and Restaurant English">Hotel and Restaurant English</option>
                                    <option value="Jobs and Occupation English">Jobs and Occupation English</option>
                                    <option value="Computer English">Computer English</option>
                                    <option value="Health and Fitness English">Health and Fitness English</option>
                                    <option value="Academic English">Academic English</option>
                                    <option value="English Literature">English Literature</option>
                                    <option value="Creative Writing">Creative Writing</option>
                                    <option value="English for Mass Communication (Media)">English for Mass
                                        Communication (Media)
                                    </option>
                                    <option value="English for Agriculture">English for Agriculture</option>
                                </select>
                            </div>
                            <p>Choose multiple option press shift or command.</p>
                        </div>
                        <div class="form-group full">
                            <label>{{ __('labels.types_of_visa')}}</label>
                            <div class="select cust">
                                <select name="visa_type" id="visa_type">
                                    <option value="">Select Visa Type</option>
                                    <option value="DIPLOMATIC VISA - Diplomat">DIPLOMATIC VISA - Diplomat</option>
                                    <option value="OFFICIAL VISA - Official">OFFICIAL VISA - Official</option>
                                    <option value="WORKING VISA - Artist">WORKING VISA - Artist</option>
                                    <option value="WORKING VISA - Journalist">WORKING VISA - Journalist</option>
                                    <option value="WORKING VISA - Religious Activities">WORKING VISA - Religious
                                        Activities
                                    </option>
                                    <option value="WORKING VISA - Investor/Business Manager">WORKING VISA -
                                        Investor/Business Manager
                                    </option>
                                    <option value="WORKING VISA - Legal/Accounting Services">WORKING VISA -
                                        Legal/Accounting Services
                                    </option>
                                    <option value="WORKING VISA - Medical Services">WORKING VISA - Medical Services
                                    </option>
                                    <option value="WORKING VISA - Researcher">WORKING VISA - Researcher</option>
                                    <option value="WORKING VISA - Instructor">WORKING VISA - Instructor</option>
                                    <option value="WORKING VISA - Engineer">WORKING VISA - Engineer</option>
                                    <option value="WORKING VISA - Specialist in Humanities/International Services">
                                        WORKING VISA - Specialist in
                                        Humanities/International Services
                                    </option>
                                    <option value="WORKING VISA - Intracompany Transferee">WORKING VISA - Intracompany
                                        Transferee
                                    </option>
                                    <option value="WORKING VISA - Entertainer">WORKING VISA - Entertainer</option>
                                    <option value="WORKING VISA - Skilled Labor">WORKING VISA - Skilled Labor</option>
                                    <option value="GENERAL VISA - Cultural Activities">GENERAL VISA - Cultural
                                        Activities
                                    </option>
                                    <option value="GENERAL VISA - College Student">GENERAL VISA - College Student
                                    </option>
                                    <option value="GENERAL VISA - Precollege Student">GENERAL VISA - Precollege
                                        Student
                                    </option>
                                    <option value="GENERAL VISA - Trainee">GENERAL VISA - Trainee</option>
                                    <option value="GENERAL VISA - Dependent">GENERAL VISA - Dependent</option>
                                    <option value="SPECIFIED VISA - Designated Activities (Working Holiday Visa included)">
                                        SPECIFIED VISA - Designated
                                        Activities (Working Holiday Visa included)
                                    </option>
                                    <option value="SPECIFIED VISA - Spouse or Child of Japanese National">SPECIFIED VISA
                                        - Spouse or Child of Japanese
                                        National
                                    </option>
                                    <option value="SPECIFIED VISA - Spouse or Child of Permanent Resident">SPECIFIED
                                        VISA - Spouse or Child of Permanent
                                        Resident
                                    </option>
                                    <option value="SPECIFIED VISA - Long-term Resident">SPECIFIED VISA - Long-term
                                        Resident
                                    </option>
                                    <option value="NO VISA GIVEN - Permanent Resident">NO VISA GIVEN - Permanent
                                        Resident
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group full">
                            <label>{{ __('labels.date_of_expiration')}}</label>
                            <input type="text" class="form-control" name="visa_expiry_date" id="visa_expirey_date">
                        </div-->
                        <div class="submit_register">
                            <label class="checkcontainer">
                                Please accept our <a href="{{ url('terms-of-use') }}">Terms of Use</a> &
                                <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
                                <input type="checkbox" name="check_terms" required>
                                <span class="checkmark"></span>
                            </label>

                            <div class="submit_btn">
                                <button type="submit" class="btnsub_arr">Submit</button>
                            </div>
                        </div>
                        </form>
                        {{--  --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
        <script>
            let Url = '{{ route('teachers.register.step2.confirm') }}';
        </script>
        <script src="{{ asset('js/teacher/register-stp-2.js') }}"></script>


    @endpush

@endsection
