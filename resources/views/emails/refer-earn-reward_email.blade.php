@extends('emails.layout')
@section('title')
    <title> You Are Invited By {{$data['user']['firstname']}} {{$data['user']['lastname']}} </title>
@endsection

@section('content')
    <?php
        $user = $data['user'];
    ?>
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Welcome to Lokalingo </h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi, </b></h3>

        <p> Please Enter This Referral Code While Register.</p>
        <p style="font-size: 14px; color: #9b9b9b; font-weight: 400;  margin: 0;  padding: 0 34px;  line-height: 20px;"> refferal code : {{$data['user']['referral_code']}} </p>
    </div>
    <p>
        <a href="{{url('student/register')}}">Click Here To Register With Referral Code</a>
    </p>
@endsection
