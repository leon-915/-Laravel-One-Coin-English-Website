@extends('layouts.app')
@section('title', __('labels.stu_login'))

@section('content')
<section class="logine_sec">

    <div class="container-fluid">
        <div class="row">
            <div class="login_img col-lg-6 col-sm-12 col-12">
                <img src="{{ asset('images/login_left.jpg')}}">
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
            	<div class="row clearfix">
                	<div class="col-lg-2 col-sm-12 col-12"></div>
                	<div class="col-lg-8 col-sm-12 col-12">
                        <div class="login_inner">
                            <div class="login_flex">
                                @if (!empty($ref) && $ref == 'teacher')
                                <form method="POST" action="{{ route('teacher.login') }}">
                                @else
                                <form method="POST" action="{{ route('login') }}">
                                @endif
                                    @csrf
                                    <h1>{{ __('labels.stu_login') }}</h1>
            
                                        <h3>{{ __('labels.stu_welcome_to')}} <b>{{ env('APP_NAME') }} </b></h3>
                                        
                                    <?php if(!empty($dateBegin) && !empty($dateEnd) && !empty($today)) { ?>
                                        <?php if (($today >= $dateBegin) && ($today <= $dateEnd)){ ?>
                                            <div class="text-center p-3 text-justify" style="border: 1px solid;border-radius: 5px;">
                                                <h2 class="mb-3" style="color:red">{{__('labels.stu_holiday_notification')}}</h2>
                                                @if(App::isLocale('en'))
                                                    <p class="mb-3 text-justify">{{$message_en}}</p>
                                                @else
                                                    <p class="mb-3 text-justify">{{$message_ja}}</p>
                                                @endif
                                            </div>
                                        <?php } ?>
                                    <?php } ?>	
            
                                    <div class="form-group">
                                        <label>{{ __('labels.stu_email') }}<span>*</span></label>
                                        <input id="email" type="text" class="form-control"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('labels.stu_password') }}<span>*</span></label>
                                        <input id="password" type="password" class="form-control " name="password" required autocomplete="current-password">
                                    </div>
            
                                    <div class="form-group">
                                        <?php $errs = $errors->all(); ?>
                                        @if($errs)
                                            <div class="alert alert-danger" role="alert">
                                                <strong><?= current($errs) ?></strong>
                                            </div>
                                        @endif
                                    </div>
            
                                    <div class="submit_register">
                                        <label class="checkcontainer"> {{ __('labels.remember_me') }}
                                            <input type="checkbox" checked="checked"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
            
                                        <div class="submit_btn">
											<?php
												if(strstr(Request::url(), 'login/onepage')){
													$referer = Request::url();
												} else if(strstr(Request::url(), 'startsession')){
													$referer = Request::url();
												} else if(strstr(Request::url(), 'profile/favorite')){
													$referer = Request::url();
												} else {
													$referer = Request::server('HTTP_REFERER');
												}
											?>
											<input type="hidden" name="referer" value="<?php echo $referer;?>" />
                                            <button type="submit" class="btnsub_arr">{{ __('labels.btn_login') }}</button>
                                        </div>
                                    </div>
            
                                    <div class="reset_pass">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="frgt_pass">
                                                {{ __('labels.forgot_your_pass') }}
                                            </a>
                                            @if (!empty($ref) && $ref == 'teacher')
                                            <span>
                                                If you would like to teach amazing lessons at {{ env('APP_NAME') }}, then
                                                <a href="{{ route('teachers.register.recruitment') }}" class="register_here">
                                                    Register here.
                                                </a>
                                            </span>
                                            @endif
                                        @endif
                                    </div>
                                </form>
            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script type="">
        var headerHeight = $('#header-sroll').outerHeight();
        var footerHeight = $('footer').outerHeight();
        var totalHeight = headerHeight + footerHeight;

        $('.login_inner').css('min-height','calc(100vh - '+footerHeight+'px - 160px)');
    </script>
@endpush
@endsection
