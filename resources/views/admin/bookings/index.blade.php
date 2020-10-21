@extends('admin.layouts.admin',['title'=>'Manage Bookings','search'=>'admin.bookings.search'])
@section('title', 'Manage Bookings')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_booking')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_booking')}}</li>
                </ol>
            </nav>
        </div>

        @include('admin.bookings.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/bookings/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Booking" title="Add Booking">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <table class="table" id="booking-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.booking_service_id')}}</th>
                                <th>{{ __('labels.booking_teacher_id')}}</th>
                                <th>{{ __('labels.booking_location_id')}}</th>
                                <th>{{ __('labels.booking_student_id')}}</th>
                                <th>{{ __('labels.lession_date')}}</th>
                                <th>{{ __('labels.lession_time')}}</th>
                                <th>{{ __('labels.lesson_duration')}}</th>
                             {{--    <th>{{ __('labels.additionl_info_teacher')}}</th>
                                <th>{{ __('labels.student_skype_id')}}</th>
                                <th>{{ __('labels.location_detail')}}</th> 
                                <th>{{ __('labels.lesson_type')}}</th>--}}
                                <th>{{ __('labels.status')}}</th>
                                <th>{{ __('labels.action')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #booking-table {
            width: 100% !important;
            overflow: auto;
            display: block;
        }
    </style>

    <div class="modal fade modal-danger show" id="exampleModalPrimary" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('labels.confirm_delete_booking')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
                    <button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw" data-dismiss="modal">
                        {{ __('labels.cancel')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
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
            var from = '';
            var to = '';
            var user_name = '';
            var oTable = $('#booking-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/bookings/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.service_id = $('input[name=service_id]').val();
                        d.teacher_id = $('input[name=teacher_id]').val();
                        d.location_id = $('input[name=location_id]').val();
                        d.user_id = $('input[name=user_id]').val();
                        d.lession_date = $('input[name=lession_date]').val();
                        d.lession_time = $('input[name=lession_time]').val();
                        d.lesson_duration = $('input[name=lesson_duration]').val();
                        d.additional_info_teacher = $('input[name=additional_info_teacher]').val();
                        d.student_skype_id = $('input[name=student_skype_id]').val();
                        d.location_detail = $('input[name=location_detail]').val();
                        d.lession_type = $('input[name=lession_type]').val();
                        d.status = $('input[name=status]').val();
                        d.from      = from;
                        d.to        = to;
                        d.user_name = user_name;
                       
                    }
                },
                /*columnDefs: [
                ],*/
                order: [[0,'DESC']],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'service_id', name: 'service_id'},
                    {data: 'teacher_id', name: 'teacher_id'},
                    {data: 'location_id', name: 'location_id'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'lession_date', name: 'lession_date'},
                    {data: 'lession_time', name: 'lession_time'},
                    {data: 'lesson_duration', name: 'lesson_duration'},
                    /*{data: 'additional_info_teacher', name: 'additional_info_teacher'},
                    {data: 'student_skype_id', name: 'student_skype_id'},
                    {data: 'location_detail', name: 'location_detail'},
                    {data: 'lession_type', name: 'lession_type'},*/
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteBooking", function () {
                var booking_id = $(this).attr('id');
                $(".yes_delete").attr('id', booking_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let booking_id = $(this).attr('id');
                $.ajax({
                    url: '{{URL::to('admin/bookings')}}' + '/' + booking_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('.el-loading').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.el-loading').addClass('d-none');
                        window.location = '{{URL::to('admin/bookings')}}';
                    }
                });
            });

            $('#from').datepicker({
                format: "yyyy/mm/dd",
                enableOnReadonly: true,
                todayHighlight: true,
            });

            $('#to').datepicker({
                format: "yyyy/mm/dd",
                enableOnReadonly: true,
                todayHighlight: true,
            });

            $("#to").change(function () {
                var startDate = document.getElementById("to").value;
                var endDate = document.getElementById("from").value;

                if ((Date.parse(startDate) < Date.parse(endDate))) {
                    alert("End date should be greater than Start date");
                    document.getElementById("to").value = "";
                }
            });

            $(document).on('change', '#from', function (e) {
                from = $('#from').val();
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('change', '#to', function (e) {
                to = $('#to').val();
                oTable.draw(true);
                e.preventDefault();
            });
			
			$(document).on('keyup', '#user_name', function (e) {
                user_name = $('#user_name').val();
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('click', '#days_filter', function (e) {
                //alert(e.target.id);
                to = ($.datepicker.formatDate('yy/mm/dd', new Date()));
                var from_f = new Date(new Date().setDate(new Date().getDate() - e.target.id));
                from = ($.datepicker.formatDate('yy/mm/dd', from_f));

                oTable.draw(true);
                e.preventDefault();
            });

        </script>
    @endpush
@endsection
