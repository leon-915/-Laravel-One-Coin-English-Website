@extends('admin.layouts.admin',['title'=>'Edit Static Page'])

@section('title','Edit Static Page')

@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title">{{ __('labels.edit_static_page')}}</h3>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> {{ __('labels.dashboard')}}</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.static-pages.index') }}">{{ __('labels.manage_static_pages')}}</a></li>
				<li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_static_page')}}</li>
			</ol>
		</nav>
	</div>
	<div class="row grid-margin">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">{{ __('labels.edit_static_page')}}</h4>

					@if (count($errors) > 0)
						@foreach ($errors->all() as $error)
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							{{ $error }}
						</div>
						@endforeach
					@endif

					{!! Form::model($page, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_static_page','route' => ['admin.static-pages.update', $page->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
						@include('admin.static-pages.form')
					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
	<script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

	<script>
		CKEDITOR.replace('body');

		$('#input-file-max-fs').dropify();

		$('#edit_static_page').validate({
			ignore: "",
			rules: {
				page_name : {
                    required: true
                },
                title:{
                    required: true
                },
                meta_description:{
                    required: true
                },
                meta_keyword:{
                    required: true
                }
			},
			messages: {
				page_name : {
                    required : "Please select page"
                },
                title:{
                    required: "Please enter title"
                },
                meta_description:{
                    required: "Please enter meta description"
                },
                meta_keyword : {
                    required : "Please enter meta keyword"
                }
			},
			errorPlacement: function(error, element) {
                if (element.attr("name") == "body") {
                    error.insertAfter(".panel");
                }
                else{
                    error.insertAfter(element);
                }
        }
		});

		$('#edit_static_page').on('submit', function(e)
        {
            e.preventDefault();
            e.stopPropagation();
            var desc = CKEDITOR.instances['body'].getData().replace(/<[^>]*>/gi, '').trim();

            if(desc != ''){
                $('#body-error').html('');
                if($(this).valid()){
                    $(this).unbind('submit').submit();
                }
            } else {
                $('#body-error').html('Please enter body.');
                return false;
            }
        });

	</script>
@endpush
@endsection
