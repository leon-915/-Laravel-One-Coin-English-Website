@extends('emails.layout')
@section('title')
		<title>Lesson rollover detail </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;">Lesson rollover detail</h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr>
							<td>
								<?php
								$message = 'Hello Admin<br><br>';
								$message .= 'For '.$data['student_name'].' ('.$data['student_email'].') '.$data['no_of_rolledover_lessons'].' lessons have been rolledover from previous order no. '.$data['previous_order_no'].'.<br>';
								$message .= 'Order id: '.$data['new_order_no'].'<br>';
								$message .= 'Product id: '.$data['service_id'].'<br><br>';
								$message .= '--<br>';
								echo$message .= $data['site_title'].'<br>';
								?>
							</td>
						</tr>

					 </tbody>
			 </table>
		</div>

@endsection
