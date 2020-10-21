<div class="card mb-3">
	<div class="card-body">
		<h4 class="card-title">{{ __('labels.facebook_posts_filter') }}</h4>
		<div class="row">
			<div class="col-12">
				{!! Form::open(array('role'=>'form','id'=>'facebook-posts-search','name'=>"facebook-posts-search",'autocomplete' => "off")) !!}
					<div class="row">
						<div class="form-group col-md-4">
							<label class="form-control-label" for="status">{{ __('labels.status') }}</label>
							<select class="form-control" name="status">
								<option value="">{{ __('labels.select_status') }}</option>
								<option value="1">Pending</option>
								<option value="2">Approved</option>
								<option value="3">Not Approved</option>
								<option value="4">Archived</option>
							</select>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

