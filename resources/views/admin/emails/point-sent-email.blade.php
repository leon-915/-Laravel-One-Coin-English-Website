@extends('emails.layout')
@section('title')
    <title> Reward Points Sent By {{ env('APP_NAME') }} </title>
@endsection

@section('content')
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Welcome to {{ env('APP_NAME') }} </h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi, {{$data['receiver']['firstname']}} {{$data['receiver']['lastname']}}</b></h3>

        <p> Point Rewarded To Your Account.</p>
        <p style="font-size: 14px; color: #9b9b9b; font-weight: 400;  margin: 0;  padding: 0 34px;  line-height: 20px;"> Reward Point : {{$data['amount']}} </p>
    </div>
   
@endsection
