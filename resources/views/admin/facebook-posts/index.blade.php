@extends('admin.layouts.admin',['title'=>'Manage Facebook Posts'])

@section('title', 'Manage Facebook Posts')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.manage_facebook_posts')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_facebook_posts')}}</li>
                </ol>
            </nav>
		</div>
		@include('admin.facebook-posts.search')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

				         {{--<button class="btn btn-inverse-info btn-rounded btn-icon add_data "--}}
				           {{--href="{{ url('admin/facebook-posts/create') }}" data-toggle="tooltip" data-placement="top" data-original-title="Add New Facebook Post" title="Add New Facebook Post" >--}}
				            {{--<i class="mdi mdi-plus" aria-hidden="true"></i>--}}
				        {{--</button>--}}

						<button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all blank" data-toggle="tooltip" title="Delete" data-original-title="Delete" style="right: 25px;">
							<i class="mdi mdi-delete" aria-hidden="true"></i>
						</button>

					    <table class="table" id="facebook-posts-table">
					        <thead class="bg-info text-white">
					            <tr>
									<th><input type="checkbox" id="checkall" value="checkall"></th>
									<th>{{ __('labels.id')}}</th>
					                <th>{{ __('labels.subject')}}</th>
					                <th>{{ __('labels.message')}}</th>
					                <th>{{ __('labels.teacher_name')}}</th>
					                <th>{{ __('labels.image')}}</th>
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
		#facebook-posts-table {
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
					<p>{{ __('labels.confirm_delete_facebook_post')}}</p>
				</div>
				<div class="modal-footer">
					<button type="button" value="{{URL::to('admin/facebook-posts')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit')}}</button>
					<button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw cancel_delete" data-dismiss="modal">{{ __('labels.cancel')}}</button>
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
	        var oTable =  $('#facebook-posts-table').DataTable({
	            processing: true,
	            serverSide: true,
	            searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
           		language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
	            ajax: {
	                url: '{{ route('admin.facebook-posts.get') }}',
	                type: 'POST',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: function (d) {
	                     d.status = $('select[name=status]').val();
	                 	}
	            },
	            /*columnDefs: [
	            ],*/
	            order: [[1,'desc']],
	            columns: [
                    { data: 'case', name: 'case',orderable: false, searchable: false},
                    { data: 'id', name: 'id'},
	                { data: 'subject', name: 'subject' },
                    { data: 'message', name: 'message' },
                    { data: 'teacher_name', name: 'teacher_name' },
                    { data: 'image', name: 'image',orderable: false,searchable: false},
                    { data: 'status', name: 'status',orderable: false,searchable: false},
	                { data: 'action', name: 'action',orderable: false, searchable: false}
	            ]
	        });


	        $(document).on("click",".deleteFacebookPost",function () {
	            var fb_post_id = $(this).attr('id');
	            $(".yes_delete").attr('id',fb_post_id);
	            $("#exampleModalPrimary").modal('show');
	        });

	        $(document).on("click",".yes_delete",function () {
	            let fb_post_id = $(this).attr('id');
	            if(fb_post_id){
                    $.ajax({
                        url: '{{URL::to('admin/facebook-posts')}}' +'/'+ fb_post_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            window.location = '{{URL::to('admin/facebook-posts')}}';
                        }
                    });
				}
	        });

	        $(document).on('change','#facebook-posts-search select',function(e){
	            oTable.draw(true);
	            e.preventDefault();
	        });

	    </script>
	@endpush
@endsection
