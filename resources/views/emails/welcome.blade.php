@extends('emails.layout')
@section('title')
    <title> Welcome to {{ env('APP_NAME') }} </title>
@endsection

@section('content')
    <?php
        $user       = $data['user'];
        $password   = $data['password'];
    ?>
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Welcome to {{ env('APP_NAME') }} </h1>
    <div class="course" style="    padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi Teacher, </b></h3>
        <p> Your account has been created successfully.</p>
        <p> Please login with below credentials.</p>
        <p style="font-size: 14px; color: #9b9b9b; font-weight: 400;  margin: 0;  padding: 0 34px;  line-height: 20px;"> Email : {{ $user->email }} </p>
        <p style="font-size: 14px; color: #9b9b9b; font-weight: 400;  margin: 0;  padding: 0 34px;  line-height: 20px;"> Password : {{ $password }} </p>
    </div>
    <p><a href="{{ url('teacher/login') }}">Click Here To Login</a></p>
@endsection
