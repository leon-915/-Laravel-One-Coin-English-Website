<?php if($student->credit_balance > 0) { ?>
	<div class="row">
		<div class="col-12">
			<div class="plan_header">
				<h2>{{__('labels.stu_balance')}}</h2>
				<p>{{__('labels.stu_balance_span')}}</p>
			</div>

			<h4>{{__('labels.stu_account_balance')}} : {{array_sum([$student->credit_balance,$student->reward_balance])}}</h4>

			<p><span> {{__('labels.stu_credit_points')}} : </span> {{!empty($student->credit_balance) ? $student->credit_balance :'0' }} </p>
			<p><span> {{__('labels.stu_reward_points')}} : </span> {{!empty($student->reward_balance) ? $student->reward_balance : '0' }} </p>

		</div>
	</div>
<?php } else { ?>
	<div class="row">
		<div class="col-12">
			<div class="plan_header">
				<h2>{{__('labels.stu_balance')}}</h2>
				<p>{{__('labels.regular_stu_balance_span')}}</p>
			</div>
			<p><span> {{__('labels.stu_reward_points')}} : </span> {{!empty($student->reward_balance) ? $student->reward_balance : '0' }} </p>

		</div>
	</div>
<?php } ?>	