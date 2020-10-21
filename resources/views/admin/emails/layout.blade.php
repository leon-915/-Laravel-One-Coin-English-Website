<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><meta charset="utf-8">
    <title> Layouts </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/admin/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/admin/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin/site.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin/jquery.toast.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin/magnific-popup.css') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('/fonts/admin/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/fonts/admin/web-icons/web-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/fonts/admin/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'>

    <link rel="stylesheet" href="{{ asset('css/admin/admin-style.css') }}">

</head>

<body class="bg" style="background: #f8f4f2; font-family: 'Roboto', sans-serif;font-size: 14px;	margin: 0;">
<div class="email_ver" style="background: #fff; max-width: 540px; margin: 40px auto 25px; text-align: center; padding: 20px; border-radius: 5px; box-shadow: 0px 10px 28px 0px rgba(0, 0, 0, 0.1);">
    <div class="your_email">
        <img src="{{asset('images/logo-blue.png')}}">

        @yield('content')

        <div class="social_icon">
            <ul style="margin: 0; padding: 0; margin-bottom: 15px;  margin-top: 40px;">
                <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://business.facebook.com/AccentLanguageEducation"> <img src="{{ asset('images/social/fb.png') }}"> </a></li>
                <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://twitter.com/AccentLanguage"> <img src="{{ asset('images/social/tw.png') }}"> </a></li>
                <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://www.instagram.com/accentlanguage/"> <img src="{{ asset('images/social/instagram.png') }}"> </a></li>
                <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://www.youtube.com/channel/UC9Kdbunq1hGpq5nGK6YqbQg?view_as=subscriber"> <img src="{{ asset('images/social/youtube.jpg') }}"> </a></li>
            </ul>
        </div>
    </div>
</div>
<p class="footer-text" style=" font-size: 14px;  color: #9b9b9b; font-weight: 400; text-align: center;"> @2019 Lokalingo </p>
</body>
</html>
