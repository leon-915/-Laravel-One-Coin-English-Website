@extends('admin.layouts.admin',['title'=>'Student Lesson Records'])
@section('title', 'Student Lesson Records')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.student_lesson_records')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.student_lesson_records')}}</li>
                </ol>
            </nav>
        </div>


        {{--Add Filter files--}}
        @include('admin.student-lesson-records.search')

        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-12">
                        <table class="table" id="student-lesson-record-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.student_name')}}</th>
                                <th>{{ __('labels.email')}}</th>
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
        #student-lesson-record-table {
            width: 100% !important;
            overflow: auto;
            display: block;
        }
    </style>

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
            var oTable = $('#student-lesson-record-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ route('admin.student.get.lesson.records') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.student_name = $('input[name=student_name]').val();
                        d.email = $('input[name=email]').val();
                    }
                },
                order: [[0,'DESC']],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'student_name', name: 'student_name'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });
        </script>

        <script>
            $(document).on('keyup','#student_name',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('keyup','#email',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

        </script>
    @endpush
@endsection
