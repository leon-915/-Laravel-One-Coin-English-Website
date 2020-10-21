@if(!empty($emails))
	@foreach ($emails as $i => $email)
		<div class="row question-options" id="email-{!! $email->id !!}">
			<div class="form-group col-6">
				<input type="email" name="email[<?= $email->id ?>]" value="{{$email->email}}" id="title-{{$email->id}}"
				class="form-control val-email" placeholder="{{__('labels.write_email_address')}}" maxlength=500 data-email>
			</div>
			
			<div class="form-group col-1">
				<button type="button" class="btn btn-danger btn-block" title="Remove Option" data-id="<?= $email->id ?>" onclick="optionAction.removeOption(this);">
					 <i class="fas fa-times" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	@endforeach
@endif



