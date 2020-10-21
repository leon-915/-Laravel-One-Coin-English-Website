
@extends('layouts.app',['title'=>'OnePage Canvas'])
@section('title', 'OnePage Canvas')
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
	<div>	
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img class="aligncenter " alt="" src="{{ asset('images/one-page11.jpg') }}"></p>
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
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img class="aligncenter " alt="" src="{{ asset('images/one-page21.jpg') }}"></p>
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
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img class="aligncenter " alt="" src="{{ asset('images/one-page32.jpg') }}"></p>
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
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img class="aligncenter " alt="" src="{{ asset('images/one-page41.jpg') }}"></p>
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
					<div class="prvcy_margin">
						@include('cms.flexible_pricing_section')
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
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img class="aligncenter " alt="" src="{{ asset('images/onepage-ja-1.jpg') }}"></p>
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
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img alt="" src="{{ asset('images/onepage-ja-2.jpg') }}"></p>
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
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img alt="" src="{{ asset('images/onepage-ja-3.jpg') }}"></p>
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
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p><img alt="" src="{{ asset('images/onepage-ja-4.jpg') }}"></p>
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
					<div class="prvcy_margin">
						@include('cms.flexible_pricing_section')
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

@endsection
