
@extends('layouts.app',['title'=>'Aspire Coaching'])
@section('title', 'Aspire Coaching')
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
	
	<!--div class="aboutus_detail_box"-->
	<div class="asp-coach">
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>What is Aspire International Business Communication and Language Coaching?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspire Coaching enables the efficient transfer of knowledge and skills related to international business communication and language between the coach and the client with sustainable effects facilitated by:</p>
										<ul>
											<li>Brain-based coaching</li>
											<li>Coaching principles</li>
											<li>Neuroscience</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">This is achieved through ongoing sessions which include:</p>
										<ul>
											<li>The International Coaching Federation (ICF) principles and competencies</li>
											<li>Diagnostics/assessment and level testing</li>
											<li>Goal and action setting</li>
											<li>Coaching conversations</li>
											<li>Coaching tools</li>
										</ul>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspire Coaching is NOT:</p>
										<ul>
											<li>A training course just working through a text book</li>
											<li>A traditional teacher/student classroom relationship</li>
											<li>A branded course where you have to buy the books belonging to that particular brand</li>
											<li>Pure coaching about the client’s problems in life</li>
											<li>A psychological process like therapy or mentoring to make the client feel better</li>
											<li>A consultancy session</li>
											<li>Just a "come and have fun" session</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>What is the International Coaching Federation (ICF)?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">The International Coaching Federation (ICF) is an international organisation dedicated to professional coaching with over 25,000 members active in 126 countries. ICF campaigns worldwide for professional standards within the coaching profession. For more information please go to their official global website here: [ <a target="_blank" href="https://www.coachfederation.org/">https://www.coachfederation.org/</a>] The ICF Japan Chapter website is here: [ <a target="_blank" href="http://www.icfjapan.com/icf-japan/sample-page-2">http://www.icfjapan.com/icf-japan/sample-page-2</a>]</p>
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
							<div class="prvcy_margin"><h5>ICF Code of Ethics & Core Competencies</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">All coaches with ICF accredited training must strictly adhere to the ICF Code of Ethics while diligently applying the ICF core competencies, continually promoting and maintaining excellence in coaching. [ <a href="https://coachfederation.org/core-competencies/" target="_blank">https://coachfederation.org/core-competencies/</a>]</p>
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
							<div class="prvcy_margin"><h5>Why is coaching necessary for learning?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">For the coach to work closely with their clients, an ICF accredited course follows the ICF’s strict code of ethics to ensure a high level of privacy and confidentiality in building a trustworthy and supportive professional relationship between the coach and the client. The professional working relationship enables the coach to support the client during and after coaching sessions. See the difference in the illustrations below on how coaching can provide the supporting framework with cooperation from the client and sponsor or company which optimizes the learning and forgetting curves. </p>
										<p><img src="{{ asset('images/graph_1.png') }}" alt="accent_graph"></p>
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
							<div class="prvcy_margin"><h5>Courses at Aspire Coaching</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">At Aspire Coaching we have a variety of courses to suit various needs. From half to full day seminars, 60 or 90-minute sessions, once or twice a week at 3-month terms for as long as is needed to accomplish your aspirations. During reasonable business hours that suit both the coach and client, courses are held during weekdays, Monday to Friday. Seminars can be held either on weekdays or Saturdays. All courses are delivered at a location the client desires such as the company or at an Aspire lesson studio, online or on the telephone. Aspire Coaching recommends the Standard Course with a good balance of face to face 60-minute sessions and 10-15-minute telephone sessions over 5 business days, between Monday and Friday. A Standard Course is comprised of the following sessions:</p>
										<ul>
											<li>2x 60-minute face to face sessions.</li>
											<li>3x 10-15-minute telephone sessions.</li>
										</ul>
										<p>													
											<table class="coaching_session_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Mon.</th>
														<th>Tue.</th>
														<th>Wed.</th>
														<th>Thurs.</th>
														<th>Fri.</th>
														<th>Sat.</th>
														<th>Sun.</th>
													</tr>
													<tr>
														<td>10-15-min.</td>
														<td>60-min.</td>
														<td>10-15-min.</td>
														<td>60-min.</td>
														<td>10-15-min.</td>
														<td></td>
														<td></td>
													</tr>
												</tbody>
											</table>
										</p>
										<ul>
											<li>*Maximum session total of 165 minutes over 5 days.</li>
											<li>*Recommended to hold 60-minute sessions on alternate days.</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>What does a typical session comprise of at Aspire Coaching?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Throughout the session, the Aspire coach is mindful of applying the ICF competencies to enhance the learning process. A 60-minute session typically comprises of the following:</p>												
										<ul>													
											<li>Determining the concrete requirements to be fulfilled for that session.</li>
											<li>Identifying clear targets and strive for commitment.</li>
											<li>Continually engaging in coaching conversations to discover, work through and maintain realistic goals.</li>
											<li>Assisting the client in creating sustainable neural connections which lead to long term memory and hardwiring.</li>
											<li>Overcoming barriers, intrinsic or extrinsic, to build confidence and certainty during the learning journey.</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>Curriculums at Aspire Coaching</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspire offers 3 main types of curriculums which can also be combined over several course terms.</p>												
										<p class="text-left">1. International Business Communications Coaching. This curriculum focuses on understanding, breaking down and working with issues that foreign or Japanese C-level executives or personnel who carry similar responsibilities experience when engaging in business in Japan. Key Concepts: </p>												
										<ul>
											<li>Western and Japanese Cultural Values</li>
											<li>Sales and Negotiations</li>
											<li>Confidence in Job Interviews</li>
										</ul>
										
										<p class="text-left">2. Language Coaching. This curriculum is recommended for lower intermediate and above speakers of English who would like to take advantage of the enhanced efficiency and effectiveness that coaching can provide to improve their language proficiency in the following areas: </p>												
										<ul>
											<li>English Used at the Office</li>
											<li>English for Social Situations</li>
											<li>TOEIC • IELTS • TOEFL</li>
										</ul>
										
										<p class="text-left">3. Eloquence is a curriculum for intermediate to high level English speakers which focuses on being able to speak more articulately in social or business situations.Key Concepts: </p>	
										<ul>
											<li>Speaking With Confidence</li>
											<li>Creating Engaging Small Talk</li>
											<li>Making a Great First Impression</li>
											<li>Staying Calm in Conversation</li>
											<li>Powerful Phrases for Positive People</li>
											<li>Mindset</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>Course Comparison</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">													
											<table class="coaching_pricing_table feature_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>Feature</th>
														<th>Aspire Coaching</th>
														<th>Accent Business English</th>
													</tr>
													<tr>
														<td>ICF Certified Neuroscience Language Training</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>ICF Code of Ethics</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>ICF Confidentiality</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Non Disclosure Agreement</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>Coaching Insight:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>Coaching 5 Pillars</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>The Learning Journey</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>6 Insights into the Brain</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Brain's Organizing Principle</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>S.C.A.R.F.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Coaching Models:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>5C's of Language Coaching</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Results Coaching Conversation</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>3Ms</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>F.E.E.L.I.N.G.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>I.M.A.G.E.S.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Dance of Insight</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>C.R.E.A.T.E.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>P.R.O.G.R.E.S.S.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Systems &amp; Reporting:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>Accent OnePage System</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>Curriculum Customisation &amp; Reporting</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>English Teaching/Coaching Certification:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>TEFL</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>TESL</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>TESOL</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>ICF</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>English 5 Days a Week</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Session/Lesson Content Type:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>Business</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>TOEIC</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>TOEFL</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>IELTS</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>EIKEN</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>BULATS</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>Session/Lesson Locations:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>Company</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>Cafe</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>Learning Centre</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>Virtually</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>Session/Lesson Cancellation Policy</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>Flexible</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>Fixed</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>Group Classes</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
												</tbody>
											</table>
										</p>
										<p class="used_symbol"><img src="{{ asset('images/available.png') }}" alt="available"> - Available</p>
										<p class="used_symbol"><img src="{{ asset('images/possible.png') }}" alt="possible"> - Possible</p>
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
	<div class="asp-coach">
		<div class="business_sec_new">
			<div class="row">
				<div class="col-12">                            
					<section class="global-services">
						<div class="container">
							<div class="prvcy_margin"><h5>Aspire(アスパイヤ) 国際ビジネスコミュニケーションと英会話コーチング とは?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspireのコーチングでは、国際ビジネスコミュニケーションと英会話に関連した知識とスキルを、以下のアプローチを用いてコーチが受講者に効率的に指導し、その効果を長く持続させます。 </p>
										<ul>
											<li>脳科学的コーチング</li>
											<li>コーチング原理</li>
											<li>神経科学</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspireでは、以下の内容を活用しながら継続的にセッションを行います。 </p>
										<ul>
											<li>脳科学的コーチング</li>
											<li>コーチング原理</li>
											<li>神経科学</li>
										</ul>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspireのコーチングは次のようなものではありません。</p>
										<ul>
											<li>テキストを読むだけのトレーニングコース</li>
											<li>従来の学校の先生と生徒の関係</li>
											<li>自社製の教材を生徒に売り、それがないと受講ができないようなコース</li>
											<li>受講生の抱える生活上の問題に対処するだけのコーチング</li>
											<li>受講生の気持ちを楽にするだけの心理療法や教育指導</li>
											<li>コンサルタントによる相談と助言の場</li>
											<li>単に「集まって楽しむ」セッション</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>国際コーチ連盟 (ICF) とは?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">国際コーチ連盟 (ICF:International Coaching Federation) は、世界126か国で活躍するプロの指導者25,000人以上のための国際組織です。ICFは、コーチングという職業の領域で高い専門性を持った国際標準を作る活動を進めています。詳細については、公式グローバルウェブサイト ( <a target="_blank" href="https://www.coachfederation.org/">https://www.coachfederation.org/</a>) をご覧ください。ICFジャパンのウェブサイトは ( <a target="_blank" href="http://www.icfjapan.com/icf-japan/sample-page-2">http://www.icfjapan.com/icf-japan/sample-page-2</a> )です。</p>
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
							<div class="prvcy_margin"><h5>ICFの倫理規定とコアコンピテンシ―</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">ICF認定トレーニングを行うすべてのコーチは、ICFの倫理規定に厳格に従わなければならず、また、ICFの掲げるコアコンピテンシーを活用しながら、常に優秀な指導者としての資質を保ちまた高めるよう努めなければなりません。(<a href="https://coachfederation.org/core-competencies/" target="_blank">https://coachfederation.org/core-competencies/</a>)</p>
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
							<div class="prvcy_margin"><h5>なぜ学習にはコーチングが必要なのか?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">コーチが受講生を親身に指導する際に、ICF認定コースはICFの厳格な倫理規定に従います。それにより、プライバシーと個人情報を高度に保護しながら、コーチはプロ意識を持って受講生との間に信頼を形成し、プロフェッショナルなサポート関係を築いていきます。高いプロ意識に支えられた関係を保つことで、コーチは、コーチングのセッション中からその終了後も受講生をサポートすることができるのです。以下では、受講生とそのスポンサーや企業の協力を得て、学習曲線や忘却曲線を最適化しながら、コーチングによっていかに受講生をサポートする枠組みを提供できるかが図解されています。a〜cの図のように、学習の中で✖️の項目が網羅されていないと、記憶の定着が低く留まってしまいます。Aspireコーチングでは、右下の図dのように、トレーニングすべき全ての項目を網羅しているため、記憶の定着が格段に高くなっているのがわかります。</p>
										<p class="align-center"><img src="{{ asset('images/graph_1.png') }}" alt="accent_graph"></p>
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
							<div class="prvcy_margin"><h5>Aspireコーチングの各コース</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspireコーチングでは、さまざまなニーズに合わせて多様なコースをご用意しています。半日セミナー、一日セミナー、60分又は90分セッション、3か月間週1回または週2回コースなど、皆様の目標を達成するために必要なだけ続けることができます。 コーチと受講生の双方に相応しい無理のない時間帯を選び、月曜から金曜までの平日にコースが実施されます。各種セミナーは、平日または土曜日に開催できます。 どのコースも、例えば受講生の勤める会社、Aspireの学習センター、オンライン、また、電話など、受講生の皆様のご希望の場所で実施します。 Aspireコーチングがお奨めする標準コースは、月曜から金曜までの5日間にわたる、60分間の対面セッションと10-15分間の電話セッションをバランスよく取り入れています。標準コース一回分には、以下のセッションが含まれます。</p>
										<ul>
											<li>2回の60分対面セッション</li>
											<li>3回の10-15分電話セッション</li>
										</ul>
										<p>											
											<table class="coaching_session_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>月</th>
														<th>火</th>
														<th>水</th>
														<th>木</th>
														<th>金</th>
														<th>土</th>
														<th>日</th>
													</tr>
													<tr>
														<td>10-15-min.</td>
														<td>60-min.</td>
														<td>10-15-min.</td>
														<td>60-min.</td>
														<td>10-15-min.</td>
														<td></td>
														<td></td>
													</tr>
												</tbody>
											</table>
										</p>
										<ul>
											<li>*セッションの最大時間は5日間を通して合計165分です。</li>
											<li>*60分間のセッションは隔日実施をお奨めします。</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>Aspireのコーチングでは、通常セッションはどのように行われますか?</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">セッションを通じて、AspireのコーチはICFコンピテンシーを活用し、学習プロセスの効果を高めます。60分セッションは通常、次のように進みます。 </p>												
										<ul>	
											<li>そのセッションで達成されるべき具体的な目標を決定します。</li>
											<li>目標を明確化し、それを確実に果たすよう努力します。</li>
											<li>現実的な目標を見つけだし、取り組み、やり通すために、繰り返しコーチングカンバセーションを実施します。</li>
											<li>脳内で永続的な神経結合ができ、記憶が長期間定着するよう、受講生をサポートします。</li>
											<li>受講生の持つ内的および外的な障壁を克服し、学習の工程において自信と確信を醸成します。</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>Aspireコーチングのカリキュラム</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">Aspireは、主に3種類のカリキュラムをご用意していますが、これらはいくつかのコースの期間に渡って組み合わせることもできます。 </p>												
										<p class="text-left">1. 国際ビジネスコミュニケーション・コーチング。このカリキュラムは、日本国内や海外の経営幹部レベルの重役または同様の重責を担う従業員が、日本でビジネスに従事する際に出会うであろう諸問題への理解、分析と対処に重点を置きます。 重要な概念: </p>												
										<ul>
											<li>アメリカ人と日本人の文化的な価値観</li>
											<li>販売と交渉</li>
											<li>面接での自信</li>
										</ul>
										
										<p class="text-left">2. 英会話のコーチング。次の領域において効率的、効果的に英会話を習得したいと願う、初中級者及びそれ以上の方のためのカリキュラムです。  </p>												
										<ul>											
											<li>オフィスで使われる英会話</li>
											<li>社交の場で使われる英会話</li>
											<li>TOEIC・IELTS・TOEFL</li>
										</ul>
										
										<p class="text-left">3. エロクエントコーチングは、英会話の中級から上級者向けで、ビジネスおよび社交の場でより明瞭で効果的に対話する能力に重点を置きます。 重要な概念: </p>	
										<ul>											
											<li>自信にあふれた話し方をする</li>
											<li>心をつかむスモールトークを作る</li>
											<li>相手に強い第一印象を与える</li>
											<li>会話の間、心を穏やかに保つ</li>
											<li>力強いフレーズで相手を動かす</li>
											<li>インドセット</li>
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
						<div class="container">
							<div class="prvcy_margin"><h5>Course Comparison</h5></div>
							<div class="row">
								<div class="col-md-12 col-lg-12 wow bounceInUp" data-wow-duration="1.4s">
									<div class="desc_text_new">
										<p class="text-left">										
											<table class="coaching_pricing_table feature_table" width="100%" cellspacing="0" cellpadding="0" border="1">
												<tbody>
													<tr>
														<th>特長</th>
														<th>Aspireコーチング</th>
														<th>Accentビジネスイングリッシュ</th>
													</tr>
													<tr>
														<td>ICF神経科学語学トレーニング</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>ICF倫理綱領</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>ICF守秘義務</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>守秘義務契約</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>コーチングのインサイト:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>コーチングの5本柱</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>学習工程</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>脳の6つのインサイト</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>脳の組織化原則</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>S.C.A.R.F.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>コーチングメソッド:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>言語コーチングの5つの「C」</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>コーチングカンバセーションの結果</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>3つの「M」</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>F.E.E.L.I.N.G.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>I.M.A.G.E.S.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>Dance of Insight</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>C.R.E.A.T.E.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>P.R.O.G.R.E.S.S.</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>システム＆レポート:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>OnePageシステム</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>カスタマイズしたカリキュラムとレポート</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>英語教育/コーチング資格:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>TEFL</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>TESL</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>TESOL</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>ICF</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>週5日の英会話</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td></td>
													</tr>
													<tr>
														<td>セッション/レッスンの内容:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>ビジネス</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>TOEIC</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>TOEFL</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>IELTS</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>英検</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>BULATS</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>セッション/レッスン場所:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>会社</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>カフェ</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>学習センター: 恵比寿</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>オンライン</td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
														<td><img src="{{ asset('images/available.png') }}" alt="available"></td>
													</tr>
													<tr>
														<td>セッション/レッスンのキャンセル規定:</td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td>フレキシブル</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>固定</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
													<tr>
														<td>グループクラス</td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
														<td><img src="{{ asset('images/possible.png') }}" alt="possible"></td>
													</tr>
												</tbody>
											</table>

										</p>
										<p class="used_symbol"><img src="{{ asset('images/available.png') }}" alt="available">- 利用可能 </p>
										<p class="used_symbol"><img src="{{ asset('images/possible.png') }}" alt="possible"> - できなくはない</p>
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
