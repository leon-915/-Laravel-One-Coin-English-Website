@extends('emails.layout')
@section('title')
    <title> Feedback Reply | Lokalingo </title>
@endsection
@section('content')
    <?php
        $user       = $data['user'];
        $feeback = $data['feedback'];
        $reply = $data['reply'];
    ?>
    <h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Feedback Reply </h1>
    <div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi {{ $user->firstname .' '. $user->lastname}}, </b></h3>
        <table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
            <tbody>

            @if(!empty($feeback['reason']))
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Reason </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ !empty($feeback['reason'])? $feeback['reason'] : '' }}</td>
                </tr>
            @endif

            @if(!empty($feeback['message']))
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Message </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ !empty($feeback['message'])? $feeback['message'] : '' }}</td>
                </tr>
            @endif

            @if(!empty($reply['comment']))
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Comment </b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {!!  !empty($reply['comment'])? $reply['comment'] : '' !!}</td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>

@endsection

