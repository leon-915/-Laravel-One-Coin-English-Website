@extends('admin.layouts.admin',['title'=>'Student Lessons','search'=>'admin.student-lessons.search'])
@section('title', 'Student Lessons')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_student_lessons')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_student_lessons')}}</li>
                </ol>
            </nav>
        </div>

        @include('admin.student-lessons.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/student-lessons/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Student Lesson" title="Add Student Lesson">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>

                        <table class="table" id="student-lesson-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.student_name')}}</th>
                                <th>Email</th>
                                <th>{{ __('labels.service')}}</th>
                               {{--  <th>{{ __('labels.available_bookings')}}</th> --}}
                                <th>{{ __('labels.price')}}</th>
                                 <th>{{ __('labels.start_date')}}</th>
                                <th>{{ __('labels.expire_date')}}</th>
                                <th>{{ __('labels.status')}}</th>
                                {{-- <th>{{ __('labels.student_level')}}</th> --}}
                               {{--  <th>{{ __('labels.free_lessons')}}</th> --}}
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
        #student-lesson-table {
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
                    <p>{{ __('labels.confirm_delete_student_lesson')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/student-lessons')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
                    <button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw cancel_delete" data-dismiss="modal">
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
            var oTable = $('#student-lesson-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/student-lessons/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.user_id = $('input[name=user_id]').val();
                        d.service_id = $('input[name=service_id]').val();
                        d.available_bookings = $('select[name=available_bookings]').val();
                        d.price = $('select[name=price]').val();
                        d.start_date = $('select[name=start_date]').val();
                        d.expire_date = $('select[name=expire_date]').val();
                        d.student_level_id = $('select[name=student_level_id]').val();
                        d.free_lessons = $('select[name=free_lessons]').val();
                        d.student = $('input[name=student]').val();
                        d.service = $('input[name=service]').val();
                    }
                },
                /*columnDefs: [
                ],*/
                order: [[1,'DESC']],
                columns: [
                    { data: 'case', name: 'case',orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'email', name: 'email'},
                    {data: 'service_id', name: 'service_id'},
                    /*{data: 'available_bookings', name: 'available_bookings'},*/
                    {data: 'price', name: 'price'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'expire_date', name: 'expire_date'},
                    {data: 'status', name: 'status'},
                   /*  {data: 'student_level_id', name: 'student_level_id'}, */
                   /* {data: 'free_lessons', name: 'free_lessons'},*/
                    { data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteStudentLesson", function () {
                var student_lesson_id = $(this).attr('id');
                $(".yes_delete").attr('id', student_lesson_id);
                $("#exampleModalPrimary").modal('show');
            });

           $(document).on("click", ".yes_delete", function () {
                let student_lesson_id = $(this).attr('id');
                if(student_lesson_id){
                    $.ajax({
                        url: '{{URL::to('admin/student-lessons')}}' + '/' + student_lesson_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/student-lessons')}}';
                        }
                    });
                }
            });

            $(document).on('keyup','#lesson-search input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });
        </script>
    @endpush
@endsection
