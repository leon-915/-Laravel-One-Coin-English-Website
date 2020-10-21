@extends('admin.layouts.admin',['title'=>'Teacher Earnings','search'=>'admin.teachers-earnings.search'])
@section('title', 'Teacher Earnings')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.teacher_earnings')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.teacher_earnings')}}</li>
                </ol>
            </nav>
        </div>

        {{--Add Filter files--}}
        @include('admin.teachers-earnings.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table" id="teacher-earnings-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.teacher_id')}}</th>
                                <th>{{ __('labels.teacher_earnings')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #teacher-earnings-table {
            width: 100% !important;
            overflow: auto;
            display: block;
        }
    </style>
    @push('scripts')
        <script>
            var oTable = $('#teacher-earnings-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ route('admin.teacherEarnings.get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.teacher_name = $('input[name=teacher_name]').val();
                        d.teacher_earnings = $('input[name=teacher_earnings]').val();
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                    }
                },
                order: [[2, 'DESC']],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'teacher_name', name: 'teacher_name'},
                    {data: 'total_earning', name: 'total_earning', orderable: true, searchable: false}
                ]
            });

            $(document).on('keyup','#teacher_name',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('change','.input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

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
