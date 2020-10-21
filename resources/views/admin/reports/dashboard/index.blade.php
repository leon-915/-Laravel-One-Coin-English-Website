@extends('admin.layouts.admin',['title'=>__('Report Dashboard') ,'search'=>'admin.teachers.search'])

@section('title',__('Dashboard') )

@section('content')

    <div class="content-wrapper ">
        <div class="page-header">
            <h3 class="page-title">Dashboard</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
{{--                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard') }}</a></li>--}}
                    {{--<li class="breadcrumb-item active" aria-current="page">Dashboard</li>--}}
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
                                    <form method="GET" accept="{{ route('admin.lesson-reports.dashboard') }}" id="go_search" name="go_search" autocomplete="off">
                                        <div class="date_top_menu">
                                            <a class="nav-item {{ !empty($filter) && $filter == 'y' ? 'active' : '' }}" href="{{ route('admin.lesson-reports.dashboard',['opt' => $option, 'filter' => 'y', 'sort' => $sort]) }}">Year</a>
                                            <a class="nav-item {{ !empty($filter) && $filter == 'm' ? 'active' : '' }}" href="{{ route('admin.lesson-reports.dashboard',['opt' => $option, 'filter' => 'm', 'sort' => $sort]) }}">This Month</a>
                                            <a class="nav-item {{ empty($filter) ? 'active' : '' }}" href="{{ route('admin.lesson-reports.dashboard',['opt' => $option, 'filter' => '', 'sort' => $sort]) }}">Last 7 Days</a>
                                            <a class="nav-item {{ !empty($filter) && $filter == 'd' ? 'active' : '' }}" href="{{ route('admin.lesson-reports.dashboard',['opt' => $option, 'filter' => 'd', 'sort' => $sort]) }}">Today</a>

                                            <div class="date_custom_sel">
                                                <p>Custom</p>
                                                <input type="text" placeholder="yyyy-mm-dd" class="form-control from_date select" id="from_date" name="from_date" value="{{ !empty($from_date) ? $from_date : '' }}" >
                                                <input type="text" placeholder="yyyy-mm-dd" class="form-control to_date select" id="to_date" name="to_date" value="{{ !empty($to_date) ? $to_date : '' }}">

                                                @if (!empty($filter))
                                                    <input type="hidden" name="filter" value="{{$filter}}">
                                                @endif

                                                @if (!empty($option))
                                                    <input type="hidden" name="opt" value="{{$option}}">
                                                @endif

                                                @if (!empty($sort))
                                                    <input type="hidden" name="sort" value="{{$sort}}">
                                                @endif

                                                <button class="go_btn btn btn-gradient-primary btn-rounded btn-fw " type="submit">Go</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="chart-container p-4 mb-4" style="position: relative; height:460px;border: 1px solid;">
                                    <canvas id="new-course-chart" height="100"></canvas>
                                </div>
                                <div class="chart-container p-4 mb-4" style="position: relative; height:460px;border: 1px solid;">
                                    <canvas id="remaining-balance-chart" height="100"></canvas>
                                </div>
                                <div class="chart-container p-4 mb-4" style="position: relative; height:460px;border: 1px solid;">
                                    <canvas id="service-expense-chart" height="100"></canvas>
                                </div>
                                <div class="chart-container p-4 mb-4" style="position: relative; height:460px;border: 1px solid;">
                                    <canvas id="expires-chart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{asset('js/Chart.min.js')}}"></script>
        @include('admin.reports.dashboard.index.new-courses')
        @include('admin.reports.dashboard.index.remaining-balance')
        @include('admin.reports.dashboard.index.expires')
        @include('admin.reports.dashboard.index.expense')
        <script>
            $('#from_date').datepicker({
                dateFormat: "yy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
                maxDate : '0d',
                changeMonth: true,
                changeYear: true,
                onClose: function (selectedDate) {
                    $("#to_date").datepicker("option", "minDate", selectedDate);
                    var date2 = $('#from_date').datepicker('getDate', '+1d');
                    date2.setDate(date2.getDate()+1); 
                    $('#to_date').datepicker('setDate', date2);
                }
            });

            $('#to_date').datepicker({
                dateFormat: "yy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
                maxDate : '0d',
                changeMonth: true,
                changeYear: true,
                onClose: function (selectedDate) {
                    $("#from_date").datepicker("option", "maxDate", selectedDate);
                }
            });
        </script>
    @endpush
@endsection
