
@extends('layouts.app',['title'=>'Pricing'])
@section('title', 'Pricing')
@section('content')

<div class="row">
	<div class="col-12">
		@include('cms.big_image_section')
	</div>
</div>
<div class="row">
	<div class="col-12">
		@include('cms.staticpage_header_section')
	</div>
</div>
<?php
if(Lang::locale() == 'en')
{
?> 
	
	<!--div class="aboutus_detail_box"-->
	<div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Course Fees</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p>											
											<table class="coaching_desc_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Description</th>
														<th>Price ( ¥ )</th>
													</tr>
													<tr>
														<td class="desc-text">Registration ( One-Off )</td>
														<td>29,900</td>
													</tr>
													<tr>
														<td class="desc-text">OnePage System( Annual Fee )</td>
														<td>5,900</td>
													</tr>
													<tr>
														<td class="desc-text">Initial Total</td>
														<td>35,800</td>
													</tr>
												</tbody>
											</table>
										</p>
									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Aspire Coaching</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">										
										<div class="tbl-layout table-pricing" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Per Person</th>
														<th>Price ( ¥ )</th>
													</tr>
													<tr>
														<td>60 minutes</td>
														<td>20,000</td>
													</tr>
													<tr>
														<td>90 minutes</td>
														<td>30,000</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout table-pricing" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Course</th>
														<th>Sessions</th>
														<th>Time (Min.)</th>
														<th>Term (Days)</th>
														<th>Price (¥)</th>
													</tr>
													<tr>
														<td>Once a Week</td>
														<td>1</td>
														<td>60</td>
														<td>7</td>
														<td>20,000</td>
													</tr>
													<tr>
														<td>Once a Week</td>
														<td>1</td>
														<td>90</td>
														<td>7</td>
														<td>30,000</td>
													</tr>
													<tr>
														<td>Once a Week • 3 months</td>
														<td>12</td>
														<td>60</td>
														<td>90</td>
														<td>216,000</td>
													</tr>
													<tr>
														<td>Once a Week • 3 months</td>
														<td>12</td>
														<td>90</td>
														<td>90</td>
														<td>306,000</td>
													</tr>
													<tr>
														<td>Twice a Week • 3 months</td>
														<td>24</td>
														<td>60</td>
														<td>90</td>
														<td>432,000</td>
													</tr>
													<tr>
														<td>Twice a Week • 3 months</td>
														<td>24</td>
														<td>90</td>
														<td>90</td>
														<td>612,000</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout table-pricing">
											<table class="coaching_pricing_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Group</th>
														<th>2 Clients</th>
														<th>3 Clients</th>
														<th>4 Clients</th>
													</tr>
													<tr>
														<td>60 minutes / Client</td>
														<td>15,000</td>
														<td>13,333</td>
														<td>12,500</td>
													</tr>
													<tr class="more-btn-table">
														<td colspan="4">
															<div class="row try-now-btn">
																<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s">
																	<a href="{{ route('students.aspire.product.index') }}">Try Now</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Casual Conversation</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">										
										<div class="tbl-layout" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table grey_th" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th class="cas-conv">Per Person</th>
														<th class="cas-conv">Price ( ¥ )</th>
													</tr>
													<tr>
														<td>50 Minutes</td>
														<td>6,000</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table grey_th" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Course</th>
														<th>Lessons</th>
														<th>Time (Min.)</th>
														<th>Term (Days)</th>
														<th>Price (¥)</th>
													</tr>
													<tr>
														<td>3 Lessons • 1 month</td>
														<td>3</td>
														<td>50</td>
														<td>30</td>
														<td>18,000</td>
													</tr>
													<tr>
														<td>8 Lessons • 2 months</td>
														<td>8</td>
														<td>50</td>
														<td>60</td>
														<td>45,600</td>
													</tr>
													<tr>
														<td>11 Lessons • 3 months</td>
														<td>11</td>
														<td>50</td>
														<td>90</td>
														<td>62,700</td>
													</tr>
													<tr>
														<td>22 Lessons • 6 months</td>
														<td>22</td>
														<td>50</td>
														<td>180</td>
														<td>112,200</td>
													</tr>
													<tr>
														<td>24 Lessons • 3 months</td>
														<td>24</td>
														<td>50</td>
														<td>90</td>
														<td>129,000</td>
													</tr>
													<tr>
														<td>48 Lessons • 6 months</td>
														<td>48</td>
														<td>50</td>
														<td>180</td>
														<td>244,800</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout">
											<table class="coaching_pricing_table grey_th" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Group</th>
														<th>2 Clients</th>
														<th>3 Clients</th>
														<th>4 Clients</th>
														<th>5 Clients</th>
														<th>6 Clients</th>
													</tr>
													<tr>
														<td>60 minutes / Client</td>
														<td>4,500</td>
														<td>4,000</td>
														<td>3,750</td>
														<td>3,600</td>
														<td>2,100</td>
													</tr>
														<tr class="more-btn-table">
														<td colspan="6">
															<div class="row try-now-btn">
																<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s">
																	<a href="{{ route('students.casual.product.index') }}">Try Now</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Accent Kids</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">										
										<div class="tbl-layout">
											<table class="coaching_pricing_table eng-lang border-0" width="100%" cellspacing="0" cellpadding="0" border="0">
												<tbody>
													<tr>
														<th style="min-width: 130px;">Monthly Tuition</th>
														<th style="min-width: 150px;">Kids Lessons</th>
														<th>Number of Lessons</th>
														<th>Lesson Duration</th>
														<th>Course Terms (Days)</th>
														<th>Course Price</th>
													</tr>
													<tr>
														<td>50 • 4 • 30</td>
														<td>4 Lessons One Per Week</td>
														<td class="num">4</td>
														<td class="num">50</td>
														<td class="num">30</td>
														<td class="num">16,000</td>
													</tr>
													<tr>
														<td>80 • 4 • 30</td>
														<td>4 Lessons One Per Week</td>
														<td class="num">4</td>
														<td class="num">80</td>
														<td class="num">30</td>
														<td class="num">24,000</td>
													</tr>
													<tr>
														<td>110 • 4 • 30</td>
														<td>4 Lessons One Per Week</td>
														<td class="num">4</td>
														<td class="num">110</td>
														<td class="num">30</td>
														<td class="num">30,000</td>
													</tr>
													<tr class="more-btn-table">
														<td colspan="6">
															<div class="row try-now-btn">
																<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s">
																	<a href="{{ route('students.kids.product.index') }}">Try Now</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<p class="star-cond">* All prices exclude tax.</p>
										<p class="star-cond">* Fees in the Course Fees table apply to the Aspire, Casual Conversation and Accent Kids courses.</p>

									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
		<!--div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Subscription</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="">
										<section class="simple-pricing-table col-4 clearfix">	
											<div class="column opacityRun">
												<header class="header">
													<h5 class="title">Virtual</h5>
												</header>

												<div class="price">
													<h2 class="cost">5,000</h2>
													<span class="description">¥/month・tax excl.</span>				
												</div>											
												<ul class="features">
													<li>¥0 Registration Fee</li>
													<li>25・50-minute lessons are  available.</li>
													<li>Virtual Lessons with teachers in the Philippines ONLY.</li>
													<li>&nbsp;<br>_</li>
													<li>OnePage Fee Included 500 credits / month</li>
													<li>4,500 points available for services.</li>
													<li>_</li>
													<li> Earn 1% of the value of an Accent lesson or service in points.</li>
													<li>Purchase a more or less   expensive subscription   plan anytime.</li>
												</ul>					
												
												<footer class="footer">
													<a class="button default" href="https://accent-language.com/en/cart/?add-to-cart=20488">Try now!</a>
												</footer>

											</div>
											
											<div class="column opacityRun">
												<header class="header">
													<h5 class="title">Light</h5>
												</header>

												<div class="price">
													<h2 class="cost">15,000</h2>
													<span class="description">¥/month・tax excl.</span>				
												</div>
													
												<ul class="features">
													<li>¥0 Registration Fee</li>
													<li>25・50-minute lessons are  available.</li>
													<li>Virtual Lessons with teachers in the Philippines and Japan.</li>
													<li>Cafe・Office &amp; Classroom Lessons and Document Services available.</li>
													<li>OnePage Fee Included 500 credits / month</li>
													<li>14,500 points available for services.</li>
													<li>_</li>
													<li> Earn 1% of the value of an Accent lesson or service in points.</li>
													<li>Purchase a more or less   expensive subscription   plan anytime.</li>
												</ul>
												
												<footer class="footer">
													<a class="button default" href="https://accent-language.com/en/cart/?add-to-cart=20493">Try now!</a>
												</footer>
											</div>

											<div class="column featured opacityRun">
												<header class="header">
													<h5 class="title">Standard</h5>
												</header>

												<div class="price">
													<h2 class="cost">25,000</h2>
													<span class="description">¥/month・tax excl.</span>				
												</div>											
													
												<ul class="features">
													<li>¥0 Registration Fee</li>
													<li>25・50-minute lessons are  available.</li>
													<li>Virtual Lessons with teachers in the Philippines and Japan.</li>
													<li>Cafe・Office &amp; Classroom Lessons and Document Services available.</li>
													<li>OnePage Fee Included 500 credits / month</li>
													<li>24,500 points available for services.</li>
													<li>20% Roll Over is available.</li>
													<li> Earn 1% of the value of an Accent lesson or service in points.</li>
													<li>Purchase a more or less   expensive subscription   plan anytime.</li>
												</ul>											
												
												<footer class="footer">
													<a class="button default" href="https://accent-language.com/en/cart/?add-to-cart=20494">Try now!</a>
												</footer>
											</div>

											<div class="column opacityRun">
												<header class="header">
													<h5 class="title">Power</h5>
												</header>

												<div class="price">
													<h2 class="cost">35,000</h2>
													<span class="description">¥/month・tax excl.</span>				
												</div>										
													
												<ul class="features">
													<li>¥0 Registration Fee</li>
													<li>25・50-minute lessons are available.</li>
													<li>Virtual Lessons with teachers in the Philippines and Japan.</li>
													<li>Cafe・Office &amp; Classroom Lessons and Document Services available.</li>
													<li>OnePage Fee Included 500 credits / month</li>
													<li>34,500 points available for services.</li>
													<li>20% Roll Over is available.</li>
													<li> Earn 1% of the value of an Accent lesson or service in points.</li>
													<li>Purchase a more or less   expensive subscription   plan anytime.</li>
												</ul>											
												
												<footer class="footer">
													<a class="button default" href="https://accent-language.com/en/cart/?add-to-cart=20497">Try now!</a>
												</footer>

											</div>

										</section>
										<p>
											<div class="desc_text">
												<p class="align-left">*1 credit or point is equal to 1 JPY. Points can be used to purchase lesson or document services or sent as a gift.</p>
												<p class="align-left">*Credits and points can ONLY be used during the period of a valid monthly subscription.</p>
												<p class="align-left">20% Roll Over means that up to 20% of the value of the next plan of any remaining credits can be rolled over.</p>
												<p class="align-left">* The OnBreak Plan is available to preserve points and credits, <a href="https://accent-language.com/en/product-category/on-break/">here</a>. Please note that credits can only be rolled over on Standard and Power plans. Credits will be lost on Virtual and Light plans. Points will be carried over on all plans.</p>
											</div>
										</p>
									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div-->		
		<div class="container">
            <div class="business_sec_new">
                <div class="row">
                    <div class="col-12">
                        <div class="accent_plan">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="accent_title">
                                        <h1>{{__('labels.stu_accent_oneplan')}}</h1>
                                        <p>
                                            {{__('labels.stu_purchase_point_with')}}
                                        </p>
                                        <!--div id="payment-request-button" class="try_btn">
                                            {{__('labels.btn_try_now')}}
                                        </div-->
                                    </div>
                                </div>
                            </div>
    
                            <div class="accent_pricebox">
                                
                                <div class="row">
    
                                    @foreach($packages as $key=>$package)
                                        <?php										
										if(in_array($package->id, [33,35])) {
											continue;
										}
										
										if($package->id == 42) { ?>
											<div class="col-lg-3 col-md-6 col-sm-6" style="margin-top:25px;">
												<div class="accent_box" style="min-height:275px;">
													<div class="acn_price">
														<h3>{{$package->title}}</h3>
														<h4>{{ number_format($package->price) }}<span>{{__('labels.stu_month_excluding_tax')}}</span>
														</h4>
													</div>
													<div class="acnt_minit">
														<p>{{__('labels.15_min_lesson_available')}}</p>
														
		
														<div class="try_now_btn">
															@if(Auth::guest())
																<a class="try_btn active" href="{{ url('/login') }}">{{__('labels.btn_try_now')}}</a>
															@else
																<form method="POST" action="{{route('students.account.payment')}}">
																	<input type="hidden"
																		   name="plan-name-{{$key}}"
																		   id="plan-name-{{$key}}"
																		   value="{{$package->title}}">
																	<input type="hidden"
																		   name="plan-description-{{$key}}"
																		   id="plan-description-{{$key}}"
																		   value="{{$package->description}}">
																	<input type="hidden"
																		   name="plan-price-{{$key}}"
																		   id="plan-price-{{$key}}"
																		   value="{{($package->price)}}">
			
			
			
																	@if(!empty($studentPackage))
																		@if ($studentPackage->package_id == $package->id)
																			@if (
																				(strtotime($studentPackage->start_date) < time()) &&
																				(strtotime($studentPackage->end_date) > time())
																				)
																				<button type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</button>
																			@elseif((time() - strtotime($studentPackage->end_date)) > 0)
																				<button type='button' id="plan-{{$key}}"
																						class="try_btn buy_package"
																						data-package-id="{{$package->id}}"
																						data-value='purchase' data-id="{{$key}}">
																					{{__('labels.btn_try_now')}}
																				</button>
																			@else
																				<span type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</span>
																			@endif
																		@else
																			<button type='button' id="plan-{{$key}}"
																					class="try_btn buy_package"
																					data-package-id="{{$package->id}}"
																					data-value='purchase' data-id="{{$key}}">
																				{{__('labels.btn_try_now')}}
																			</button>
																		@endif
																	@else
																		<button type='button' id="plan-{{$key}}"
																				class="try_btn buy_package"
																				data-package-id="{{$package->id}}"
																				data-value='purchase' data-id="{{$key}}">
																			{{__('labels.btn_try_now')}}
																		</button>
																	@endif
																</form>
															@endif
														</div>
													</div>
												</div>
											</div>
											<?php
										} else { ?>
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="accent_box">
													<div class="acn_price">
														<h3>{{$package->title}}</h3>
														<h4>{{ number_format($package->price) }}<span>{{__('labels.stu_month_excluding_tax')}}</span>
														</h4>
													</div>
													<div class="acnt_minit">
														<p>{{__('labels.stu_min_lesson_available')}}</p>
														<p>{{__('labels.stu_virtual_lesson_with_teacher')}}</p>
														<p>{{__('labels.stu_cafe_office_classroom')}}</p>
														<p>{{__('labels.stu_onepage_fee_include')}}
															{{ number_format($package->onepage_fee)}} {{__('labels.stu_point_month')}}
														</p>
		
														<p>¥{{ number_format($package->registration_fee) }} {{__('labels.stu_registration_fee')}} </p>
		
														<p>{{__('labels.stu_you_will_get')}} {{$package->reward_point}} {{__('labels.stu_reward_point_for_each_lesson')}}</p>
		
														<p>{{__('labels.stu_purchase_a_mor_or_less')}}.</p>
		
														<div class="try_now_btn">
															@if(Auth::guest())
																<a class="try_btn active" href="{{ url('/login') }}">{{__('labels.btn_try_now')}}</a>
															@else
																<form method="POST" action="{{route('students.account.payment')}}">
																	<input type="hidden"
																		   name="plan-name-{{$key}}"
																		   id="plan-name-{{$key}}"
																		   value="{{$package->title}}">
																	<input type="hidden"
																		   name="plan-description-{{$key}}"
																		   id="plan-description-{{$key}}"
																		   value="{{$package->description}}">
																	<input type="hidden"
																		   name="plan-price-{{$key}}"
																		   id="plan-price-{{$key}}"
																		   value="{{($package->price)}}">
			
			
			
																	@if(!empty($studentPackage))
																		@if ($studentPackage->package_id == $package->id)
																			@if (
																				(strtotime($studentPackage->start_date) < time()) &&
																				(strtotime($studentPackage->end_date) > time())
																				)
																				<button type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</button>
																			@elseif((time() - strtotime($studentPackage->end_date)) > 0)
																				<button type='button' id="plan-{{$key}}"
																						class="try_btn buy_package"
																						data-package-id="{{$package->id}}"
																						data-value='purchase' data-id="{{$key}}">
																					{{__('labels.btn_try_now')}}
																				</button>
																			@else
																				<span type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</span>
																			@endif
																		@else
																			<button type='button' id="plan-{{$key}}"
																					class="try_btn buy_package"
																					data-package-id="{{$package->id}}"
																					data-value='purchase' data-id="{{$key}}">
																				{{__('labels.btn_try_now')}}
																			</button>
																		@endif
																	@else
																		<button type='button' id="plan-{{$key}}"
																				class="try_btn buy_package"
																				data-package-id="{{$package->id}}"
																				data-value='purchase' data-id="{{$key}}">
																			{{__('labels.btn_try_now')}}
																		</button>
																	@endif
																</form>
															@endif
														</div>
													</div>
												</div>
											</div>
											<?php
										}
										?>
                                        <!--div class="col-lg-3 col-md-6 col-sm-6">
                                            <div class="accent_box">
                                                <div class="acn_price">
                                                    <h3>{{$package->title}}</h3>
                                                    <h4>{{ number_format($package->price) }}<span>{{__('labels.stu_month_excluding_tax')}}</span>
                                                    </h4>
                                                </div>
                                                <div class="acnt_minit">
                                                    <p>{{__('labels.stu_min_lesson_available')}}</p>
                                                    <p>{{__('labels.stu_virtual_lesson_with_teacher')}}</p>
                                                    <p>{{__('labels.stu_cafe_office_classroom')}}</p>
                                                    <p>{{__('labels.stu_onepage_fee_include')}}
                                                        {{ number_format($package->onepage_fee)}} {{__('labels.stu_point_month')}}
                                                    </p>
    
                                                    <p>¥{{ number_format($package->registration_fee) }} {{__('labels.stu_registration_fee')}} </p>
    
                                                    <p>{{__('labels.stu_you_will_get')}} {{$package->reward_point}} {{__('labels.stu_reward_point_for_each_lesson')}}</p>
    
                                                    <p>{{__('labels.stu_purchase_a_mor_or_less')}}.</p>
    
                                                    <div class="try_now_btn">
														@if(Auth::guest())
															<a class="try_btn active" href="{{ url('/login') }}">{{__('labels.btn_try_now')}}</a>
														@else
															<form method="POST" action="{{route('students.account.payment')}}">
																<input type="hidden"
																	   name="plan-name-{{$key}}"
																	   id="plan-name-{{$key}}"
																	   value="{{$package->title}}">
																<input type="hidden"
																	   name="plan-description-{{$key}}"
																	   id="plan-description-{{$key}}"
																	   value="{{$package->description}}">
																<input type="hidden"
																	   name="plan-price-{{$key}}"
																	   id="plan-price-{{$key}}"
																	   value="{{($package->price)}}">
		
		
		
																@if(!empty($studentPackage))
																	@if ($studentPackage->package_id == $package->id)
																		@if (
																			(strtotime($studentPackage->start_date) < time()) &&
																			(strtotime($studentPackage->end_date) > time())
																			)
																			<button type='button' class="try_btn active">
																				{{__('labels.btn_subscribed')}}
																			</button>
																		@elseif((time() - strtotime($studentPackage->end_date)) > 0)
																			<button type='button' id="plan-{{$key}}"
																					class="try_btn buy_package"
																					data-package-id="{{$package->id}}"
																					data-value='purchase' data-id="{{$key}}">
																				{{__('labels.btn_try_now')}}
																			</button>
																		@else
																			<span type='button' class="try_btn active">
																				{{__('labels.btn_subscribed')}}
																			</span>
																		@endif
																	@else
																		<button type='button' id="plan-{{$key}}"
																				class="try_btn buy_package"
																				data-package-id="{{$package->id}}"
																				data-value='purchase' data-id="{{$key}}">
																			{{__('labels.btn_try_now')}}
																		</button>
																	@endif
																@else
																	<button type='button' id="plan-{{$key}}"
																			class="try_btn buy_package"
																			data-package-id="{{$package->id}}"
																			data-value='purchase' data-id="{{$key}}">
																		{{__('labels.btn_try_now')}}
																	</button>
																@endif
															</form>
														@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div-->
                                    @endforeach
                                </div>
    
                            </div>
    
                            <div class="price_point">
                                <div class="row">
                                    <div class="col-12">
                                        <p>*{{__('labels.stu_one_plan_p1')}}</p>
    
                                        <p>*{{__('labels.stu_one_plan_p2')}}</p>
    
                                        <p>*{{__('labels.stu_one_plan_p3')}}</p>
                                        <p>*{{__('labels.stu_one_plan_p4')}}</p>
                                        <p>*{{__('labels.stu_one_plan_the')}}
                                            <a href="{{ route('students.account.onbreak') }}" style="color: blue;font-weight: 600;">
                                                {{__('labels.stu_accent_onbreak_plan')}}
                                            </a>
                                            {{__('labels.stu_one_plan_p5')}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.lesson_anywhere_section')
					</div>
				</div>
			</div>
		</div>
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.amazing_language_partners_section')
					</div>
				</div>
			</div>
		</div>
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.what_our_learners_say_section')
					</div>
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.book_a_lesson_section')
					</div>
				</div>
			</div>
		</div>
	</div>
        
<?php
} else {
?>	
	<div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>コース料金</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p>												
											<table class="coaching_desc_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>基本</th>
														<th>価格（円）</th>
													</tr>
													<tr>
														<td class="desc-text">入会金 ( ２名以上で同時に入会の時、入会金は半額 )</td>
														<td>29,900</td>
													</tr>
													<tr>
														<td class="desc-text">OnePageシステム使用料金 (12ヶ月)</td>
														<td>5,900</td>
													</tr>
													<tr>
														<td class="desc-text">初期費用合計</td>
														<td>35,800</td>
													</tr>
												</tbody>
											</table>
										</p>
									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Aspire(アスパイヤ)</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">											
										<div class="tbl-layout table-pricing" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>お一人</th>
														<th>価格（円）</th>
													</tr>
													<tr>
														<td>60分</td>
														<td>20,000</td>
													</tr>
													<tr>
														<td>90分</td>
														<td>30,000</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout table-pricing" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>コース</th>
														<th>セッション数</th>
														<th>時間 (分)</th>
														<th>期間 (日)</th>
														<th>Price ( ¥ )</th>
													</tr>
													<tr>
														<td>週1回</td>
														<td>1</td>
														<td>60</td>
														<td>7</td>
														<td>20,000</td>
													</tr>
													<tr>
														<td>週1回</td>
														<td>1</td>
														<td>90</td>
														<td>7</td>
														<td>30,000</td>
													</tr>
													<tr>
														<td>週1回3ヶ月間12回</td>
														<td>12</td>
														<td>60</td>
														<td>90</td>
														<td>216,000</td>
													</tr>
													<tr>
														<td>週1回3ヶ月間12回</td>
														<td>12</td>
														<td>90</td>
														<td>90</td>
														<td>306,000</td>
													</tr>
													<tr>
														<td>週2回3ヶ月間24回</td>
														<td>24</td>
														<td>60</td>
														<td>90</td>
														<td>432,000</td>
													</tr>
													<tr>
														<td>週2回3ヶ月間24回</td>
														<td>24</td>
														<td>90</td>
														<td>90</td>
														<td>612,000</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout table-pricing">
											<table class="coaching_pricing_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>グループ</th>
														<th>２人</th>
														<th>３人</th>
														<th>４人</th>
													</tr>
													<tr>
														<td>60分/お一人分</td>
														<td>15,000</td>
														<td>13,333</td>
														<td>12,500</td>
													</tr>
													<tr class="more-btn-table">
														<td colspan="4">
															<div class="row try-now-btn">
																<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s">
																	<a href="{{ route('students.aspire.product.index') }}">今すぐトライ</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>カジュアルカンバセーション</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">											
										<div class="tbl-layout" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table grey_th" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
												<tr>
													<th class="cas-conv">お一人</th>
													<th class="cas-conv">価格（円）</th>
												</tr>
												<tr>
													<td>50分</td>
													<td>6,000</td>
												</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout" style="margin-bottom: 0px;">
											<table class="coaching_pricing_table grey_th" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>コース</th>
														<th>レッスン数</th>
														<th>時間 (分)</th>
														<th>期間 (日)</th>
														<th>価格（円）</th>
													</tr>
													<tr>
														<td>1ヶ月間3回</td>
														<td>3</td>
														<td>50</td>
														<td>30</td>
														<td>18,000</td>
													</tr>
													<tr>
														<td>2ヶ月間8回</td>
														<td>8</td>
														<td>50</td>
														<td>60</td>
														<td>45,600</td>
													</tr>
													<tr>
														<td>3ヶ月間11回</td>
														<td>11</td>
														<td>50</td>
														<td>90</td>
														<td>62,700</td>
													</tr>
													<tr>
														<td>6ヶ月間22回</td>
														<td>22</td>
														<td>50</td>
														<td>180</td>
														<td>112,200</td>
													</tr>
													<tr>
														<td>3ヶ月間24回</td>
														<td>24</td>
														<td>50</td>
														<td>90</td>
														<td>129,000</td>
													</tr>
													<tr>
														<td>6ヶ月間48回</td>
														<td>48</td>
														<td>50</td>
														<td>180</td>
														<td>244,800</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tbl-layout">
											<table class="coaching_pricing_table grey_th" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>グループ</th>
														<th>２人</th>
														<th>３人</th>
														<th>４人</th>
														<th>５人</th>
														<th>６人</th>
													</tr>
													<tr>
														<td>60分/お一人分</td>
														<td>4,500</td>
														<td>4,000</td>
														<td>3,750</td>
														<td>3,600</td>
														<td>2,100</td>
													</tr>
													<tr class="more-btn-table">
														<td colspan="6">
															<div class="row try-now-btn">
																<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s">
																	<a href="{{ route('students.casual.product.index') }}">今すぐトライ</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>スーパーキッズ</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">										
										<div class="tbl-layout">										
											<table class="coaching_pricing_table eng-lang border-0" width="100%" cellspacing="0" cellpadding="0" border="0">
												<tbody>
													<tr>
														<th style="min-width: 130px;">月謝</th>
														<th style="min-width: 150px;">キッズレッスン</th>
														<th>レッスン数</th>
														<th>時間（分</th>
														<th>時間（日）</th>
														<th>価格（円）</th>
													</tr>
													<tr>
														<td>50 • 4 • 30</td>
														<td>1ヶ月間4回</td>
														<td class="num">4</td>
														<td class="num">50</td>
														<td class="num">30</td>
														<td class="num">16,000</td>
													</tr>
													<tr>
														<td>80 • 4 • 30</td>
														<td>1ヶ月間4回</td>
														<td class="num">4</td>
														<td class="num">80</td>
														<td class="num">30</td>
														<td class="num">24,000</td>
													</tr>
													<tr>
														<td>110 • 4 • 30</td>
														<td>1ヶ月間4回</td>
														<td class="num">4</td>
														<td class="num">110</td>
														<td class="num">30</td>
														<td class="num">30,000</td>
													</tr>
													<tr class="more-btn-table">
														<td colspan="6">
															<div class="row try-now-btn">
																<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s">
																	<a href="{{ route('students.kids.product.index') }}">今すぐトライ</a>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<p class="star-cond">* 価格は全て税別です。</p>
										<p class="star-cond">* コース料金表に記載されている料金は、アスパイアコース、カジュアルカンバセーションコース、キッズコースの全てに共通です。</p>

									</div>
								</div>
							</div>									
						</div>
					</section>																	
				</div>
			</div>
		</div>
		
        <div class="container">
            <div class="business_sec_new">
                <div class="row">
                    <div class="col-12">
                        <div class="accent_plan">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="accent_title">
                                        <h1>{{__('labels.stu_accent_oneplan')}}</h1>
                                        <p>
                                            {{__('labels.stu_purchase_point_with')}}
                                        </p>
                                        <!--div id="payment-request-button" class="try_btn">
                                            {{__('labels.btn_try_now')}}
                                        </div-->
                                    </div>
                                </div>
                            </div>
    
                            <div class="accent_pricebox">
                                <div class="row">
                                    
                                </div>
                                <div class="row">
    
                                    @foreach($packages as $key=>$package)
                                        <?php										
										if(in_array($package->id, [33,35])) {
											continue;
										}
										
										if($package->id == 42) { ?>
											<div class="col-lg-3 col-md-6 col-sm-6" style="margin-top:25px;">
												<div class="accent_box" style="min-height:275px;">
													<div class="acn_price">
														<h3>{{$package->title}}</h3>
														<h4>{{ number_format($package->price) }}<span>{{__('labels.stu_month_excluding_tax')}}</span>
														</h4>
													</div>
													<div class="acnt_minit">
														<p>{{__('labels.15_min_lesson_available')}}</p>
														
		
														<div class="try_now_btn">
															@if(Auth::guest())
																<a class="try_btn active" href="{{ url('/login') }}">{{__('labels.btn_try_now')}}</a>
															@else
																<form method="POST" action="{{route('students.account.payment')}}">
																	<input type="hidden"
																		   name="plan-name-{{$key}}"
																		   id="plan-name-{{$key}}"
																		   value="{{$package->title}}">
																	<input type="hidden"
																		   name="plan-description-{{$key}}"
																		   id="plan-description-{{$key}}"
																		   value="{{$package->description}}">
																	<input type="hidden"
																		   name="plan-price-{{$key}}"
																		   id="plan-price-{{$key}}"
																		   value="{{($package->price)}}">
			
			
			
																	@if(!empty($studentPackage))
																		@if ($studentPackage->package_id == $package->id)
																			@if (
																				(strtotime($studentPackage->start_date) < time()) &&
																				(strtotime($studentPackage->end_date) > time())
																				)
																				<button type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</button>
																			@elseif((time() - strtotime($studentPackage->end_date)) > 0)
																				<button type='button' id="plan-{{$key}}"
																						class="try_btn buy_package"
																						data-package-id="{{$package->id}}"
																						data-value='purchase' data-id="{{$key}}">
																					{{__('labels.btn_try_now')}}
																				</button>
																			@else
																				<span type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</span>
																			@endif
																		@else
																			<button type='button' id="plan-{{$key}}"
																					class="try_btn buy_package"
																					data-package-id="{{$package->id}}"
																					data-value='purchase' data-id="{{$key}}">
																				{{__('labels.btn_try_now')}}
																			</button>
																		@endif
																	@else
																		<button type='button' id="plan-{{$key}}"
																				class="try_btn buy_package"
																				data-package-id="{{$package->id}}"
																				data-value='purchase' data-id="{{$key}}">
																			{{__('labels.btn_try_now')}}
																		</button>
																	@endif
																</form>
															@endif
														</div>
													</div>
												</div>
											</div>
											<?php
										} else { ?>
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="accent_box">
													<div class="acn_price">
														<h3>{{$package->title}}</h3>
														<h4>{{number_format($package->price)}}<span>{{__('labels.stu_month_excluding_tax')}}</span>
														</h4>
													</div>
													<div class="acnt_minit">
														<p>{{__('labels.stu_min_lesson_available')}}</p>
														<p>{{__('labels.stu_virtual_lesson_with_teacher')}}</p>
														<p>{{__('labels.stu_cafe_office_classroom')}}</p>
														<p>{{__('labels.stu_onepage_fee_include')}}
															{{ number_format($package->onepage_fee)}} {{__('labels.stu_point_month')}}
														</p>
		
														<p>¥{{ number_format($package->registration_fee) }} {{__('labels.stu_registration_fee')}} </p>
		
														<p>{{__('labels.stu_you_will_get')}} {{$package->reward_point}} {{__('labels.stu_reward_point_for_each_lesson')}}</p>
		
														<p>{{__('labels.stu_purchase_a_mor_or_less')}}.</p>
		
														<div class="try_now_btn">
															@if(Auth::guest())
																<a class="try_btn active" href="{{ url('/login') }}">{{__('labels.btn_try_now')}}</a>
															@else
																<form method="POST" action="{{route('students.account.payment')}}">
																	<input type="hidden"
																		   name="plan-name-{{$key}}"
																		   id="plan-name-{{$key}}"
																		   value="{{$package->title}}">
																	<input type="hidden"
																		   name="plan-description-{{$key}}"
																		   id="plan-description-{{$key}}"
																		   value="{{$package->description}}">
																	<input type="hidden"
																		   name="plan-price-{{$key}}"
																		   id="plan-price-{{$key}}"
																		   value="{{($package->price)}}">
			
			
			
																	@if(!empty($studentPackage))
																		@if ($studentPackage->package_id == $package->id)
																			@if (
																				(strtotime($studentPackage->start_date) < time()) &&
																				(strtotime($studentPackage->end_date) > time())
																				)
																				<button type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</button>
																			@elseif((time() - strtotime($studentPackage->end_date)) > 0)
																				<button type='button' id="plan-{{$key}}"
																						class="try_btn buy_package"
																						data-package-id="{{$package->id}}"
																						data-value='purchase' data-id="{{$key}}">
																					{{__('labels.btn_try_now')}}
																				</button>
																			@else
																				<span type='button' class="try_btn active">
																					{{__('labels.btn_subscribed')}}
																				</span>
																			@endif
																		@else
																			<button type='button' id="plan-{{$key}}"
																					class="try_btn buy_package"
																					data-package-id="{{$package->id}}"
																					data-value='purchase' data-id="{{$key}}">
																				{{__('labels.btn_try_now')}}
																			</button>
																		@endif
																	@else
																		<button type='button' id="plan-{{$key}}"
																				class="try_btn buy_package"
																				data-package-id="{{$package->id}}"
																				data-value='purchase' data-id="{{$key}}">
																			{{__('labels.btn_try_now')}}
																		</button>
																	@endif
																</form>
															@endif
														</div>
													</div>
												</div>
											</div>
											<?php
										}
										?>
                                    @endforeach
                                </div>
    
                            </div>
    
                            <div class="price_point">
                                <div class="row">
                                    <div class="col-12">
                                        <p>*{{__('labels.stu_one_plan_p1')}}</p>
    
                                        <p>*{{__('labels.stu_one_plan_p2')}}</p>
    
                                        <p>*{{__('labels.stu_one_plan_p3')}}</p>
                                        <p>*{{__('labels.stu_one_plan_p4')}}</p>
                                        <p>*{{__('labels.stu_one_plan_the')}}
                                            <a href="{{ route('students.account.onbreak') }}" style="color: blue;font-weight: 600;">
                                                {{__('labels.stu_accent_onbreak_plan')}}
                                            </a>
                                            {{__('labels.stu_one_plan_p5')}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.lesson_anywhere_section')
					</div>
				</div>
			</div>
		</div>
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.amazing_language_partners_section')
					</div>
				</div>
			</div>
		</div>
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.what_our_learners_say_section')
					</div>
				</div>
			</div>
		</div>
		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">
					<div class="prvcy_margin">
						@include('cms.book_a_lesson_section')
					</div>
				</div>
			</div>
		</div>
	</div>
        
<?php } ?>

	@push('scripts')
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="{{asset('js/student/account/index.js')}}"></script>
        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter : 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif

        @include('students.account.index.js')
        {{-- <script src="{{ asset('js/student/profile/index.js') }}"></script> --}}
    @endpush
	
@endsection
