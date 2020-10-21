@extends('emails.layout')
@section('title')
		<title> Onbreak Expiry notification </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Onbreak Expiry notification </h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr style=" font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> 
									<?php
										$message = 'Hello '.$data['student_name'].'<br><br>';
										$message .= 'This is a general reminder for your Onbreak renewal which is due in next '.$data['package_expire_reminder_days'].' day(s) on '.env('APP_NAME').'<br>';
										$message .= 'Please purchase it again <a href="'.route('students.account.onbreak').'">here</a> if you want to continue OnBreak plan. Or contact admin to reactivate your subscription<br>';
										echo $message .= '--<br>'.env('APP_NAME').'<br>';
									?>
								</td>
                        </tr>
                       
					 </tbody>
			 </table>
		</div>

@endsection
