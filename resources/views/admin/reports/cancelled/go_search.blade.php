
<div class="row">
    <div class="col-12">
        <div class="row  mt-2">
            <div class="col-lg-12">
                <div class="date_top_menu_main">
                    <form method="GET" accept="{{ route('admin.reports.cancelled.index') }}" id="go_search" name="go_search" autocomplete="off">
                        <div class="date_top_menu">
                            <a class="nav-item {{ !empty($filter) && $filter == 'y' ? 'active' : '' }}" href="{{ route('admin.reports.cancelled.index',['opt' => $option, 'filter' => 'y', 'sort' => $sort]) }}">Year</a>
                            <a class="nav-item {{ !empty($filter) && $filter == 'm' ? 'active' : '' }}" href="{{ route('admin.reports.cancelled.index',['opt' => $option, 'filter' => 'm', 'sort' => $sort]) }}">This Month</a>
                            <a class="nav-item {{ empty($filter) ? 'active' : '' }}" href="{{ route('admin.reports.cancelled.index',['opt' => $option, 'filter' => '', 'sort' => $sort]) }}">Last 7 Days</a>
                            <a class="nav-item {{ !empty($filter) && $filter == 'd' ? 'active' : '' }}" href="{{ route('admin.reports.cancelled.index',['opt' => $option, 'filter' => 'd', 'sort' => $sort]) }}">Today</a>

                            <div class="date_custom_sel">
                                <p>Custom</p>
                                <input type="text" placeholder="yyyy-mm-dd" class="form-control from_date select" id="from_date" name="from_date" value="{{ !empty($from_date) ? $from_date : '' }}" >
                                <input type="text" placeholder="yyyy-mm-dd" class="form-control to_date select" id="to_date" name="to_date" value="{{ !empty($to_date) ? $to_date : '' }}">

                                <select class="form-control all-select" id="type" data-plugin="selectpicker" name="type">
                                    <option value="">All</option>
                                    <option value="csd" <?= (!empty($type) && $type == 'csd') ? 'selected' : '' ?>>CSD</option>
                                    <option value="cancel" <?= (!empty($type) && $type == 'cancel') ? 'selected' : '' ?>>Cancelled</option>
                                    <option value="student_not_show" <?= (!empty($type) && $type == 'student_not_show') ? 'selected' : '' ?>>Snoshow</option>
                                    <option value="teacher_not_show" <?= (!empty($type) && $type == 'teacher_not_show') ? 'selected' : '' ?>>Tnoshow</option>
                                </select>

                                @if (!empty($users))
                                    <select class="form-control all-select" id="user_id" data-plugin="selectpicker" name="user_id">
                                        <option value="">Select </option>
                                        @foreach($users as $student)
											@if($student['firstname'] != '')
                                            <option value="{{ $student['id'] }}" <?= (!empty($user_id) && $student['id'] == $user_id) ? 'selected' : '' ?>> {{ $student['firstname'] . ' '. $student['lastname'] }} </option>
										@endif
                                        @endforeach
                                    </select>
                                @endif

                                @if (!empty($locations))
                                    <select class="form-control all-select" id="location_id" data-plugin="selectpicker" name="location_id">
                                        <option value="">Select Location</option>
                                        @foreach($locations as $loc)
                                            <option value="{{ $loc['id'] }}" <?= (!empty($location_id) && $loc['id'] == $location_id) ? 'selected' : '' ?>> {{ $loc['title'] }} </option>
                                        @endforeach
                                    </select>
                                @endif

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
            <div class="col-lg-3">
                <ul class="left_adm_menu">
                    <li class="nav-item {{ !empty($option) && $option == 'total_cancelled' ? 'active' : '' }} ">
                        <a class="nav-link" href="{{ route('admin.reports.cancelled.index',['opt' => 'total_cancelled']) }}">
                            Total number of lesson cancellations
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'total_cancelled_per_teacher' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.cancelled.index',['opt' => 'total_cancelled_per_teacher']) }}">
                            Number of lesson cancellations per teacher
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'total_cancelled_per_student' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.cancelled.index',['opt' => 'total_cancelled_per_student',]) }}">
                            Number of lesson cancellations per student
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'total_cancelled_per_location' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.cancelled.index',['opt' => 'total_cancelled_per_location']) }}">
                            Location of lesson cancellations
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'time_of_cancellations' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.cancelled.index',['opt' => 'time_of_cancellations']) }}">
                            Time of lesson cancellations
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9 pl-0">
                <div class="div-canvas-chart">
                    <canvas id="bar-chart" width="600" height="500"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
