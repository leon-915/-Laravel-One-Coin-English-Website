@extends('emails.layout')
@section('title')
		<title> Reminder to book next appointment. </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Reminder to book next appointment. </h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr style=" font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> 
									<?php
																			
										$message = ''.$data['student_name'].' 様<br><br>';
										$message .='いつも大変お世話になっております。<br>';
										$message .= $data['last_booked'].' におとりいただいた前回のレッスンから'.$data['days_diff'].'日経っています。現レッスンの期限は'.date('Y-m-d', $data['expiry_date']).'までとなっており、'.$data['lesson_remaining'].'回のレッスンが残っています。<br><br>';
										$message .='レッスンは<br>';
										$message .='<a href="'.route('student.reservation.index').'</a><br>';
										$message .='からご予約いただけます。<br><br>';
										$message .='システムのご利用方法は　<a href="http://goo.gl/iFgAEP">http://goo.gl/iFgAEP</a>　をご参照ください。"<br>';
										$message .='このメールと入れ違いにご予約を頂いていましたらお手数をおかけいたしますがこちらは破棄くださいますようお願いいたします。<br />';
										$message .='レッスンでお会いできるのを楽しみにしております。<br /><br />';
										$message .= 'このメールはシステムによる自動送信です。ご返信頂けませんのでご注意下さい。<br>';
										echo $message .= '<br>--<br>'.env('APP_NAME').'<br>';
									?>
								</td>
                        </tr>
                       
					 </tbody>
			 </table>
		</div>

@endsection
