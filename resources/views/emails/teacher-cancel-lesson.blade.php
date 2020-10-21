@extends('emails.layout2')
@section('title')
    {{-- <title> Lesson Cancellation</title> --}}
@endsection

@section('content')
    <!--div class="course" style="padding-bottom: 25px;">
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b> Hi, {{$data['receiver']['firstname']}} {{$data['receiver']['lastname']}}</b></h3>
        <h3 style="color: #484848; font-size: 18px; margin-bottom: 0; font-weight: 700;"><b>Your booking is cancelled</b></h3>

        <div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr style=" font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson</b></td>
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> {{$data['booking']['service']['title']}}</td>
                        </tr>
                        <tr style=" font-size: 14px; color: #353535;">
                            <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Student Name</b></td>
                            <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ucfirst($data['booking']['student']['firstname'])}}  {{ucfirst($data['booking']['student']['lastname'])}}</td>
                         </tr>
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Date</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{$data['booking']['lession_date']}}</td>
                         </tr>
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Time</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{$data['booking']['lession_time']}} </td>
                         </tr>
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Location</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{$data['booking']['location']['title']}} </td>
                         </tr>

					 </tbody>
			 </table>
		</div>
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
													<h1 style="margin:0;font-size:18px;color:#496617">Appointment Cancellation</h1>
												</td>
											</tr>
											<tr>
												<td style="padding:17px 20px;font-size:15px;line-height:18px">
													<p style="margin:0 0 17px 0"><span style="line-height:18px;color:#404040;font-family:Helvetica,Arial,sans-serif">The following appointment has been cancelled:</span></p>
													<p style="margin:0 0 0 0;font-weight:bold"><?php echo $data['booking']['service']['title'];?> with <?php echo $data['user']['firstname'].' '.$data['user']['lastname'];?></p>
													<p style="margin:0 0 17px 0;font-weight:bold"><?php echo date('m', strtotime($data['booking']['lession_date']));?>月 <?php echo date('d', strtotime($data['booking']['lession_date']));?>, <?php echo date('Y', strtotime($data['booking']['lession_date']));?> <?php echo $data['booking']['lession_time'];?></p>
													<p style="margin:0 0 17px 0">at this location
														<span style="margin:0 0 0 0;font-weight:bold">
															<?php echo $data['booking']['location']['title'];?>
														</span>
													</p>
													<p style="margin:0 0 17px 0">with
														<span style="margin:0 0 0 0;font-weight:bold">
															<?php echo $data['booking']['student']['firstname'].' '.$data['booking']['student']['lastname'];?>
														</span>															
													</p>
													<p style="margin:0 0 17px 0;font-weight:bold"></p>
													<p style="margin:0 0 17px 0">{{ env('APP_NAME') }}</p>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<!--tr>
								<td>
									<p style="margin:12px 0 0 22px;font-size:13px;color:#f1fadd">Sent by <a style="font-weight:bold;color:#f1fadd;text-decoration:none" href="<?php echo $data['site_url'];?>" target="_blank">Accent</a></p>
								</td>
							</tr-->
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
   
@endsection
