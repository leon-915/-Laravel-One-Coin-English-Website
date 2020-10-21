@extends('admin.layouts.admin',['title'=>'Manage Services'])
@section('title', 'Manage Services')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_services')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_services')}}</li>
                </ol>
            </nav>
        </div>
		
		@include('admin.services.search')
        
		<div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                        href="{{ url('admin/services/create') }}" data-toggle="tooltip" data-placement="top"
                        data-original-title="Add Service" title="Add Service" style="line-height: 41px;">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>
                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="col-12">
                        <table class="table" id="services-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.title')}}</th>
                                {{--<th>{{ __('labels.description')}}</th>--}}
                                <th>{{ __('labels.length')}}</th>
                                {{--<th>{{ __('labels.length_type')}}</th>--}}
                                {{--<th>{{ __('labels.padding_minutes')}}</th>--}}
                                {{--<th>{{ __('labels.padding_type')}}</th>--}}
                                <th>{{ __('labels.price')}}</th>
                                <th>{{ __('labels.no_of_days')}}</th>
                                {{--<th>{{ __('labels.capacity')}}</th>--}}
                                {{--<th>{{ __('labels.is_flexible_appointment_start_time')}}</th>--}}
                                {{--<th>{{ __('labels.flexible_appointment_start_time')}}</th>--}}
                                {{--<th>{{ __('labels.is_system_service')}}</th>--}}
                                {{--<th>{{ __('labels.receive_credit_on_booking_type')}}</th>--}}
                                {{--<th>{{ __('labels.receive_credit_on_booking')}}</th>--}}
                                {{-- <th>{{ __('labels.service_name_en')}}</th> --}}
                                {{--<th>{{ __('labels.prepayment_type')}}</th>--}}
                                {{--<th>{{ __('labels.prepayment')}}</th>--}}
                                {{--<th>{{ __('labels.available_lessons')}}</th>--}}
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
        #services-table {
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
                    <p>{{ __('labels.confirm_delete_service')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/services')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#services-table').DataTable({
                
                processing: true,
                serverSide: true,
                searching: false,
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/services/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.title = $('input[name=title]').val();
                        d.year = $('select[name=year]').val();
                        /*d.length_type = $('select[name=length_type]').val();
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
                    {data: 'title', name: 'title'},
                    
                    {data: 'length', name: 'length',searchable: false},
                    
                    // {data: 'length_type', name: 'length_type'},
                    // {data: 'padding_minutes', name: 'padding_minutes'},
                    // {data: 'padding_type', name: 'padding_type'},
                    {data: 'price', name: 'price',searchable: false},
                    {data: 'no_of_days', name: 'no_of_days',searchable: false},
                    // {data: 'flexible_appointment_start_time', name: 'flexible_appointment_start_time'},
                    // {data: 'is_system_service', name: 'is_system_service'},
                    // {data: 'receive_credit_on_booking_type', name: 'receive_credit_on_booking_type'},
                    // {data: 'receive_credit_on_booking', name: 'receive_credit_on_booking'},
                    //{data: 'service_name_en', name: 'service_name_en'},
                    // {data: 'prepayment_type', name: 'prepayment_type'},
                    // {data: 'prepayment', name: 'prepayment'},
                    // {data: 'available_lessons', name: 'available_lessons'},
                    {data: 'status', name: 'status',searchable: false},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteService", function () {
                var services = $(this).attr('id');
                $(".yes_delete").attr('id', services);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let services = $(this).attr('id');
                if(services){
                    $.ajax({
                        url: '{{URL::to('admin/services')}}' + '/' + services,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/services')}}';
                        }
                    });
                }
            });
			
			$(document).on('keyup','.input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });           

            $('#year').change(function(e){
                oTable.draw(true);
                e.preventDefault();
            });
        </script>
    @endpush
@endsection
