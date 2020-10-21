@extends('admin.layouts.admin',['title'=>'Testimonial'])
@section('title', 'Testimonial')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_testimonial')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_testimonial')}}</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
                           href="{{ url('admin/testimonial/create') }}" data-toggle="tooltip" data-placement="top"
                           data-original-title="Add testimonial" title="Add testimonial">
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </a>

                        <table class="table" id="testimonial-table">
                            <thead class="bg-info text-white">
                            <tr>
                                <th>{{ __('labels.id')}}</th>
                                <th>{{ __('labels.title')}}</th>
                                {{--<th>{{ __('labels.description_en')}}</th>--}}
                                {{--<th>{{ __('labels.description_ja')}}</th>--}}
                                {{--<th>{{ __('labels.excerpt')}}</th>--}}
                                <th>{{ __('labels.position')}}</th>
                                <!--th>{{ __('labels.title_slug')}}</th-->
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
        #testimonial-table {
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
                    <p>{{ __('labels.confirm_delete_testimonial')}}</p>
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
            var oTable = $('#testimonial-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
                ajax: {
                    url: '{{ url('admin/testimonial/get') }}',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (d) {
                        d.title = $('input[name=title]').val();
                        // d.description_en = $('input[name=description_en]').val();
                        // d.description_ja = $('input[name=description_ja]').val();
                        d.excerpt = $('input[name=excerpt]').val();
                        d.position = $('input[name=position]').val();
                        //d.title_slug = $('input[name=title_slug]').val();
                        d.status = $('input[name=status]').val();
                    }
                },
                /*columnDefs: [
                ],*/
                order: [[0,'DESC']],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    // {data: 'description_en', name: 'description_en'},
                    // {data: 'description_ja', name: 'description_ja'},
                    //{data: 'excerpt', name: 'excerpt'},
                    {data: 'position', name: 'position'},
                    //{data: 'title_slug', name: 'title_slug'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action',orderable: false, searchable: false}
                ]
            });


            $(document).on("click", ".deleteTestimonial", function () {
                var testimonial_id = $(this).attr('id');
                $(".yes_delete").attr('id', testimonial_id);
                $("#exampleModalPrimary").modal('show');
            });

            $(document).on("click", ".yes_delete", function () {
                let testimonial_id = $(this).attr('id');
                $.ajax({
                    url: '{{URL::to('admin/testimonial')}}' + '/' + testimonial_id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        window.location = '{{URL::to('admin/testimonial')}}';
                    }
                });
            });
        </script>
    @endpush
@endsection