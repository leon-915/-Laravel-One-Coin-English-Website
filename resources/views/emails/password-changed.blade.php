@extends('emails.layout')
@section('title')
	<title> Password Changed </title>
@endsection
@section('content')
	<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Your password has been changed. </h1>
	<p style="font-size: 14px; color: #9b9b9b; font-weight: 400; margin: 0; padding: 0; line-height: 20px;
    text-align: left;"> This is a confirmation that your password has been changed. </p>
	<br>
	<p style="font-size: 14px; color: #9b9b9b; font-weight: 400; margin: 0; padding: 0; line-height: 20px;
    text-align: left;"> Didn’t change your password? Contact <a href="{{ url('/support') }}" class="blue" style="cursor: pointer;"> Lokalingo Support </a> so we can take immediate action to investigate.</p>
@endsection
