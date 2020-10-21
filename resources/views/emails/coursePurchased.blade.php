@extends('emails.layout')
@section('title')
		<title> Order on {{ $data['site_name'] }} </title>
@endsection
@section('content')

		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						@if($data['payment_method'] == 'PayPal')
							<tr style="">
									<td colspan="2" style="">{{ __('labels.your_order_is_complete') }}</td>
							</tr>
							<tr style="">
									<td colspan="2" style="">{{ __('labels.order_details_are_as_follows_paypal') }}</td>
							</tr>
						@elseif($data['payment_method'] == 'Cash' && $data['status'] == 0)
							<tr style="">
								<td colspan="2" style="">{{ __('labels.thank_you_for_your_order') }}</td>
							</tr>
							<tr style="">
									<td colspan="2" style="">{{ __('labels.order_details_are_as_follows_bank_transfer') }}</td>
							</tr>
						@else
							<tr style="">
								<td colspan="2" style="">{{ __('labels.thank_you_for_your_order') }}</td>
							</tr>
							<tr style="">
									<td colspan="2" style="">{{ __('labels.order_details_are_as_follows_bank_transfer') }}</td>
							</tr>
						@endif
						<tr style="">
								<td colspan="2" style="">{{ __('labels.order_number') }}: #{{ $data['order_number'] }}</td>
                        </tr>
				<table>
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">		
						<tr style="">
								<th style="">{{ __('labels.dash_cource') }}</th>
								<th style="">{{ __('labels.qty') }}</th>
								<th style="">{{ __('labels.fee') }}</th>
                        </tr>
						@if(!empty($data['courses']))
							@foreach($data['courses'] as $course)
								<tr style="">
									<td style="">{{ $course['title'] }}</td>
									<td style="">1</td>
									<td style="">{{ $course['price'] }}</td>
								</tr>
							@endforeach
						@endif
                        <tr style="">
                                <td colspan="3"></td>
                        </tr>
				</table>		 
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">		 
                         <tr style="">
                                <td style=""> <b>{{ __('labels.stu_cart_subtotal') }}</b></td>
                                <td style=""> {{ $data['orderTotal'] }}</td>
                         </tr> 
                         <tr style="">
                                <td style=""> <b>{{ __('labels.order_tax') }}</b></td>
                                <td style=""> {{ $data['taxAmt'] }}</td>
                         </tr> 
                         <tr style="">
                                <td style=""> <b>{{ __('labels.payment_method') }}</b></td>
                                <td style="">{{ $data['payment_method'] }}</td>
                         </tr>
                         <tr style="">
                                <td style=""> <b>{{ __('labels.stu_order_total') }}</b></td>
                                <td style=""> {{ $data['orderTotal'] + $data['taxAmt'] }}</td>
                         </tr>
				</table>
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						
						<tr style="">
								<td colspan="2" style="">{{ __('labels.customer_details') }}</td>
                        </tr>
						<tr style="">
								<td colspan="2" style="">{{ __('labels.email') }}: {{ $data['customer_email'] }}</td>
                        </tr>
				<table>
		</div>

@endsection
