@extends('emails.layout')
@section('title')
		<title> Package Expiry notification </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Package Expiry notification </h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr style=" font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> 
									<?php
										$message = ''.$data['student_name'].' 様<br><br>';
										$message .='いつも大変お世話になっております。<br>';
										$message .='おとりいただいているレッスンコースの期限'.$data['end_date'].' まであと７日になりました。<br>';
										$message .='レッスンのお繰り越しをご希望の方はレッスン繰越制度にそって繰り越ししていただくことができます。繰越制度の詳細はこちら でご確認いただけます。<br><br>';
										$message .= 'このメールはシステムによる自動送信です。ご返信頂けませんのでご注意下さい。<br>';
										$message .='同じレッスンコースをご購入される方は、こちらから<br><br>';
										echo $message .= '--<br>'.env('APP_NAME').'<br>';
									?>
								</td>
                        </tr>
                       
					 </tbody>
			 </table>
		</div>

@endsection
