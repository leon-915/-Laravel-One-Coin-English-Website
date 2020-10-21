<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
</head>

<body class="bg" style="background: #f8f4f2; font-family: 'Roboto', sans-serif;font-size: 14px;	margin: 0;">
    <div class="email_ver" style="background: #fff; max-width: 540px; margin: 40px auto 25px; text-align: center; padding: 20px; border-radius: 5px; box-shadow: 0px 10px 28px 0px rgba(0, 0, 0, 0.1);">
        <div class="your_email">
            <img src="{{ asset('images/logo.png') }}" style="padding-bottom: 50px;padding-top: 50px;">

            @yield('content')

            <div class="social_icon">
                <ul style="margin: 0; padding: 0; margin-bottom: 15px;  margin-top: 40px;">
                    <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://www.facebook.com/"> <img src="{{ asset('images/social/fb.png') }}"> </a></li>
                    <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://twitter.com/"> <img src="{{ asset('images/social/tw.png') }}"> </a></li>
                    <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://plus.google.com/"> <img src="{{ asset('images/social/google.png') }}"> </a></li>
                    <li style="display: inline-block; list-style: none; padding: 0 7px; cursor: pointer;"> <a href="https://in.linkedin.com/"> <img src="{{ asset('images/social/linkdin.png') }}"> </a></li>
                </ul>
            </div>
        </div>
    </div>
    <p class="footer-text" style=" font-size: 14px;  color: #9b9b9b; font-weight: 400; text-align: center;">Best regards,</p>
    <p class="footer-text" style=" font-size: 14px;  color: #9b9b9b; font-weight: 400; text-align: center;">The team at Accent</p>
    <p class="footer-text" style=" font-size: 14px;  color: #9b9b9b; font-weight: 400; text-align: center;">https://accent-language.com</p>
</body>
</html>
