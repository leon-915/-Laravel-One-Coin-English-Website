@extends('admin.layouts.admin',['title'=>'Manage One Page Levels Points'])
@section('title', 'Search Analytics')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.search_analytics')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.search_analytics')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="admin_date_sec">
                <div class="row">
					<div class="col-12">
						<div class="row  mt-2">
							<div class="col-lg-12">
								<div class="date_top_menu_main">
									<div class="date_top_menu">
										<div class="date_custom_sel">
											<div class="date_custom_filter">
											{!! Form::open(array('method'=>'get','route' =>'admin.search-analytics.index','role'=>'form','id'=>'go_search','name'=>"go_search",'autocomplete' => "off")) !!}
												<input type="text" placeholder="yyyy-mm-dd" class="form-control from_date select "
													   name="from_date" id="from_date" value="">
												<input type="text" placeholder="yyyy-mm-dd" class="form-control to_date select"
													   name="to_date" id="to_date" value="">
													   
												<button class="go_btn btn btn-gradient-primary btn-rounded btn-fw" type="submit">Go</button>	
											{!! Form::close() !!}												
											</div>
											<div>
												<a href="{{ route('admin.search-analytics-download') }}">Download OnePage Tracker CSV</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">							
							<div class="col-lg-9 pl-0">
							
								<div class="div-canvas-chart">
									<canvas id="bar-chart" width="600" height="500"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
@push('scripts')
    <script>

        $('.from_date').datepicker({
            dateFormat: "yy-mm-dd",
            enableOnReadonly: true,
            todayHighlight: true,
            maxDate : '0d',
            changeMonth: true,
            changeYear: true,
            onClose: function (selectedDate) {
                $(".to_date").datepicker("option", "minDate", selectedDate);
                var date2 = $('#from_date').datepicker('getDate', '+1d');
                date2.setDate(date2.getDate()+1);
                $('.to_date').datepicker('setDate', date2);
            }
        });

        $('.to_date').datepicker({
            dateFormat: "yy-mm-dd",
            enableOnReadonly: true,
            todayHighlight: true,
            maxDate : '0d',
            changeMonth: true,
            changeYear: true,
            onClose: function (selectedDate) {
                $(".from_date").datepicker("option", "maxDate", selectedDate);
            }
        });

    </script>
	<script>
            $(document).on("click", ".deleteOnePageLevelsPoints", function () {
                var one_page_levels_points_id = $(this).attr('id');
                $(".yes_delete").attr('id', one_page_levels_points_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let one_page_levels_points_id = $(this).attr('id');
                if(one_page_levels_points_id){
                    $.ajax({
                        url: '{{URL::to('admin/one-page-points')}}' + '/' + one_page_levels_points_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/one-page-points')}}';
                        }
                    });
                }
            });
        </script>
		
		<script src="{{asset('js/Chart.min.js')}}"></script>

        @if(!empty($lessionsData))
            <script>
                // Return with commas in between
                var numberWithCommas = function (x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                };
                var bar_ctx2 = document.getElementById('bar-chart');
                var bar_chart2 = {
                    type: 'bar',
                    data: {
                        labels:<?=  json_encode($lessionsData['lables']) ?>,
                        datasets: [
                            {
                                label: 'Count',
                                data:  <?= !empty($lessionsData['data']) ? json_encode($lessionsData['data']) : json_encode([])?>,
                                backgroundColor: "rgba(55, 160, 225, 0.7)",
                                hoverBackgroundColor: "rgba(55, 160, 225, 0.7)",
                                hoverBorderWidth: 2,
                                hoverBorderColor: 'lightgrey'
                            }
                        ]
                    },
                    options: {
                        animation: {
                            duration: 10
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    console.log(tooltipItem, data);
                                    return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                stacked: true,
                                gridLines: {display: false},
                            }],
                            yAxes: [{
                                stacked: true,
                                // ticks: {
                                //     callback: function(value) {
                                //         return 5 },
                                // },
                                // display: true,
                                ticks: {
                                    min: 0,
                                    stepSize: 5,
                                    maxTicksLimit: 20
                                }
                            }],
                        }, // scales
                        legend: {display: true}
                    } // options
                };
                new Chart(bar_ctx2, bar_chart2)
            </script>
        @endif
@endpush   
@endsection
