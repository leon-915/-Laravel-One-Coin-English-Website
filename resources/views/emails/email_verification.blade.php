@extends('emails.layout')

@section('title')
	<title> Email Verification </title>
@endsection

@section('content')
<h1 style="font-size: 25px; color: #212529; font-weight: 500;  margin: 0; padding: 20px 0;"> Verify your email address </h1>

<p style="font-size: 14px; color: #9b9b9b; font-weight: 400; margin: 0; padding: 0px 50px; line-height: 20px;"> Please confirm that you would like to use this email address as your Lokalingo's access account .
	Welcome to Lokalingo!
 </p>


<a href="<?= env('APP_URL') . '/verify-email/' . $data['user']['verify_token'] ?>" style="cursor: pointer;">
	<button style="background: #1551a5; cursor: pointer; border: 0; height: 50px; font-size: 16px; color: #fff; font-weight: 600; border-radius: 50px; margin: 38px 0; letter-spacing: 0.5px; padding: 0 55px;  outline: none;">
		Verify Email
	</button>
</a>

<div class="brower_link" style="padding-bottom: 35px;">
	<p style="font-size: 14px; color: #9b9b9b; font-weight: 400; margin: 0; padding: 0px 50px;">Or paste this link into your browser:  </p>
	<a href="<?= env('APP_URL') . '/verify-email/' . $data['user']['verify_token'] ?>" style="text-decoration: none; color: #0137ff; font-weight: 500;"> <?= env('APP_URL').'/verify-email/' . $data['user']['verify_token'] ?> </a>
	<?php /*
	<a href="{{url('/verify-email', $data['user']['verify_token'])}}" style="text-decoration: none; color: #0137ff; font-weight: 500;"> {{url('/verify-email', $data['user']['verify_token'])}} </a> */ ?>
</div>
@endsection


