@extends('admin.layouts.admin',['title'=>'Manage Settings'])

@section('title','Manage Settings')

@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('labels.settings')}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('labels.dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.settings')}}</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('labels.settings')}}</h4>
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
                        {!! Form::open(array('route' => 'admin.settings.store','id'=>'create_settings','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                        <fieldset>
                            @include('admin.settings.form')
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
            $('#create_settings').validate({
                ignore: "",
                rules: {
                    book_before_time : {
                        maxlength:3,
                        number:true
                    },
                    cancel_before_time : {
                        number:true
                    },
                    onepage_certified_fee : {
                        number:true
                    },
                    tax : {
                        max:100,
                        number:true
                    },
                    no_of_free_lesson_rating : {
                        maxlength:3,
                        number:true
                    },
                    teacher_credits_rate : {
                        maxlength:3,
                        number:true
                    },
                    max_globle_lesson_price: {
                        number:true
                    }

                }
            });
        </script>

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
            {{--if ($("#globle-lesson-range").length) {--}}
                {{--var globlebigValueSlider = document.getElementById('globle-lesson-range'),--}}
                    {{--globlebigValueSpan = document.getElementById('globle-lesson-value');--}}
                {{--noUiSlider.create(globlebigValueSlider, {--}}
                    {{--start: {{ !empty($settings->max_globle_lesson_price) ? $settings->max_globle_lesson_price : 0 }},--}}
                    {{--step: 50,--}}
                    {{--range: {min: 0, max: 5000}--}}
                {{--});--}}
                {{--globlebigValueSlider.noUiSlider.on('update', function (values, handle) {--}}
                    {{--console.log(Math.floor(values));--}}
                    {{--globlebigValueSpan.innerHTML = Math.floor(values);--}}
                    {{--$('#max_globle_lesson_price').val(Math.floor(values))--}}
                {{--});--}}
            {{--}--}}

            if ($("#class-room-lesson-range").length) {
                var classbigValueSlider = document.getElementById('class-room-lesson-range'),
                    classbigValueSpan = document.getElementById('class-room-lesson-value');
                noUiSlider.create(classbigValueSlider, {
                    start: {{ !empty($settings->max_classroom_lesson_price_per) ? $settings->max_classroom_lesson_price_per : 0 }},
                    step: 1,
                    range: {min: 0, max: 100}
                });
                classbigValueSlider.noUiSlider.on('update', function (values, handle) {
                    console.log(Math.floor(values));
                    classbigValueSpan.innerHTML = Math.floor(values);
                    $('#max_classroom_lesson_price_per').val(Math.floor(values))
                });
            }

            if ($("#vertual-lesson-range").length) {
                var vertualbigValueSlider = document.getElementById('vertual-lesson-range'),
                    vertualbigValueSpan = document.getElementById('vertual-lesson-value');
                noUiSlider.create(vertualbigValueSlider, {
                    start: {{ !empty($settings->max_vertual_lesson_price_per) ? $settings->max_vertual_lesson_price_per : 0 }},
                    step: 1,
                    range: {min: 0, max: 100}
                });
                vertualbigValueSlider.noUiSlider.on('update', function (values, handle) {
                    console.log(Math.floor(values));
                    vertualbigValueSpan.innerHTML = Math.floor(values);
                    $('#max_vertual_lesson_price_per').val(Math.floor(values))
                });
            }

            if ($("#cafe-lesson-range").length) {
                var cafebigValueSlider = document.getElementById('cafe-lesson-range'),
                    cafebigValueSpan = document.getElementById('cafe-lesson-value');
                noUiSlider.create(cafebigValueSlider, {
                    start: {{ !empty($settings->max_cafe_lesson_price_per) ? $settings->max_cafe_lesson_price_per : 0 }},
                    step: 1,
                    range: {min: 0, max: 100}
                });
                cafebigValueSlider.noUiSlider.on('update', function (values, handle) {
                    console.log(Math.floor(values));
                    cafebigValueSpan.innerHTML = Math.floor(values);
                    $('#max_cafe_lesson_price_per').val(Math.floor(values))
                });
            }

            if ($("#admin-commision-range").length) {
                var adminCommisionValueSlider = document.getElementById('admin-commision-range'),
                    adminCommisionValueSpan = document.getElementById('admin-commision-value');
                noUiSlider.create(adminCommisionValueSlider, {
                    start: {{ !empty($settings->admin_commision) ? $settings->admin_commision : 0 }},
                    step: 1,
                    range: {min: 0, max: 100}
                });
                adminCommisionValueSlider.noUiSlider.on('update', function (values, handle) {
                    console.log(Math.floor(values));
                    adminCommisionValueSpan.innerHTML = Math.floor(values);
                    $('#admin_commision').val(Math.floor(values))
                });
            }
			
			if ($("#student-referred-admin-commision-range").length) {
                var studentreferredadminCommisionValueSlider = document.getElementById('student-referred-admin-commision-range'),
                    studentreferredadminCommisionValueSpan = document.getElementById('student-referred-admin-commision-value');
                noUiSlider.create(studentreferredadminCommisionValueSlider, {
                    start: {{ !empty($settings->student_referred_admin_commision) ? $settings->student_referred_admin_commision : 0 }},
                    step: 1,
                    range: {min: 0, max: 100}
                });
                studentreferredadminCommisionValueSlider.noUiSlider.on('update', function (values, handle) {
                    console.log(Math.floor(values));
                    studentreferredadminCommisionValueSpan.innerHTML = Math.floor(values);
                    $('#student_referred_admin_commision').val(Math.floor(values))
                });
            }
			
			if ($("#regular-course-rollover-precentage-range").length) {
                var regularCourseRolloverPrecentageValueSlider = document.getElementById('regular-course-rollover-precentage-range'),
                    regularCourseRolloverPrecentageValueSpan = document.getElementById('regular-course-rollover-precentage-value');
                noUiSlider.create(regularCourseRolloverPrecentageValueSlider, {
                    start: {{ !empty($settings->regular_course_rollover_precentage) ? $settings->regular_course_rollover_precentage : 0 }},
                    step: 1,
                    range: {min: 0, max: 100}
                });
                regularCourseRolloverPrecentageValueSlider.noUiSlider.on('update', function (values, handle) {
                    console.log(Math.floor(values));
                    regularCourseRolloverPrecentageValueSpan.innerHTML = Math.floor(values);
                    $('#regular_course_rollover_precentage').val(Math.floor(values))
                });
            }

            $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
			
			function changePercentageGlobal(dis) {
				console.log($(dis).val());
				var id = $(dis).attr('id') + '_val';
				var val = $(dis).val();
				console.log(val + ' %');
				$('#'+id).text(val);
			}

        </script>
    @endpush
@endsection

