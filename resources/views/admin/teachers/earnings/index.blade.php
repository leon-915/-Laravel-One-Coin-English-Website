@extends('admin.layouts.admin',['title'=>__('labels.teacher_earnings') ,'search'=>'admin.teachers.earnings.search'])

@section('title',__('labels.teacher_earnings') )

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.teacher_earnings') }} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Manage Teachers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('labels.teacher_earnings') }}</li>
                </ol>
            </nav>
		</div>

		@include('admin.teachers.earnings.search')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
					     <table class="table" id="teacher-earning-table">
                            <thead class="bg-info text-white"> 
					       
					            <tr>
					                <th>{{ __('labels.id') }}</th>
					                <th>{{ __('labels.student') }}</th>
					                <th>{{ __('labels.service') }}</th>
					                <th>{{ __('labels.earning') }}</th>
					                <th>{{ __('labels.date') }}</th>
					            </tr>
					        </thead>
					    </table>
                    </div>
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
	        var oTable =  $('#teacher-earning-table').DataTable({
	            processing: true,
	            serverSide: true,
	            searching: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
           		language: {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="dot-opacity-loader"><span></span><span></span><span></span></div>'
                },
	            ajax: {
	                url: '{{ route('admin.teachers.get.earning.detail') }}',
	                type: 'POST',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: function (d) {
	                	d.teacher_id = $('input[name=teacher_id]').val();
	                	d.from      = $('input[name=from]').val();
                        d.to 	    = $('input[name=to]').val();
	                }
	            },
	            /*columnDefs: [
	            ],*/
				order: [[0,'desc']],
	            columns: [
	                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable:false,searchable:false},
	                { data: 'student.firstname', name: 'student.firstname'},
	                { data: 'service.title', name: 'service.title' },
	                { 
	                	data: 'teacher_earnings', 
	                	name: 'teacher_earnings',
	                	render: $.fn.dataTable.render.number(',', '.', 0, '¥'),
	                	orderable:false,
	                	searchable:false 
	                },
	                { data: 'created_at', name: 'created_at'}
	            ]
	        });

	        $('#from').datepicker({
                format: "yyyy/mm/dd",
                enableOnReadonly: true,
                todayHighlight: true,
            });

            $('#to').datepicker({
                format: "yyyy/mm/dd",
                enableOnReadonly: true,
                todayHighlight: true,
            });

            $("#to").change(function () {
                var startDate = document.getElementById("to").value;
                var endDate = document.getElementById("from").value;

                if ((Date.parse(startDate) < Date.parse(endDate))) {
                    alert("End date should be greater than Start date");
                    document.getElementById("to").value = "";
                }
            });

            $(document).on('change', '#from', function (e) {
                oTable.draw(true);
                e.preventDefault();
            });

            $(document).on('change', '#to', function (e) {
                oTable.draw(true);
                e.preventDefault();
            });

	    </script>
	@endpush
@endsection
