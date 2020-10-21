@extends('emails.layout')
@section('title')
    <title>{{ env('APP_NAME') }}</title>
@endsection

@section('content')
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Completed phase 2</h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"> Hello {{$data['user']['firstname']}} {{$data['user']['lastname']}}, </h3>
        <p> You have successfully completed phase 2 of 2 of the recruitment stage.</p>
        <p> We will be in touch with you shortly.</p>
        <p> Thank you.</p>
    </div>
@endsection
