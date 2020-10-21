@extends('layouts.app',['title'=>'contact_us'])
@section('title', 'contact_us')
@section('content')

    <section class="sub_page_padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="sub_page_header">{{__('labels.home_contact_us')}}</h4>
                </div>
            </div>
            <div class="aboutus_detail_box">
                <div class="row">
                    <div class="col-12 col-lg-5 col-md-12">
                        <div class="contact_map">
                            <div class="map-responsive">
                                <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=accent+language+inc+tokyo+Japan"
                                        width="600" height="450" frameborder="0" style="border:0"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <div class="conatct_info">
                            <ul>
                                <li><img src="{{asset('images/contact_loca.png')}}" alt="loca">{{__('labels.contact_location_detail')}}</li>
                                <li><img src="{{asset('images/contact_message.png')}}" alt="massage">supporting_you@accent-admin.com </li>
                                <li><img src="{{asset('images/contact_call.png')}}" alt="call"> {{__('labels.contact_telephone')}} </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 col-md-12">
                        <div class="abt_header">
                            <h5>{{ __('labels.contact_us_want_to')}}</h5>
                            <p>{{ __('labels.contact_us_leave_msg')}}</p>
                        </div>

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

                        <div class="mesg_form">
                            {!! Form::model('contact_us', ['method' => 'POST',  'id'=>'contact_us','route' => ['contact_us.submit'],'autocomplete' => "off","enctype"=>"multipart/form-data"]) !!}
                                <div class="row">
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{ __('labels.contact_your_name')}}<span class="vali">*</span></label>
                                                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}"
                                                       placeholder="{{ __('labels.contact_your_name')}}" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{ __('labels.contact_your_email')}}<span class="vali">*</span></label>
                                                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}"
                                                       placeholder="{{ __('labels.contact_your_email')}}" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('labels.contact_subject')}}<span class="vali">*</span></label>
                                            <input type="text" name="subject" id="subject" class="form-control" value="{{old('subject')}}"
                                                   placeholder="{{__('labels.contact_subject')}}" aria-describedby="emailHelp">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('labels.contact_your_msg')}}<span class="vali">*</span></label>
                                            <textarea name="message" id = "message" placeholder = "{{ __('labels.contact_your_msg')}}" class ="text-control" aria-describedby = "emailHelp">{{old('message')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group captcha_text">
                                            <label for="exampleInputEmail1">{{ __('labels.contact_captcha')}}</label>
                                            {!! captcha_image_html('ExampleCaptcha') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('labels.contact_enter_captcha')}}<span class="vali">*</span></label>
                                            {!! Form::text('captcha_code', '', array('placeholder' => __('labels.contact_enter_captcha') ,'class'=> 'form-control','id' => 'captcha_code'))!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn_sub btn btn_custon">{{__('labels.contact_send')}}</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

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

        <script type="text/javascript">
            //set content bottom padding
            $("#content").css("padding-bottom", $("footer").outerHeight() + 'px');
            $("#content").css("padding-top", $("header").outerHeight() + 'px');
        </script>

        <script>
            $('#contact_us').validate({
                ignore: "",
                rules: {
                    name : {
                        required: true
                    },
                    email : {
                        required: true
                    },
                    subject:{
                        required: true
                    },
                    message:{
                        required: true
                    },
                    CaptchaCode:{
                        required: true
                    },
                    // terms:{
                    //     required: true
                    // }
                },
                messages: {
                    name : {
                        required: 'Please enter your name'
                    },
                    email : {
                        required:  'Please enter your email'
                    },
                    subject:{
                        required: 'Please enter subject '
                    },
                    message:{
                        required: 'please enter message'
                    },
                    CaptchaCode:{
                        required: 'Please enter captcha code'
                    }
                }
            });
        </script>
        <style>
            a#ExampleCaptcha_SoundLink {
                display: none !important;
            }
        </style>
    @endpush
@endsection