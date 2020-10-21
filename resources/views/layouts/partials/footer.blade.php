
	<?php if(!empty(Auth::id()) && (Auth::user()->user_type == 'teacher')) { ?>

<script>
var chat_appid = '53942';
var chat_auth = '16ac5390fca20dcbfc28aebc5effcc79';
</script>
 <script>
	var chat_id = "<?php echo Auth::id(); ?>";
	var chat_name = "<?php echo isset(Auth::user()->firstname) ? Auth::user()->firstname : Auth::user()->email; ?>"; 
	var chat_link = ""; 
	var chat_avatar = ""; 
	<?php 
	if(!empty(Auth::id()) && (Auth::user()->user_type == 'teacher')) { ?>
		var chat_role = "teacher"; 
	<?php 
	}/* else {
		if(!empty(Auth::id()) && Auth::id() == 363) { ?>
			var chat_role = "premium"; 
			<?php
		} else { ?>
			var chat_role = "basic"; 
			<?php 
		} 
	}*/ ?>
	var chat_friends = ''; // eg: 14,16,20 in case if friends feature is enabled.
	</script>

	<script>
	(function() {
		var chat_css = document.createElement('link'); 
		chat_css.rel = 'stylesheet'; 
		chat_css.type = 'text/css'; 
		chat_css.href = 'https://fast.cometondemand.net/'+chat_appid+'x_xchat.css';
		document.getElementsByTagName("head")[0].appendChild(chat_css);
		var chat_js = document.createElement('script'); chat_js.type = 'text/javascript'; 
		chat_js.src = 'https://fast.cometondemand.net/'+chat_appid+'x_xchat.js'; 
		var chat_script = document.getElementsByTagName('script')[0]; 
		chat_script.parentNode.insertBefore(chat_js, chat_script);
	})();
	
	</script>
	
<?php } ?>

<footer>
	<div class="social-icons">
		<a href="https://linkedin.com">
			<i class="fab fa-linkedin-in"></i>
		</a>
		<a href="https://instagram.com">
			<i class="fab fa-instagram"></i>
		</a>
		<a href="https://facebook.com">
			<i class="fab fa-facebook-f"></i>
		</a>
		<a href="https://twitter.com">
			<i class="fab fa-twitter"></i>
		</a>
		<a href="https://youtube.com">
			<i class="fab fa-youtube"></i>
		</a>
	</div>

	<nav>
		<ul>
			<li class="tab" onclick="openTab3('q_a');"><a>Q&A</a></li>
			<li class="tab" onclick="openTab3('company');"><a>Company</a></li>
			<li class="tab" onclick="openTab3('privacy_policy');"><a>Privacy Policy</a></li>
			<li class="tab" onclick="openTab3('terms_of_use');"><a>Terms of Use</a></li>
		</ul>
	</nav>

	<div class="container">
		<!--------------- Q&A ------------------>
		<div class="q-a accordion tab-content-3" id="q_a" style="display: none">
			<button class="collapsible">
				{{ __('qa.qa_Q1') }}
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			<div class="accordion-content">
				<p>{{ __('qa.qa_A1') }}</p>
			</div>
			<button class="collapsible">
				{{ __('qa.qa_Q2') }}
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			<div class="accordion-content">
				<p>{{ __('qa.qa_A2') }}</p>
			</div>
			<button class="collapsible">
				{{ __('qa.qa_Q3') }}
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			<div class="accordion-content">
				<p>{{ __('qa.qa_A3') }}</p>
			</div>
			<button class="collapsible">
				{{ __('qa.qa_Q4') }}
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			<div class="accordion-content">
				<p>{{ __('qa.qa_A4') }}</p>
			</div>
			<button class="collapsible">
				{{ __('qa.qa_Q5') }}
				<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
				<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
			</button>
			<div class="accordion-content">
				<p>{{ __('qa.qa_A5') }}</p>
			</div>
			<div id="show_more_qa" class="d-none">
				<button class="collapsible">
					{{ __('qa.qa_Q6') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A6') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q7') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A7') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q8') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A8') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q9') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p><?php echo __('qa.qa_A9');?></p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q10') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p><?php echo __('qa.qa_A10');?></p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q11') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A11') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q12') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A12') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q13') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A13') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q14') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A14') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q15') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A15') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q16') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A16') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q17') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A17') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q18') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A18') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q19') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A19') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q20') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A20') }}</p>
				</div>
				<button class="collapsible">
					{{ __('qa.qa_Q21') }}
					<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus-on">
					<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus-off">
				</button>
				<div class="accordion-content">
					<p>{{ __('qa.qa_A21') }}</p>
				</div>
			</div>

			<div id="qa_more" class="more-btn align-center">
				<button>More...</button>
			</div>
		</div>

		<script>
	        // Collapsible
			$(".collapsible").on("click", function() {
	        	if( $(this).hasClass("active") ) {
	        		$(this).removeClass("active");

	        		$(this).next().css("max-height", 0);
	        	} else {
	        		$(".collapsible").removeClass("active");
	        		$("footer .accordion-content").css("max-height", 0);

	        		$(this).addClass("active");
	        		var height = $(this).next().prop("scrollHeight");
	        		$(this).next().css("max-height", height);
	        	}
	        });
	    </script>
		
		<!-- ------------- End ---------------- -->

		<!-- ------------- Company ---------------- -->
		<div class="company tab-content-3" id="company" style="display: none">
			<div class="row table-row">
				<div class="title table-cell">company name</div>
				<div class="desc table-cell">lokalingo k.k.</div>
			</div>

			<div class="row table-row">
				<div class="title table-cell">description of business</div>
				<div class="desc table-cell">language education technology company</div>
			</div>

			<div class="row table-row">
				<div class="title table-cell">date founded</div>
				<div class="desc table-cell">september 19, 2017</div>
			</div>

			<div class="row table-row">
				<div class="title table-cell">capital</div>
				<div class="desc table-cell">3,000,000 jpy</div>
			</div>

			<div class="row table-row">
				<div class="title table-cell">location</div>
				<div class="desc table-cell">shibuyabashi A bldg. 5F, 1-15-16 hiroo, shibuya-ku, tokyo, 150-0012, japan</div>
			</div>

			<div class="row table-row">
				<div class="title table-cell">telephone</div>
				<div class="desc table-cell">+81 3 5422 8677</div>
			</div>
		</div>
		<!-- --------------- End ------------------ -->


		<!-- ---------- Privacy Policy ------------ -->
		<div class="privacy-policy tab-content-3" id="privacy_policy" style="display: none">
			<p>
				Privacy Policy
			</p>	
			<p>	
				Last updated: September 09, 2015 LokaLingo KK ('us', 'we', or 'our') operates the LokaLingo KK website (the 'Service').
			</p>	
			<p>	
				This page informs you of our policies regarding the collection, use and disclosure of Personal Information when you use our Service.
			</p>	
			<p>	
				We will not use or share your information with anyone except as described in this Privacy Policy.
			</p>	
			<p>	
				We use your Personal Information for providing and improving the Service. By using the Service, you agree to the collection and use of information in accordance with this policy. Unless otherwise defined in this Privacy Policy, terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, accessible at LokaLingo KK Information Collection And Use.
			</p>	
			<p>	
				While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information may include, but is not limited to, your email address, name, phone number, postal address ('Personal Information').
			<p>	
				Log Data
			</p>	
			<p>	
				We collect information that your browser sends whenever you visit our Service ('Log Data'). This Log Data may include information such as your computer's Internet Protocol ('IP') address, browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages and other statistics. In addition, we may use third party services such as Google Analytics that collect, monitor and analyze this type of information in order to increase our Service's functionality. These third party service providers have their own privacy policies addressing how they use such information.
			</p>	
			<p>	
				Cookies
			</p>	
			<p>	
				Cookies are files with a small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer's hard drive. We use 'cookies' to collect information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.
			</p>	
			<p>	
				DoubleClick Cookie
			</p>	
			<p>	
				Google, as a third party vendor, uses cookies to serve ads on our Service. Google's use of the DoubleClick cookie enables it and its partners to serve ads to our users based on their visit to our Service or other web sites on the Internet. You may opt out of the use of the DoubleClick Cookie for interest-­based advertising by visiting the Google Ads Settings web page.
			</p>	
			<p>	
				Behavioral Remarketing
			</p>	
			<p>	
				LokaLingo KK uses remarketing services to advertise on third party websites to you after you have visited our Service. We, and our third party vendors, use cookies to inform, optimize and serve ads based on your past visits to our Service.
			</p>	
			<p>	
				Google
			</p>	
			<p>	
				Google AdWords remarketing service is provided by Google Inc. You can opt out of Google Analytics for Display Advertising and customize the Google Display Network ads by visiting the Google Ads Settings page:http://www.google.com/settings/ads Google also recommends installing the Google Analytics Opt­out Browser Add­on ­https://tools.google.com/dlpage/gaoptout ­ for your web browser. Google Analytics Opt out Browser Add On provides visitors with the ability to prevent their data from being collected and used by Google Analytics. For more information on the privacy practices of Google, please visit the Google Privacy & Terms web page: Privacy Policy – Privacy & Terms
			</p>	
			<p>	
				Service Providers
			</p>	
			<p>	
				We may employ third party companies and individuals to facilitate our Service, to provide the Service on our behalf, to perform Service­-related services or to assist us in analyzing how our Service is used. These third parties have access to your Personal Information only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.
			</p>	
			<p>	
				Communications
			</p>	
			<p>	
				We may use your Personal Information to contact you with newsletters, marketing or promotional materials and other information that may be of interest to you. You may opt out of receiving any, or all, of these communications from us by following the unsubscribe link or instructions provided in any email we send
			</p>	
			<p>	
				Compliance With Laws
			</p>	
			<p>	
				We will disclose your Personal Information where required to do so by law or subpoena or if we believe that such action is necessary to comply with the law and the reasonable requests of law enforcement or to protect the security or integrity of our Service.
			</p>	
			<p>	
				Business Transaction
			</p>	
			<p>	
				If LokaLingo KK is involved in a merger, acquisition or asset sale, your Personal Information may be transferred. We will provide notice before your Personal Information is transferred and becomes subject to a different Privacy Policy.
			</p>	
			<p>	
				Security
			</p>	
			<p>	
				The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security.
			</p>	
			<p>	
				International Transfer
			</p>	
			<p>	
				Your information, including Personal Information, may be transferred to — and maintained on — computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from your jurisdiction.
				If you are located outside Japan and choose to provide information to us, please note that we transfer the information, including Personal Information, to Japan and process it there.
				Your consent to this Privacy Policy followed by your submission of such information represents your agreement to that transfer.
			</p>	
			<p>	
				Links To Other Sites
			</p>	
			<p>	
				Our Service may contain links to other sites that are not operated by us. If you click on a third party link, you will be directed to that third party's site. We strongly advise you to review the Privacy Policy of every site you visit. We have no control over, and assume no responsibility for the content, privacy policies or practices of any third party sites or services.
			</p>	
			<p>	
				Changes To This Privacy Policy
			</p>	
			<p>	
				We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page. You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.
			</p>	
			<p>	
				Contact Us
			</p>	
			<p>	
				If you have any questions about this Privacy Policy, please contact us.
			</p>
		</div>
		<!-- --------------- End ------------------ -->


		<!-- --------------- Term Of Use ------------------ -->
		<div class="term-of-use tab-content-3" id="terms_of_use" style="display: none">
			<p>
				Terms of Use
			</p>
			<p>
				1.Acceptance of Terms
			</p>
			<p>
				The services that LokaLingo KK provides to User is subject to the following Terms of Use ("TOU"). LokaLingo KK reserves the right to update the TOU at any time without notice to User. The most current version of the TOU can be reviewed by clicking on the "Terms of Use" hypertext link located at the bottom of our Web pages.
				<br>A.This Agreement, which incorporates by reference other provisions applicable to use of https://lokalingo.com/, including, but not limited to, supplemental terms and conditions set forth hereof ("Supplemental Terms") governing the use of certain specific material contained in https://lokalingo.com/, sets forth the terms and conditions that apply to use of https://lokalingo.com/ by User. By using LokaLingo KK (other than to read this Agreement for the first time), User agrees to comply with all of the terms and conditions hereof. The right to use https://lokalingo.com/ is personal to User and is not transferable to any other person or entity. User is responsible for all use of User's Account (under any screen name or password) and for ensuring that all use of User's Account complies fully with the provisions of this Agreement. User shall be responsible for protecting the confidentiality of User's password(s), if any.
				<br>B. This Agreement, which incorporates by reference other provisions applicable to use of https://lokalingo.com/, including, but not limited to, supplemental terms and conditions set forth hereof ("Supplemental Terms") governing the use of certain specific material contained in https://lokalingo.com/, sets forth the terms and conditions that apply to use of https://lokalingo.com/ by User. By using LokaLingo KK (other than to read this Agreement for the first time), User agrees to comply with all of the terms and conditions hereof. The right to use https://lokalingo.com/ is personal to User and is not transferable to any other person or entity. User is responsible for all use of User's Account (under any screen name or password) and for ensuring that all use of User's Account complies fully with the provisions of this Agreement. User shall be responsible for protecting the confidentiality of User's password(s), if any.
			</p>
			<p>
				2. Changed Terms
			</p>
			<p>
				LokaLingo KK shall have the right at any time to change or modify the terms and conditions applicable to User's use of https://lokalingo.com/, or any part thereof, or to impose new conditions, including, but not limited to, adding fees and charges for use. Such changes, modifications, additions or deletions shall be effective immediately upon notice thereof, which may be given by means including, but not limited to, posting on https://lokalingo.com/, or by electronic or conventional mail, or by any other means by which User obtains notice thereof. Any use of https://lokalingo.com/ by User after such notice shall be deemed to constitute acceptance by User of such changes, modifications or additions.
			</p>
			<p>	
				3. Description of Services
			</p>
			<p>	
				Through its Web property, LokaLingo KK provides User with access to a variety of resources, including download areas, communication forums and product information (collectively "Services"). The Services, including any updates, enhancements, new features, and/or the addition of any new Web properties, are subject to the TOU.
			</p>
			<p>	
				4. Equipment
			</p>
			<p>	
				User shall be responsible for obtaining and maintaining all telephone, computer hardware, software and other equipment needed for access to and use of https://lokalingo.com/ and all charges related thereto.
			</p>
			<p>	
				5. User Conduct
			</p>
			<p>	
				A. User shall use https://lokalingo.com/ for lawful purposes only. User shall not post or transmit through https://lokalingo.com/ any material which violates or infringes in any way upon the rights of others, which is unlawful, threatening, abusive, defamatory, invasive of privacy or publicity rights, vulgar, obscene, profane or otherwise objectionable, which encourages conduct that would constitute a criminal offense, give rise to civil liability or otherwise violate any law, or which, without LokaLingo KK 's express prior approval, contains advertising or any solicitation with respect to products or services. Any conduct by a User that in LokaLingo KK's discretion restricts or inhibits any other User from using or enjoying https://lokalingo.com/ will not be permitted. User shall not use https://lokalingo.com/ to advertise or perform any commercial solicitation, including, but not limited to, the solicitation of users to become subscribers of other on-line information services competitive with LokaLingo KK.
				<br>B. https://lokalingo.com/ contains copyrighted material, trademarks and other proprietary information, including, but not limited to, text, software, photos, video, graphics, music and sound, and the entire contents of https://lokalingo.com/ are copyrighted as a collective work under the Japanese copyright laws. LokaLingo KK owns a copyright in the selection, coordination, arrangement and enhancement of such content, as well as in the content original to it. User may not modify, publish, transmit, participate in the transfer or sale, create derivative works, or in any way exploit, any of the content, in whole or in part. User may download copyrighted material for User's personal use only. Except as otherwise expressly permitted under copyright law, no copying, redistribution, retransmission, publication or commercial exploitation of downloaded material will be permitted without the express permission of LokaLingo KKand the copyright owner. In the event of any permitted copying, redistribution or publication of copyrighted material, no changes in or deletion of author attribution, trademark legend or copyright notice shall be made. User acknowledges that it does not acquire any ownership rights by downloading copyrighted material.
				<br>C. User shall not upload, post or otherwise make available on https://lokalingo.com/ any material protected by copyright, trademark or other proprietary right without the express permission of the owner of the copyright, trademark or other proprietary right and the burden of determining that any material is not protected by copyright rests with User. User shall be solely liable for any damage resulting from any infringement of copyrights, proprietary rights, or any other harm resulting from such a submission. By submitting material to any public area of https://lokalingo.com/, User automatically grants, or warrants that the owner of such material has expressly granted LokaLingo KK the royalty-free, perpetual, irrevocable, non-exclusive right and license to use, reproduce, modify, adapt, publish, translate and distribute such material (in whole or in part) worldwide and/or to incorporate it in other works in any form, media or technology now known or hereafter developed for the full term of any copyright that may exist in such material. User also permits any other User to access, view, store or reproduce the material for that User's personal use. User hereby grants LokaLingo KKthe right to edit, copy, publish and distribute any material made available on https://lokalingo.com/ by User.
				<br>D. The foregoing provisions of Section 5 are for the benefit of LokaLingo KK, its subsidiaries, affiliates and its third party content providers and licensors and each shall have the right to assert and enforce such provisions directly or on its own behalf.
			</p>
			<p>	
				6. Use of Services
			</p>
			<p>	
				The Services may contain e-mail services, bulletin board services, chat areas, news groups, forums, communities, personal web pages, calendars, photo albums, file cabinets and/or other message or communication facilities designed to enable User to communicate with others (each a "Communication Service" and collectively "Communication Services"). User agrees to use the Communication Services only to post, send and receive messages and material that are proper and, when applicable, related to the particular Communication Service. By way of example, and not as a limitation, User agrees that when using the Communication Services, User will not:
				<br>Use the Communication Services in connection with surveys, contests, pyramid schemes, chain letters, junk email, spamming or any duplicative or unsolicited messages (commercial or otherwise).
				<br>Defame, abuse, harass, stalk, threaten or otherwise violate the legal rights (such as rights of privacy and publicity) of others.
				<br>Publish, post, upload, distribute or disseminate any inappropriate, profane, defamatory, obscene, indecent or unlawful topic, name, material or information. Upload, or otherwise make available, files that contain images, photographs, software or other material protected by intellectual property laws, including, by way of example, and not as limitation, copyright or trademark laws (or by rights of privacy or publicity) unless User own or control the rights thereto or have received all necessary consent to do the same.
				<br>Use any material or information, including images or photographs, which are made available through the Services in any manner that infringes any copyright, trademark, patent, trade secret, or other proprietary right of any party.
				<br>Upload files that contain viruses, Trojan horses, worms, time bombs, cancelbots, corrupted files, or any other similar software or programs that may damage the operation of another's computer or property of another.
				<br>Advertise or offer to sell or buy any goods or services for any business purpose, unless such Communication Services specifically allows such messages. Download any file posted by another user of a Communication Service that User know, or reasonably should know, cannot be legally reproduced, displayed, performed, and/or distributed in such manner.
				<br>Falsify or delete any copyright management information, such as author attributions, legal or other proper notices or proprietary designations or labels of the origin or source of software or other material contained in a file that is uploaded.
				<br>Restrict or inhibit any other user from using and enjoying the Communication Services.
				<br>Violate any code of conduct or other guidelines which may be applicable for any particular Communication Service.
				<br>Harvest or otherwise collect information about others, including e-mail addresses.
				<br>Violate any applicable laws or regulations.
				<br>Create a false identity for the purpose of misleading others.
				<br>Use, download or otherwise copy, or provide (whether or not for a fee) to a person or entity any directory of users of the Services or other user or usage information or any portion thereof.
				<br>LokaLingo KK has no obligation to monitor the Communication Services. However, LokaLingo KK reserves the right to review materials posted to the Communication Services and to remove any materials in its sole discretion. LokaLingo KK reserves the right to terminate User’s access to any or all of the Communication Services at any time, without notice, for any reason whatsoever. LokaLingo KK reserves the right at all times to disclose any information as it deems necessary to satisfy any applicable law, regulation, legal process or governmental request, or to edit, refuse to post or to remove any information or materials, in whole or in part, in LokaLingo KK's sole discretion.
				<br>Materials uploaded to the Communication Services may be subject to posted limitations on usage, reproduction and/or dissemination; User is responsible for adhering to such limitations if User downloads the materials.
				<br>Always use caution when giving out any personally identifiable information in any Communication Services. LokaLingo KK does not control or endorse the content, messages or information found in any Communication Services and, therefore, LokaLingo KK specifically disclaims any liability with regard to the Communication Services and any actions resulting from User’s participation in any Communication Services. Managers and hosts are not authorized LokaLingo KK spokespersons, and their views do not necessarily reflect those of LokaLingo KK.
			</p>
			<p>	
				7. Member Account, Password, and Security
			</p>
			<p>	
				If any of the Services requires User to open an account, User must complete the registration process by providing LokaLingo KK with current, complete and accurate information as prompted by the applicable registration form. User also will choose a password and a user name. User is entirely responsible for maintaining the confidentiality of User’s password and account. Furthermore, User is entirely responsible for any and all activities that occur under User’s account. User agrees to notify LokaLingo KK immediately of any unauthorized use of User’s account or any other breach of security. LokaLingo KK will not be liable for any loss that User may incur as a result of someone else using User’s password or account, either with or without User’s knowledge. However, User could be held liable for losses incurred by LokaLingo KK or another party due to someone else using User’s account or password. User may not use anyone else's account at any time, without the permission of the account holder.
			</p>
			<p>	
				8. Notice Specific to Software Available on this Website
			</p>
			<p>	
				Any software that is made available to download from the Services ("Software") is the copyrighted work of LokaLingo KK and/or its suppliers. Use of the Software is governed by the terms of the end user license agreement, if any, which accompanies or is included with the Software ("License Agreement"). An end user will be unable to install any Software that is accompanied by or includes a License Agreement, unless he or she first agrees to the License Agreement terms.
				<br>The Software is made available for download solely for use by end users according to the License Agreement. Any reproduction or redistribution of the Software not in accordance with the License Agreement is expressly prohibited by law, and may result in severe civil and criminal penalties. Violators will be prosecuted to the maximum extent possible.
				<br>WITHOUT LIMITING THE FOREGOING, COPYING OR REPRODUCTION OF THE SOFTWARE TO ANY OTHER SERVER OR LOCATION FOR FURTHER REPRODUCTION OR REDISTRIBUTION IS EXPRESSLY PROHIBITED, UNLESS SUCH REPRODUCTION OR REDISTRIBUTION IS EXPRESSLY PERMITTED BY THE LICENSE AGREEMENT ACCOMPANYING SUCH SOFTWARE. THE SOFTWARE IS WARRANTED, IF AT ALL, ONLY ACCORDING TO THE TERMS OF THE LICENSE AGREEMENT. EXCEPT AS WARRANTED IN THE LICENSE AGREEMENT, LokaLingo KK HEREBY DISCLAIMS ALL WARRANTIES AND CONDITIONS WITH REGARD TO THE SOFTWARE, INCLUDING ALL WARRANTIES AND CONDITIONS OF MERCHANTABILITY, WHETHER EXPRESS, IMPLIED OR STATUTORY, FITNESS FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT.
				<br>FOR YOUR CONVENIENCE, LokaLingo KK MAY MAKE AVAILABLE AS PART OF THE SERVICES OR IN ITS SOFTWARE PRODUCTS, TOOLS AND UTILITIES FOR USE AND/OR DOWNLOAD. LokaLingo KK DOES NOT MAKE ANY ASSURANCES WITH REGARD TO THE ACCURACY OF THE RESULTS OR OUTPUT THAT DERIVES FROM SUCH USE OF ANY SUCH TOOLS AND UTILITIES. PLEASE RESPECT THE INTELLECTUAL PROPERTY RIGHTS OF OTHERS WHEN USING THE TOOLS AND UTILITIES MADE AVAILABLE ON THE SERVICES.
			</p>
			<p>	
				9. Notice Specific to Documents Available on This Website
			</p>
			<p>	
				Permission to use Documents (such as white papers, press releases, datasheets and FAQs) from the Services is granted, provided that (1) the below copyright notice appears in all copies and that both the copyright notice and this permission notice appear, (2) use of such Documents from the Services is for informational and non-commercial or personal use only and will not be copied or posted on any network computer or broadcast in any media, and (3) no modifications of any Documents are made. Accredited educational institutions, such as universities, private/public colleges, and state community colleges, may download and reproduce the Documents for distribution in the classroom. Distribution outside the classroom requires express written permission. Use for any other purpose is expressly prohibited by law, and may result in severe civil and criminal penalties. Violators will be prosecuted to the maximum extent possible
				<br>LokaLingo KK AND/OR ITS RESPECTIVE SUPPLIERS MAKE NO REPRESENTATIONS ABOUT THE SUITABILITY OF THE INFORMATION CONTAINED IN THE DOCUMENTS AND RELATED GRAPHICS PUBLISHED AS PART OF THE SERVICES FOR ANY PURPOSE. ALL SUCH DOCUMENTS AND RELATED GRAPHICS ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY KIND. LokaLingo KK AND/OR ITS RESPECTIVE SUPPLIERS HEREBY DISCLAIM ALL WARRANTIES AND CONDITIONS WITH REGARD TO THIS INFORMATION, INCLUDING ALL WARRANTIES AND CONDITIONS OF MERCHANTABILITY, WHETHER EXPRESS, IMPLIED OR STATUTORY, FITNESS FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT. IN NO EVENT SHALL LokaLingo KK AND/OR ITS RESPECTIVE SUPPLIERS BE LIABLE FOR ANY SPECIAL, INDIRECT OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF INFORMATION AVAILABLE FROM THE SERVICES.
				<br>THE DOCUMENTS AND RELATED GRAPHICS PUBLISHED ON THE SERVICES COULD INCLUDE TECHNICAL INACCURACIES OR TYPOGRAPHICAL ERRORS. CHANGES ARE PERIODICALLY ADDED TO THE INFORMATION HEREIN. LokaLingo KK AND/OR ITS RESPECTIVE SUPPLIERS MAY MAKE IMPROVEMENTS AND/OR CHANGES IN THE PRODUCT(S) AND/OR THE PROGRAM(S) DESCRIBED HEREIN AT ANY TIME.
			</p>	
			<p>
				10. NOTICES REGARDING SOFTWARE, DOCUMENTS AND SERVICES AVAILABLE ON THIS SITE
			</p>	
			<p>
				IN NO EVENT SHALL LokaLingo KK AND/OR ITS RESPECTIVE SUPPLIERS BE LIABLE FOR ANY SPECIAL, INDIRECT OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF SOFTWARE, DOCUMENTS, PROVISION OF OR FAILURE TO PROVIDE SERVICES, OR INFORMATION AVAILABLE FROM THE SERVICES.
			</p>	
			<p>
				11. MATERIALS PROVIDED TO LokaLingo KK OR POSTED AT ANY OF ITS WEB SITES
			</p>	
			<p>
				LokaLingo KK does not claim ownership of the materials User provide to LokaLingo KK (including feedback and suggestions) or post, upload, input or submit to any Services or its associated services for review by the general public, or by the members of any public or private community, (each a "Submission" and collectively "Submissions"). However, by posting, uploading, inputting, providing or submitting ("Posting") User’s Submission User is granting LokaLingo KK, its affiliated companies and necessary sublicensees permission to use User’s Submission in connection with the operation of their Internet businesses (including, without limitation, all LokaLingo KK Services), including, without limitation, the license rights to: copy, distribute, transmit, publicly display, publicly perform, reproduce, edit, translate and reformat User’s Submission; to publish User’s name in connection with User’s Submission; and the right to sublicense such rights to any supplier of the Services.
				<br>No compensation will be paid with respect to the use of User’s Submission, as provided herein. LokaLingo KK is under no obligation to post or use any Submission User may provide and LokaLingo KK may remove any Submission at any time in its sole discretion. By Posting a Submission User warrants and represents to own or otherwise control all of the rights to User’s Submission as described in these Terms of Use including, without limitation, all the rights necessary for User to provide, post, upload, input or submit the Submissions.
				<br>In addition to the warranty and representation set forth above, by Posting a Submission that contain images, photographs, pictures or that are otherwise graphical in whole or in part ("Images"), User warrant and represent that (a) User is the copyright owner of such Images, or that the copyright owner of such Images has granted User permission to use such Images or any content and/or images contained in such Images consistent with the manner and purpose of User’s use and as otherwise permitted by these Terms of Use and the Services, (b) User have the rights necessary to grant the licenses and sublicenses described in these Terms of Use, and (c) that each person depicted in such Images, if any, has provided consent to the use of the Images as set forth in these Terms of Use, including, by way of example, and not as a limitation, the distribution, public display and reproduction of such Images. By Posting Images, User is granting (a) to all members of User’s private community (for each such Images available to members of such private community), and/or (b) to the general public (for each such Images available anywhere on the Services, other than a private community), permission to use User’s Images in connection with the use, as permitted by these Terms of Use, of any of the Services, (including, by way of example, and not as a limitation, making prints and gift items which include such Images), and including, without limitation, a non-exclusive, world-wide, royalty-free license to: copy, distribute, transmit, publicly display, publicly perform, reproduce, edit, translate and reformat User’s Images without having User’s name attached to such Images, and the right to sublicense such rights to any supplier of the Services. The licenses granted in the preceding sentences for a Images will terminate at the time User completely remove such Images from the Services, provided that, such termination shall not affect any licenses granted in connection with such Images prior to the time User completely remove such Images. No compensation will be paid with respect to the use of User’s Images.
			</p>
			<p>
				12. Disclaimer of Warranty; Limitation of Liability
			</p>
			<p>
				A. USER EXPRESSLY AGREES THAT USE OF https://lokalingo.com/ IS AT USER'S SOLE RISK. NEITHER LokaLingo KK, ITS AFFILIATES NOR ANY OF THEIR RESPECTIVE EMPLOYEES, AGENTS, THIRD PARTY CONTENT PROVIDERS OR LICENSORS WARRANT THAT https://lokalingo.com/ WILL BE UNINTERRUPTED OR ERROR FREE; NOR DO THEY MAKE ANY WARRANTY AS TO THE RESULTS THAT MAY BE OBTAINED FROM USE OF https://lokalingo.com/, OR AS TO THE ACCURACY, RELIABILITY OR CONTENT OF ANY INFORMATION, SERVICE, OR MERCHANDISE PROVIDED THROUGH https://lokalingo.com/
				<br>B. THIS DISCLAIMER OF LIABILITY APPLIES TO ANY DAMAGES OR INJURY CAUSED BY ANY FAILURE OF PERFORMANCE, ERROR, OMISSION, INTERRUPTION, DELETION, DEFECT, DELAY IN OPERATION OR TRANSMISSION, COMPUTER VIRUS, COMMUNICATION LINE FAILURE, THEFT OR DESTRUCTION OR UNAUTHORIZED ACCESS TO, ALTERATION OF, OR USE OF RECORD, WHETHER FOR BREACH OF CONTRACT, TORTIOUS BEHAVIOR, NEGLIGENCE, OR UNDER ANY OTHER CAUSE OF ACTION. USER SPECIFICALLY ACKNOWLEDGES THAT LokaLingo KK IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE OR ILLEGAL CONDUCT OF OTHER USERS OR THIRD-PARTIES AND THAT THE RISK OF INJURY FROM THE FOREGOING RESTS ENTIRELY WITH USER.
				<br>C. IN NO EVENT WILL LokaLingo KK, OR ANY PERSON OR ENTITY INVOLVED IN CREATING, PRODUCING OR DISTRIBUTING https://lokalingo.com/ OR THE LokaLingo KK SOFTWARE, BE LIABLE FOR ANY DAMAGES, INCLUDING, WITHOUT LIMITATION, DIRECT, INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL OR PUNITIVE DAMAGES ARISING OUT OF THE USE OF OR INABILITY TO USE https://lokalingo.com/. USER HEREBY ACKNOWLEDGES THAT THE PROVISIONS OF THIS SECTION SHALL APPLY TO ALL CONTENT ON THE SITE.
				<br>D. IN ADDITION TO THE TERMS SET FORTH ABOVE NEITHER, LokaLingo KK, NOR ITS AFFILIATES, INFORMATION PROVIDERS OR CONTENT PARTNERS SHALL BE LIABLE REGARDLESS OF THE CAUSE OR DURATION, FOR ANY ERRORS, INACCURACIES, OMISSIONS, OR OTHER DEFECTS IN, OR UNTIMELINESS OR UNAUTHENTICITY OF, THE INFORMATION CONTAINED WITHIN https://lokalingo.com/, OR FOR ANY DELAY OR INTERRUPTION IN THE TRANSMISSION THEREOF TO THE USER, OR FOR ANY CLAIMS OR LOSSES ARISING THEREFROM OR OCCASIONED THEREBY. NONE OF THE FOREGOING PARTIES SHALL BE LIABLE FOR ANY THIRD-PARTY CLAIMS OR LOSSES OF ANY NATURE, INCLUDING, BUT NOT LIMITED TO, LOST PROFITS, PUNITIVE OR CONSEQUENTIAL DAMAGES. F. PRIOR TO THE EXECUTION OF A STOCK TRADE, USERS ARE ADVISED TO CONSULT WITH YOUR BROKER OR OTHER FINANCIAL REPRESENTATIVE TO VERIFY PRICING OR OTHER INFORMATION. LokaLingo KK, ITS AFFILIATES, INFORMATION PROVIDERS OR CONTENT PARTNERS SHALL HAVE NO LIABILITY FOR INVESTMENT DECISIONS BASED ON THE INFORMATION PROVIDED. NEITHER, LokaLingo KK, NOR ITS AFFILIATES, INFORMATION PROVIDERS OR CONTENT PARTNERS WARRANT OR GUARANTEE THE TIMELINESS, SEQUENCE, ACCURACY OR COMPLETENESS OF THIS INFORMATION. ADDITIONALLY, THERE ARE NO WARRANTIES AS TO THE RESULTS OBTAINED FROM THE USE OF THE INFORMATION.
			</p>
			<p>
				13. LINKS TO THIRD PARTY SITES
			</p>
			<p>
				THE LINKS IN THIS AREA WILL LET YOU LEAVE LokaLingo KK'S SITE. THE LINKED SITES ARE NOT UNDER THE CONTROL OF LokaLingo KK AND LokaLingo KK IS NOT RESPONSIBLE FOR THE CONTENTS OF ANY LINKED SITE OR ANY LINK CONTAINED IN A LINKED SITE, OR ANY CHANGES OR UPDATES TO SUCH SITES. LokaLingo KK IS NOT RESPONSIBLE FOR WEBCASTING OR ANY OTHER FORM OF TRANSMISSION RECEIVED FROM ANY LINKED SITE. LokaLingo KK IS PROVIDING THESE LINKS TO YOU ONLY AS A CONVENIENCE, AND THE INCLUSION OF ANY LINK DOES NOT IMPLY ENDORSEMENT BY LokaLingo KK OF THE SITE.
				<br>LokaLingo KK is a distributor (and not a publisher) of content supplied by third parties and Users. Accordingly, LokaLingo KK has no more editorial control over such content than does a public library, bookstore, or newsstand. Any opinions, advice, statements, services, offers, or other information or content expressed or made available by third parties, including information providers, Users or any other user of https://lokalingo.com/, are those of the respective author(s) or distributor(s) and not of LokaLingo KK Neither LokaLingo KK nor any third-party provider of information guarantees the accuracy, completeness, or usefulness of any content, nor its merchantability or fitness for any particular purpose.
				<br>In many instances, the content available through https://lokalingo.com/ represents the opinions and judgments of the respective information provider, User, or other user not under contract with LokaLingo KK.  LokaLingo KK neither endorses nor is responsible for the accuracy or reliability of any opinion, advice or statement made on https://lokalingo.com/ by anyone other than authorized LokaLingo KK employee spokespersons while acting in their official capacities. Under no circumstances will LokaLingo KK be liable for any loss or damage caused by a User's reliance on information obtained through https://lokalingo.com/. It is the responsibility of User to evaluate the accuracy, completeness or usefulness of any information, opinion, advice or other content available through LokaLingo KK. Please seek the advice of professionals, as appropriate, regarding the evaluation of any specific information, opinion, advice or other content.
			</p>
			<p>
				14. UNSOLICITED IDEA SUBMISSION POLICY
			</p>
			<p>
				LokaLingo KK OR ANY OF ITS EMPLOYEES DO NOT ACCEPT OR CONSIDER UNSOLICITED IDEAS, INCLUDING IDEAS FOR NEW ADVERTISING CAMPAIGNS, NEW PROMOTIONS, NEW PRODUCTS OR TECHNOLOGIES, PROCESSES, MATERIALS, MARKETING PLANS OR NEW PRODUCT NAMES. PLEASE DO NOT SEND ANY ORIGINAL CREATIVE ARTWORK, SAMPLES, DEMOS, OR OTHER WORKS. THE SOLE PURPOSE OF THIS POLICY IS TO AVOID POTENTIAL MISUNDERSTANDINGS OR DISPUTES WHEN LokaLingo KK'S PRODUCTS OR MARKETING STRATEGIES MIGHT SEEM SIMILAR TO IDEAS SUBMITTED TO LokaLingo KK. SO, PLEASE DO NOT SEND YOUR UNSOLICITED IDEAS TO LokaLingo KK OR ANYONE AT LokaLingo KK. IF, DESPITE OUR REQUEST THAT YOU NOT SEND US YOUR IDEAS AND MATERIALS, YOU STILL SEND THEM, PLEASE UNDERSTAND THAT LokaLingo KK MAKES NO ASSURANCES THAT YOUR IDEAS AND MATERIALS WILL BE TREATED AS CONFIDENTIAL OR PROPRIETARY.
			</p>
			<p>
				15. Monitoring
			</p>
			<p>
				LokaLingo KK shall have the right, but not the obligation, to monitor the content of https://lokalingo.com/, including chat rooms and forums, to determine compliance with this Agreement and any operating rules established by LokaLingo KK and to satisfy any law, regulation or authorized government request. LokaLingo KK shall have the right in its sole discretion to edit, refuse to post or remove any material submitted to or posted on https://lokalingo.com/. Without limiting the foregoing, LokaLingo KK shall have the right to remove any material that LokaLingo KK, in its sole discretion, finds to be in violation of the provisions hereof or otherwise objectionable.
			</p>
			<p>
				16. Indemnification
			</p>
			<p>
				User agrees to defend, indemnify and hold harmless LokaLingo KK, its affiliates and their respective directors, officers, employees and agents from and against all claims and expenses, including attorneys' fees, arising out of the use of LokaLingo KK by User or User's Account.
			</p>
			<p>
				17. Termination
			</p>
			<p>
				Either LokaLingo KK or User may terminate this Agreement at any time. Without limiting the foregoing, LokaLingo KK shall have the right to immediately terminate User's Account in the event of any conduct by User which LokaLingo KK, in its sole discretion, considers to be unacceptable, or in the event of any breach by User of this Agreement.
			</p>
			<p>
				18. Miscellaneous
			</p>
			<p>
				This Agreement and any operating rules for https://lokalingo.com/ established by LokaLingo KK constitute the entire agreement of the parties with respect to the subject matter hereof, and supersede all previous written or oral agreements between the parties with respect to such subject matter. This Agreement shall be construed in accordance with the laws of the [STATE/PROVINCE, COUNTRY], without regard to its conflict of laws rules. No waiver by either party of any breach or default hereunder shall be deemed to be a waiver of any preceding or subsequent breach or default. The section headings used herein are for convenience only and shall not be given any legal import.
			</p>
			<p>	
				19. COPYRIGHT NOTICE
			</p>
			<p>	
				LokaLingo KK its logos are trademarks of LokaLingo KK Ltd. All rights reserved. All other trademarks appearing on LokaLingo KK are the property of their respective owners.
			</p>
			<p>	
				20. TRADEMARKS
			</p>
			<p>	
				The names of actual companies and products mentioned herein may be the trademarks of their respective owners. The example companies, organizations, products, domain names, email addresses, logos, people and events depicted herein are fictitious. No association with any real company, organization, product, domain name, e-mail address, logo, person, or event is intended or should be inferred. Any rights not expressly granted herein are reserved.
			</p>
		</div>
		<!-- --------------- End ------------------ -->
	</div>

	<script>
		// Tab
		function openTab3(tabName) {
			var i;
			var x = document.getElementsByClassName("tab-content-3");
			
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";  
			}
			
			document.getElementById(tabName).style.display = "block";  
		}

		$("footer .tab").on("click", function() {
			$("footer .tab").removeClass("active");
			$(this).addClass("active");
		});

			
	</script>

	


	<div class="language-change mt-30">
		@if (Auth::guest())
            <div class="nav-wrapper">
                <div class="dropdown language">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(App::isLocale('en'))
                            <i class="flag-icon flag-icon-us"></i> EN
                        @else
                            <i class="flag-icon flag-icon-jp"></i> 日本語
                        @endif
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ url('locale/en') }}"><i
                                    class="flag-icon flag-icon-us"></i> EN</a>
                        <a class="dropdown-item" href="{{ url('locale/jp') }}"><i
                                    class="flag-icon flag-icon-jp"></i> 日本語</a>
                    </div>
                </div>
            </div>
        @else
            @if (Auth::user()->user_type == 'student')
                <div class="nav-wrapper">
                    <div class="dropdown language">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(App::isLocale('en'))
                                <i class="flag-icon flag-icon-us"></i> EN
                            @else
                                <i class="flag-icon flag-icon-jp"></i> 日本語
                            @endif
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ url('locale/en') }}"><i
                                        class="flag-icon flag-icon-us"></i> EN</a>
                            <a class="dropdown-item" href="{{ url('locale/jp') }}"><i
                                        class="flag-icon flag-icon-jp"></i> 日本語</a>
                        </div>
                    </div>
                </div>
            @else
                <?php
                    Session::put('locale', 'en');
                ?>
            @endif
        @endif
        @if (!Auth::guest())
        <div class="toggle_menu">
                    
            <div class="toggle_nav_open">
                <ul>                                    
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }} </a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </ul>
            </div>
        </div>
        @endif
	</div>

	<div class="copyright">
		<p>Copyright © <?php echo date('Y');?> One Coin English produced by LokaLingo K.K. All rights reserved.</p>
	</div>
</footer>
<script>
$('#qa_more').click(function() {
	$('#show_more_qa').removeClass('d-none');
	$('#qa_more').addClass('d-none');
});
</script>