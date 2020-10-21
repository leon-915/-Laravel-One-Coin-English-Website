@extends('admin.layouts.admin',['title'=>'Manage Static Pages'])

@section('title', 'Manage Static Pages')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.manage_static_pages')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_static_pages')}}</li>
                </ol>
            </nav>
		</div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

				        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
				           href="{{ url('admin/static-pages/create') }}" data-toggle="tooltip" data-placement="top" data-original-title="Add New Static Page" title="Add New Static Page" >
				            <i class="mdi mdi-plus" aria-hidden="true"></i>
				        </a>

					    <table class="table" id="static-pages-table">
					        <thead class="bg-info text-white">
					            <tr>
					                <th>{{ __('labels.id')}}</th>
					                <th>{{ __('labels.page_name')}}</th>
					                <th>{{ __('labels.title')}}</th>
					                <th>{{ __('labels.meta_description')}}</th>
					                <th>{{ __('labels.meta_keyword')}}</th>
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
		#static-pages-table {
			width: 100% !important;
			overflow: auto;
			display: block;
		}
	</style>

	<div class="modal fade modal-danger show" id="exampleModalPrimary" tabindex="-1" role="dialog" aria-labelledby="exampleModalPrimary" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel-2">Delete</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>{{ __('labels.confirm_delete_static_page')}}</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
					<button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw" data-dismiss="modal">{{ __('labels.cancel')}}</button>
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
	        var oTable =  $('#static-pages-table').DataTable({
	            processing: true,
	            serverSide: true,
	            searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
           		language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
	            ajax: {
	                url: '{{ route('admin.static-pages.get') }}',
	                type: 'POST',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: function (d) {
	                     d.name = $('input[name=name]').val();
	                     d.status = $('select[name=status]').val();
	                 	}
	            },
	            /*columnDefs: [
	            ],*/
	            order: [],
	            columns: [
	                { data: 'id', name: 'id'},
	                { data: 'page_name', name: 'page_name' },
                    { data: 'title', name: 'title' },
                    { data: 'meta_description', name: 'meta_description' },
                    { data: 'meta_keyword', name: 'meta_keyword'},
	                { data: 'action', name: 'action',orderable: false, searchable: false}
	            ]
	        });


	        $(document).on("click",".deleteStaticPage",function () {
	            var static_page_id = $(this).attr('id');
	            $(".yes_delete").attr('id',static_page_id);
	            $("#exampleModalPrimary").modal('show');
	        });

	        $(document).on("click",".yes_delete",function () {
	            let static_page_id = $(this).attr('id');
	            $.ajax({
	                url: '{{URL::to('static-pages')}}' +'/'+ static_page_id,
	                type: 'DELETE',
	                headers: {
	                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	                },
	                success: function(result) {
	                    window.location = '{{URL::to('static-pages')}}';
	                }
	            });
	        });
	    </script>
	@endpush
@endsection
