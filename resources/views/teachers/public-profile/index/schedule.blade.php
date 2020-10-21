<div class="row">
    <!--div class="col-12">
        <div class="plan_header">
            <h2>Available Time</h2>
            <p>See all time when teacher is available and not available.</p>
        </div>
    </div-->
    <div class="col-12">
        <div class="indicators_point">
            <p><span class="grey_in"></span>Not Available</p>
            <p><span class="blue_in"></span>Available</p>
        </div>
    </div>
</div>
<div class="row" style="">
    <div class="col-lg-9 col-12">
        <div class="coach_table table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">TIME</th>
                        <th scope="col">MON</th>
                        <th scope="col">TUE</th>
                        <th scope="col">WED</th>
                        <th scope="col">THU</th>
                        <th scope="col">FRI</th>
                        <th scope="col">SAT</th>
                        <th scope="col">SUN</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach($teacherSchedule as $id => $schedule)
                        <tr>
                            <td><?php if(strlen($id) == '1') {echo 0;} ?>{{$id}}<span>:</span>00 -
                                <?php if(strlen($id+1) == '1') {echo 0;} ?>{{($id == 23)? '00' : $id+1}}<span>:</span>00</td>
                            <td><span class="{{($schedule['monday'] == 1) ? "dots_blue" :"dots_grey"}}"></span></td>
                            <td><span class="{{($schedule['tuesday'] == 1) ? "dots_blue" :"dots_grey"}}"></span></td>
                            <td><span class="{{($schedule['wednesday'] == 1) ? "dots_blue" :"dots_grey"}}"></span></td>
                            <td><span class="{{($schedule['thursday'] == 1) ? "dots_blue" :"dots_grey"}}"></span></td>
                            <td><span class="{{($schedule['friday'] == 1) ? "dots_blue" :"dots_grey"}}"></span></td>
                            <td><span class="{{($schedule['saturday'] == 1) ? "dots_blue" :"dots_grey"}}"></span></td>
                            <td><span class="{{($schedule['sunday'] == 1) ? "dots_blue" :"dots_grey"}}"></span></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
			
        </div>
		<div class="button" style="text-align:center;">
		
			@if(Auth::guest())
				<a href="<?php echo url('/login');?>" class="onepage-report-action p-2">{{ __('labels.schedule')}}</a>
			@else
				<a href="<?php echo url('/student/reservation');?>" class="onepage-report-action p-2">{{ __('labels.schedule')}}</a>
			@endif
			
			
		</div>
    </div>
	
</div>
 @if(!empty($teacherLocations->toArray()))
    <!--div class="row">
        <div class="col-12">
            <div class="plan_header">
                <h2>Locations Available </h2>
                <p>See all nearby location where teacher avilable.</p>
            </div>
        </div>
    </div>
    <div class="location_listing">
        <div class="row">
            <div class="col-lg-12">
                <ul class="location_av">
                    @foreach($teacherLocations as $id => $teacherLocation)
                        <li><span>{{$id+1}})</span>{{$teacherLocation['location']['title_jp']}}・{{$teacherLocation['location']['title']}}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div-->
@endif
