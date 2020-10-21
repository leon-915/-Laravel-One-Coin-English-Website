@extends('admin.layouts.admin',['title'=>'Manage Coupons'])
@section('title', 'Manage Coupons')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_coupon')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_coupon')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/coupons/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Coupon" title="Add Coupon">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>

                        <table class="table" id="coupon-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.coupon_code')}}</th>
                                <th>{{ __('labels.discount_type')}}</th>
                                <th>{{ __('labels.discount')}}</th>
                                <th>{{ __('labels.from_date')}}</th>
                                <th>{{ __('labels.to_date')}}</th>
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
        #coupon-table {
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
                    <p>{{ __('labels.confirm_delete_coupon')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/coupons')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#coupon-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/coupons/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.coupon_code = $('input[name=coupon_code]').val();
                        d.discount_type = $('input[name=discount_type]').val();
                        d.discount = $('input[name=discount]').val();
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                        d.status = $('select[name=status]').val();
                    }
                },
                /*columnDefs: [
                ],*/
                order: [[1,'DESC']],
                columns: [
                    { data: 'case', name: 'case',orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'coupon_code', name: 'coupon_code'},
                    {data: 'discount_type', name: 'discount_type'},
                    {data: 'discount', name: 'discount'},
                    {data: 'from_date', name: 'from_date'},
                    {data: 'to_date', name: 'to_date'},
                    {data: 'status', name: 'status'},
                    { data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteCoupon", function () {
                var coupon_id = $(this).attr('id');
                $(".yes_delete").attr('id', coupon_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let coupon_id = $(this).attr('id');
                if(coupon_id){
                    $.ajax({
                        url: '{{URL::to('admin/coupons')}}' + '/' + coupon_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/coupons')}}';
                        }
                    });
                }

            });
        </script>
    @endpush
@endsection
