
@extends('layouts.app',['title'=>'Casual Conversation'])
@section('title', 'Casual Conversation')
@section('content')

<div class="row">
	<div class="col-12">
		@include('cms.big_image_section')
	</div>
</div>
<div class="row">
	<div class="col-12">
		@include('cms.casual_header_section')
	</div>
</div>
	
<?php
if(Lang::locale() == 'en')
{
?>
	<div class="cas-conv">
	<div>		
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">						
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Casual Conversation</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">For very affordable and flexible sessions to suit your every day English needs, a casual conversation course is for you. Below are some use cases for which a Casual Conversation course is best suited.</p>            
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
							<div class="prvcy_margin"><h5>Use case #1: Using English on Vacation</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">If you are about to go on vacation but lack the confidence to communicate in English, taking a few sessions to brush up your skills and increase your confidence will make your holiday much more enjoyable. While abroad, use OnePage to search for your personal keywords and phrases that you have learned.</p>            
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
							<div class="prvcy_margin"><h5>Use case #2: Communicating better with English speaking friends.</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
								<div class="desc_text_new">
									<p class="text-left">Have you experienced the awkward situation of pretending to understand your English speaking friends, or them pretending to understand your broken English? Use Casual Conversation sessions in which the language partner will kindly point out your grammatical mistakes, improve your listening and speaking skills with natural English expressions using the OnePage Canvas.</p>            
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
							<div class="prvcy_margin"><h5>Use case #3: An alternative to Aspire</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
								<div class="desc_text_new">
									<p class="text-left">The Aspire Coaching course is an intensive course designed for working professionals who want their sessions facilitated by specialized language partners, if you prefer a non intensive, cheaper course for business, TOEIC, and EIKEN etc. then a Casual Conversation course with OnePage Canvas is for you.</p>            
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
							<div class="prvcy_margin"><h5>カジュアルカンバセーション</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
								<div class="desc_text_new">
									<p class="text-left">日常英会話を身に付けるための手ごろでフレキシブルなセッションを求める方には、カジュアルカンバセーションコースがおすすめです。カジュアルカンバセーションコースは、次のようなご利用に最適です。</p>            
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
							<div class="prvcy_margin"><h5>利用例１：休暇で英語を使う</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
								<div class="desc_text_new">
									<p class="text-left">休暇で海外に行く予定があるけれど、英語でのコミュニケーションに自信がない。そんな時は英語スキルを磨くためのセッションを何回か受けてください。コミュニケーションの自信がアップして、休暇がより楽しいものになります。海外にいる間もOnePageキャンバスを使って、学んだキーワードやフレーズを確認することができます。</p>            
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
							<div class="prvcy_margin"><h5>利用例２：外国人の友達とのコミュニケーションで英語を使う</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
								<div class="desc_text_new">
									<p class="text-left">外国人の友達との会話中、相手の英語を理解しているふりをしてしまう、あるいは自分のブロークンな英語を相手がわかっているふりをしてくれている、そんなちょっと気まずい思いをしたことはありませんか。カジュアルカンバセーションコースを利用すれば、学習パートナーがあなたの文法のミスを丁寧に指摘するとともに、自然な英語表現を使ったリスニングとスピーキングのスキルを向上させてくれます。</p>            
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
							<div class="prvcy_margin"><h5>利用例３：Aspireの代わりとして</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
								<div class="desc_text_new">
									<p class="text-left">Aspireコーチングコースは、特別な学習パートナーが導くセッションを希望するビジネスパーソンのための強化コースです。ビジネスやTOEIC、英検などを目的としているけれど、強化コースでなくとも良いという方には、OnePageキャンバスを使ったカジュアルカンバセーションコースがおすすめです。</p>            
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
	
	
         
</div>	
<?php } ?>
@endsection
