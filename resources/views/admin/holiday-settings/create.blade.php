@extends('admin.layouts.admin',['title'=>'Holiday Settings'])

@section('title','Holiday Settings')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.holiday_settings')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.holiday_settings')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.holiday_settings')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.holiday.setting.store','id'=>'create_holiday_settings','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.holiday-settings.form')
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
        <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
        <script>

            $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });

            $('.desc_star').maxlength({
                alwaysShow: true,
                warningClass: "badge mt-1 badge-success",
                limitReachedClass: "badge mt-1 badge-danger"
            });

            $('.datepicker-popup').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: '1d',
                autoclose: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "0:+10",
                dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            });
        </script>
    @endpush
@endsection

