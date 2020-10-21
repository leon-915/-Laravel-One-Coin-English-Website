<?php if($student->credit_balance > 0) { ?>
	<div class="row">
		<div class="col-12">
			<div class="plan_header">
				<h2>{{ __('labels.stu_refer_and_earn_reward')}}</h2>
				<p>{{ __('labels.stu_refer_and_earn_reward_span')}}</p>
			</div>

			<h4>{{ __('labels.stu_your_referral_code_is')}} :  {{ $user->referral_code }}</h4>

			<p><span> {{__('labels.stu_credit_points')}} : </span> {{!empty($student->credit_balance) ? $student->credit_balance :'0' }} </p>
			<p><span> {{ __('labels.stu_reward_points')}} : </span> {{!empty($student->reward_balance) ? $student->reward_balance : '0' }} </p>

		</div>
	</div>
<?php } else { ?>
	<div class="row">
		<div class="col-12">
			<div class="plan_header">
				<h2>{{ __('labels.stu_refer_and_earn_reward')}}</h2>
				<p>{{ __('labels.stu_refer_and_earn_reward_span')}}</p>
			</div>

			<h4>{{ __('labels.stu_your_referral_code_is')}} :  {{ $user->referral_code }}</h4>

			<p><span> {{ __('labels.stu_reward_points')}} : </span> {{!empty($student->reward_balance) ? $student->reward_balance : '0' }} </p>

		</div>
	</div>
<?php } ?>	

<div class="row mt-4">
    <div class="col-12">
        <div class="form-group">
            <label>{{__('labels.stu_email')}}</label>
            <input type="text" name="email" id="email" value="" class="form-control" placeholder="{{__('labels.stu_write_email_to_friend')}}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 text-right mt-3">
        <button class="btn_sub btnsub_arr">{{__('labels.btn_refer_student')}}</button>
    </div>
</div>