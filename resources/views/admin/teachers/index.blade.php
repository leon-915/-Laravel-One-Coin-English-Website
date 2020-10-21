@extends('admin.layouts.admin',['title'=>__('labels.manage_teachers') ,'search'=>'admin.teachers.search'])

@section('title',__('labels.manage_teachers') )

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.manage_teachers') }} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('labels.manage_teachers') }}</li>
                </ol>
            </nav>
		</div>

		@include('admin.teachers.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 custom_tbl">

				        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
				           href="{{ route('admin.teachers.create') }}" data-toggle="tooltip" data-placement="top" data-original-title="Add New User" title="Add New Teacher" >
				            <i class="mdi mdi-account-plus" aria-hidden="true"></i>
				        </a>

						<button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
							<i class="mdi mdi-delete" aria-hidden="true"></i>
						</button>

					    <table class="table" id="teachers-table">
					        <thead class="bg-info text-white">
					            <tr>
					                <th><input type="checkbox" id="checkall" value="checkall"></th>
					                <th>{{ __('labels.id')}}</th>
					                <th>Image</th>
					              {{--   <th>{{ __('labels.first_name') }}</th>
					                <th>{{ __('labels.last_name') }}</th> --}}
					                <th>Name</th>
					                <th>{{ __('labels.email') }}</th>
									{{-- <th>{{ __('labels.birth_date') }}</th> --}}
					                {{-- <th>{{ __('labels.city') }}</th>
					                <th>{{ __('labels.state') }}</th>
					                <th>{{ __('labels.country') }}</th>
									<th>{{ __('labels.zip_code') }}</th>
					                <th>{{ __('labels.earning') }}(￥)</th> --}}
					                {{--<th>{{ __('Last Login') }}</th>--}}
					                <th>{{ __('labels.status') }}</th>
					                <th>{{ __('labels.step1_verified') }}</th>
					                {{--<th>{{ __('labels.last_login_at') }}</th>--}}
					                <th>{{ __('labels.action') }}</th>
					            </tr>
					        </thead>
					    </table>
                    </div>
                </div>
            </div>
        </div>
	</div>

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
					<p>Are you sure to delete this teacher?</p>
				</div>
				<div class="modal-footer">
					<button type="button" value="{{URL::to('admin/teachers')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">Submit</button>
					<button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw cancel_delete" data-dismiss="modal">Cancel</button>
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
            selected = [];
	        var oTable =  $('#teachers-table').DataTable({
	            processing: true,
	            serverSide: true,
	            searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
           		language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
	            ajax: {
	                url: '{{ route('admin.teachers.get') }}',
	                type: 'POST',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: function (d) {
	                     d.firstname = $('input[name=firstname]').val();
	                     d.lastname = $('input[name=lastname]').val();
	                     d.email = $('input[name=email]').val();
	                     d.status = $('select[name=status]').val();
	                     d.step_verified = $('select[name=step_verified]').val();
	                                        }
	            },
	            /*columnDefs: [
	            ],*/
				order: [[1,'desc']],
	            columns: [
	                { data: 'case', name: 'case',orderable: false, searchable: false},
	                { data: 'id', name: 'id'},
	                { data: 'profile_image', name: 'profile_image', orderable: false, searchable: false },
	               // { data: 'firstname', name: 'firstname' },
	                { data: 'name', name: 'name' },
	                { data: 'email', name: 'email'},
                    /* { data: 'dob', name: 'dob'}, */
	            /*    { data: 'city', name: 'city'},
	                { data: 'state', name: 'state'},
	                { data: 'country', name: 'country'},
                    { data: 'zipcode', name: 'zipcode'},
	                { data: 'earning', name: 'earning',orderable: false,render: $.fn.dataTable.render.number(',', '.', 0, '¥  ')},*/
	                //{ data: 'last_login_at', name: 'last_login_at',orderable: false,searchable: false},
	                { data: 'status', name: 'status',orderable: false},
	                { data: 'step1_verified', name: 'step1_verified',orderable: false},
	                //{ data: 'last_login_at', name: 'last_login_at',orderable: false, searchable: false },
	                { data: 'action', name: 'action',orderable: false, searchable: false}
	            ]
	        });


	        $(document).on("click",".deleteUser",function () {
	            var user_id = $(this).attr('id');
	            $(".yes_delete").attr('id',user_id);
	            $("#exampleModalPrimary").modal('show');
	        });

	        $(document).on("click",".yes_delete",function () {
	            let user_id = $(this).attr('id');
	            if(user_id){
                    $.ajax({
                        url: '{{URL::to('admin/teachers')}}' +'/'+ user_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            window.location = '{{URL::to('admin/teachers')}}';
                        }
                    });
				}
	        });

	        $(document).on('keyup','#user-search input',function(e){
	            oTable.draw(true);
	            e.preventDefault();
	        });

	        $(document).on('change','#user-search select',function(e){
	            oTable.draw(true);
	            e.preventDefault();
	        });



	    </script>
	@endpush
@endsection
