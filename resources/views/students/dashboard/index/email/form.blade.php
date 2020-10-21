<div class="row question-options" id="email-{inx}">
	<div class="form-group col-9 col-md-9 col-lg-6">
		{{-- <label class="form-control-label" for="title-{inx}">Option - {inx}</label> --}}
		<input type="text" name="email[{inx}]" placeholder="{{__('labels.stu_write_email_to_friend')}}" class="form-control val-email" id="title-{inx}" maxlength="500" data-email/>
	</div>
	<div class="form-group col-3 col-md-3 col-lg-1">
		{{-- <label class="form-control-label" for="title">&nbsp;</label> --}}
		<button type="button" class="btn btn-danger btn-block" title="Remove Option" data-id="{inx}" onclick="optionAction.removeOption(this);">
			 <i class="fas fa-times" aria-hidden="true"></i>
		</button>
	</div>
</div>
<style type="text/css">
	.btn-danger {
	    color: #fff;
	    background-color: #bd2130;
	    border-color: #b21f2d;
	    height: 50px;
	}
</style>