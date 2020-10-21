<div class="reservation_chart">

    @include('students.reservation.index.chart')
	
    <?php if(!empty($dateBegin) && !empty($dateEnd) && !empty($today)) { ?>
        <?php if (($today >= $dateBegin) && ($today <= $dateEnd)){ ?>
            <div class="text-center p-3 text-justify" style="border: 1px solid;border-radius: 5px;">
                <h2 class="mb-3" style="color:red">{{__('labels.stu_holiday_notification')}}</h2>
                <p class="mb-3 text-justify">{{$message_en}}</p>
                <p class="mb-3 text-justify">{{$message_ja}}</p>
            </div>
        <?php } ?>
    <?php } 
	if(!empty($individualServices)) { 
		if(1==1) { 
			foreach($individualServices as $individualService) {
				if($individualService['service']['no_of_days'] > 30) {
					$expiry_date = $individualService->expire_date;
					$datediff = strtotime($expiry_date) - strtotime(date('Y-m-d'));
					$rdays = floor($datediff / (60 * 60 * 24));
					if($rdays <= 30 && $individualService['service']['no_of_days'] > 30) {
						?>
						<div class="alert-warning show" role="alert" style="border: 1px solid;border-radius: 5px;padding: .75rem 1.25rem;
	margin-bottom: 1rem;">
							<?php echo __('labels.course_expiry_notification', ['daysvalue'=> $rdays, 'link'=> url('student/add-cart/' . $individualService['service']['id'])]); ?>
						</div>
						<?php
						break;
					}
				}
			}
		}
		
		/*$onepage_end_date = $user->onepage_end_date;
		if(!empty($onepage_end_date)){
			$diff = strtotime($onepage_end_date) - strtotime(date('Y-m-d'));
			$onepage_rdays = floor($diff / (60 * 60 * 24));
			if($onepage_rdays < 30) { 
				$onepage_rdays = $onepage_rdays < 1 ? 0 : $onepage_rdays;
				?>
				<div class="alert-warning show" role="alert" style="border: 1px solid;border-radius: 5px;padding: .75rem 1.25rem;
	margin-bottom: 1rem;">
					
						<?php echo __('labels.onepage_fee_notification', ['daysvalue'=> $onepage_rdays, 'link'=> url('student/add-cart/' . env('ONEPAGE_SERVICE_ID'))]); ?>
				</div>
				<?php
			}
		}*/
		
		if($display_onepage_expiry == true) {
			$cls = $onepage_rdays < 1 ? 'danger' : 'warning';
			?>
				<div class="alert-<?php echo $cls;?> show" role="alert" style="border: 1px solid;border-radius: 5px;padding: .75rem 1.25rem;
	margin-bottom: 1rem;">
					
					<?php echo __('labels.onepage_fee_notification', ['daysvalue'=> $onepage_rdays, 'link'=> url('student/add-cart/' . env('ONEPAGE_SERVICE_ID'))]); ?>
				</div>
				<?php
		}
	}
	?>
    {!! Form::model('stepTwo', ['method' => 'POST',  'id'=>'stepTwo','route' => ['students.reservation.store'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
        <div class="row">
            <div class="col-12 col-lg-6 ">
                <div class="form-group">
                    <div class="title_step">
                        <label>{{__('labels.stu_service')}}<span class="astric">*</span></label>
                    </div>
                    <div class="custom_select">
                        <div class="select cust" id="select_service">
                            {!! Form::select('service',$services,'', array('placeholder' => __('labels.stu_choose_service'),'class'=>'form-control','id' => 'service')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <div class="title_step">
                        <label>{{__('labels.stu_location')}}<span class="astric">*</span></label>
                    </div>
                    <div class="custom_select">
                        <div class="select cust" id="select_location">
                            {!! Form::select('location',[],'', array('placeholder' => __('labels.stu_choose_location'),'class'=>'form-control','id' => 'location')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 ">
                <div class="form-group">
                    <div class="title_step">
                        <label>{{__('labels.stu_teacher')}}<span class="astric">*</span></label>
                    </div>
                    <div class="custom_select">
                        <div class="select cust" id="select_teacher">
                            {!! Form::select('teacher',!empty($teachers) ? $teachers : [],'', array('placeholder' => __('labels.stu_choose_teacher'),'class'=>'form-control','id' => 'teacher')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <div class="title_step">
                        <label>{{__('labels.stu_date')}}<span class="astric">*</span></label>
                    </div>
                    <input type="text" class="form-control reserve_date" name="reserve_date" id="reserve_date"
                            placeholder= "{{__('labels.select_date')}}">
                </div>
            </div>
        </div>
        <div class="row d-none" id="skype_id_container">
            <div class="col-md-12 ">
                <div class="form-group">
                    <label for="skype_id">{{__('labels.skype_id')}}<span class="astric">*</span></label>
                    <input type="text" name="skype_id" class="form-control" placeholder="{{__('labels.skype_id')}}" id="skype_id" value="{{isset($user->skype_name) ? $user->skype_name : ''}}">
                </div>
            </div>
        </div>
        <div class="row" id="booking_teacher_profile">
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mt-3" id="available_time">
                    <label for="exampleInputEmail1" class="">{{__('labels.time')}}<span class="astric">*</span></label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">
                       {{__('labels.please_fill_here_that_you_want_to_tell')}}
                    </label>
                    <textarea name="additional_info" class="form-control textarea_custom"
                                placeholder="{{__('labels.stu_enter_detail')}}"></textarea>
                </div>
            </div>
            <div class="col-12 col-lg-6" id="location_detail_container">
                <div class="form-group">
                    <label for="exampleInputEmail1">{{__('labels.stu_location_detail')}}<span
                                class="astric">*</span></label>
                    <textarea name="location_details" class="form-control textarea_custom"
                                placeholder="{{__('labels.stu_location_detail')}}" id="location_details"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right mt-3">
                <button role="menuitem" class="btn_custon">{{__('labels.btn_submit')}}</button>
            </div>
        </div>
    {!! Form::close() !!}

</div>

