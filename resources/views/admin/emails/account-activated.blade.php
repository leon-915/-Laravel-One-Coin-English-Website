@extends('emails.layout')
@section('title')
    <title> Account Activation | Lokalingo </title>
@endsection
@section('content')
    <?php
        $user = $data['user'];
    ?>
    <h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Account Activation </h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi {{ $user->firstname .' '. $user->lastname }}, </b></h3>
        <p> Your account has been activated successfully.</p>
        <p> Please login with your credential!</p>
        <p> Email : {{ $user->email }} </p>

        <p><a href="{{ env('APP_URL') }}">Click Here To Login</a></p>
    </div>

@endsection
