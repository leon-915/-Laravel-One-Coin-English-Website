@extends('admin.layouts.admin',['title'=>'Manage One Page Levels Points'])
@section('title', 'Manage One Page Levels Points')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_one_page_levels_points')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_one_page_levels_points')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/one-page-points/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add One Page Levels Points" title="Add One Page Levels Points">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>

                        <table class="table" id="one-page-level-point-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.level_name')}}</th>
                                <th>{{ __('labels.rating_point')}}</th>
                                {{--<th>{{ __('labels.description_en')}}</th>--}}
                                {{--<th>{{ __('labels.description_ja')}}</th>--}}
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
        #one-page-level-point-table {
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
                    <p>{{ __('labels.confirm_delete_one_page_levels_point')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/one-page-points')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#one-page-level-point-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/one-page-points/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.level_id = $('input[name=level_id]').val();
                        d.rating_point = $('input[name=rating_point]').val();
                        // d.description_en = $('input[name=description_en]').val();
                        // d.description_ja = $('input[name=description_ja]').val();
                        d.status = $('select[name=status]').val();
                    }
                },
                /*columnDefs: [
                ],*/
                order: [[1,'DESC']],
                columns: [
                    { data: 'case', name: 'case',orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'level_id', name: 'level_id'},
                    {data: 'rating_point', name: 'rating_point'},
                    // {data: 'description_en', name: 'description_en'},
                    // {data: 'description_ja', name: 'description_ja'},
                    {data: 'status', name: 'status'},
                    { data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteOnePageLevelsPoints", function () {
                var one_page_levels_points_id = $(this).attr('id');
                $(".yes_delete").attr('id', one_page_levels_points_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let one_page_levels_points_id = $(this).attr('id');
                if(one_page_levels_points_id){
                    $.ajax({
                        url: '{{URL::to('admin/one-page-points')}}' + '/' + one_page_levels_points_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/one-page-points')}}';
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
