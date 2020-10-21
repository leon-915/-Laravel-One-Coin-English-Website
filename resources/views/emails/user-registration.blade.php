@extends('emails.layout')
@section('title')
    <title> New Registration | Lokalingo </title>
@endsection
@section('content')
    <?php
    $user       = $data['user'];
    $retailer       = $data['retailer'];
    ?>
    <h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> New Registration </h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi, Admin, </b></h3>
        <p> New User has been registered successfully.</p>

        <table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
            <tbody>
            <tr style=" font-size: 14px; color: #353535;">
                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Email</b></td>
                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $retailer->email }}</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection
