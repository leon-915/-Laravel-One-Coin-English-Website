<div class="row">
    <div class="col-12">
        {!! Form::open(array('method'=>'get','route' =>'admin.admin-lessons-report.index','role'=>'form','id'=>'go_search','name'=>"go_search",'autocomplete' => "off")) !!}

        <div class="row  mt-2">
            <div class="col-lg-12">
                <div class="date_top_menu_main">
                    <div class="date_top_menu">
                        <a class="nav-item {{ !empty($filter) && $filter == 'y' ? 'active' : '' }}"
                           href="{{ route('admin.admin-lessons-report.index',['filter' => 'y','opt' => $option,'sort' => $sort]) }}">
                            Year
                        </a>

                        <a class="nav-item {{ !empty($filter) && $filter == 'm' ? 'active' : '' }}"
                           href="{{ route('admin.admin-lessons-report.index',['filter' => 'm','opt' => $option,'sort' => $sort]) }}">
                            This Month
                        </a>

                        <a class="nav-item {{  empty($filter)  ? 'active' : '' }}"
                           href="{{ route('admin.admin-lessons-report.index',['filter' => '','opt' => $option,'sort' => $sort]) }}">
                            Last 7 Days
                        </a>

                        <a class="nav-item {{ !empty($filter) && $filter == 'd' ? 'active' : '' }}"
                           href="{{ route('admin.admin-lessons-report.index',['filter' => 'd','opt' => $option,'sort' => $sort]) }}">
                            Today
                        </a>

                        <div class="date_custom_sel">
                            <div class="date_custom_filter">

                                <a class="nav-item {{ !empty($from_date) && !empty($to_date) ? 'active' : '' }}">
                                    Custom
                                </a>

                                <input type="text" placeholder="yyyy-mm-dd" class="form-control from_date select "
                                       name="from_date" id="from_date" value="">
                                <input type="text" placeholder="yyyy-mm-dd" class="form-control to_date select"
                                       name="to_date" id="to_date" value="">

                                {{--@if(!empty($option) && $option == 'per_stu' )--}}
                                    {{--<select class="form-control all-select" id="duration" data-plugin="selectpicker"--}}
                                            {{--name="status">--}}
                                        {{--<option selected="selected" value="">All</option>--}}
                                        {{--<option value="15">15</option>--}}
                                        {{--<option value="25">25</option>--}}
                                        {{--<option value="50">50</option>--}}
                                    {{--</select>--}}
                                {{--@endif--}}

                                @if (!empty($students))
                                    <select class="form-control all-select" id="sid" data-plugin="selectpicker"
                                            name="sid">
                                        @foreach($students as $student)
											@if($student['firstname'] != '')
                                            <option value="{{ $student['id'] }}" {{!empty($sid) && $sid == $student['id'] ? 'selected' :''}}> {{ $student['full_name'] }} </option>
										@endif
                                        @endforeach
                                    </select>
                                @endif

                                <button class="go_btn btn btn-gradient-primary btn-rounded btn-fw" type="submit">Go</button>

                                @if(!empty($filter))
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                @endif

                                @if(!empty($option))
                                    <input type="hidden" name="opt" value="{{ $option }}">
                                @endif

                                @if(!empty($sort) && $sort == 'perteacher' || !empty($sort) && $sort == 'desc' || !empty($sort) && $sort == 'asc' )
                                    <input type="hidden" name="sort" value="{{ $sort }}">
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-3">
                <ul class="left_adm_menu">

                    <li class="nav-item {{ empty($option) ? 'active' : '' }} ">
                        <a class="nav-link" href="{{ route('admin.admin-lessons-report.index') }}"> Number of lessons
                            taken by all Students </a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'per_stu' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.admin-lessons-report.index',['opt' => 'per_stu']) }}">
                            Number of lessons taken by per student </a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'top_students' && $sort == 'desc' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'top_students','sort'=>'desc']) }}">
                            Display top 10 students</a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'top_students' && $sort == 'asc' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'top_students','sort'=>'asc']) }}">
                            Display least 10 students</a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'allteachers' && $sort == '' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'allteachers']) }}"> Number of
                            lessons taught by teacher </a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'allteachers' && $sort == 'perteacher' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'allteachers','sort'=>'perteacher']) }}">
                            Number of lessons taught per teacher </a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'top_teachers' && $sort == 'desc' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'top_teachers','sort'=>'desc' ]) }}">
                            Display top 10 teachers lessons taught </a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'top_teachers' && $sort == 'asc' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'top_teachers','sort'=>'asc']) }}">
                            Display least 10 teachers lessons taught </a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'total_trial_lessons' && $sort == '' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'total_trial_lessons']) }}">
                            Total number of trial lessons </a>
                    </li>

                    <li class="nav-item {{ !empty($option) && $option == 'total_trial_lessons' && $sort == 'perteacher' ? 'active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.admin-lessons-report.index',['opt' => 'total_trial_lessons','sort'=>'perteacher']) }}">
                            Number of trial lessons per teacher </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9 pl-0">
                <div class="div-canvas-chart">
                    <canvas id="bar-chart" width="600" height="500"></canvas>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
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

@endpush
