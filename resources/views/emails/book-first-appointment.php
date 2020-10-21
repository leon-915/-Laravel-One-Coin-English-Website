@extends('emails.layout')
@section('title')
		<title> Reminder to book first appointment </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Reminder to book first appointment </h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr style=" font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> 
									<?php
										$message = 'Hello '.$data['student_name'].',<br /><br />';
										$message .= 'You have not booked any appointment of '.$data['packages_name'].' since you purchased it.<br />';
										$message .= 'You can fix an appointment from <a href="'.route('students.reservation.index').'">Reservation</a> link on website at <a href="'.$data['site_url'].'">'.$data['site_url'].'</a>.<br /><br />';
										$message .= '--<br />';
										$message .= 'Team '.env('APP_NAME').'<br /><a href="'.env('APP_NAME').'">'.env('APP_NAME').'</a>';
									?>
								</td>
                        </tr>
                       
					 </tbody>
			 </table>
		</div>

@endsection
