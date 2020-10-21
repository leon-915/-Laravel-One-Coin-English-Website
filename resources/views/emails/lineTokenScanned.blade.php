@extends('emails.layout')
@section('title')
		<title>Line Token Scanned</title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;">Line Token Scanned</h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr>
							<td>
								<?php
								$message = 'Hello Admin<br><br>';
								$message .= $data['user_name'].' has entered line token.<br>';
								$message .= '--<br>';
								echo $message .= $data['site_title'].'<br>';
								?>
							</td>
						</tr>

					 </tbody>
			 </table>
		</div>

@endsection
