@extends('admin.layouts.admin',['title'=>'Manage Categories'])
@section('title', 'Manage Categories')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_categories')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_categories')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-right mb-3">
                        <a class="btn btn-inverse-info btn-rounded btn-icon"
                        href="{{ url('admin/categories/create') }}" data-toggle="tooltip" data-placement="top"
                        data-original-title="Add Service" title="Add Service" style="line-height: 41px;">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>
                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="col-12">
                        <table class="table" id="categories-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.title_en')}}</th>
                                <th>{{ __('labels.title_ja')}}</th>
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
        #categories-table {
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
                    <p>{{ __('labels.confirm_delete_category')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/categories')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#categories-table').DataTable({
                pageLength: 10,
                processing: true,
                serverSide: true,
                searching: true,
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/categories/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        /* d.title = $('input[name=title]').val();
                        d.length = $('input[name=length]').val();
                        d.length_type = $('select[name=length_type]').val();
                        d.padding_minutes = $('input[name=padding_minutes]').val();
                        d.padding_type = $('select[name=padding_type]').val();
                        d.price = $('input[name=price]').val();
                        d.no_of_days = $('input[name=no_of_days]').val();
                        d.flexible_appointment_start_time = $('select[name=flexible_appointment_start_time]').val();
                        d.is_system_service = $('select[name=is_system_service]').val();
                        d.receive_credit_on_booking_type = $('select[name=receive_credit_on_booking_type]').val();
                        d.receive_credit_on_booking = $('input[name=receive_credit_on_booking]').val();
                        d.service_name_en = $('input[name=service_name_en]').val();
                        d.prepayment_type = $('select[name=prepayment_type]').val();
                        d.prepayment = $('input[name=prepayment]').val();
                        d.available_lessons = $('input[name=available_lessons]').val();
                        d.status = $('select[name=status]').val(); */
                    }
                },
                order: [[1,'desc']],
                columns: [
                    { data: 'case', name: 'case',orderable: false, searchable: false},
                    {data: 'id', name: 'id',searchable: false},
                    {data: 'title_en', name: 'title'},
                    {data: 'title_ja', name: 'title'},
                    {data: 'status', name: 'status',searchable: false},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteService", function () {
                var categories = $(this).attr('id');
                $(".yes_delete").attr('id', categories);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let categories = $(this).attr('id');
                if(categories){
                    $.ajax({
                        url: '{{URL::to('admin/categories')}}' + '/' + categories,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/categories')}}';
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
