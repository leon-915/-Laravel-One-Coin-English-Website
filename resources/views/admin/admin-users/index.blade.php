@extends('admin.layouts.admin',['title'=>'Manage Admin'])
@section('title', 'Manage Admin')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_admin')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_admin')}}</li>
                </ol>
            </nav>
        </div>

        @include('admin.admin-users.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/admin-users/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Booking" title="Add Admin">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>
                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>

                        <table class="table" id="admin-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Action</th>
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
                    <p>Are you sure to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{ URL::to('admin/admin-users') }}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#admin-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/get-admin-users') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.name = $('input[name=name]').val();
                        d.email = $('input[name=email]').val();
                        d.status = $('select[name=status]').val();
                        d.role = $('select[name=role]').val();
                    }
                },
                /*columnDefs: [
                ],*/
                order: [[1,'DESC']],
                columns: [
                    { data: 'case', name: 'case',orderable: false, searchable: false},
                    { data: 'id', name: 'id',orderable: true, searchable: false},
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email'},
                    { data: 'status', name: 'status'},
                    { data: 'role', name: 'role',searchable: false},
                    { data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click",".deleteUser",function () {
                var user_id = $(this).attr('id');
                $(".yes_delete").attr('id',user_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click",".yes_delete",function () {
                let user_id = $(this).attr('id');
                if(user_id){
                    $.ajax({
                        url: '{{ URL::to('admin/admin-users') }}' +'/'+ user_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            window.location = '{{URL::to('admin/admin-users')}}';
                        }
                    });
                }
            });

            $(document).on('keyup','#user-search input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('change','#user-search select',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on("click",".ShowUser",function () {
                var user_id = $(this).attr('id');
                $.ajax({
                    url: '{{ url('admin/admin-user-detail')}}',
                    type: 'POST',
                    data: {id:user_id},
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        var html = result.returnHTML;
                        $("#exampleGrid").find('.modal-body').html(html);
                        $("#exampleGrid").modal('show');
                    }
                });
            });

        </script>
    @endpush
@endsection
