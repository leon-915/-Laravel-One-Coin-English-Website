@if(!empty($emails))
	@foreach ($emails as $i => $email)

		<div class="row question-options" id="email-{!! $email->id !!}">
			<div class="form-group col-6">
				{!!
					Form::text(
						"email[".$email->id."]",
						$email->email,
						array(
							'placeholder' => __('labels.stu_write_email_to_friend'),
							'class' 	=> 'form-control val-email',
							'id'  		=> 'title-'.$email->id,
							"maxlength" => 500
						)
					)
				!!}
			</div>
			
			<div class="form-group col-1">
				<button type="button" class="btn btn-danger btn-block" title="Remove Option" data-id="<?= $email->id ?>" onclick="optionAction.removeOption(this);">
					<i class="fas fa-trash" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	@endforeach
@endif

