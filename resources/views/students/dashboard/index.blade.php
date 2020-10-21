@extends('layouts.app',['title'=> __('labels.student_dashboard')])
@section('title', __('labels.student_dashboard'))
@section('content')
    <section class="profile_sec stud-sec-cont">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="card custome_nav">
                            <ul class="nav nav-tabs one-page-tab" role="tablist">
                                <li role="presentation">
                                    <a href="#management" aria-controls="management" role="tab" data-toggle="tab"
                                       class="dash_tab" data-url="{{route('student.dashboard.get.current')}}">
                                        <span>{{__('labels.dash_current_cource')}}</span>
                                    </a>
                                </li>

                                <li role="presentation" class="">
                                    <a href="#prev_course" aria-controls="prev_course" role="tab" data-toggle="tab"
                                       class="dash_tab" data-url="{{route('student.dashboard.get.previous')}}">
                                        <span>{{__('labels.dash_previous_cource')}}</span>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="#order" aria-controls="order"
                                       data-url="{{route('student.dashboard.get.orders')}}" role="tab" data-toggle="tab"
                                       class="dash_tab">
                                        <span>{{__('labels.dash_recent_order')}}</span>
                                    </a>
                                </li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpane1" class="tab-pane " id="management">

                                </div>


                                <div role="tabpane2" class="tab-pane " id="prev_course">

                                </div>


                                <div role="tabpane3" class="tab-pane active" id="order">


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
            $(document).ready(function () {
                let cloader = <?= json_encode(View::make('layouts.partials.loader')->render()) ?>;
                let tab = "{{ $ref }}";
                let dis = $('a[aria-controls=' + tab + ']');
                let curl = dis.data('url');
                $('.dash_tab').removeClass('active');
                dis.addClass('active');
                $('.tab-pane').removeClass('active').removeClass('show');
                $('#' + tab).addClass('active').addClass('show');

                if (curl) {
                    $.ajax({
                        url: curl,
                        dataType: 'JSON',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        beforeSend: function () {
                            $('#' + tab).html(cloader);
                        },
                        success: function (resp) {
                            if (resp.type == 'success') {
                                $('#' + tab).html(resp.html);
                                if (tab == "order") {
                                    applyTabJs(tab);
                                }
                            }
                        }
                    });
                }

                $(document).on('click', '.dash_tab', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let tab = $(this).attr('aria-controls');
                    const params = new URLSearchParams(location.search);
                    params.set('ref', tab);
                    window.history.replaceState({}, '', `${location.pathname}?${params}`);
                    $('.dash_tab').removeClass('active');
                    $(this).addClass('active');

                    let curl = $(this).data('url');
                    if (curl) {
                        $.ajax({
                            url: curl,
                            dataType: 'JSON',
                            type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            beforeSend: function () {
                                $('#' + tab).html(cloader);
                            },
                            success: function (resp) {
                                if (resp.type == 'success') {
                                    $('#' + tab).html(resp.html);
                                    if (tab == "order") {
                                        applyTabJs(tab);
                                    }
                                    if (tab == "prev_course") {
                                        applyTabJs(tab);
                                    }
                                }
                            }
                        });
                    }
                });

                var oTable = '';
                var prevTable = '';

                function applyTabJs(tab) {
                    if (tab == 'order') {
                        oTable = $('#order_table').DataTable({
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
                                url: '{{route('students.dashboard.get.orders.list')}}',
                                type: 'POST',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: function (d) {

                                }
                            },
                            order: [[2, 'DESC']],
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex','orderable':false,'searchable':false},
                                // {data: 'id', name: 'id', render: $.fn.dataTable.render.number(',', '.', 0, '#')},
                                {data: 'product', name: 'product',orderable: false, searchable: false},
                                {data: 'created_at', name: 'created_at'},
                                /* {data: 'status', name: 'status', orderable: false, searchable: false}, */
                                {
                                    data: 'amount',
                                    name: 'amount',
                                    //render: $.fn.dataTable.render.number(',', '.', 0, '¥')
                                },
                                {data: 'package_status', name: 'package_status', orderable: false, searchable: false},
                                {data: 'action', name: 'action', orderable: false, searchable: false},
                            ]
                        });
                    }
                }
            });

            $(document).on('click', '#cancel', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var url = $(this).attr('data-url');
                $(".yes_delete").attr('id', url);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let url = $(this).attr('id');
                $.ajax({
                    url: url,
                    dataType: 'JSON',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend:function(){
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (res) {
                        $("#exampleModalPrimary").modal('hide');
                        window.location.href = '{{route('students.dashboard.index')}}';
                        //$('.app-loader').addClass('d-none');
                    }
                });
            });

        </script>
    @endpush


@endsection
