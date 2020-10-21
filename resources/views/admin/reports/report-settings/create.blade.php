@extends('admin.layouts.admin',['title'=>'Report Settings'])

@section('title','Report Settings')

@section('content')
<?php
$url = url('');

if (Auth::guard('admin')->user()->role == 'sub_admin') {
	$url = url('/admin/lesson-reports/admin-lessons-report');
} else {
	$url = url('/admin/dashboard');
}

?>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.report_settings')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ $url }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.report_settings')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.report_settings')}}</h4>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        {!! Form::open(array('route' => 'admin.report.settings.store','id'=>'create_report_settings','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.reports.report-settings.form')
                        </fieldset>
                        {!! Form::close() !!}
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

        <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

        <script>

            $('#create_report_settings').validate({
                ignore: "",
                rules: {
                    ultimate: {
                        maxlength: 10,
                        number: true
                    },
                    ideal: {
                        maxlength: 10,
                        number: true
                    },
                    target: {
                        maxlength: 10,
                        number: true
                    },
                    minimum: {
                        maxlength: 10,
                        number: true
                    }
                }
            })

        </script>

    @endpush
@endsection