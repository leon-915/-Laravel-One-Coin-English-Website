<?php
if(Lang::locale() == 'en')
{
?>
<div class="business_sec_new">
	<div class="row">
		<div class="col-12">
			
											<div class="video-full-container">

	<div class="video-full-entry">
		<section id="flexible-pricing">
<div class="container">

        <div class="prvcy_margin text-center">
					<h5>{{__('labels.flexible_pricing')}}</h5>
				</div>
<div class="row">
<div class="col-md-6 col-lg-4 wow bounceInUp offset-md-2" data-wow-duration="1.4s">
<div class="box">
<h4 class="title"><a href="">Lesson Course Packages</a></h4>
<p class="description">provide you a set number of lessons for a specific term.</p>

</div>
</div>
<div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-duration="1.4s">
<div class="box">
<h4 class="title"><a href="">Monthly Subscriptions</a></h4>
<p class="description">are automatically withdrawn every month simplifying your life.</p>

</div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s"><a href="{{ url('pricing') }}">+ More</a></div>
</div>
</div>
</section>	</div><!--/ .video-full-entry-->	

</div><!--/ .video-full-container-->										
		</div>
	</div>
</div>
<?php
} else { ?>
	<div class="business_sec_new">
		<div class="row">
			<div class="col-12">
				
											<div class="video-full-container">

	<div class="video-full-entry">
		<section id="flexible-pricing">
<div class="container">

        <div class="prvcy_margin text-center">
					<h5>柔軟な価格</h5>
				</div>
<div class="row">
<div class="col-md-6 col-lg-4 wow bounceInUp offset-md-2" data-wow-duration="1.4s">
<div class="box">
<h4 class="title"><a href="">レッスンコースパッケージは、</a></h4>
<p class="description">一定の期間内で決まった数のレッスンを提供します。</p>

</div>
</div>
<div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-duration="1.4s">
<div class="box">
<h4 class="title"><a href="">月謝は自動引き落としのため</a></h4>
<p class="description">振り込み等のわずらわしさもありません。</p>

</div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp text-center more" data-wow-duration="1.4s"><a href="{{ url('pricing') }}">+ さらに詳しく</a></div>
</div>
</div>
</section>	</div><!--/ .video-full-entry-->	

</div><!--/ .video-full-container-->										
			</div>
		</div>
	</div>
	
<?php } ?>