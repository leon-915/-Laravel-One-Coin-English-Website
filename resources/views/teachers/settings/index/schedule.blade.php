{!! Form::open(array('route' => 'teachers.settings.update.schedule','class'=>'cmxform', 'id'=>'frm_update_schedule','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
    <div class="lesson_record_sec">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <h4>Time of day in which you are available to teach ?</h4>
                <span class="header_span">Available lesson time (you can update your
                    schedule anytime online)
                    Times are in Tokyo, Japan (+9:00 GMT). Compare your time
                    here.</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive table_custom manage">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                            {{--  <th scope="col"></th> --}}
                                <th scope="col">Mon</th>
                                <th scope="col">Tue</th>
                                <th scope="col">Wed</th>
                                <th scope="col">Thu</th>
                                <th scope="col">Fri</th>
                                <th scope="col">Sat</th>
                                <th scope="col">Sun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $fromTime = '00:00';
                                $toTime   = '01:00';
                            @endphp

                            @foreach ($teacherSch as $key => $sch)
                                <tr>
                                    <td scope="row">{{ $fromTime }}-{{ $toTime }}</td>
                                {{--  <td scope="row">{{ date('H:i',strtotime($sch['from_time'])) }}-{{ date('H:i',strtotime($sch['to_time'])) }}</td> --}}
                                    <td>
                                        <div class="form-group full">
                                            <label class="checkcontainer">
                                                <input type="checkbox" name="schedule[{{$sch['id']}}][monday]" {{ ($sch['monday'] == 1) ? 'checked' : '' }} value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group full">
                                            <label class="checkcontainer">
                                                <input type="checkbox" name="schedule[{{$sch['id']}}][tuesday]" {{ ($sch['tuesday'] == 1) ? 'checked' : '' }} value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group full">
                                            <label class="checkcontainer">
                                                <input type="checkbox" name="schedule[{{$sch['id']}}][wednesday]" {{ ($sch['wednesday'] == 1) ? 'checked' : '' }} value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group full">
                                            <label class="checkcontainer">
                                                <input type="checkbox" name="schedule[{{$sch['id']}}][thursday]" {{ ($sch['thursday'] == 1) ? 'checked' : '' }} value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group full">
                                            <label class="checkcontainer">
                                                <input type="checkbox" name="schedule[{{$sch['id']}}][friday]" {{ ($sch['friday'] == 1) ? 'checked' : '' }} value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group full">
                                            <label class="checkcontainer">
                                                <input type="checkbox" name="schedule[{{$sch['id']}}][saturday]" {{ ($sch['saturday'] == 1) ? 'checked' : '' }} value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group full">
                                            <label class="checkcontainer">
                                                <input type="checkbox" name="schedule[{{$sch['id']}}][sunday]" {{ ($sch['sunday'] == 1) ? 'checked' : '' }} value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                @php
                                    $fromTime =  date('H:i',strtotime($fromTime) + 60*60);
                                    $toTime =  date('H:i',strtotime($toTime) + 60*60);

                                    if($fromTime == '24:00') break;
                                    if($toTime == '25:00') break;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <div class="add_excepion date">
                    <label>Exception</label>
                    <div class="form-group">
                        <a style="cursor: pointer;" onclick="exOptionAction.addOption(this);">+ Add Exception</a>
                    </div>
                    <div id="exception_container">
                        @include('teachers.settings.index.schedule.exceptions')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group half padd">
                    <label>Teaching Mode(S) </label>
                    <p>{{ ($teacherDetails->is_remote_teaching == 1) ? 'Skype' : 'In Person' }}</p>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-12">
                <div class="add_excepion">
                    <div class="form-group half">
                        <label>Exception</label>
                        <a href="#">+ Add Exception</a>
                    </div>
                    <div class="form-group half padd">
                        <label>Teaching Mode(S) </label>
                        <p>{{ ($teacherDetails->is_remote_teaching == 1) ? 'Skype' : 'In Person' }}</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-6" style="font-size: 14px;"> Teacher Location(s)</div>
                    <div class="col-lg-6 mobile-head" style="font-size: 14px;"> All Location(s)</div>
                </div>
                <div id="listswap_2" class="listswap-wrap my-plugin-class">
                    <select id="teacher_locations_ltl" data-search="Search for options" name="teacher_locations[]" multiple>
                        @foreach ($locations as $lkey => $loc)
                            @if(in_array($lkey, $teacherLocations))
                                <option value="{{$lkey}}" selected>{{$loc}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select id="teacher_locations_rtl" data-search="Search for options" >
                        @foreach ($locations as $lkey => $loc)
                            @if(!in_array($lkey, $teacherLocations))
                                <option value="{{$lkey}}">{{$loc}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Teaching Locations</label>
                    <?php 
                        $teaching_locations = "-";
                        $teaching_locations_arr = "";
                            if(!empty($teacherDetails->teaching_locations)){

                                $teaching_locations_arr = explode(',', $teacherDetails->teaching_locations);
                                foreach ($teaching_locations_arr as $key => $value) {
                                   $teaching_locations_arr[$key] = ucfirst($value);
                                }

                                $teaching_locations = implode(', ', $teaching_locations_arr);
                            }
                    ?>
                    
                    <p>{{ $teaching_locations }}</p>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <?php $canTeach = explode(',', $teacherDetails->lesson_minute_able_to_teach); ?>
                    <label>Lesson duration able to teach <span>*</span> </label>
                    <label class="checkcontainer">15 Min
                    <input type="checkbox" name="lesson_minute_able_to_teach[]" {{ in_array(15, $canTeach) ? 'checked' : '' }} value="15">
                    <span class="checkmark"></span>
                    </label>
                    <label class="checkcontainer">25 Min
                    <input type="checkbox" name="lesson_minute_able_to_teach[]" {{ in_array(25, $canTeach) ? 'checked' : '' }} value="25">
                    <span class="checkmark"></span>
                    </label>
                    <label class="checkcontainer">50 Min
                    <input type="checkbox" name="lesson_minute_able_to_teach[]" {{ in_array(50, $canTeach) ? 'checked' : '' }} value="50">
                    <span class="checkmark"></span>
                    </label>
                    <div style="clear: both;"></div>
                    <small id="tagsHelp" class="form-text text-muted">Students may book lessons back to back to create longer lesson duration. e.g. 25 + 50 = 75</small>
                    <div style="clear: both;"></div>
                    <label id="lesson_minute_able_to_teach[]-error" class="error" for="lesson_minute_able_to_teach[]"></label>
                </div>
            </div>
        </div>


        <div class="row ">
            <div class="col-12 ">
                <div class="form-group row appointment-sec-teacher">
                    <label class="col-3">Client can book appointment up to </label>
                    <div class="col-6"><input type="text" class="form-control" name="book_before_time" value="{{ !empty($teacherDetails->book_before_time) ? $teacherDetails->book_before_time : 0 }}" placeholder="Before start time"></div><div class="col-3"> (hrs) before start time </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group row appointment-sec-teacher">
                    <label class="col-3">Client can cancel/reschedule appointment</label>
                    <div class="col-6"><input type="text" class="form-control" name="cancel_before_time" value="{{ !empty($teacherDetails->cancel_before_time) ? $teacherDetails->cancel_before_time : 0 }}" placeholder="Before start time"></div><div class="col-3"> (hrs) before start time </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-right">
                <button type="submit" class="btnsub_arr"> Update </button>
            </div>
        </div>
    </div>
{!! Form::close() !!}

@include('teachers.settings.index.schedule.js')



<style>
#listswap_2{}



</style>
