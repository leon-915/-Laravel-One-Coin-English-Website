@extends('admin.layouts.admin',['title'=>'Manage Packages'])
@section('title', 'Manage Packages')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.manage_packages')}}  </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> {{ __('labels.dashboard')}} </a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{ __('labels.manage_packages')}} </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/packages/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add Location Type" title="Add Package">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
                            <i class="mdi mdi-delete" aria-hidden="true"></i>
                        </button>

                        <table class="table" id="packages-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th><input type="checkbox" id="checkall" value="checkall"></th>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.package_title')}}</th>
                                <th>{{ __('labels.package_price')}}</th>
                             {{--    <th>{{ __('labels.register_fee')}}</th>
                                <th>{{ __('labels.onepage_fee')}}</th> --}}
                                {{--<th>{{ __('labels.available_lesson')}}</th>--}}
                                {{--<th>{{ __('labels.duration_lesson')}}</th>--}}
                                {{--<th>Description</th>--}}
                                {{--<th>{{ __('labels.reward_point')}}</th>--}}
                             {{--    <th>{{ __('labels.roleover_condition')}}</th> --}}
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
        #packages-table{
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
                    <p>{{ __('labels.confirm_delete_package')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" value="{{URL::to('admin/packages')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
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
            var oTable = $('#packages-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/packages/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.title = $('input[name=title]').val();
                        d.price = $('input[name=price]').val();
                        d.registration_fee = $('input[name=registration_fee]').val();
                        d.onepage_fee = $('input[name=onepage_fee]').val();
                        //d.no_of_lesson_available = $('input[name=no_of_lesson_available]').val();
                        //d.duration_of_lesson = $('input[name=duration_of_lesson]').val();
                        // d.description = $('input[name=description]').val();
                        // d.reward_point = $('input[name=reward_point]').val();
                        d.roleover_condition = $('input[name=roleover_condition]').val();
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
                    {data: 'price', name: 'price'},
                   /* {data: 'registration_fee', name: 'registration_fee'},
                    {data: 'onepage_fee', name: 'onepage_fee'},*/
                    //{data: 'no_of_lesson_available', name: 'no_of_lesson_available'},
                    //{data: 'duration_of_lesson', name: 'duration_of_lesson'},
                    // {data: 'description', name: 'description'},
                    // {data: 'reward_point', name: 'reward_point'},
                   /* {data: 'roleover_condition', name: 'roleover_condition'},*/
                    {data: 'status', name: 'status'},
                    { data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deletePackage", function () {
                var package_id = $(this).attr('id');
                $(".yes_delete").attr('id', package_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let package_id = $(this).attr('id');
                if(package_id){
                    $.ajax({
                        url: '{{URL::to('admin/packages')}}' + '/' + package_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            window.location = '{{URL::to('admin/packages')}}';
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
