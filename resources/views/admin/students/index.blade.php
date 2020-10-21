@extends('admin.layouts.admin',['title'=>'Manage Students'])

@section('title', 'Manage Students')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.manage_students') }} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.manage_students') }}</li>
                </ol>
            </nav>
		</div>
		@include('admin.students.search')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

				        <a class="btn btn-inverse-info btn-rounded btn-icon add_data"
				           href="{{ url('admin/students/create') }}" data-toggle="tooltip" data-placement="top" data-original-title="Add New Student" title="Add New Student" >
				            <i class="mdi mdi-plus" aria-hidden="true"></i>
				        </a>

						<button type="button" id="deleteAll" class="btn btn-outline-danger btn-rounded btn-icon remove-row detele-all" data-toggle="tooltip" title="Delete" data-original-title="Delete">
							<i class="mdi mdi-delete" aria-hidden="true"></i>
						</button>

					    <table class="table" id="students-table">
					        <thead class="bg-info text-white">
					            <tr>
									<th><input type="checkbox" id="checkall" value="checkall"></th>
									<th>{{ __('labels.id') }}</th>
					                <th>{{ __('labels.first_name') }}</th>
					                <th>{{ __('labels.last_name') }}</th>
					                <th>{{ __('labels.email') }}</th>
					                <th>{{ __('labels.contact_no') }}</th>
									<th>{{ __('labels.status') }}</th>
									{{-- <th>{{ __('labels.profile_image') }}</th> --}}
									{{-- <th>{{ __('labels.service') }}</th> --}}
					                <th>{{ __('labels.action') }}</th>
					            </tr>
					        </thead>
					    </table>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<style>
		#students-table {
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
					<p>{{ __('labels.confirm_delete_student') }}</p>
				</div>
				<div class="modal-footer">
					<button type="button" value="{{URL::to('admin/students')}}" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{ __('labels.submit') }}</button>
					<button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw cancel_delete" data-dismiss="modal">{{ __('labels.cancel') }}</button>
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
			var indexUrl = '{{ route('admin.students.index') }}';
			var csrfToken = $('meta[name="csrf-token"]').attr('content');
			var getListUrl = '{{ route('admin.students.get') }}';
	    </script>
		<script src="{{ asset('js/admin/student/index.js') }}"></script>
	@endpush
@endsection
