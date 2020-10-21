@extends('emails.layout')
@section('title')
		<title> Lesson Reminder </title>
@endsection
@section('content')
	 <table>
		<tbody>
			<tr>
				<td style="background:#89b556;border:2px solid #6f9a3e;padding:15px 15px 12px 15px;font-family:Helvetica,Arial,Sans-Serif">
					<table cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td style="background:#fff;border:2px solid #6f9a3e;color:#404040" width="400">
									<table style="border-collapse:collapse;width:100%">
										<tbody>
											<tr>
												<td style="background:#ecfacd;border-bottom:1px solid #bcd98b;padding:24px 20px 19px 20px">
													<h1 style="margin:0;font-size:18px;color:#496617">
														<span class="il">Appointment Reminder</span>
													</h1>
												</td>
											</tr>
											<tr>
												<td style="padding:17px 20px;font-size:15px;line-height:18px">
													<p style="margin:0 0 17px 0"><?php echo $data['student_name'];?>様</p>
													<p style="margin:0 0 17px 0">お世話になっております。</p>
													<p style="margin:0 0 17px 0;font-weight:bold"><?php echo date('M d, Y', strtotime($data['lesson_date']));?><?php echo $data['lesson_time'];?></p>
													<p style="margin:0 0 0 0;font-weight:bold"><?php echo $data['service_name'];?> 担当講師 <?php echo $data['teacher_name'];?></p>
													<p style="margin:0 0 17px 0">でご予約をいただいております。</p>
													<p style="margin:0 0 17px 0">ご不明点がございましたらお気軽にご連絡ください。</p>
													<p style="margin:0 0 17px 0"><?php echo env('APP_NAME');?></p>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<p style="margin:12px 0 0 22px;font-size:13px;color:#f1fadd">Sent by <a style="font-weight:bold;color:#f1fadd;text-decoration:none" href="<?php echo $data['site_url'];?>" target="_blank"><?php echo env('APP_NAME');?></a></p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
			 
@endsection
