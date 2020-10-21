@extends('admin.layouts.admin',['title'=>'Edit Coupon'])

@section('title','Edit Coupon')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.edit_coupon')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">{{ __('labels.manage_coupon')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_coupon')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.edit_coupon')}}</h4>

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
                        {!! Form::model($coupons, ['method' => 'PATCH', 'class'=>'cmxform', 'id'=>'edit_coupon','route' => ['admin.coupons.update', $coupons->id],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                            <fieldset>
                                @include('admin.coupons.form')
                            </fieldset>
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
            $('#edit_coupon').validate({
                ignore: "",
                rules: {
                    coupon_code : {
                        required: true
                    },
                    discount:{
                        required: true,
                        number:true
                    },
                    to_date:{
                        required: true
                    },
                    from_date:{
                        required: true
                    },
                    status:{
                        required: true
                    },
                    usage_limit_per_coupon:{
                        number: true,
                        max: 1000000,
                    },
                    usage_limit_per_user:{
                        number: true,
                        max: 1000000,
                    }
                },
                messages: {
                    coupon_code : {
                        required : "Please enter coupon code"
                    },
                    discount:{
                        required: "Please enter discount",
                        number:'Please enter numeric value only'
                    },
                    to_date:{
                        required: 'Please select to date'
                    },
                    from_date:{
                        required: 'Please select from date'
                    },
                    status:{
                        required: 'Please select status'
                    }
                }
            });

            $('#from_date').datepicker({
                minDate: new Date(),
                format: "yyyy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
                // endDate : '-1d',
                startDate: '+0d',
                onClose: function (selectedDate) {
                    $("#to_date").datepicker("option", "minDate", selectedDate);
                }
            });

            $('#to_date').datepicker({
                minDate: new Date(),
                format: "yyyy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
                // endDate : '-1d',
                startDate: '+1d',
                onClose: function (selectedDate) {
                    $("#from_date").datepicker("option", "maxDate", selectedDate);
                }
            });

            $("#discount").rules("add", {
                required: true,
                number: true,
                max: 1000000,
                min: 1
            });

            $(document).ready(function () {
                var discount_type = $('#discount_type').val();

                if (discount_type == 1) {
                    $("#discount").rules("remove");
                    $("#discount").rules("add", {
                        required: true,
                        number: true,
                        max: 1000000,
                        min: 1
                    });
                } else if (discount_type == 2) {
                    $("#discount").rules("remove");
                    $("#discount").rules("add", {
                        required: true,
                        number: true,
                        max: 99,
                        min: 1
                    });
                }
            });

            $(document).on('change', '#discount_type', function () {
                var discount_type = $(this).val();

                if (discount_type == 1) {
                    $("#discount").rules("remove");
                    $("#discount").rules("add", {
                        required: true,
                        number: true,
                        max: 1000000,
                        min: 1
                    });
                } else if (discount_type == 2) {
                    $("#discount").rules("remove");
                    $("#discount").rules("add", {
                        required: true,
                        number: true,
                        max: 99,
                        min: 1
                    });
                }
            });
        </script>
    @endpush
@endsection
