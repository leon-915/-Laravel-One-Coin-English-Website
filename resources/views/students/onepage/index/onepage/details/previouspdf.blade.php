<div class="card">
    <div class="card-header" id="heading-pdf">
        <h5 class="mb-0">
            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-pdf"
                aria-expanded="false" aria-controls="collapse-pdf">
                Previous Lesson PDF ・ 前回のレッスンのPDF
            </a>
        </h5>
    </div>
    <div id="collapse-pdf" class="collapse" data-parent="#accordion" aria-labelledby="heading-pdf">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="stus_tbl">
                        <div class="row" id="pdf_listing">
										
						</div>
						<div class="row">
							 <div class="col-sm-12 col-md-12 col-lg-12 text-center">
								<input type="button" id="load_more_button" value="{{ __('labels.view_more') }}" class="button">
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
	<script type="text/javascript">
		var track_page = 1; //track user click as page number, right now page number is 1
		load_contents(track_page, '<?php echo $booking->user_id; ?>'); //load content
		$("#load_more_button").prop("disabled", false);
		$(document).on('click', "#load_more_button", function (e) { //user clicks on button
			track_page++; //page number increment everytime user clicks load button
			load_contents(track_page, '<?php echo $booking->user_id; ?>'); //load content
		});

		//Ajax load function
		function load_contents(track_page, student_id) {
			$.ajax({
				url: "<?php echo route('teachers.dashboard.get.pdfs')?>",
				method: "post",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{
					page: track_page,
					student_id: student_id,
				},
				success: function (result) {
					if (result.trim().length == 0) {
						//display text and disable load button if nothing to load
						$("#load_more_button").val("No more records!").prop("disabled", true);
					}
					$("#pdf_listing").append(result); //append data into #results element
					
				}
			});
		}
	</script>
@endpush