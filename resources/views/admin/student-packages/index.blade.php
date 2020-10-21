@extends('admin.layouts.admin',['title'=>'Manage Student Packages','search'=>'admin.student-lessons.search'])
@section('title', 'Manage Student Packages')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_student_packages')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_student_packages')}}</li>
                </ol>
            </nav>
        </div>

        @include('admin.student-packages.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/student-packages/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Student Package" title="Add Student Package">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <table class="table" id="student-package-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.student_id')}}</th>
                                <th>Email</th>
                                <th>{{ __('labels.package_id')}}</th>
                                <th>{{ __('labels.price')}}</th>
                                <th>{{ __('labels.start_date')}}</th>
                                <th>{{ __('labels.expire_date')}}</th>
                                <th>{{ __('labels.subscription_status')}}</th>
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
        #student-package-table {
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
                    <p>{{ __('labels.confirm_delete_student_package')}}</p>
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
            var oTable = $('#student-package-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/student-packages/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.student = $('input[name=student]').val();
                        d.package = $('input[name=package]').val();
                    }
                },
                order: [[0,'DESC']],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'email', name: 'email'},
                    {data: 'package_id', name: 'package_id'},
                    {data: 'price', name: 'price'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'status', name: 'status', orderable: false},
                    { data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteStudentPackage", function () {
                var student_package_id = $(this).attr('id');
                $(".yes_delete").attr('id', student_package_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let student_package_id = $(this).attr('id');
                $.ajax({
                    url: '{{URL::to('admin/student-packages')}}' + '/' + student_package_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        window.location = '{{URL::to('admin/student-packages')}}';
                    }
                });
            });

            $(document).on('keyup','#package-search input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });
        </script>
    @endpush
@endsection
