@extends('admin.layouts.admin',['title'=>'Teacher Ratings','search'=>'admin.teacher-ratings.search'])
@section('title', 'Teacher Ratings')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_teacher_rating')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_teacher_rating')}}</li>
                </ol>
            </nav>
        </div>
            
            @include('admin.teacher-ratings.search')
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        {{--<a class="btn btn-inverse-info btn-rounded btn-icon add_data"--}}
                           {{--href="{{ url('admin/rating-types/create') }}" data-toggle="tooltip" data-placement="top"--}}
                           {{--data-original-title="Add Rating Type" title="Add Rating Type">--}}
                            {{--<i class="mdi mdi-plus" aria-hidden="true"></i>--}}
                        {{--</a>--}}

                        <table class="table" id="teacher-rating-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.teacher_name')}}</th>
                                <th>{{ __('labels.student_name')}}</th>
                                <th>{{ __('labels.service')}}</th>
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
        #teacher-rating-table {
            width: 100% !important;
            overflow: auto;
            display: block;
        }
    </style>

    @push('scripts')

       
        <script>
            var oTable = $('#teacher-rating-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/teacher-ratings/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.teacher_id = $('input[name=teacher_id]').val();
                        d.student_id = $('input[name=student_id]').val();
                        d.rating_id = $('input[name=rating_id]').val();
                        d.ratings = $('input[name=ratings]').val();
                        d.student = $('input[name=student]').val();
                        d.teacher = $('input[name=teacher]').val();
                    }
                },
                order: [[0,'DESC']],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex','orderable':false,'searchable':false},
                    {data: 'teacher', name: 'teacher',orderable: false, searchable: false},
                    {data: 'student', name: 'student',orderable: false, searchable: false},
                    {data: 'title', name: 'title',orderable: false, searchable: false},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });

            $(document).on('keyup','#rating-search input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });


        </script>
    @endpush
@endsection
