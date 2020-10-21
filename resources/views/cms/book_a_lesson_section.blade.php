<?php
if(Lang::locale() == 'en')
{
?>
<div class="business_sec_new">
	<div class="row">
		<div class="col-12">
			<section id="book-lesson">
				<div class="container">
					<div class="prvcy_margin">
						<div class="text-center"><a href="{{ url('student/register') }}" class="book-lesson">Book A Session</a></div>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
							<div class="count-box clearfix">
								<aside class="section">
									<div class="count-circle">1</div>
									<a href="#">Sign Up</a>
								</aside>
								<aside class="section">
									<div class="count-circle">2</div>
									<a href="#">Choose a Language Partner</a>
								</aside>
								<aside class="section">
									<div class="count-circle">3</div>
									<a href="#">Book a Session</a>
								</aside>
							</div>
						</div>
					</div>
				</div>
			</section>			
		</div>
	</div>
</div>

<?php
} else { 
?>
	<div class="business_sec_new">
		<div class="row">
			<div class="col-12">				
				<section id="book-lesson">
					<div class="container">
						<div class="prvcy_margin">
							<div class="text-center">
								<a href="{{ url('student/register') }}" class="book-lesson">無料デモセッション</a></div>
						</div>
						<div class="row">
							<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
								<div class="count-box clearfix">
									<aside class="section">
										<div class="count-circle">1</div>
										<a href="#">登録</a>
									</aside>
									<aside class="section">
										<div class="count-circle">2</div>
										<a href="#">学習パートナーを選ぶ</a>
									</aside>
									<aside class="section">
										<div class="count-circle">3</div>
										<a href="#">セッションのご予約</a>
									</aside>
								</div>
							</div>
						</div>
					</div>					
				</section>	
			</div>
		</div>
	</div>
<?php } ?>