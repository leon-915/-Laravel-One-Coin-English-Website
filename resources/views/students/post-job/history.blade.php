@extends('layouts.app',['title'=> __('labels.stu_job_post')])
@section('title', __('labels.stu_job_post'))
@section('content')

    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="{{route('students.post.job.index')}}">
                                        <span>{{__('labels.stu_new_job')}}</span></a>
                                </li>
                                <li role="presentation"><a href="{{route('students.post.job.form')}}">
                                        <span>{{__('labels.stu_create_job')}}</span></a>
                                </li>
                                <li role="presentation"><a href="#history" aria-controls="history" role="tab"
                                                           data-toggle="tab" class="active"><span>{{__('labels.stu_history')}}</span></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpane1" class="tab-pane active" id="history">
                                    @include('students.post-job.tabs.jobhistory')
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    @push('scripts')
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

        <script type="text/javascript">

            //set content bottom padding
            $("#content").css("padding-bottom", $("footer").outerHeight() + 'px');
            $("#content").css("padding-top", $("header").outerHeight() + 'px');

            // $(document).on("click", ".open_detail", function (e) {
            //     console.log(123);
            //     e.preventDefault();
            //     $('.history_detail').removeClass('d-none');
            //     $('.history').addClass('d-none');
            //     $('.history_detail').show();
            // });
            //
            // $(document).on("click", "#cancel-edit-job", function (e) {
            //     e.preventDefault();
            //     $('.history_detail').addClass('d-none');
            //     $('.history').removeClass('d-none');
            // });

            // $(document).ready(function () {
            //     // $("#new_job").on("click", function () {
            //     //     //alert("hello");
            //     //     $(".post_add_remove").slideToggle("fast");
            //     // });
            //
            //     // $("#open_detail").on("click", function () {
            //     //     //alert("hello");
            //     //     $(".order_details_sec.history").slideToggle("fast");
            //     //     $(".order_details_sec.history_detail").slideToggle("fast");
            //     // });
            // });

        </script>

        <script>

            /* chart.js chart examples */
            // chart colors
            var colors = ['#062039', '#032e56', '#125a93', '#1ba1d7', '#ddebfc', '#e1e1e1'];
            var cornerRadius = 20;

            /* 3 donut charts */
            var donutOptions = {
                cutoutPercentage: 85,
                legend: {position: 'bottom', padding: 20, labels: {pointStyle: 'circle', usePointStyle: true}}
            };

            // donut 3
            var chDonutData3 = {
                labels: ['1 TecherStudent - Classroom', '2 IBC060_TWE', '3 Talent 60 - 24 - 90', '4 IBC060 - 12 - 90', '5-Aktana . 24 . 90', 'Others'],
                datasets: [
                    {
                        backgroundColor: colors.slice(0, 6),
                        borderWidth: 0,
                        data: [16, 16, 16, 16, 16, 16]
                    }
                ]
            };
            var chDonut3 = document.getElementById("chDonut3");
            if (chDonut3) {
                new Chart(chDonut3, {
                    type: 'pie',
                    data: chDonutData3,
                    options: donutOptions

                });
            }
            // donut 3
            var chDonutData4 = {
                labels: ['1 TecherStudent - Classroom', '2 IBC060_TWE', '3 Talent 60 - 24 - 90', '4 IBC060 - 12 - 90', '5-Aktana . 24 . 90', 'Others'],
                datasets: [
                    {
                        backgroundColor: colors.slice(0, 6),
                        borderWidth: 0,
                        data: [16, 16, 16, 16, 16, 16]

                    }
                ]
            };
            var chDonut4 = document.getElementById("chDonut4");
            if (chDonut4) {
                new Chart(chDonut4, {
                    type: 'pie',
                    data: chDonutData4,
                    options: donutOptions

                });
            }


            oTable = $('#history_table').DataTable({
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
                    url: '{{route('students.post.job.historytable')}}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {

                    }
                },
                order: [[0, 'DESC']],
                columns: [
                    {data: 'price', name: 'price', render: $.fn.dataTable.render.number(',', '.', 0, '¥')},
                    {data: 'subject', name: 'subject', orderable: false},
                    {data: 'created_at', name: 'created_at'},
                    // {data: 'time', name: 'status', orderable: false, searchable: false},
                    {
                        data: 'bid.bid_price',
                        name: 'bid.bid_price',
                        render: $.fn.dataTable.render.number(',', '.', 0, '¥'),
                        orderable: false, searchable: false
                    },
                    {data: 'bid.teacher.firstname', name: 'bid.teacher.firstname', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            })


        </script>
    @endpush
@endsection