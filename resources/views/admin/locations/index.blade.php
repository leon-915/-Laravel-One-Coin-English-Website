@extends('admin.layouts.admin',['title'=>'Manage Locations'])
@section('title', 'Manage Locations')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_location')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_location')}}</li>
                </ol>
            </nav>
        </div>

        @include('admin.locations.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/locations/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Location" title="Add Location">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>

                        <table class="table" id="locations-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.location_title')}}</th>
                                <th>{{ __('labels.location_name_ja')}}</th>
                                {{--<th>{{ __('labels.seats_available')}}</th>--}}
                               {{--  <th>{{ __('labels.phone_number')}}</th> --}}
                                <th>{{ __('labels.location_type')}}</th>
                               {{--  <th>{{ __('labels.address')}}</th>
                                <th>{{ __('labels.city')}}</th>
                                <th>{{ __('labels.state_province')}}</th>
                                <th>{{ __('labels.country')}}</th>
                                <th>{{ __('labels.zipcode')}}</th> --}}
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
        #locations-table {
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
                    <p>{{ __('labels.confirm_delete_location')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/locations')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#locations-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/locations/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.title = $('input[name=title]').val();
                        d.title_jp = $('input[name=title_jp]').val();
                        // d.seats_available = $('select[name=seats_available]').val();
                        d.phone_no = $('input[name=phone_no]').val();
                        d.location_type = $('select[name=location_type]').val();
                        d.address = $('input[name=address]').val();
                        d.city = $('select[name=city]').val();
                        d.state = $('select[name=state]').val();
                        d.country = $('select[name=country]').val();
                        d.zipcode = $('input[name=zipcode]').val();
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
                    {data: 'title_jp', name: 'title_jp'},
                    // {data: 'seats_available', name: 'seats_available'},
                   /* {data: 'phone_no', name: 'phone_no'},*/
                    {data: 'location_type', name: 'location_type'},
                   /* {data: 'address', name: 'address'},
                    {data: 'city', name: 'city'},
                    {data: 'state', name: 'state'},
                    {data: 'country', name: 'country'},
                    {data: 'zipcode', name: 'zipcode'},*/
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteLocations", function () {
                var locations = $(this).attr('id');
                $(".yes_delete").attr('id', locations);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let locations = $(this).attr('id');
                if(locations){
                    $.ajax({
                        url: '{{URL::to('admin/locations')}}' + '/' + locations,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/locations')}}';
                        }
                    });
                }
            });

            $(document).on('keyup','.input',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('change','.select',function(e){
                oTable.draw(true);
                e.preventDefault();
            });

        </script>
    @endpush
@endsection
