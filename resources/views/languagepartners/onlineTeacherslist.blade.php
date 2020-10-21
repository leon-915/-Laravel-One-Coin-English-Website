<style>
	#teacherlist .container {
	    max-width: 800px !important;
	}

	@media (max-width: 991px) {
		#teacherlist .container {
		    max-width: 100%;
		}
	}
</style>

<div class="container">
	<div class="top">
		<div class="row">
			<div class="col-6 left">
				<img src="{{ asset('images/list_lp/FilterIcon.png') }}" class="setting">
			</div>

			<div class="col-6 align-right right">
				<span>View</span>
				<div class="nav-wrapper">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <label>05</label>
                            <img src="{{ asset('images/list_lp/DownOn.png') }}">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">05</a>
                            <a class="dropdown-item" href="#">10</a>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>

	<div class="list-content accordion">
		<div class="list-cell collapsible-2">
			<div class="row">
				<div class="photo-column pr-0 align-center">
					<div class="photo">
						<img src="{{ asset('images/teacher_profile.png') }}">
					</div>

					<div class="stars">
						<i class="fas fa-star fill"></i>
						<i class="fas fa-star fill"></i>
						<i class="fas fa-star fill"></i>
						<i class="fas fa-star fill"></i>
						<i class="far fa-star"></i>
					</div>

					<div class="summary"><img src="{{ asset('images/list_lp/One-Coin-English-Japanese-NewButton.png') }}"></div>
				</div>

				<div class="right">
					<div class="row">
						<div class="left">
							<div class="availability">
								<span class="online"></span>
								<label>Availability</label>
							</div>

							<div class="space mt-7"></div>
							
							<div class="name">
								<i class="flag-icon flag-icon-us"></i>
								<span>Angela</span>
							</div>

							<div class="space mt-7"></div>

							<div class="teaches">
								<label>Teaches</label>	
								<label class="background-fill">Conversational</label>	
								<label class="background-fill">IT</label>	
								<label class="background-fill">Kids</label>	
								<label>English</label>	
							</div>

							<div class="space mt-7"></div>

							<div class="occupation">
								<label>Occupation</label>	
								<label class="background-fill">Project Manager</label>	
							</div>

							<div class="space mt-7"></div>

							<div class="speaks">
								<span>Speaks</span>
								<i class="flag-icon flag-icon-jp"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorInt.png') }}" class="level">
								<i class="flag-icon flag-icon-us"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorHigh.png') }}" class="level">
								<i class="flag-icon flag-icon-us"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorLow.png') }}"  class="level">
							</div>
						</div>

						<div class="right">
							<div class="table-cell favourite-column">
								<div class="favourite">
									<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Thumb-Off.png') }}">
									<span>Favourite</span>
								</div>

								<div class="space mt-15"></div>

								<div class="verified">
									<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Verified.png') }}">
									<span>Verified</span>
								</div>

								<div class="space mt-15"></div>

								<div class="teaches-beginners">
									<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LP-for-Beginner.png') }}">
									<span>Teaches Beginners</span>
								</div>
							</div>

							<div class="table-cell">
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Share.png') }}" class="share">
								<img src="{{ asset('images/list_lp/oce-j-speak-now.png') }}" class="speak-now">
								<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus plus-on">
								<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus plus-off">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="accordion-content">
			<div class="intro-with-audio">
				<div class="inner-content">
					<div class="row mb-20">
						<div class="col-6 align-center tab audio-tab active" onclick="openTab('audio_2')">Intro With Audio</div>

						<div class="col-6 align-center tab video-tab" onclick="openTab('video_2')">Video</div>
					</div>

					<div id="audio_2" class="tab-content audio-tab-content" style="display: none">
						<div class="row">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis laoreet pulvinar. Cras elementum erat eget felis ultrices, in pharetra sem fermentum. Sed semper nulla ac nulla ornare, lobortis blandit nulla suscipit. Vivamus ullamcorper posuere sapien sed consectetur. Nulla bibendum odio vitae egestas varius. Maecenas placerat, nisi nec tincidunt faucibus, velit risus sollicitudin eros, sit amet iaculis diam lorem a dui. Vestibulum eget lobortis ipsum, ac egestas risus. Nulla sit amet ex turpis. Nullam sed consectetur lorem, nec condimentum orci. Mauris a varius lectus. Praesent pretium dolor velit, at pretium felis bibendum vel. Fusce ornare nisi mattis placerat aliquam. Nam vitae dolor non metus interdum vestibulum. Etiam sed leo id nisl dignissim dignissim rutrum eu nibh. Etiam sed leo id nisl dignissim dignissim rutrum eu.</p>
						</div>

						<div class="row align-right audio-button">
							<span class="fas fa-volume-up"></span>
						</div>
					</div>

					<div id="video_2" class="tab-content video-tab-content hide align-center">
						<video controls>
							<source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
						</video>
					</div>
				</div>
			</div>
		</div>

		<div class="list-cell collapsible-2">
			<div class="row">
				<div class="photo-column pr-0 align-center">
					<div class="photo">
						<img src="{{ asset('images/teacher_profile.png') }}">
					</div>

					<div class="stars">
						<i class="fas fa-star fill"></i>
						<i class="fas fa-star fill"></i>
						<i class="fas fa-star fill"></i>
						<i class="fas fa-star fill"></i>
						<i class="far fa-star"></i>
					</div>

					<div class="summary">1,000 Lessons</div>
				</div>

				<div class="right">
					<div class="row">
						<div class="left">
							<div class="availability">
								<span class="offline"></span>
								<label>Availability</label>
							</div>

							<div class="space mt-7"></div>
							
							<div class="name">
								<i class="flag-icon flag-icon-us"></i>
								<span>Angela</span>
							</div>

							<div class="space mt-7"></div>

							<div class="teaches">
								<label>Teaches</label>	
								<label class="background-fill">Conversational</label>	
								<label class="background-fill">IT</label>	
								<label class="background-fill">Kids</label>	
								<label>English</label>	
							</div>

							<div class="space mt-7"></div>

							<div class="occupation">
								<label>Occupation</label>	
								<label class="background-fill">Project Manager</label>	
							</div>

							<div class="space mt-7"></div>

							<div class="speaks">
								<span>Speaks</span>
								<i class="flag-icon flag-icon-jp"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorInt.png') }}" class="level">
								<i class="flag-icon flag-icon-us"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorHigh.png') }}" class="level">
								<i class="flag-icon flag-icon-us"></i>
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-LevelIndicatorLow.png') }}"  class="level">
							</div>
						</div>

						<div class="right">
							<div class="table-cell favourite-column">
								<div class="favourite">
									<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Thumb-On.png') }}">
									<span>Favourite</span>
								</div>

								<div class="space mt-15"></div>

								<div class="verified">
									<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Verified.png') }}">
									<span>Verified</span>
								</div>

							</div>

							<div class="table-cell">
								<img src="{{ asset('images/list_lp/One-Coin-English-Japanes-Share.png') }}" class="share">
								<img src="{{ asset('images/list_lp/oce-j-speak-now.png') }}" class="speak-now">
								<img src="{{ asset('images/list_lp/AccordianPlusOff.png') }}" class="plus plus-off">
								<img src="{{ asset('images/list_lp/AccordianPlusOn.png') }}" class="plus plus-on">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="accordion-content">
			<div class="intro-with-audio">
				<div class="inner-content">
					<div class="row mb-20">
						<div class="col-6 align-center tab audio-tab" onclick="openTab('audio_1')">Intro With Audio</div>

						<div class="col-6 align-center tab video-tab" onclick="openTab('video_1')">Video</div>
					</div>

					<div id="audio_1" class="tab-content audio-tab-content">
						<div class="row">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis laoreet pulvinar. Cras elementum erat eget felis ultrices, in pharetra sem fermentum. Sed semper nulla ac nulla ornare, lobortis blandit nulla suscipit. Vivamus ullamcorper posuere sapien sed consectetur. Nulla bibendum odio vitae egestas varius. Maecenas placerat, nisi nec tincidunt faucibus, velit risus sollicitudin eros, sit amet iaculis diam lorem a dui. Vestibulum eget lobortis ipsum, ac egestas risus. Nulla sit amet ex turpis. Nullam sed consectetur lorem, nec condimentum orci. Mauris a varius lectus. Praesent pretium dolor velit, at pretium felis bibendum vel. Fusce ornare nisi mattis placerat aliquam. Nam vitae dolor non metus interdum vestibulum. Etiam sed leo id nisl dignissim dignissim rutrum eu nibh. Etiam sed leo id nisl dignissim dignissim rutrum eu.</p>
						</div>

						<div class="row align-right audio-button">
							<span class="fas fa-volume-up"></span>
						</div>
					</div>

					<div id="video_1" class="tab-content video-tab-content hide align-center">
						<video controls>
							<source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
						</video>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="more-btn align-center">
		<button>More...</button>
	</div>
</div>

<script>
	$(document).ready(function() {

		// Accordion
	    // var coll = document.getElementsByClassName("collapsible-2");
	    // var i;

	    // for (i = 0; i < coll.length; i++) {
	    //     coll[i].addEventListener("click", function() {
	           
	    //         // Blocking Audio Tab When Clicking Collapse
	    //         $("#teacherlist .accordion-content .tab-content").css("display", "none");
	    //         $("#teacherlist .accordion-content .audio-tab-content").css("display", "block");
	    //         $("#teacherlist .accordion-content .tab").removeClass("active");
	    //         $("#teacherlist .accordion-content .audio-tab").addClass("active");

	    //         if( (this.classList['value']).indexOf("active") >= 0 ) {
	    //             this.classList.remove("active");
	                
	    //             var content = this.nextElementSibling;
	    //             content.style.maxHeight = null;
	    //         } else {

	    //             for (var j = 0; j < coll.length; j++) {
	                
	    //                 coll[j].classList.remove("active");

	    //                 var content = coll[j].nextElementSibling;
	    //                 content.style.maxHeight = null;
	    //             }

	    //             this.classList.toggle("active");
	    //             var content = this.nextElementSibling;
	    //             content.style.maxHeight = content.scrollHeight + "px";
	    //         }

	    //     });
	    // }

	    // Collapsible
		$(".collapsible-2").on("click", function() {
        	if( $(this).hasClass("active") ) {
        		$(this).removeClass("active");

        		$(this).next().css("max-height", 0);
        	} else {
        		$(".collapsible-2").removeClass("active");
        		$("#teacherlist .accordion-content").css("max-height", 0);

        		$(this).addClass("active");
        		var height = $(this).next().prop("scrollHeight");
        		$(this).next().css("max-height", height);
        	}
        });

	    // Tab
		function openTab(tabName) {
			var i;
			var x = document.getElementsByClassName("tab-content");
			
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";  
			}
			
			document.getElementById(tabName).style.display = "block";  
		}

		$("#teacherlist .accordion-content .tab").on("click", function() {
			$("#teacherlist .accordion-content .tab").removeClass("active");
			$(this).addClass("active");
		})
	})

</script>
