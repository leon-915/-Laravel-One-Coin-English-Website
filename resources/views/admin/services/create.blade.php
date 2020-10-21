@extends('admin.layouts.admin',['title'=>'Add Service'])

@section('title','Add Service')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ __('labels.add_service')}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('admin.services.index') }}">{{ __('labels.manage_services')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.add_service')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.add_service')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.services.store','id'=>'create_service','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.services.form',['form' => 'create'])
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

            jQuery.validator.addMethod("requiredTags", function (value, element) {
                if (value.length) {
                    return true;
                } else {
                    return false;
                }
            }, '');

            $('#create_service').validate({
                ignore: "",
                rules: {
                    title: {
                        required: true,
                        maxlength: 191
                    },
                    description: {
                        //required: true,
                        maxlength: 900
                    },
                    length: {
                        required: true,
                        number: true,
                        maxlength: 2
                    },
                    padding_minutes: {
                        required: true,
                        number: true,
                        maxlength: 2
                    },
                    price: {
                        //required: true,
                        number: true,
                        maxlength: 10
                    },
                    service_name_en: {
                        required: true,
                        maxlength: 191
                    },
                    available_lessons: {
                        required: true,
                        number: true,
                        maxlength: 3
                    },
                    no_of_days: {
                        required: true,
                        number: true,
                        maxlength: 3
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter title"
                    },
                    description: {
                        // required: 'Please enter description',
                        maxlength: 'Please enter maximum 900 character'
                    },
                    length: {
                        required: 'Please enter length',
                        number: 'Please enter numeric value only',
                        maxlength: 'Enter Length maximum 2 digits'
                    },
                    padding_minutes: {
                        required: 'Please enter padding minutes',
                        number: 'Please enter numeric value only',
                        maxlength: 'Enter padding minutes maximum 2 digits'
                    },
                    price: {
                        // required: 'Please enter price',
                        number: 'Please enter numeric value only',
                        maxlength: 'Enter price maximum 10 digits'
                    },
                    service_name_en: {
                        required: 'Please enter service name(english)'
                    },
                    prepayment: {
                        number: 'Please enter numeric value only',
                        maxlength: 'Enter prepayment maximum 6 digits'
                    },
                    available_lessons: {
                        required: 'Please enter available lessons',
                        number: 'Please enter numeric value only',
                        maxlength: 'Enter lessons maximum 3 digits'
                    },
                    no_of_days: {
                        required: 'Please enter days',
                        number: 'Please enter numeric value only',
                        maxlength: 'Enter days maximum 3 digits'
                    },
                    status: {
                        required: "Please select status"
                    }
                }
            });
            $(document).ready(function () {
                $('.multiple-package').select2({
                    placeholder: "  Select Packages"
                });

                $('.multiple-location').select2({
                    placeholder: "  Select Locations"
                });

                $('.multiple-teacher').select2({
                    placeholder: "  Select Teachers"
                });
            });

            $(document).ready(function () {

                //Appointment Hide/Show Script
                $('select.appointment_time').attr('disabled', true).val('');

                $('.Appointment_chekbox').click(function () {
                    if ($(this).is(':checked')) {
                        $('select.appointment_time').attr('disabled', false);
                    }
                    if (!$(this).is(':checked')) {
                        $('select.appointment_time').attr('disabled', true).val('');
                    }
                });

                //Prepayment Hide/Show Script
                $('div.prepayment_div').hide();
                $('input[name="prepayment_type"]').attr('checked', null);
                $('input[name="prepayment"]').val('');

                $('.payment_chekbox').click(function () {
                    if ($(this).is(':checked')) {
                        $('div.prepayment_div').show();
                    }
                    if (!$(this).is(':checked')) {
                        $('div.prepayment_div').hide();
                        $('input[name="prepayment_type"]').attr('checked', null).val('');
                        $('input[name="prepayment"]').val('');
                    }
                });

                $('#packages-cont').addClass('d-none');
            });

            $(document).on('change', '#is_system_service', function (e) {
                e.preventDefault();
                console.log($('#is_system_service').is(":checked"));
                if ($('#is_system_service').is(":checked")) {

                    $('#no_of_days').val('');
                    $('#available_lessons').val('');
                    $('#no_of_days_container').addClass('d-none');
                    $('#available_lessons_container').addClass('d-none');
                    $('#packages-cont').removeClass('d-none');
                    $("#package_id").rules("add", {required: true});
                    $("#no_of_days").rules("remove");
                    $("#available_lessons").rules("remove");
                    $('#receive-credit-cont').removeClass('d-none');
                    $('#trial-container').addClass('d-none');
                }
                else {
                    $('#no_of_days_container').removeClass('d-none');
                    $('#available_lessons_container').removeClass('d-none');
                    $('#package_id').val(null).trigger('change');
                    $('#receive_credit_on_booking').val('');
                    $('#packages-cont').addClass('d-none');
                    $("#package_id").rules("remove");
                    $("#no_of_days").rules("add", {required: true});
                    $("#available_lessons").rules("add", {required: true});
                    $('#receive-credit-cont').addClass('d-none');
                    $('#trial-container').removeClass('d-none');
                }
            });

            $(document).on('change', '.prepayment_type', function (e) {
                e.preventDefault();
                var radio = $(this).val();
                if (radio == 1) {
                    $("#prepayment").rules("remove");
                    $("#prepayment").rules("add", {
                        required: true,
                        number: true,
                        max: 99999999,
                        min: 1
                    });
                } else if (radio == 2) {
                    $("#prepayment").rules("remove");
                    $("#prepayment").rules("add", {
                        required: true,
                        number: true,
                        max: 100,
                        min: 1
                    });
                }
            });

            /*$(document).on('change', '#package_id', function (e) {
                e.preventDefault();
                var len = $(this).val().length;
                
                if (len >= 1) {
                    $('#trial-container').addClass('d-none');
                } else {
                    $('#trial-container').removeClass('d-none');
                }
            });*/


            $(document).on('change', '#receive_credit_on_booking_type', function () {
                var booking_type = $(this).val();

                if (booking_type == 1) {
                    $("#receive_credit_on_booking").rules("remove");
                    $("#receive_credit_on_booking").rules("add", {
                        required: true,
                        number: true,
                        max: 1000000,
                        min: 1
                    });
                } else if (booking_type == 2) {
                    $("#receive_credit_on_booking").rules("remove");
                    $("#receive_credit_on_booking").rules("add", {
                        required: true,
                        number: true,
                        max: 99,
                        min: 1
                    });
                }
            });

            // $("#receive_credit_on_booking").rules("add", {
            //     required: true,
            //     number: true,
            //     max: 1000000,
            //     min: 1
            // });


        </script>
    @endpush
@endsection
