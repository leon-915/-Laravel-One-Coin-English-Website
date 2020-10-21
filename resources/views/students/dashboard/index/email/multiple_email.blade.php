@if(!empty($emails))
	@foreach ($emails as $i => $email)

		<div class="row question-options" id="email-{!! $email->id !!}">
			<div class="form-group col-9 col-md-9 col-lg-6">
				<input type="email" name="email[<?= $email->id ?>]" value="{{$email->email}}" id="title-{{$email->id}}"
				class="form-control val-email" placeholder="{{__('labels.stu_write_email_to_friend')}}" maxlength=500 data-email>
				{{-- {!!
					Form::text(
						"email[".$email->id."]",
						$email->email,
						array(
							'placeholder' => 'Write email to your friend',
							'class' 	=> 'form-control val-email',
							'id'  		=> 'title-'.$email->id,
							'data-email',
							"maxlength" => 500
						)
					)
				!!} --}}
			</div>

			<div class="form-group col-3 col-md-3 col-lg-1">
				<button type="button" class="btn btn-danger btn-block" title="Remove Option" data-id="<?= $email->id ?>" onclick="optionAction.removeOption(this);">
					 <i class="fas fa-times" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	@endforeach
@endif

