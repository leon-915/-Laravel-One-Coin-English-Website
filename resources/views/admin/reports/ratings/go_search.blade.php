
<div class="row">
    <div class="col-12">
        <div class="row  mt-2">
            <div class="col-lg-12">
                <div class="date_top_menu_main">
                    <form method="GET" accept="{{ route('admin.reports.ratings.index') }}" id="go_search" name="go_search" autocomplete="off">
                        <div class="date_top_menu">
                            <a class="nav-item {{ !empty($filter) && $filter == 'y' ? 'active' : '' }}" href="{{ route('admin.reports.ratings.index',['opt' => $option, 'filter' => 'y', 'sort' => $sort]) }}">Year</a>
                            <a class="nav-item {{ !empty($filter) && $filter == 'm' ? 'active' : '' }}" href="{{ route('admin.reports.ratings.index',['opt' => $option, 'filter' => 'm', 'sort' => $sort]) }}">This Month</a>
                            <a class="nav-item {{ empty($filter) ? 'active' : '' }}" href="{{ route('admin.reports.ratings.index',['opt' => $option, 'filter' => '', 'sort' => $sort]) }}">Last 7 Days</a>
                            <a class="nav-item {{ !empty($filter) && $filter == 'd' ? 'active' : '' }}" href="{{ route('admin.reports.ratings.index',['opt' => $option, 'filter' => 'd', 'sort' => $sort]) }}">Today</a>

                            <div class="date_custom_sel">
                                <p>Custom</p>
                                <input type="text" placeholder="yyyy-mm-dd" class="form-control from_date select" id="from_date" name="from_date" value="{{ !empty($from_date) ? $from_date : '' }}" >
                                <input type="text" placeholder="yyyy-mm-dd" class="form-control to_date select" id="to_date" name="to_date" value="{{ !empty($to_date) ? $to_date : '' }}">
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
                    <li class="nav-item {{ !empty($option) && $option == 'rating_evaluate_by_students' ? 'active' : '' }} ">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'rating_evaluate_by_students']) }}">
                            Number of ratings and evaluations given by student
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'rating_evaluate_per_student' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'rating_evaluate_per_student']) }}">
                            Number of ratings and evaluations given per student
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'top_10_student_by_rating' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'top_10_student_by_rating',]) }}">
                            Top 10 students by ratings and evaluations
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'last_10_student_by_rating' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'last_10_student_by_rating']) }}">
                            Least 10 students by ratings and evaluations
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'rating_received_by_teachers' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'rating_received_by_teachers']) }}">
                            Number of ratings and evaluations received by teacher
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'rating_received_per_teacher' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'rating_received_per_teacher']) }}">
                            Number of ratings and evaluations received per teacher
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'top_10_teacher_by_rating' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'top_10_teacher_by_rating']) }}">
                            Top 10 teachers received ratings and evaluations
                        </a>
                    </li>
                    <li class="nav-item {{ !empty($option) && $option == 'last_10_teacher_by_rating' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reports.ratings.index',['opt' => 'last_10_teacher_by_rating']) }}">
                            Least 10 teachers received ratings and evaluations
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
