@extends('emails.layout2')
@section('title')
		<title> Lesson Booking </title>
@endsection
@section('content')
		<!--h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Lesson Booking Detail</h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
                        <tr style=" font-size: 14px; color: #353535;">
                            <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Teacher Name</b></td>
                            <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['teacher']['firstname']." ". $data['teacher']['lastname'] }}</td>
                         </tr>
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Date</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['date'] }}</td>
                         </tr>
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Time</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['time'] }}</td>
                         </tr> 
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson </b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['lesson'] }}</td>
                         </tr> 
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Location</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['location'] }}</td>
                         </tr>

					 </tbody>
			 </table>
		

        <p><a style="background: #1551a5; cursor: pointer; border: 0; width: 100%; height: 50px; font-size: 16px; color: #fff; font-weight: 600; border-radius: 50px; margin: 38px 0; letter-spacing: 0.5px;  outline: none;padding : 5px;" href="{{ url('/student/dashboard') }}">Click Here To Cancel Booking</a></p>

        <p><a style="background: #1551a5; cursor: pointer; border: 0; width: 100%; height: 50px; font-size: 16px; color: #fff; font-weight: 600; border-radius: 50px; margin: 38px 0; letter-spacing: 0.5px;  outline: none;padding : 5px;" href="{{ url('/student/current-course/booking-detail/' . $data['booking_id']) }}">Click Here To Reschedule Booking</a></p>
    </div-->
	
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
												<h1 style="margin:0;font-size:18px;color:#496617"><?php echo $data['title'];?></h1>
											</td>
										</tr>
										<tr>
											<td style="padding:17px 20px;font-size:15px;line-height:18px">
												<p style="margin:0 0 17px 0">{{ $data['student']['firstname']." ". $data['student']['lastname'] }}様</p>
												<p style="margin:0 0 17px 0">お世話になっております。 次回のご予約を下記の通りおとりいたしました。</p>
												<p style="margin:0 0 17px 0;font-weight:bold"><?php echo date('m', strtotime($data['date']));?>月 <?php echo date('d', strtotime($data['date']));?>, <?php echo date('Y', strtotime($data['date']));?> <?php echo $data['time'];?></p>
												<p style="margin:0 0 17px 0;font-weight:bold"><?php echo $data['lesson'];?> 担当講師 {{ $data['teacher']['firstname']." ". $data['teacher']['lastname'] }}</p>
												<p style="margin:0 0 17px 0;font-weight:bold">場所{{ $data['location'] }}</p>
												<p style="margin:0 0 17px 0">
													<a href="{{ url('/student/dashboard') }}" target="_blank">キャンセルする場合はこちらから</a>
												</p>
												<p style="margin:0 0 17px 0">
													<a href="{{ url('/student/current-course/booking-detail/' . $data['booking_id']) }}" target="_blank">スケジュールを変更する場合はこちらから</a>
												</p>
												<p style="margin:0 0 17px 0">キャンセル、<wbr>スケジュール変更はご予約の24時間前までにご連絡ください。</p>
												<p style="margin:0 0 17px 0">{{ env('APP_NAME') }}</p>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<!--tr>
							<td>
								<p style="margin:12px 0 0 22px;font-size:13px;color:#f1fadd">Sent by <a style="font-weight:bold;color:#f1fadd;text-decoration:none" href="{{ $data['site_url'] }}" target="_blank">Accent</a>
							</p>
							</td>
						</tr-->
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

@endsection
