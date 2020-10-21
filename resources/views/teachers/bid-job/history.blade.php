@extends('layouts.app',['title'=> __('labels.teacher_bid_job')])
@section('title', __('labels.teacher_bid_job'))
@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="{{route('teachers.job.list')}}">
                                        <span>New job</span></a>
                                </li>
                                <li role="presentation"><a href="#history" aria-controls="history" role="tab"
                                                           data-toggle="tab" class="active"><span>History</span></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpane1" class="tab-pane active" id="history">
                                    <div class="order_details_sec history">
                                        <div class="row">
                                            <div class="col-12 col-lg-6 cpl-md-12">
                                                <div class="plan_header">
                                                    <h2>Previous Job</h2>
                                                    <p>Some details of your previous job post</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive view_order_list">
                                                    <table class="table" id="history_table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Sr.No</th>
                                                            <th scope="col">Student Name</th>
                                                            <th scope="col">Subject</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Time</th>
                                                            <th scope="col">Bidding Price</th>
                                                            <th scope="col">Job Price</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                        </thead>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


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
        <script>
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
                    url: '{{route('teachers.job.bid.history')}}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {

                    }
                },
                order: [[3, "desc"]],
                columns: [
                    // {data: 'id', name: 'id'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex','orderable':false,'searchable':false},
                    {data: 'student', name: 'student'},
                    {data: 'job.subject', name: 'job.subject'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'time', name: 'time', orderable: false, searchable: false},
                    {
                        data: 'bid_price',
                        name: 'bid_price',
                        // render: $.fn.dataTable.render.number(',', '.', 0, '¥')
                    },
                    {data: 'job.price', name: 'job.price', render: $.fn.dataTable.render.number(',', '.', 0, '¥')},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            })

        </script>
    @endpush
@endsection



