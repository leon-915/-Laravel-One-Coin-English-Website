@extends('emails.layout')
@section('title')
    <title> Welcome to {{ env('APP_NAME') }} </title>
@endsection
@section('content')
    <?php
        $user       = $data['user'];
    ?>
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Welcome to {{ env('APP_NAME') }} </h1>
    <div class="course" style="    padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi {{ $user->firstname . ' ' . $user->lastname}}, </b></h3>
        <p> Your account has been created successfully.</p>
        <p> Please use your email and password to login.</p>
        <p> Email : {{ $user->email }} </p>
        <p> Password : {{ $user->password }} </p>
    </div>
    <p><a href="{{ url('/login') }}">Click Here To Login</a></p>
@endsection

