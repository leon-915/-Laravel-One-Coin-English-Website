
<div class="row question-options" id="email-{inx}">
	<div class="form-group col-6">
		<input type="text" name="email[{inx}]" placeholder="{{__('labels.stu_write_email_to_friend')}}" class="form-control val-email" id="title-{inx}" maxlength="500" />
	</div>
	<div class="form-group col-1">
		<button type="button" class="btn btn-danger btn_sub" title="Remove Option" data-id="{inx}" onclick="optionAction.removeOption(this);">
			<i class="fas fa-times" aria-hidden="true"></i>
		</button>
	</div>
</div>