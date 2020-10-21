@extends('admin.layouts.admin',['title'=>'Manage Rating Types'])
@section('title', 'Manage Rating Types')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_rating_type')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_rating_type')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/rating-types/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Rating Type" title="Add Rating Type">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>

                        <table class="table" id="rating-type-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.title')}}</th>
                                {{--<th>{{ __('labels.description')}}</th>--}}
                                {{--<th>{{ __('labels.desc_star1')}}</th>--}}
                                {{--<th>{{ __('labels.desc_star2')}}</th>--}}
                                {{--<th>{{ __('labels.desc_star3')}}</th>--}}
                                {{--<th>{{ __('labels.desc_star4')}}</th>--}}
                                {{--<th>{{ __('labels.desc_star5')}}</th>--}}
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
        #rating-type-table {
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
                    <p>{{ __('labels.confirm_delete_rating_type')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/rating-types')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#rating-type-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/rating-types/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.title = $('input[name=title]').val();
                        // d.description = $('input[name=description]').val();
                        // d.desc_star1 = $('input[name=desc_star1]').val();
                        // d.desc_star2 = $('input[name=desc_star2]').val();
                        // d.desc_star3 = $('input[name=desc_star3]').val();
                        // d.desc_star4 = $('input[name=desc_star4]').val();
                        // d.desc_star5 = $('input[name=desc_star5]').val();
                        d.status = $('select[name=status]').val();
                    }
                },
                /*columnDefs: [
                ],*/
                order: [[1,'DESC']],
                columns: [
                    { data: 'case', name: 'case',orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    // {data: 'description', name: 'description'},
                    // {data: 'desc_star1', name: 'desc_star1'},
                    // {data: 'desc_star2', name: 'desc_star2'},
                    // {data: 'desc_star3', name: 'desc_star3'},
                    // {data: 'desc_star4', name: 'desc_star4'},
                    // {data: 'desc_star5', name: 'desc_star5'},
                    {data: 'status', name: 'status'},
                    { data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteRatingType", function () {
                var rating_type_id = $(this).attr('id');
                $(".yes_delete").attr('id', rating_type_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let rating_type_id = $(this).attr('id');
                if(rating_type_id){
                    $.ajax({
                        url: '{{URL::to('admin/rating-types')}}' + '/' + rating_type_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/rating-types')}}';
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
