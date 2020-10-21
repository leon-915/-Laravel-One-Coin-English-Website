<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0"/>

	<meta NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta content="恵比寿教室, Accent, アクセント, オンライン英会話, カフェレッスン, 英会話教室, ビジネス英会話, 英会話無料, マンツーマン, 無料トライアル" name="keywords">
	<meta content="Accent(アクセント)は恵比寿にある手頃な料金プランでレッスンをカスタムメイドできる英会話教室です。恵比寿駅の近くにある教室にて25分もしくは50分のマンツーマンレッスン。また、オンラインやカフェなど、日本全国から受講可能です。無料トライアルレッスン実施中！" name="description">
	<meta name="google-site-verification" content="lRRcKwWz26p3TgQnqJJ2DrqeC2SAAVq4rcqlDTm-T30" />
	      
	<link rel="apple-touch-icon" href="{{ asset('assets/admin/images/apple-touch-icon.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/admin/images/apple-touch-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/admin/images/apple-touch-icon-114x114.png') }}">
	<meta name="google-site-verification" content="lRRcKwWz26p3TgQnqJJ2DrqeC2SAAVq4rcqlDTm-T30" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>手頃な料金プランの英会話恵比寿教室・オンライン、オフィス、カフェレッスンも可能 :Accent英会話 | @yield('title')</title> --}}

    <?php
        $siteTitle = \App\Models\Settings::getSettings('site_title');
    ?>
    <title>英語で話したい？思い立ったら 今がその時！</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}


    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">

	<link href="{{ asset('css/jquery.steps.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery.timepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/toast/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/listswap/jquery.listswap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/croppie/croppie.css') }}" rel="stylesheet">

    <link href='{{ asset('plugins/fullcalendar/packages/core/main.css') }}' rel='stylesheet' />
	<link href='{{ asset('plugins/fullcalendar/packages/daygrid/main.css') }}' rel='stylesheet' />
	<link href='{{ asset('plugins/fullcalendar/packages/timegrid/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('plugins/fullcalendar/packages/list/main.css') }}' rel='stylesheet' />


	<link href='{{ asset('plugins/star-ratings/css/star-rating.css') }}' rel='stylesheet' />
	<link href='{{ asset('plugins/sweetalert/sweetalert.css') }}' rel='stylesheet' />
	<link href='{{ asset('plugins/star-ratings/themes/krajee-svg/theme.css') }}' rel='stylesheet' />
	<link href='{{ asset('plugins/microtip/microtip.min.css') }}' rel='stylesheet' />
	<!-- custom styles-->
    {{-- <link href="{{ asset('onepage/css/update-style-new.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/onepage-custom.css') }}" rel="stylesheet">
	<link href="{{ asset('css/new-lokalingo-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts/stylesheet.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}

	<link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.png') }}" />
	<link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
	
	<link rel="stylesheet" href="{{ asset('assets/jquery-textext/css/textext.core.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/jquery-textext/css/textext.plugin.autocomplete.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/jquery-textext/css/textext.plugin.tags.css') }}">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158746282-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-158746282-1');
	</script>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


</head>
<?php
$cls = '';
if (!Auth::guest() && Auth::user()->user_type == 'teacher'){
	$cls = 'hkjhj';
}
?>
<body class="<?php echo $cls;?>">
    <div id="wrapper" class="">
        @include('layouts.partials.header')
        <div id="content" class="">
            @yield('content')
        </div>
        @include('layouts.partials.footer')
        @include('layouts.partials.scan-modal')
    </div>

    <div class="el-loading app-loader d-none">
        <div class="jumping-dots-loader">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

   {{--  @if (Auth::guest())
    @else
        <div class="modal fade" id="logout-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alert</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to Logout ?</p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    {{-- <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script> --}}
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script> --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/menu.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery.steps.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toast/jquery.toast.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/croppie/croppie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/sweetalert/sweetalert.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}

    @php $user = Auth::user();  @endphp

    @if($user and ($user->line_token == null) and ($user->send_line_notifications == 0))
        <script>
            $('#qrModal').modal('show');
        </script>
    @endif

    <script type="text/javascript">
    var setLineNotificationFlag = '{{ route('setLineNotificationFlag') }}';
        //set content bottom padding
        $("#content").css("padding-bottom", $("footer").outerHeight()+'px');
        $("#content").css("padding-top", $("header").outerHeight()+'px');

        $(document).ready(function(){
            $('#lineNotification').on('click',function(){
                let user_id = $(this).val(),
                csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: setLineNotificationFlag,
                    type: 'POST',
                    //data: 'user_id=' + user_id,
                    data: { user_id : user_id, data_to_update : 1 },
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    beforeSend:function(){
                        $('.app-loader').removeClass('d-none');
                    },
                    success: function (result) {
                        $('.app-loader').addClass('d-none');
                        $('#qrModal').modal('hide');
                        $.toast({
                            heading: 'Success',
                            text: "Line notification status saved successfully",
                            icon: 'success',
                            position: 'top-right',
                        })
                    }
                });
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* setTimeout(() => { $(".alert").slideUp(function() {
                $(this).remove();
                });
            }, 10000); */

            // $(document).on('click','#btn-header-logout',function(e){
            //     console.log(123);
            //     e.preventDefault();
            //     $('#logout-modal').show('modal');
            // });
        });
    </script>
    @stack('scripts')
</body>
</html>
