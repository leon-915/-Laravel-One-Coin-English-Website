@extends('emails.layout')
@section('title')
    <title> {{ $data['user']['name'] }} Want us to contact you </title>
@endsection

@section('content')
    <?php
        $user = $data['user'];
    ?>

    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi Admin, </b></h3>

        <p> {{$data['user']['name']}} has submmited his detail on {{$data['site_title']}} and wants us to contact him</p>

        <table style="width:100%;padding-left: 100px;">
            <tbody style="width: 100%;display: inline-block;margin: 0 auto;">
            <tr>
                <th style="width:22%;vertical-align: top;text-align: right;">User Name :</th>
                <td style="width:76%;padding-bottom: 5px;text-align: left;padding-left: 20px;">{{$data['user']['name']}}</td>
            </tr>
            <tr>
                <th style="width:22%;vertical-align: top;text-align: right;">User Email :</th>
                <td style="width:76%;padding-bottom: 5px;text-align: left;padding-left: 20px;">{{$data['user']['email']}}</td>
            </tr>
            <tr>
                <th style="width:22%;vertical-align: top;text-align: right;">Subject :</th>
                <td style="width:76%;padding-bottom: 5px;text-align: left;padding-left: 20px;">{{$data['user']['subject']}}</td>
            </tr>

            <tr>
                <th style="width:22%; vertical-align: top;text-align: right;">Message :</th>
                <td style="width:76%;padding-bottom: 5px;text-align: left;padding-left: 20px;">{{$data['user']['message']}}</td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
