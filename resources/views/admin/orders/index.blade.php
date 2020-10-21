@extends('admin.layouts.admin',['title'=>'Payment Transactions','search'=>'admin.orders.search'])
@section('title', 'Payment Transactions')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_order')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_order')}}</li>
                </ol>
            </nav>
        </div>

            @include('admin.orders.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table" id="order-table">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>{{ __('labels.order_id')}}</th>
                                    <th>{{ __('labels.order_user_id')}}</th>
                                    <th>{{ __('labels.product')}}</th>
                                    <th>{{ __('labels.date')}}</th>
                                    <th>{{ __('labels.payment_status')}}</th>
                                    <th>{{ __('labels.payment_ip')}}</th>
                                    <th>{{ __('labels.total')}}</th>
                                    <th>{{ __('labels.action')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger show" id="exampleModalPrimary" aria-hidden="true" aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reorder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to reorder this transaction?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="yes_delete" data-href="" class="btn btn-danger" id="">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        #order-table{
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
            var oTable = $('#order-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ route('admin.orders.get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.user_id = $('input[name=user_id]').val();
                        d.transaction_type_id = $('input[name=transaction_type_id]').val();
                        d.created_at = $('select[name=created_at]').val();
                        d.payment_status = $('select[name=payment_status]').val();
                        d.amount = $('select[name=amount]').val();
                        d.status = $('select[name=status]').val();
                        d.student = $('input[name=student]').val();
                    }
                },
                order: [[0,'DESC']],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'transaction_type_id', name: 'transaction_type_id'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'payment_status', name: 'payment_status'},
                    {data: 'payment_ip', name: 'payment_ip'},
                    {data: 'amount', name: 'amount'},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });

            $(document).on('keyup','#order-search input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('change','#order-search select',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('click','.reorderTransaction',function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                console.log(url);
                $("#yes_delete").data('href', url);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click","#yes_delete",function (e) {
                e.preventDefault();
                var rurl = $(this).data('href');
                console.log(rurl);
                window.location = rurl;

                // $.ajax({
                //     url: rurl,
                //     type: 'POST',
                //     headers: {
                //         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     success: function(result) {
                //         var html = result.returnHTML;
                //         $("#exampleGrid").find('.modal-body').html(html);
                //         $("#exampleGrid").modal('show');
                //     }
                // });
            });
        </script>
    @endpush
@endsection
