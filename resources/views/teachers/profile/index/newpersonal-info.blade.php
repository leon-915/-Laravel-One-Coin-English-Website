
<style>
	.container {
		margin: 0 auto;
	}

	.lp-profile {
		width: 100%;
	}
	
	.lp-profile .container {
		max-width: 970px;
	}

	.profile_sec {
	    background: #7fabd9;
	}

	@media (min-width: 768px) and (max-width: 991px) {
		.col-md-7 {
		    -ms-flex: 0 0 70%;
		    flex: 0 0 70%;
		    max-width: 70%;
		    width: 70%;
		}

		.col-md-5 {
		    -ms-flex: 0 0 30%;
		    flex: 0 0 30%;
		    max-width: 30%;
		    width: 30%;
		}
	}
</style>

<div class="lp-profile">
	<div class="container">
		<div class="row graphics">
			<div class="col-md-4">
				<div class="graphic">
					<div style="width: 100%; height:100%; margin: 0 auto">
						<canvas style="width:70px; height:70px;" id="earning-Chart" ></canvas>
					</div>					
				</div>
				<p>Earnings</p>
			</div>

			<div class="col-md-4">
				<div class="graphic">
					<div style="width: 100%; height:100%; margin: 0 auto">
						<canvas style="width:70px; height:70px;" id="fav-sessions-chart" ></canvas>
					</div>
				</div>
				<p>Favorites & Sessions</p>
			</div>

			<div class="col-md-4">
				<div class="graphic">
					<div style="width: 100%; height:100%; margin: 0 auto">
						<canvas style="width:70px; height:70px;" id="rating-chart" ></canvas>
					</div>
				</div>
				<p>Star Ratings</p>
			</div>				
		</div>
		<script src="{{asset('js/Chart.min.js')}}"></script>
		<script>
			// Return with commas in between
			var numberWithCommas = function (x) {
				return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			};
			var bar_ctx2 = document.getElementById('earning-Chart');
			var bar_chart2 = {
				type: 'bar',
				data: {
					labels:<?php echo json_encode($lessionsData['lables']); ?>,
					datasets: [
						{
							label: 'Earning',
							data: <?php echo !empty($lessionsData['data']) ? json_encode($lessionsData['data']) : json_encode([])?>,
							backgroundColor: "#00A6D7",
							hoverBackgroundColor: "rgba(55, 160, 225, 0.7)",
							hoverBorderWidth: 2,
							hoverBorderColor: 'lightgrey'
						}
					]
				},
				options: {
					animation: {
						duration: 10
					},
					tooltips: {
						mode: 'label',
						callbacks: {
							label: function (tooltipItem, data) {
								console.log(tooltipItem, data);
								return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel)+'jpy';
							}
						}
					},
					scales: {
						xAxes: [{
							stacked: true,
							gridLines: {display: false},
						}],
						yAxes: [{
							stacked: true,
							gridLines: {display: false},
							ticks: {
								display: false,
								min: 0,
								stepSize: 5,
								maxTicksLimit: 20
							},
							barPercentage: 0.1
						}],
					}, // scales
					legend: {display: false}
				} // options
			};
			new Chart(bar_ctx2, bar_chart2)
			
			var bar_ctx3 = document.getElementById('fav-sessions-chart');
			var bar_chart3 = {
				type: 'bar',
				data: {
					labels:<?php echo json_encode(['Favorites', 'Sessions']); ?>,
					datasets: [
						{
							label: 'Count',
							data: <?php echo json_encode([1,4])?>,
							backgroundColor: "#00A6D7",
							hoverBackgroundColor: "rgba(55, 160, 225, 0.7)",
							hoverBorderWidth: 2,
							hoverBorderColor: 'lightgrey'
						}
					]
				},
				options: {
					animation: {
						duration: 10
					},
					tooltips: {
						mode: 'label',
						callbacks: {
							label: function (tooltipItem, data) {
								console.log(tooltipItem, data);
								return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
							}
						}
					},
					scales: {
						xAxes: [{
							stacked: true,
							gridLines: {display: false},
						}],
						yAxes: [{
							stacked: true,
							gridLines: {display: false},
							ticks: {
								display: false,
								min: 0,
								stepSize: 5,
								maxTicksLimit: 20
							}
						}],
					}, // scales
					legend: {display: false}
				} // options
			};
			new Chart(bar_ctx3, bar_chart3)	
			
			var bar_ctx4 = document.getElementById('rating-chart');
			var bar_chart4 = {
				type: 'bar',
				data: {
					labels:<?php echo json_encode(['5', '4', '3', '2', '1']); ?>,
					datasets: [
						{
							label: 'Count',
							data: <?php echo json_encode([6,4,3,5,2])?>,
							//backgroundColor: "rgba(55, 160, 225, 0.7)",
							backgroundColor: ["#021A88", "#0058B3", "#00A6D7", "#30E7ED", "#86FAF2"], 
							hoverBackgroundColor: "rgba(55, 160, 225, 0.7)",
							hoverBorderWidth: 2,
							hoverBorderColor: 'lightgrey'
						}
					]
				},
				options: {
					animation: {
						duration: 10
					},
					tooltips: {
						mode: 'label',
						callbacks: {
							label: function (tooltipItem, data) {
								console.log(tooltipItem, data);
								return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
							}
						}
					},
					scales: {
						xAxes: [{
							stacked: true,
							gridLines: {display: false},
						}],
						yAxes: [{
							stacked: true,
							gridLines: {display: false},
							ticks: {
								display: false,
								min: 0,
								stepSize: 5,
								maxTicksLimit: 20
							}
						}],
					}, // scales
					legend: {display: false}
				} // options
			};
			new Chart(bar_ctx4, bar_chart4)	
		</script>
			
		<div class="accordion">
			<button class="collapsible-3">
				Personal Details
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			
			<div class="accordion-content">
				<div class="inner-content">
					{!! Form::model('personal-info', ['method' => 'POST','name'=>'personal-info',  'id'=>'personal-info','route' => ['teachers.profile.info.save'],'autocomplete' => "off","enctype"=>"multipart/form-data",'class' => 'form_field']) !!}
					<div class="row">

						<div class="col-md-7 padding-2">
							<div>
								<div class="photo-upload-container">
									<!--div class="photo-container">
										<div class="photo"></div>
									</div>

									<div class="resize mt-10">
										<div class="resize-bar">
											<div class="point"></div>
										</div>

										<p>Resize</p>
									</div>

									<div class="upload-photo-btn btn-container mt-10">
										<input type="file" name="" class="hide">
										<button class="btn-upload"><font color="red">*</font>Upload Photo</button>
									</div-->
									
									
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
										<input type="hidden" name="image">
										<input type="hidden" id="url" value="{{$image}}">
									</label>

									<div class="upload-verification-btn btn-container">
										<div class="">
											
											<div class="attachments">
												<div class="file-select">
													<div class="file-select-name" id="noFile">Drop your files here or</div>
													<!--div class="file-select-button" id="fileName">SELECT FILE</div-->
													<input type="file" name="attachments[]" class="custom-file-upload" id="attachments"
														   multiple>
												</div>
											</div>
											<label id="attachments-error" class="error" for="attachments"
												   style="display: none;"></label>
												   {{--<p>Teaching certificate, visa, CV, bank details. Only pdf, docx, xls, xlsx, jpg, gif, png,
												   text, csv formats are allowed.</p>--}}
										</div>
									</div>

									<div class="btn-container">
										<button class="btn-upload btn-papers">Verification Papers List [3] Here</button>
									</div>
								</div>

								<div class="profile-data">
									<div class="table-row">
										<div class="left table-cell">Nickname</div>
										<div class="right table-cell">
											<input type="text" value="{{$teacher->nickname}}" name="nickname" placeholder="Enter Nickname">
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell"><font color="red">*</font>Nationality</div>
										<div class="right table-cell">
											<!--input type="text" name="" placeholder="Search Nationality"-->
											{!!
												Form::select(
													'nationality',
													$countries,
													$teacherDetails->nationality,
													array(
														'class' 		=> '',
														'placeholder' 	=> 'Select Nationality',
														"data-plugin" 	=> "selectpicker",
														"id" 			=> "nationality",
														"required" 		=> "true"
													)
												)
											!!}
											
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell"><font color="red">*</font>First Name</div>
										<div class="right table-cell">
											<!--input type="text" name="" placeholder="Enter First Name"-->
											<input type="text" class="" placeholder="Enter First Name" name="firstname" id="firstname" value="{{$teacher->firstname}}">
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell"><font color="red">*</font>Last Name</div>
										<div class="right table-cell">
											<!--input type="text" name="" placeholder="Enter Last Name"-->
											<input type="text" class="" placeholder="Enter Last Name" name="lastname" id="lastname" value="{{$teacher->lastname}}">
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell"><font color="red">**</font>Gender</div>
										<div class="right table-cell">
											<label class="radio-container">Male
											  <!--input type="radio" checked="checked" name="radio"-->
											  <input type="radio" {{$teacherDetails->gender == '' || $teacherDetails->gender == 'male' ? 'checked' : ''}} name="gender" value="male">
											  <span class="checkmark"></span>
											</label>
											<label class="radio-container">Female
											  <!--input type="radio" name="radio"-->
											  <input type="radio" {{$teacherDetails->gender == 'female' ? 'checked' : ''}} name="gender" value="female">
											  <span class="checkmark"></span>
											</label>
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell"><font color="red">**</font>Date of Birth</div>
										<div class="right table-cell">
											<!--input type="text" name="" placeholder="Select Date from Date Picker"-->
											<input type="text" placeholder="Select Date from Date Picker" class="" id="dob" name="dob" value="{{$teacherDetails->dob}}">
										</div>
									</div>

									<!--div class="table-row">
										<div class="left table-cell"><font color="red">*</font>Email</div>
										<div class="right table-cell">
											<input type="text" name="" placeholder="Enter Email">
										</div>
									</div-->

									<div class="table-row">
										<div class="left table-cell"><font color="red">**</font>Reside in Japan</div>
										<div class="right table-cell line-height-1">
											<!--label class="radio-container mt-5 mb-5">Yes
											  <input type="radio" checked="checked" name="radio-2">
											  <span class="checkmark"></span>
											</label>
											<label class="radio-container mt-5 mb-5">No
											  <input type="radio" name="radio-2">
											  <span class="checkmark"></span>
											</label-->
											@foreach($japanese_resident as $key => $resident)
												@php
													$checkedA = ($key == $teacherDetails->japanese_resident) ? 'checked' : '';
												@endphp
												<label class="radio-container mt-5 mb-5">{{ $resident }}
													<input type="radio" name="japanese_resident" {{ $checkedA }} value="<?php echo $key; ?>">													
													<span class="checkmark"></span>
												</label>
											@endforeach
<?php
$hide_address_line_div = 'd-none';
if($teacherDetails->japanese_resident == 0) {
	$hide_address_line_div = '';
}
?>
											<div id="address_line_div" class="mb-5 <?php echo $hide_address_line_div;?>">
												<!--input type="text" name="" class="placeholder-8" placeholder="If no Search Country"-->
												<input type="text" placeholder="If no Search Country" name="address_line1" value="{{$teacherDetails->address_line1}}" id="autocomplete" class="placeholder-8" required="">
											</div>
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell"><font color="red">*</font>Occupation</div>
										<div class="right table-cell line-height-1">
											<!--input type="text" name="" placeholder="Search Occupation"-->
											<input type="text" placeholder="Occupation" class="" name="occupation" id="occupation" value="{{$teacherDetails->occupation}}">
											
											<input type="text" name="" class="placeholder-8" placeholder="If Occuption is Student then this field appears to Search Studies">
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell">Teach Beginners</div>
										<div class="right table-cell">
											<!--label class="radio-container">Yes
											  <input type="radio" checked="checked" name="radio-3">
											  <span class="checkmark"></span>
											</label>
											<label class="radio-container">No
											  <input type="radio" name="radio-3">
											  <span class="checkmark"></span>
											</label-->
											@foreach($teach_beginers as $key => $value)
												@php
													$checkedA = ($key == $teacherDetails->teach_beginers) ? 'checked' : '';
												@endphp
												<label class="radio-container">{{ $value }}
													<input type="radio" name="teach_beginers" {{ $checkedA }} value="<?php echo $key; ?>">													
													<span class="checkmark"></span>
												</label>
											@endforeach
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell"><font color="red">*</font>Topic Specializtion</div>
										<div class="right table-cell">
											@foreach($conversation_topic as $ckey => $topic)
												@php
													$checkedC = in_array($ckey, explode(',', $teacherDetails->conversation_topic)) ? 'checked' : '';
												@endphp
												<label class="checkcontainer">
													{{ $topic }}
													<input class="conversation_topic" type="checkbox" name="conversation_topic[]" {{ $checkedC }}  value="<?= $ckey ?>">
													<span class="checkmark"></span>
												</label>
											@endforeach
										</div>
									</div>

									<div class="table-row">
										<div class="left table-cell">Speaks</div>
										<div class="right table-cell">
											<table>
												<tr>
													<td>
														<?php
														if($teacherDetails->teaching_english_in != '') {
															list($teaching_english_in_1, $teaching_english_in_2, $teaching_english_in_3) = explode(',', $teacherDetails->teaching_english_in);
														} else {
															$teaching_english_in_1 = $teaching_english_in_2 = $teaching_english_in_3 = '';
														}
														
														if($teacherDetails->speaking_level != '') {
															list($speaking_level1, $speaking_level2, $speaking_level3) = explode(',', $teacherDetails->speaking_level);
														} else {
															$speaking_level1 = $speaking_level2 = $speaking_level3 = '';
														}
														
														?>
														<select class="speaks_select" name="teaching_english_in_1">
															@foreach($teaching_english_in as $key => $value)
																@php
																	$checkedC = $key == $teaching_english_in_1 ? 'selected="selected"' : '';
																@endphp
																<option value="{{$key}}" {{$checkedC}}>{{$value}}</option>
															@endforeach
														</select>
													</td>
													<td>
														<select class="speaks_select" name="teaching_english_in_2">
															@foreach($teaching_english_in as $key => $value)
																@php
																	$checkedC = $key == $teaching_english_in_2 ? 'selected="selected"' : '';
																@endphp
																<option value="{{$key}}" {{$checkedC}}>{{$value}}</option>
															@endforeach
														</select>													
													</td>
													<td>
														<select class="speaks_select" name="teaching_english_in_3">
															@foreach($teaching_english_in as $key => $value)
																@php
																	$checkedC = $key == $teaching_english_in_3 ? 'selected="selected"' : '';
																@endphp
																<option value="{{$key}}"  {{$checkedC}}>{{$value}}</option>
															@endforeach
														</select>													
													</td>
												</tr>
												<tr>
													<td>
														@foreach($speaking_level as $key => $value)
															@php
																$checkedA = ($key == $speaking_level1 || $key == 1) ? 'checked' : '';
															@endphp
															<label class="radio-container">{{ $value }}
																<input type="radio" name="speaking_level1" {{$checkedA}} value="<?php echo $key; ?>">													
																<span class="checkmark"></span>
															</label>
														@endforeach
													</td>
													<td>
														@foreach($speaking_level as $key => $value)
															@php
																$checkedA = ($key == $speaking_level2 || $key == 1) ? 'checked' : '';
															@endphp
															<label class="radio-container">{{ $value }}
																<input type="radio" name="speaking_level2" {{$checkedA}} value="<?php echo $key; ?>">													
																<span class="checkmark"></span>
															</label>
														@endforeach
													</td>
													<td>
														@foreach($speaking_level as $key => $value)
															@php
																$checkedA = ($key == $speaking_level3 || $key == 1) ? 'checked' : '';
															@endphp
															<label class="radio-container">{{ $value }}
																<input type="radio" name="speaking_level3" {{$checkedA}} value="<?php echo $key; ?>">													
																<span class="checkmark"></span>
															</label>
														@endforeach
													</td>
												</tr>
											</table>
										</div>
									</div>

									<div class="required-desc">
										<p><font color="red">*Required</font></p>
										<p><font color="red">**Required / Not Displayed</font></p>
									</div>

								</div>	
							</div>

							<div class="calendar-section">
								<div class="top row">
									<div class="col-6">
										<div class="switch-container">
											<label class="switch">
												<input type="checkbox" checked>
												<span class="slider round"></span>
												<span class="available">Available</span>
												<span class="unavailable">Unavailable</span>
											</label>
										</div>
									</div>

									<div class="col-6">
										<p class="align-center mb-15">Availability</p>
									</div>
								</div>

								<table>
									<tr class="border-bottom-1">
										<th>TIME</th><th>MON</th><th>TUE</th><th>WED</th><th>THU</th><th>FRI</th><th>SAT</th><th>SUN</th>
									</tr>
									<tr>
										<td>00 - 01</td><td>+</td><td class="active">+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>01 - 02</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>02 - 03</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>03 - 04</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>04 - 05</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>05 - 06</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>06 - 07</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>07 - 08</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>08 - 09</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>09 - 10</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>10 - 11</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>11 - 12</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>12 - 13</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>13 - 14</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>14 - 15</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>15 - 16</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>16 - 17</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>17 - 18</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>18 - 19</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>19 - 20</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>20 - 21</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>21 - 22</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>22 - 23</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
									<tr>	
										<td>23 - 00</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td><td>+</td>
									</tr>
								</table>

								<div class="btn-container">
									<!--button class="btn-save">Save</button-->
									<button type="submit" class="btn-save">Submit</button>
								</div>
							</div>
							
						</div>
						
						<div class="col-md-5 padding-2">
							<div class="audio-upload upload-section">
								<div class="desc">
									<font color="red">*</font>
									<textarea name="message_en" placeholder="Please write an appealing introduction message for your Learners.  [ Min. 50 / Max. 120 words]">{{ !empty($teacherDetails->message_en) ? $teacherDetails->message_en : ''}}</textarea>
									
								</div>
								
								<div class="btn-container">
									<!--input type="file" name="" class="hide">
									<button class="btn-upload"><font color="red">*</font>Upload Audio of Intro</button-->
									<?php
									if($teacherDetails->audio_attachment !='') { ?>
										<div class="audio_desc">
											<audio controls>
											  <source src="{{ url($teacherDetails->audio_attachment)}}" type="audio/mp3">
											Your browser does not support the audio element.
											</audio> 
											<a href="javascript:void(0);" id="audio">Delete</a>
										</div>
									<?php }
									?>
									<div class="file-upload">
										<div class="file-select">
											<!--div class="file-select-button" id="fileName">Choose file</div-->
											<!--div class="file-select-name" id="noFile">Upload your audio here</div-->
											<input type="file" name="audio_attachment" class="custom-file-upload" id="audio_attachment">
										</div>
									</div>
									<label id="audio_attachment-error" class="error" for="audio_attachment"  style="display: none;"></label>
									<input type="hidden" name="saved_audio_attachment" id="saved_audio_attachment" value="<?php echo $teacherDetails->audio_attachment;?>">
								</div>
							</div>

							<div class="video-upload upload-section">
								<div class="video_desc">
									<?php
									if($teacher->video !='') { ?>
										<video width="370" height="260" controls>
											<source src="{{$teacher->video}}" type="video/mp4">
										</video>  
										<a href="javascript:void(0);" id="video">Delete</a>
									<?php }
									?>
								</div>
								
								<div class="btn-container">
									<!--input type="file" name="" class="hide">
									<button class="btn-upload">Video Upload</button-->
									
											<div class="file-select-button">Update Video</div>
											<input type="file" name="video" class="custom-file-upload" id="video">
										
								</div>
							</div>

							<div class="image-upload upload-section">
								<div class="desc">
									<div class="tab-container row">
										<div class="col-6 tab active" onclick="openTab2('new_post')">New Post</div>

										<div class="col-6 tab" onclick="openTab2('all_posts')">All Posts</div>
									</div>

									<div class="tab-content-container">
										<div id="new_post" class="tab-content">
											<p><font color="red">*</font>Subject</p>
											<textarea rows="3"></textarea>

											<p class="message"><font color="red">*</font>Message</p>
											<textarea rows="5"></textarea>

											<div class="btn-container">
												<button class="btn-upload">Image Upload</button>
											</div>												
										</div>

										<div id="all_posts" class="tab-content"></div>
									</div>
								</div>

								<div class="btn-container">
									<button class="btn-upload">Post Submit</button>
								</div>
							</div>
						</div>
					</div>
					
			{!! Form::close() !!}
				</div>
			</div>
			
			<button class="collapsible-3">
				Lesson Records
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			
			<div class="accordion-content">
				content
			</div>
			
			<button class="collapsible-3">
				Reviews
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			
			<div class="accordion-content">
				content
			</div>

			<button class="collapsible-3">
				Referral
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			
			<div class="accordion-content">
				content
			</div>

			<button class="collapsible-3">
				Settings
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			
			<div class="accordion-content">
				content
			</div>

		</div>
		
		<script>
	        var coll_3 = document.getElementsByClassName("collapsible-3");
	        var i;

	        for (i = 0; i < coll_3.length; i++) {
	            coll_3[i].addEventListener("click", function() {
	                console.log(this.classList['value']);

	                if( (this.classList['value']).indexOf("active") >= 0 ) {
	                    this.classList.remove("active");
	                    
	                    var content = this.nextElementSibling;
	                    content.style.maxHeight = null;
	                } else {

	                    for (var j = 0; j < coll_3.length; j++) {
	                    
	                        coll_3[j].classList.remove("active");

	                        var content = coll_3[j].nextElementSibling;
	                        content.style.maxHeight = null;
	                    }

	                    this.classList.toggle("active");
	                    var content = this.nextElementSibling;
	                    content.style.maxHeight = content.scrollHeight + "px";
	                }
	            });
	        }

	        // Tab
			function openTab2(tabName) {
				var i;
				var x = document.getElementsByClassName("tab-content");
				
				for (i = 0; i < x.length; i++) {
					x[i].style.display = "none";  
				}
				
				document.getElementById(tabName).style.display = "block";  
			}

			$(".lp-profile .image-upload .tab").on("click", function() {
				$(".lp-profile .image-upload .tab").removeClass("active");
				$(this).addClass("active");
			});
			
			$(document).ready(function () {
				$('.conversation_topic').change(function(evt) {
					var maxAllowed = 3;
					var cnt = $("input[name='conversation_topic[]']:checked").length;
					if (cnt > maxAllowed)
					{
						$(this).prop("checked", "");
						alert('You can select maximum ' + maxAllowed + ' topics!');
					}
				});
			});
			
			
			$(document).ready(function () {
				$('.speaks_select').change(function () {
					if ($('.speaks_select option[value="' + $(this).val() + '"]:selected').length > 1) {
						$(this).val('-1').change();
						alert('You have already selected this option previously - please choose another.');
					}
				});
			});
	    </script>
		
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
	</div>
</div>
