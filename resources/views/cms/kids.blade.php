
@extends('layouts.app',['title'=>'Kids'])
@section('title', 'Kids')
@section('content')
<?php
if(Lang::locale() == 'en')
{
?>
    
        
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
			<!--div class="aboutus_detail_box"-->
			<div>
				<div class="business_sec_new">
                    <div class="row">
                        <div class="col-12">
							<section class="global-services text-center"><img src="{{ asset('images/kids.png') }}" alt="kids" width="264"></section>
							<section class="global-services">
								<div class="container">
									<div class="prvcy_margin"><h5>What is Accent Kids?</h5></div>
									<div class="row">
										<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
											<div class="desc_text_new">
											<p class="text-left">At Accent Kids children learn to think in a foreign language. Not only for communication but also to build their interest of other cultures and the benefits of collaboration through teamwork.</p>
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
									<div class="prvcy_margin"><h5>What makes Accent Kids different?</h5></div>
									<div class="row">
										<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
											<div class="desc_text_new">
												<p class="text-left">Our kids program includes:</p>
												<ul>
													<li>Natural lifestyle conversation practice.</li>
													<li>Hands-on learning through sports, art &amp; crafts, programming, and more.</li>
													<li>Project-based curriculums</li>
													<li>Custom-made Lesson Plans</li>
													<li>Goal oriented activities</li>
												</ul>
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
<div class="container"><div class="prvcy_margin"><h5>Why choose Accent Kids for your kids?</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">Accent Kids is conveniently surrounded by many local and foreign culture settings. It’s a safe and rich environment where children can explore, play, and learn while communicating in English with their teachers and peers. We organize several outdoor and day-trip activities for kids to practice English. For example:</p>
<ul>
	<li>Kids parties</li>
	<li>Sporting events</li>
	<li>Local excursions to museums, cultural events, science centers.</li>
	<li>Overseas travel opportunities</li>
</ul>
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
<div class="container"><div class="prvcy_margin"><h5>Accent Kids Curriculum</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new"><p class="text-left">Accent Kids implements physical, cognitive, and social activities that challenges children to apply English into their everyday lifestyle. The Accent Kids curriculum in based on:</p>
<ul>
	<li>Engaging and relevant vocabulary from Super Kids and Oxford Reading Tree books</li>
	<li>Full English communication between classmates</li>
	<li>Teamwork centered PBL projects</li>
</ul>
<div class="text-center"><img src="{{ asset('images/books.png') }}" alt="Kids Curriculum"></div>
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
<div class="container"><div class="prvcy_margin"><h5>What does a lesson at Accent Kids look like?</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">Our proprietary Accent Kids lesson plans are build to maximize English natural conversation skills. A typical 50-minute English lesson covers the following:</p>
<ul>
	<li>Greeting and Conversation</li>
	<li>Alphabet and Phonics</li>
	<li>Book reading and Songs</li>
<li>Vocabulary building conversation book</li>
<li>Review of learned material</li>
</ul>
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
<div class="container"><div class="prvcy_margin"><h5>Level 1 - Lesson Plan #1</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new tbl-layout">
<table class="coaching_pricing_table lesson_table border-0" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<th style="min-width: 80px;">time/min.</th>
<th style="min-width: 150px;">Activity</th>
<th style="min-width: 200px;">Language</th>
<th style="min-width: 200px;">Instructions</th>
<th style="min-width: 150px;">Materials</th>
</tr>
<tr>
<td>5</td>
<td>Greeting</td>
<td>Introductions</td>
<td></td>
<td></td>
</tr>
<tr>
<td>15</td>
<td>Create a name card</td>
<td>What's your name?Can you write your name?</td>
<td></td>
<td>Name batch</td>
</tr>
<!--tr>
<td></td>
<td></td>
<td></td>
<td></td>
</tr-->
<tr>
<td>10</td>
<td>Classroom English</td>
<td>Sit Down, Stand up, Back to your seats, I know!, Excuse me!, Quiet please</td>
<td>Listen and repeat commands with gestures</td>
<td></td>
</tr>
<tr>
<td>15</td>
<td>Alphabet and Phonics games</td>
<td>Alphabet and Phonics</td>
<td>Put the blocks in order.Hit the Phonic sound.</td>
<td>ABC Blocks
Phonics cards</td>
</tr>
<tr>
<td>10</td>
<td>Story-Time &amp; Sing</td>
<td>Book keywords
Song Lyrics</td>
<td>Listen to the story.
Repeat and perform keywords
Sing book song.</td>
<td>Story Book
Songs</td>
</tr>
<tr>
<td>7</td>
<td>Super Kids</td>
<td>Vocabulary</td>
<td>Integrate vocabulary into conversation</td>
<td>Super Kids Book</td>
</tr>
<tr>
<td>5</td>
<td>Goodbye</td>
<td>See you (day)!</td>
<td>Sing together
Say goodbye properly.</td>
<td>Goodbye Song</td>
</tr>
</tbody>
</table>
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
<div class="container"><div class="prvcy_margin"><h5>What books will the kids learn from?</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new"><p class="text-left">Accent Kids implements grammar and vocabulary from some of the highest rated books. Students learn to use both British and American English styles.</p>
            <ul>
                <li>Super Kids - Emphasizes listening and speaking skills through grammar dialogs.</li>
                <li>Oxford Reading Tree - Used in more than 130 countries around the world.</li>
            </ul>
<div class="text-center"><img src="{{ asset('images/inline_books.png') }}" alt="highest rated books"></div>
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
<div class="container"><div class="prvcy_margin"><h5>What is Project Based Learning (PBL)?</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">Project Based Learning (PBL) is a method in which students learn to investigate and respond to an authentic, engaging and complex question, problem, or challenge.</p>
<p class="text-left">Using science and technology PBL provides opportunities for students to be challenged, reflect, and create amazing works throughout the span of the school year.</p>


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
<div class="prvcy_margin"><h5>Accent Kids Learning Express Activities</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<div class="kids_activties">
                <div class="age_group five_to_six">
                    <h4><span>5 to 6 years</span><img src="{{ asset('images/animal1.png') }}" alt="bunny"></h4>
                    <div class="clearfix">
                        <aside><h5>WEEKDAYS</h5>
                            <ul>
                                <li>Puppet Shows</li>
                                <li>Art</li>
                                <li>Let’s Sing</li>
                                <li>ABCs</li>
                                <li>Story-Time</li>
                            </ul></aside>
                        <aside><h5>SATURDAYS</h5>
                            <ul>
                                <li>Dance Club</li>
                                <li>Sports</li>
                                <li>Art</li>
                                <li>Build It</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group six_to_seven">
                    <h4><span>6 to 7 years</span><img src="{{ asset('images/animal2.png') }}" alt="monkey"></h4>
                    <div class="clearfix">
                        <aside><h5>WEEKDAYS</h5>
                            <ul>
                                <li>Fun Phonics</li>
                                <li>Story-Time</li>
                                <li>Let’s Sing</li>
                                <li>Super Kids </li>
                                <li>Mini Sports</li>
                            </ul></aside>
                        <aside><h5>SATURDAYS</h5>
                            <ul>
                                <li>Dance Club</li>
                                <li>Sports</li>
                                <li>Art</li>
                                <li>Build It</li>
                                <li>Homework Club</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group seven_to_eight">
                    <h4><span>7 to 8 years</span><img src="{{ asset('images/animal7.png') }}" alt="giraffe"></h4>
                    <div class="clearfix">
                        <aside><h5>WEEKDAYS</h5>
                            <ul>
                                <li>Fun Phonics</li>
                                <li>Create Your Story</li>
                                <li>English Heroes</li>
                                <li>Super Kids </li>
                            </ul></aside>
                        <aside><h5>SATURDAYS</h5>
                            <ul>
                                <li>Dance Club</li>
                                <li>Sports</li>
                                <li>Art</li>
                                <li>Accent Tube</li>
                                <li>Homework Club</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group eight_to_nine">
                    <h4><span>8 to 9 years</span><img src="{{ asset('images/animal3.png') }}" alt="hippo"></h4>
                    <div class="clearfix">
                        <aside><h5>WEEKDAYS</h5>
                            <ul>
                                <li>Fun Phonics</li>
                                <li>Create Your Story</li>
                                <li>Super Kids &amp; Conversation</li>
                                <li>Writing</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>SATURDAYS</h5>
                            <ul>
                                <li>Dance Club</li>
                                <li>Sports</li>
                                <li>Accent Tube</li>
                                <li>Create Your Story</li>
                                <li>Homework Club</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group nine_to_ten">
                    <h4><span>9 to 10 years</span><img src="{{ asset('images/animal6.png') }}" alt="elephant"></h4>
                    <div class="clearfix">
                        <aside><h5>WEEKDAYS</h5>
                            <ul>
                                <li>Phonics &amp; Writing</li>
                                <li>My Research Project</li>
                                <li>English Heroes &amp; Storybook</li>
                                <li>Super Kids &amp; Conversation</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>SATURDAYS</h5>
                            <ul>
                                <li>My Comic</li>
                                <li>Sports</li>
                                <li>Accent Tube</li>
                                <li>Science</li>
                                <li>Evaluation</li>
                                <li>Homework Club</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group ten_to_eleven">
                    <h4><span>10 to 11 years</span><img src="{{ asset('images/animal4.png') }}" alt="lion"></h4>
                    <div class="clearfix">
                        <aside><h5>WEEKDAYS</h5>
                            <ul>
                                <li>Phonics &amp; Writing</li>
                                <li>Programming</li>
                                <li>English Heroes &amp; Storybook</li>
                                <li>Super Kids &amp; Conversation</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>SATURDAYS</h5>
                            <ul>
                                <li>Programming</li>
                                <li>Sports</li>
                                <li>Accent Tube</li>
                                <li>Science</li>
                                <li>Evaluation</li>
                                <li>Homework Club</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group eleven_to_twelve">
                    <h4><span>11 to 12 years</span><img src="{{ asset('images/animal5.png') }}" alt="alligator"></h4>
                    <div class="clearfix">
                        <aside><h5>WEEKDAYS</h5>
                            <ul>
                                <li>Phonics &amp; Writing</li>
                                <li>My Research Project</li>
                                <li>English Heroes &amp; Storybook</li>
                                <li>Super Kids &amp; Conversation</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>SATURDAYS</h5>
                            <ul>
                                <li>Programming</li>
                                <li>Sports</li>
                                <li>Accent Tube</li>
                                <li>Science</li>
                                <li>Evaluation</li>
                                <li>Homework Club</li>
                            </ul></aside>
                    </div>
                </div>
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
			
			<!--div class="row">
					<div class="col-12">
						<h4 class="sub_page_header"><img src="{{asset('images/aspire_small.png')}}">Kids <?php echo Lang::locale();?></h4>
					</div>
			</div-->
            <div class="aboutus_detail_box">
                <div class="business_sec_new">
                    <div class="row">
						<div class="col-12">
							
											<section class="global-services text-center"><img src="{{ asset('images/kids.png') }}" alt="kids" width="264"></section><section class="global-services">
<div class="container"><div class="prvcy_margin"><h5>Accentキッズとは？</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">Accentキッズの子ども達は、外国語で考えることを学習します。これはコミュニーケーションのためだけでなく、他文化への関心を深め、チームワークを通し協力していくことの利点を学ぶためです。</p>

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
<div class="container"><div class="prvcy_margin"><h5>Accentキッズの特徴は？</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">Accentキッズのプログラム：</p>

<ul>
	<li>自然な日常会話練習。</li>
	<li>スポーツ、アート、工作、プログラミングなどを通した実践学習。</li>
	<li>プロジェクトに基づいたカリキュラム。</li>
	<li>それぞれのお子さまに合わせたレッスンプラン。</li>
	<li>目標志向のアクティビティー。</li>
</ul>
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
<div class="container"><div class="prvcy_margin"><h5>なぜお子さまのためにAccentキッズを選ぶのか？</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left" accentキッズは、さまざまな現地文化および外国文化に簡単に触れられる環境に囲まれています。子ども達が先生やクラスメートと英語で会話しながら、探検や遊び、学習することができる安全で恵まれた環境です。="" 英語を練習するために、アウトドア活動や遠足を企画します。例えば：<="" p="">

</p><ul>
	<li>キッズパーティー</li>
	<li>スポーツイベント</li>
	<li>地元の博物館、文化イベント、サイエンスセンターへの遠足。</li>
	<li>海外旅行の機会</li>
</ul>
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
<div class="container"><div class="prvcy_margin"><h5>Accentキッズのカリキュラム</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">Accentキッズは子ども達が英語を日常生活に取り入れるため、身体活動、認知活動、社会活動を導入しています。

Accentキッズカリキュラムの基本：</p>

<ul>
	<li>スーパーキッズ、オックスフォード・リーディングツリーブックを使い、生徒に関連があり生徒が興味を持てる単語を学習。</li>
	<li>クラスメートとの会話では英語のみを使用。</li>
	<li>チームワークに重点を置いたPBL(問題に基づく学習)プロジェクト。</li>
</ul>
<div class="text-center"><img src="{{ asset('images/books.png') }}" alt="Kids Curriculum"></div>
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
<div class="container"><div class="prvcy_margin"><h5>Accentキッズのレッスンはどのように行われますか？</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">本校独自のAccentキッズレッスンプランは、英語での自然な日常会話スキルを最大限にするために組み立てられています。一般的な５０分のレッスンは下記の内容で構成されています。</p>

<ul>
	<li>あいさつと会話。</li>
	<li>アルファベットとフォニックス。</li>
	<li>本を読む＆歌。</li>
	<li>語彙を増やすための会話ブック。</li>
	<li>すでに学習した教材の復習。</li>
</ul>
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
<div class="container"><div class="prvcy_margin"><h5>レベル１— レッスンプラン♯１</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new tbl-layout">
<table class="coaching_pricing_table china-lang border-0" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                    <th class="txt-wrpng">時間/分</th>
                    <th style="min-width:200px;">アクティビティー</th>
                    <th style="min-width:200px;">言語</th>
                    <th style="min-width:200px;">指導</th>
                    <th style="min-width:150px;">教材</th>
                </tr>
                <tr>
                    <td>5</td>
                    <td>あいさつ</td>
                    <td>自己紹介</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>名前カードを作る</td>
                    <td>あなたの名前は何ですか？あなたの名前を書いてくれますか？</td>
                    <td>&nbsp;</td>
                    <td>ネームバッチ</td>
                </tr>
                <!--tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr-->
                <tr>
                    <td>10</td>
                    <td>教室で使う英語</td>
                    <td>座ってください、立ってください、席に戻ってください、知っています、すみません、静かにしてください。</td>
                    <td>身振りを伴って指示を聞き、繰り返す。</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>アルファベットとフォニックスゲーム</td>
                    <td>アルファベットとフォニックス</td>
                    <td>ブロックを順番に置く。フォニックスの音を押す。</td>
                    <td>ABCブロック、フォ <br>ニックスカード</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>本を読む&amp;歌</td>
                    <td>本に出てきたキーワード。<br>歌の歌詞。</td>
                    <td>お話を聞く。<br> キーワードを繰り返し発音する。<br>本の歌を歌う。</td>
                    <td>お話の本<br>歌</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>スーパーキッズ</td>
                    <td>単語</td>
                    <td>会話に単語を取り入れる。</td>
                    <td>スーパーキッズブック</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>さようなら</td>
                    <td>またね！</td>
                    <td>一緒に歌う。<br>語で正しくさようならを言う。</td>
                    <td>グッバイソング</td>
                </tr>
            </tbody></table>
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
<div class="container"><div class="prvcy_margin"><h5>どのような本を教材として使っていますか？</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">Accentキッズでは、高評価を得た教材を使用し、文法や単語を導入します。子ども達は、イギリス英語とアメリカ英語両方の使い方を学習します。</p>

<ul>
	<li>スーパーキッズ – 文法の対話を通してリスニングおよびスピーキング力を強化します。</li>
	<li>オックスフォードリーディングツリー – 世界１３０カ国で使用されています。</li>
</ul>
<div class="text-center"><img src="{{ asset('images/inline_books.png') }}" alt="highest rated books"></div>
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
<div class="container"><div class="prvcy_margin"><h5>問題に基づく学習(PBL)とは何ですか？</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<p class="text-left">問題に基づく学習(PBL)とは、生徒に関連し真に必要とされるような、複雑な質問・問題・挑戦に対して、調べて応答する力を養うための教育手法です。</p>
<p class="text-left">PBLは、科学とテクノロジーを利用して、生徒が挑戦し、能力を反映させ、素晴らしい実力を高める機会を学年を通して提供します。</p>

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
<div class="container"><div class="prvcy_margin"><h5>Accentキッズ・ラーニングエキスプレスの活動内容</h5></div>
<div class="row">
<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
<div class="desc_text_new">
<div class="kids_activties">
                <div class="age_group five_to_six">
                    <h4><span>５〜６歳</span><img src="{{ asset('images/animal1.png') }}" alt="bunny"></h4>
                    <div class="clearfix">
                        <aside><h5>月曜日から金曜日</h5>
                            <ul>
                                <li>人形劇</li>
                                <li>アート</li>
                                <li>歌いましょう</li>
                                <li>ABC</li>
                                <li>ストーリータイム</li>
                            </ul></aside>
                        <aside><h5>土曜日</h5>
                            <ul>
                                <li>ダンスクラブ</li>
                                <li>スポーツ</li>
                                <li>アート</li>
                                <li>組み立て</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group six_to_seven">
                    <h4><span>６〜７歳</span><img src="{{ asset('images/animal2.png') }}" alt="monkey"></h4>
                    <div class="clearfix">
                        <aside><h5>月曜日から金曜日</h5>
                            <ul>
                                <li>楽しいフォニックス</li>
                                <li>ストーリータイム</li>
                                <li>歌いましょう</li>
                                <li>スーパーキッズ </li>
                                <li>ミニスポーツ</li>
                            </ul></aside>
                        <aside><h5>土曜日</h5>
                            <ul>
                                <li>ダンスクラブ</li>
                                <li>スポーツ</li>
                                <li>アート</li>
                                <li>組み立て</li>
                                <li>宿題クラブ</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group seven_to_eight">
                    <h4><span>７〜８歳</span><img src="{{ asset('images/animal7.png') }}" alt="giraffe"></h4>
                    <div class="clearfix">
                        <aside><h5>月曜日から金曜日</h5>
                            <ul>
                                <li>楽しいフォニックス</li>
                                <li>自分でストーリーを作りましょう</li>
                                <li>イングリッシュヒーローズ</li>
                                <li>スーパーキッズ</li>
                            </ul></aside>
                        <aside><h5>土曜日</h5>
                            <ul>
                                <li>ダンスクラブ</li>
                                <li>スポーツ</li>
                                <li>アート</li>
                                <li>Accentチューブ</li>
                                <li>宿題クラブ</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group eight_to_nine">
                    <h4><span>８〜９歳</span><img src="{{ asset('images/animal3.png') }}" alt="hippo"></h4>
                    <div class="clearfix">
                        <aside><h5>月曜日から金曜日</h5>
                            <ul>
                                <li>楽しいフォニックス</li>
                                <li>自分でストーリーを作りましょう</li>
                                <li>スーパーキッズ&amp;会話</li>
                                <li>ライティング</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>土曜日</h5>
                            <ul>
                                <li>ダンスクラブ</li>
                                <li>スポーツ</li>
                                <li>Accentチューブ</li>
                                <li>自分でストーリーを作りましょう</li>
                                <li>宿題クラブ</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group nine_to_ten">
                    <h4><span>９〜１０歳</span><img src="{{ asset('images/animal6.png') }}" alt="elephant"></h4>
                    <div class="clearfix">
                        <aside><h5>月曜日から金曜日</h5>
                            <ul>
                                <li>フォニックス＆ライティング</li>
                                <li>私の研究プロジェクト</li>
                                <li>イングリッシュヒーローズ＆ストーリーブック</li>
                                <li>スーパーキッズ＆会話</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>土曜日</h5>
                            <ul>
                                <li>マイコミック</li>
                                <li>スポーツ</li>
                                <li>Accentチューブ</li>
                                <li>サイエンス</li>
                                <li>評価</li>
                                <li>宿題クラブ</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group ten_to_eleven">
                    <h4><span>１０〜１１歳</span><img src="{{ asset('images/animal4.png') }}" alt="lion"></h4>
                    <div class="clearfix">
                        <aside><h5>月曜日から金曜日</h5>
                            <ul>
                                <li>フォニックス＆ライティング</li>
                                <li>プログラミング</li>
                                <li>イングリッシュヒーローズ＆ストーリーブック</li>
                                <li>スーパーキッズ＆会話</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>土曜日</h5>
                            <ul>
                                <li>プログラミング</li>
                                <li>スポーツ</li>
                                <li>Accentチューブ</li>
                                <li>サイエンス</li>
                                <li>評価</li>
                                <li>宿題クラブ</li>
                            </ul></aside>
                    </div>
                </div>
                <div class="age_group eleven_to_twelve">
                    <h4><span>１１〜１２歳</span><img src="{{ asset('images/animal5.png') }}" alt="alligator"></h4>
                    <div class="clearfix">
                        <aside><h5>月曜日から金曜日</h5>
                            <ul>
                                <li>フォニックス＆ライティング</li>
                                <li>私の研究プロジェクト</li>
                                <li>イングリッシュヒーローズ＆ストーリーブック</li>
                                <li>スーパーキッズ＆会話</li>
                                <li>PBL</li>
                            </ul></aside>
                        <aside><h5>土曜日</h5>
                            <ul>
                                <li>プログラミング</li>
                                <li>スポーツ</li>
                                <li>Accentチューブ</li>
                                <li>サイエンス</li>
                                <li>評価</li>
                                <li>宿題クラブ</li>
                            </ul></aside>
                    </div>
                </div>
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
@push('script')

    <script type="text/javascript">
        //set content bottom padding
        $("#content").css("padding-bottom", $("footer").outerHeight()+'px');
        $("#content").css("padding-top", $("header").outerHeight()+'px');

        $(document).ready(function(){
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
            });
        });
    </script>

@endpush
@endsection
