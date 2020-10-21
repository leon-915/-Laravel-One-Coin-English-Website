@extends('layouts.admin',['title'=>'Manage Users','search'=>'admin.retailers.search'])

@section('title', 'Manage Users')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Manage Users </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
                </ol>
            </nav>
		</div>

		@include('admin.users.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

				        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
				           href="{{ url('users/create') }}" data-toggle="tooltip" data-placement="top" data-original-title="Add New User" title="Add New User" >
				            <i class="mdi mdi-account-plus" aria-hidden="true"></i>
				        </a>

					    <table class="table respsive-dt-table" id="users-table">
					        <thead class="bg-info text-white">
					            <tr>
					                <th>ID</th>
					                <th>Name</th>
					                <th>Email</th>
									<th>Birth Date</th>
					                <th>City</th>
					                <th>State</th>
									<th>Zip Code</th>
					                <th>Status</th>
					                <th>Action</th>
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
					<p>Are you sure to delete this user?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">Submit</button>
					<button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw" data-dismiss="modal">Cancel</button>
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
	        var oTable =  $('#users-table').DataTable({
	            processing: true,
	            serverSide: true,
	            searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
           		language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
	            ajax: {
	                url: '{{ url('users/get') }}',
	                type: 'POST',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: function (d) {
	                     d.name = $('input[name=name]').val();
	                     d.email = $('input[name=email]').val();
	                     d.status = $('select[name=status]').val();
	                                        }
	            },
	            /*columnDefs: [
	            ],*/
				order: [[0,'desc']],
	            columns: [
	                { data: 'id', name: 'id'},
	                { data: 'name', name: 'name' },
	                { data: 'email', name: 'email'},
                    { data: 'birth_date', name: 'birth_date'},
	                { data: 'city', name: 'city'},
	                { data: 'state', name: 'state'},
                    { data: 'zip_code', name: 'zip_code'},
	                { data: 'status', name: 'status'},
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
                        url: '{{URL::to('users')}}' +'/'+ user_id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            /*   oTable.draw(true);
                               $("#exampleModalPrimary").modal('hide');*/
                            window.location = '{{URL::to('users')}}';
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
