@extends('layouts.app',['title'=> __('labels.stu_order')])
@section('title', __('labels.stu_order'))
@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="order_details_sec">
							@if($order->payment_status == 'pending' && $order->provider == 'direct_bank_transfer')
								<div class="row">
									<div class="col-md-12">
										<div class="plan_header">
											<h2>{{  __('labels.thankyou_order_received') }}</h2>
										</div>
									</div>
								</div>
							@endif
                            <div class="row">
                                <div class="col-12 col-lg-6 cpl-md-12">
                                    <div class="plan_header">
                                        <h2>{{ __('labels.stu_order_detail')}}</h2>
										<table class="table">
											<tr>
												<td>{{  __('labels.order') }}</td>
												<td>{{  __('labels.date') }}</td>
												<td>{{  __('labels.total') }}</td>
												<td>{{  __('labels.payment_method') }}</td>
											</tr>
											<tr>
												<td>#{{ $order->id }}</td>
												<td>{{\Carbon\Carbon::parse($order->created_at)->format('M d,Y')}}</td>
												<td>¥{{number_format($order->amount)}}</td>
												<td>
													@if ($order->provider == 'paypal')
														{{ __('labels.paypal') }}
													@elseif($order->provider == 'stripe')
														{{ __('labels.stripe') }}
													@else
														{{ __('labels.direct_bank_transfer') }}
													@endif
												</td>
											</tr>
										</table>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
							@if($order->payment_status == 'pending' && $order->provider == 'direct_bank_transfer')
								<div class="row">
									<div class="col-md-12">
										<div class="plan_header">
											<h5>{{  __('labels.make_payment_in_our_acoount') }}</h5>
										</div>
									</div>
								</div>
							@endif
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="table-responsive view_order_list clearfix">
                                        <table class="table" id="orderdetail_table">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('labels.dash_product')}}</th>
                                                <th scope="col">{{__('labels.dash_total')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <p>{{$product}}</p>
                                                </td>
                                                <td>
                                                    ¥{{number_format($order->subtotal)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>{{ __('labels.stu_cart_sub_total')}}:</strong>
                                                </td>
                                                <td>
                                                    ¥{{number_format($order->subtotal)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>{{ __('labels.stu_discount')}}:</strong>
                                                </td>
                                                <td>
                                                    <?php
													if($order->discount_type == 1) {
														echo '¥'.number_format($order->discount);
													} else {
														echo '¥'.(($order->subtotal * $order->discount) / 100);
														echo ' ('.number_format($order->discount).'%)';
													}
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>{{ __('labels.stu_tax')}}  ({{ \App\Models\Settings::getSettings('tax') .'%' }}) :</strong>
                                                </td>
                                                <td>
                                                    ¥{{number_format($order->tax)}}
                                                </td>
                                            </tr>

                                            {{-- <tr>
                                                <td>
                                                    <strong>{{ __('labels.onepage_certified_fee')}}:</strong>
                                                </td>
                                                <td>
                                                    ¥{{number_format($order->one_page_fee)}}
                                                </td>
                                            </tr> --}}

                                            <tr>
                                                <td>
                                                    <strong>{{ __('labels.stu_order_total')}}:</strong>
                                                </td>
                                                <td>
                                                    ¥{{number_format($order->amount)}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <p>{{ __('labels.stu_customer_detail')}}</p>

                                    <span>{{ __('labels.stu_email')}}: {{$order->user->email}}</span>

                                    {{--<p>{{__('labels.stu_billing_address')}}</p>--}}

                                    {{--<span>N/A</span>--}}

                                    <div class="text-right mt-3">
                                        <a href ="/student/dashboard?ref=order" class="btn_custon">{{__('labels.btn_back')}}</a>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
