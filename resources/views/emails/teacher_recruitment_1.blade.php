@extends('emails.layout')
@section('title')
    <title> Welcome to {{ env('APP_NAME') }} </title>
@endsection

@section('content')
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Welcome to {{ env('APP_NAME') }} </h1>
    <div class="course" style="    padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;">
            <b> Hi {{ $data['user']['firstname']}}  {{ $data['user']['lastname']}}, </b>
        </h3>
        <p> Congratulations!</p>
        <p> You have been approved and may now proceed to the phase 2 of the recruitment stage!</p>
        <p> Please click the link below or copy and paste it in your browser to proceed to phase 2 of the recruitment process.</p>
    </div>
    <p><a style="background: #1551a5; cursor: pointer; border: 0; width: 100%; height: 50px; font-size: 16px; color: #fff; font-weight: 600; border-radius: 50px; margin: 38px 0; letter-spacing: 0.5px;  outline: none;padding : 5px;" href="{{ url('/teacher/register/step-2/' . $data['user']['step2_verification_token']) }}">Click Here</a></p>

    <p>OR</p>
    <p>Use this Link</p>
    <p>
        <a href="{{ url('/teacher/register/step-2/' . $data['user']['step2_verification_token']) }}">
            {{ url('/teacher/register/step-2/' . $data['user']['step2_verification_token']) }}
        </a>
    </p>
@endsection
