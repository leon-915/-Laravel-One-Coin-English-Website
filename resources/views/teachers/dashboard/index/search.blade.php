@extends('layouts.app',['title'=>'Teacher Dashboard'])
@section('title', 'Teacher Dashboard')

@section('content')
<?php
$search_query = isset($_REQUEST['search_query']) && $_REQUEST['search_query'] != '' ? $_REQUEST['search_query'] : '';
$radio_search_by = isset($_REQUEST['radio_search_by']) && $_REQUEST['radio_search_by'] != '' ? $_REQUEST['radio_search_by'] : '';
$keyword_checked = 'checked="checked"';
$onepage_checked = '';
if ($radio_search_by == 'onepage') {
	$onepage_checked = 'checked="checked"';
	$keyword_checked = '';
}

$student_name = '';
if (strpos($search_query, ':')) {
	$recived_string = explode(':', $search_query);
	$serch_date = $recived_string[0];
	$student_name = $recived_string[1];
	$student_name = preg_replace('/\s+/', '', $student_name);
}
?>
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        {{-- <div class="top_search_sec">
                            @include('teachers.dashboard.index.keyword-search')
                        </div> --}}
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation">
                                    <a href="{{ route('teachers.dashboard.index') }}?ref=management" class="setting-tabs">
                                        <span>Management Dashboard</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="{{ route('teachers.dashboard.index') }}?ref=canvas" class="setting-tabs">
                                        <span>Onepage Canvas</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#keywords" aria-controls="keywords"
                                       data-url="{{ route('teachers.dashboard.get.keywords') }}" role="tab"
                                       data-toggle="tab" class="setting-tabs active">
                                        <span>Keywords & Phrases</span>
                                    </a>
                                </li>
                            </ul>
							<div class="tab-content">
                                <div role="tabpane1" class="tab-pane {{ ($ref == 'management') ? 'active' : ''}}"
                                     id="management">
                                </div>
                                <div role="tabpane3" class="tab-pane {{ ($ref == 'canvas') ? 'active' : ''}}"
                                     id="canvas">
                                </div>
                                <div role="tabpane2" class="tab-pane {{ ($ref == 'keywords') ? 'active' : ''}}"
                                     id="keywords"></div>
                            </div>
                           <div class="top_search_sec">
								<div class="row">
									<form name="frm-keyword-search" id="frm-keyword-search" action="<?php echo route('teachers.dashboard.getsearch');?>">
									  
										<div class="col-12">
											<div class="row">
												<div class="col-12">
													<div class="form-group has-search custom_search mb-3 ">
														<input type="text" name="search_query" id="search_query" class="form-control" placeholder="Search in English or Japanese." value="{{ $search_query }}" required>
														<button class="btn-search-keyword" type="submit"><i class="fa fa-search"></i>OnePage Search</button>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-2 col-md-4 col-12">
													<div class="form-group">
														<label class="checkcontainer">
															<input type="radio" <?php echo $keyword_checked; ?> name="radio_search_by" class="radio-search-type" value="keyword"> Keyword
															<span class="radiobtn"></span>
														</label>
													</div>
												</div>
												<div class="col-lg-3 col-md-4 col-12">
													<div class="form-group">
														<label class="checkcontainer">
															<input type="radio" <?php echo $onepage_checked;?> name="radio_search_by" class="radio-search-type" value="onepage"> OnePage Report
															<span class="radiobtn"></span>
														</label>
													</div>
												</div>
											</div>
										</div>
										<!--input type="hidden" name="ref" value="keywords"-->
									</form>
								</div>
							</div>
							<div class="reservation_keyword">
								<div class="row">
									<div class="col-12">
										<div class="alert alert-warning alert-dismissible fade show" role="alert">
											* Google translations may be inaccurate.
										</div>
									</div>
								</div>

								<div id="keyword-search-table-container">
									@if ($radio_search_by == 'onepage')
										<div class="row">
											<div class="col-12">
												<input type="hidden" id="search-keyword" name="search" value="{{ $squery }}">
												<div class="table-responsive keyword_table">
													<table class="table" id="onepage-table" style="width:100%">
														<thead>
															<tr>
																<th scope="col">Sr No</th>
																<th scope="col">Title</th>
																<th scope="col">Topic</th>
																<th scope="col">Student</th>
															</tr>
															@if (!empty($results))
																<?php 
																	$topic_array = [];
																	$i = 1; 
																?>
																@foreach ($results as $result)
																	<?php 
																	if($student_name != ''){
																		if((!strstr(strtolower($result->student->firstname), strtolower($student_name))) && (!strstr(strtolower($result->student->lastname), strtolower($student_name)))) {
																			
																			continue;
																		}
																	}
																	?>
																	<tr>
																		<td scope="col">{{ $i }}</td>
																		<td scope="col"><a href="{{route('students.share.onepage.index', ['id' => encrypt($result->id)]) }}">Accent OnePage{{ $result->onepage_title }}</a></td>
																		<td scope="col">
																			@if (!empty($result->topics))
																				<?php $topic_array = [];?>
																				@foreach ($result->topics as $topics)
																					<?php $topic_array[] = $topics['title'];?>
																				@endforeach	
																					<?php
																						echo implode(', ', $topic_array);
																					?>
																			@endif
																		</td>
																		<td scope="col">
																			<span class="badge badge-info" style="background-color:#002e58;">
																				{{ $result->student->firstname }} {{ $result->student->lastname }}
																			</span>	
																		</td>
																	</tr>
																	<?php $i++; ?>
																@endforeach														
															@endif
														</thead>
													</table>
												</div>
											</div>
										</div>									
									@else
										<div class="row">
											<div class="col-12">
												<input type="hidden" id="search-keyword" name="search" value="{{ $squery }}">
												<div class="table-responsive keyword_table">
													<table class="table" id="keyword-onepage-table" style="width:100%">
														<thead>
															<tr>
																<th scope="col">Sr No</th>
																<th scope="col">Topic</th>
																<th scope="col">Topic JP</th>
																<th scope="col">Student</th>
																<th scope="col">Action</th>
															</tr>
															@if (!empty($results))
																<?php 
																	$i = 1; 
																?>
																@foreach ($results as $result)
																	<tr>
																		<td scope="col">{{ $i }}</td>
																		<td scope="col"><a target="_blank" href="https://translate.google.com/#en/ja/{{ urlencode($result->keyword) }}">{{ $result->keyword }}</a></td>
																		<td scope="col"><a target="_blank" href="https://translate.google.com/#ja/en/{{ urlencode($result->keyword_ja) }}">{{ $result->keyword_ja }}</a></td>
																		<td scope="col">
																			<span class="badge badge-info" style="background-color:#002e58;">{{ $result->student_name }}</span>
																		</td>
																		<td scope="col">
																			<a target="_blank" class="onepage-report-action p-2" href="{{ route('students.share.onepage.index', ['id' => encrypt($result['lesson_booking_id'])]) }} ">ONEPAGE REPORT</a>
																		</td>
																	</tr>
																	<?php $i++;?>
																@endforeach														
															@endif
														</thead>
													</table>
												</div>
											</div>
										</div>
									@endif									
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @push('scripts')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter : 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif

        <script>
            let cloader = <?= json_encode(View::make('layouts.partials.loader')->render()) ?>;
            let curUrl = "{{ route('teachers.settings.index') }}";
            let lessonListUrl = "{{ route('teachers.settings.get.lessons.list') }}";
            let startSessionUrl = "{{ route('teachers.dashboard.start.session') }}";
            let cTab = "{{ $ref }}";
			
			$("input[type='radio']").on('click',function(){
		
				var searchby = $(this).val();
					$('#search_query').val('');
				if(searchby == 'keyword'){
					$('#search_query').attr('placeholder','Search in English or Japanese.');
				} else if (searchby == 'onepage') {
					$('#search_query').attr('placeholder','e.g. 170119 (YYMMDD) or 1701:John or 170119:John');
				} else {
					$('#search_query').attr('placeholder','Search in English or Japanese.');
				}
			});


        </script>
        <!--script src="{{ asset('js/teacher/dashboard.js') }}"></script-->
        <script src="{{ asset('js/teacher/onepage.js') }}"></script>
        <script src="{{ asset('onepage/js/simple-undo.js') }}"></script>
    @endpush
@endsection
