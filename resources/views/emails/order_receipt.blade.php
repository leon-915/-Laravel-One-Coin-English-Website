@extends('emails.layout')
@section('title')
		<title> Your Order </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Your Order  :-) </h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr style=" font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Product Name</b></td>
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['order']['product']['name'] }}</td>
						</tr>
						<?php /*if($data['package']['packages']['title'] == 'Apprentice') { ?>
						<tr style="border-top: 1px solid #dee2e6; font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px "> <b>Total Reports</b> </td>
								<td style="border-top: 1px solid #dee2e6; padding: 5px "> Evalution report </td>
						</tr>
						<?php } else {?>
					 <tr style="border-top: 1px solid #dee2e6; font-size: 14px; color: #353535;">
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> <b>Total Reports</b> </td>
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> <?= !empty($data['package']['no_of_reports']) ? count(explode(',',$data['package']['no_of_reports'])) : 0 ?> analytical reports </td>
					 </tr>
					 <?php } ?>
					 <tr style="border-top: 1px solid #dee2e6; font-size: 14px; color: #353535;">
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> <b>Total Courses</b> </td>
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> {{ $data['package']['no_of_courses'] }} </td>
					 </tr>
					 <tr style="border-top: 1px solid #dee2e6; font-size: 14px; color: #353535;">
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> <b>Total Learners</b> </td>
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> {{ $data['package']['no_of_learners'] }} </td>
					 </tr>
					 <tr style="border-top: 1px solid #dee2e6; font-size: 14px; color: #353535;">
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> <b>Expired Date</b> </td>
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> {{ $data['package']['expired_at'] }} </td>
					 </tr>
					 <tr style="border-top: 1px solid #dee2e6; font-size: 14px; color: #353535;">
						<td style="border-top: 1px solid #dee2e6; padding: 5px "> <b>Total Charges</b> </td>
						<td style="border-top: 1px solid #dee2e6; padding: 5px "> {{ $data['package']['packages']['price'] * 12 }} for 12 months </td>
						</tr>
					 <tr style="border-top: 1px solid #dee2e6; font-size: 14px; color: #353535; background: #6a7c8d; color: #fff;">
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> <b>Price</b> </td>
							 <td style="border-top: 1px solid #dee2e6; padding: 5px "> {{ $data['package']['packages']['price'] }} per month</td>
					 </tr> */ ?>
					 </tbody>
			 </table>
		</div>

@endsection
