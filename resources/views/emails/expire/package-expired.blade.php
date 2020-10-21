@extends('emails.layout')
@section('title')
    <title>Package Expired</title>
@endsection

@section('content')
    <h1 style="font-size: 25px;  color: #212529;  font-weight: 500;  margin: 0;  padding: 20px 0;">Subscription Expired</h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;">
            Hi {{$package->student->firstname}} {{$package->student->lastname}},
        </h3>
        <p>
            Your <b>{{$package->package->title}}</b> membership is expired on <b>{{ date('F d,Y',strtotime($package->end_date))}}.</b>
        </p>
        <p>
            We sincerely hope that you will join us for another outstanding package of great programs and professional training.
        </p>
    </div>
@endsection


