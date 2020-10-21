<div class="order_details_sec">
    <div class="row">
        <div class="col-12 col-lg-6 cpl-md-12">
            <div class="plan_header">
                <h2>{{__('labels.dash_previous_cource')}}</h2>
                <p>{{__('labels.dash_previous_cource_details')}}</p>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="table-responsive view_order_list clearfix">
                <table class="table"  id="previous_course_table">
                    <thead>
                    <tr>
                        <th scope="col" width="80%">{{__('labels.dash_cource')}}</th>
                        <th scope="col" width="10%">{{__('labels.dash_action')}}</th>
                        <th scope="col" width="10%"></th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
       {{--  <div class="col-12">
            <p class="subscribe_text">Order other Subscriptions <a href="#"
                                                                   class="blue_colr"> here </a></p>
        </div> --}}
    </div>

</div>

{{-- <div class="courses_list">
    <div class="row">
        <div class="col-12">
            @if (!empty($student_lessons) && $student_lessons->toArray())
                <div class="plan_header">
                    <h2>Courses List</h2>
                    <p>Your current course details you can see here</p>
                </div>
                <div class="prev_course_list">
                    <p>Course Title</p>
                    <ul class="follow_list">
                        @foreach($student_lessons as $lesson)
                            <li>{{$lesson['service']['title']}}<a href="{{route('student.dashboard.get.previous.detail', $lesson['id'])}}">View Details</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
            <div class="plan_header">
                <h2>No previous courses</h2>
            </div>
            @endif
        </div>
    </div>
</div> --}}

<script type="text/javascript">
    prevTable = $('#previous_course_table').DataTable({
        dom: "<'row'<'col-sm-12 col-md-9'i><'col-sm-12 col-md-3'l>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-12'p>>",
        processing: true,
        serverSide: true,
        searching: false,
        language: {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="jumping-dots-loader"><span></span><span></span><span></span></div>',
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>",
            }
        },
        ajax: {
            url: '{{route('students.dashboard.get.previous.list')}}',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: function (d) {

            }
        },
        order: [[0, 'DESC']],
        columns: [
            {data: 'title', name: 'title',orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'reorder', name: 'reorder', orderable: false, searchable: false},
        ]
    });
</script>