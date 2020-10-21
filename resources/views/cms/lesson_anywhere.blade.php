
@extends('layouts.app',['title'=>'Lesson Anywher'])
@section('title', 'Lesson Anywher')
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
							<div class="prvcy_margin"><h5>In-Person Sessions</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Learning a language in a stimulating environment, interacting with the language partner at your favourite cafe, bar, restaurant, mall, beach or park, enhances the memorisation of new foreign language. While you talk, the keywords and phrases that you want to learn are input into the OnePage Canvas by the language partner. </p>
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
							<div class="prvcy_margin"><h5>Remote Sessions</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Taking advantage of short 15-minutes sessions and being able to practice English daily via LINE, Facebook Messenger, or Skype is appealing for busy learners. Combining longer in-person sessions with short remote sessions is a great way to stay motivated, learning more and more really useful keywords and phrases that the language partner has input into the OnePage Canvas. </p>
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
						@include('cms.amazing_language_partners_section')
					</div>
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
							<div class="prvcy_margin"><h5>対面セッション</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">カフェやバー、レストラン、ショッピングモール、ビーチや公園など、あなたのお気に入りの場所で、外部からの程よい刺激のある環境の中、学習パートナーと交流をしながら語学を学ぶことは、新しい言語を記憶する力を高めます。 あなたが話している間、あなたが必要とする言葉やフレーズを、学習パートナーがOnePage Canvasに入力していきます </p>
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
							<div class="prvcy_margin"><h5>オンラインセッション</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">15分という短かいセッションの特性を生かし、LINEやFacebookメッセンジャー、スカイプなどを使って毎日英語を学べることは、忙しい学習者の方々には嬉しいポイントです。 長めの対面セッションと短いオンラインセッションの組み合わせは、学習パートナーがOnePage Canvasに入力した役立つキーワードやフレーズをどんどん学んでいくことや、そのやる気を持続するためにはとても良い方法です。 </p>
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
						@include('cms.amazing_language_partners_section')
					</div>
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
