<?php
if(Lang::locale() == 'en')
{
?>

<section id="intro" class="clearfix">
    <div class="container d-flex h-100">
      <div class="row justify-content-center align-self-center w100per">
        <div class="col-md-12 intro-info order-md-first order-last">
          <h2 class="text-center">Your English goals.<br>Your lesson topics.</h2>
		  <div class="text-center">
            <a href="{{ url('student/register') }}" class="book-lesson">Free Demo Session</a>
          </div>
		   <h2 class="text-center"><span>For work, rest &amp; play.</span></h2>
        </div>
      </div>
    </div>
  </section>
<?php
} else { ?>
	<section id="intro" class="clearfix">
    <div class="container d-flex h-100">
      <div class="row justify-content-center align-self-center w100per">
        <div class="col-md-12 intro-info order-md-first order-last">
          <h2 class="text-center">あなたの目標に合わせ<br>英語学習をカスタマイズ</h2>
		  <div class="text-center">
            <a href="{{ url('student/register') }}" class="book-lesson">無料デモセッション</a>
          </div>
		   <h2 class="text-center"><span>仕事にも、日常生活にも、遊びの場にも</span></h2>
        </div>
      </div>

    </div>
  </section>
	
<?php } ?>
