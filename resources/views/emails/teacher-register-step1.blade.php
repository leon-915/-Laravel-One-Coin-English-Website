@extends('emails.layout')
@section('title')
    <title>{{ env('APP_NAME') }}</title>
@endsection

@section('content')
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Completed phase 1</h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"> Hello {{ $data['user']['firstname'] }} {{$data['user']['lastname']}}, </h3>
        <p> You have successfully completed phase 1 of 2 of the recruitment stage.</p>
        <p> Thank you for applying for the English language teaching position at {{ env('APP_NAME') }}</p>
        <p>  We have received many applications and will be short-listing for qualified candidates. If you have not heard from Accent for over a week, please feel free to enquire about the status of your application. Contact details are on our website.</p>
    </div>
@endsection

