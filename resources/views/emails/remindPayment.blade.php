@extends('emails.layout')
@section('title')
    <title> Payment Remind </title>
@endsection

@section('content')
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">New Custom Message</h1>
    <div class="course" style="    padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"> Hi {{$reminder['user']['first_name']}}, </h3>
        <p style="font-size: 14px; color: #9b9b9b; font-weight: 400;  margin: 0;  padding: 0 34px;  line-height: 20px;"> Expiry Date: {{$reminder['expiry_date']}}, </p>
    </div>
@endsection


