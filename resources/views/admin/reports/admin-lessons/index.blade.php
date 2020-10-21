@extends('admin.layouts.admin',['title'=>__('labels.admin_lesson_report')])

@section('title',__('labels.admin_lesson_report') )

@section('content')
<?php
$url = url('');

	if (Auth::guard('admin')->user()->role == 'sub_admin') {
		$url = url('/admin/lesson-reports/admin-lessons-report');
	} else {
		$url = url('/admin/dashboard');
	}

?>
    <div class="content-wrapper ">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.admin_lesson_report') }} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                                href="{{ $url }}">{{ __('labels.dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('labels.admin_lesson_report') }}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="admin_date_sec">
                @include('admin.reports.admin-lessons.go_search')
            </div>
        </div>
    </div>

    @push('scripts')

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
                                label: 'Lesson',
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
