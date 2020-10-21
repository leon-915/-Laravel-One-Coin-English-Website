<div class="business_sec_new">
	<div class="row">
		<div class="col-12">
			<div class="prvcy_margin text-center">
				<h5>{{__('labels.what_our_learners_say')}}</h5>
			</div>
			<section id="our-learner">
				<div class="container">
					<ul class="row quotesa " dataa-timeout="3000">
	                   <?php
					   if(!empty($testimonials)) {
						   foreach($testimonials as $testimonial) { ?>
								<li class="col-md-6 col-lg-4">
									<div class="box test-section" onclick="window.location.href = 'https://accent-language.com/testimonials/';">
										<div class="text-left"><img src="{{asset('images/quotation-mark.png')}}" alt="" width="54"></div>
										<blockquote class="description">
											<p>
												<?php
												if(Lang::locale() == 'en') {
													//echo substr($testimonial->title, 30);
													if (preg_match('/^.{1,110}\b/s', $testimonial->title, $match))
													{
														$line=$match[0];
													}	
													echo $line.' ...';	
												} else {
													echo $testimonial->title_ja;
												}
												?>
											</p>
										</blockquote>
										<div class="row footer">
											<div class="col-md-4 col-lg-4">
												<div class="quote-image img-container">
													<img alt="S.O.・Hair &amp; Makeup Artist" src="{{asset('images/200_logo1-70x70.png')}}" width="70" height="70">
												</div>
											</div>
										</div>
									</div>
								</li>	
						   <?php
						   }
					   }
					   ?>					   
					</ul><!--/ .quotes-->
					<div class="row">
						<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s"><a href="{{ url('testimonials') }}">{{__('labels.more_btn_home')}}</a></div>
					</div>
				</div>
			</section>													
		</div>
	</div>
</div>