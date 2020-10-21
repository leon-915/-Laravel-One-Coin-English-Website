@extends('layouts.app',['title'=> __('labels.student_dashboard')])
@section('title', __('labels.student_dashboard'))
@section('content')
  
 	<style>
		header {
		    background: transparent;
		    margin-bottom: -90px;
		}	

		.banner {
    		padding: 130px 15px 40px;
    	}

    	.banner .desc .search, .search {
		    background: #0058B3;
		    padding: 5px 15px;
		    border-radius: 30px;
		    font-size: 16px;
    	}

    	.coming .inside {
		    background: white;
		    border-radius: 30px;
		    text-align: right;
		    padding: 0;
		    overflow: hidden;
		}

		.coming .inside a {
			float: left;
			width: 92px;
		}

		.coming .inside input {
			border: 0;
		    width: calc(100% - 92px);
		    float: left;
		    text-align: center;
		    background: transparent;
		    height: 34px;
		}

		@media (max-width: 767px) {
			.banner .desc .search, .search {
			    padding: 2px 15px;
			    font-size: 14px;
			}

			.coming .inside input {
			    height: 28px;
			    font-size: 14px;

			}
		}
	</style>

	<div class="banner">
		<div class="container">
			<div class="row">
	            <div class="col-12">
	                <div class="desc">
	                    <h2><?php echo __('labels.speak_english_to_your_language_learning_partner_now'); ?></h2>
	                    
	                    <p><?php echo __('labels.one_to_one_group'); ?></p>

	                    <div class="desc-item">
	                        <div>
	                            <img src="{{ asset('images/check-icon.png') }}">
	                        </div>
	                        <label><?php echo __('labels.get_instant_access'); ?></label>
	                    </div>

	                    <div class="space mt-15"></div>

	                    <div class="desc-item">
	                        <div>
	                            <img src="{{ asset('images/check-icon.png') }}">
	                        </div>
	                        <label><?php echo __('labels.improve_speaking'); ?></label>
	                    </div>

	                    <div class="space mt-15"></div>

	                    <div class="desc-item">
	                        <div>
	                            <img src="{{ asset('images/check-icon.png') }}">
	                        </div>
	                        <label><?php echo __('labels.in_a_safe_environment'); ?></label>
	                    </div>

	                    <div class="space mt-15"></div>
	                    
	                    <div class="coming outside">
	                        <div class="middle">
	                            <div class="inside">
	                            	<input type="text" name="" placeholder="Your Email">
	                                <a href="#">
										<button class="search">
											Sign Up
											<!-- <?php echo __('labels.search_for_my_language_partner'); ?> -->
										</button>
									</a>
	                            </div>
	                        </div>
	                    </div>
	                    
	                </div>  
	            </div>
	            
	        </div>	
		</div>
          

    </div>

	<div class="section section-1">
		<div class="container">
			<h2><?php echo __('labels.many_valuable_opportunities'); ?></h2>

			<div class="row">
				<div class="col-md-4">
					<img src="{{ asset('images/one-coin-english-japnese-work.png') }}">
					<h4><?php echo __('labels.poor_timing'); ?></h4>
					<p><?php echo __('labels.timing_determines'); ?></p>
				</div>

				<div class="col-md-4">
					<img src="{{ asset('images/one-coin-english-japnese-calendar.png') }}">
					<h4><?php echo __('labels.unpredictable_schedules'); ?></h4>
					<p><?php echo __('labels.as_a_busy_person_working'); ?></p>
				</div>

				<div class="col-md-4">
					<img src="{{ asset('images/one-coin-english-japnese-question.png') }}">
					<h4><?php echo __('labels.unreliable_assistance'); ?></h4>
					<p><?php echo __('labels.asking_your_coworkers'); ?></p>
				</div>
			</div>		
		</div>
	</div>

	<div class="section section-2">
		<div class="container">
			<h2><?php echo __('labels.we_are_ready_to_help'); ?></h2>

			<div class="table">
				<div class="table-row">
					<div class="table-cell">
						<img src="{{ asset('images/check-icon.png') }}">
					</div>

					<div class="table-cell">
						<p><?php echo __('labels.get_instant_access_to_many'); ?></p>
					</div>
				</div>

				<div class="mt-30"></div>

				<div class="table-row">
					<div class="table-cell">
						<img src="{{ asset('images/check-icon.png') }}">
					</div>

					<div class="table-cell">
						<p><?php echo __('labels.find_the_time'); ?></p>
					</div>
				</div>

				<div class="mt-30"></div>

				<div class="table-row">
					<div class="table-cell">
						<img src="{{ asset('images/check-icon.png') }}">
					</div>

					<div class="table-cell">
						<p><?php echo __('labels.select_from_reliable'); ?></p>
					</div>
				</div>

				<div class="mt-30"></div>	
			</div>
		</div>
	</div>

	<div class="section section-3">
		<div class="container">
			<h2><?php echo __('labels.it_is_safe'); ?></h2>

			<div class="row">
				<div class="col-md-4">
					<h4>1</h4>
					<p><?php echo __('labels.view_and_create_a_favourites_list'); ?></p>
				</div>

				<div class="col-md-4">
					<h4>2</h4>
					<p><?php echo __('labels.from_your_favourites_list'); ?></p>
				</div>

				<div class="col-md-4">
					<h4>3</h4>
					<p><?php echo __('labels.at_an_affordable_price'); ?></p>
				</div>
			</div>

			<div class="search-bar">
				<div class="coming outside">
		            <div class="middle">
		                <div class="inside">
		                	<input type="text" name="" placeholder="Your Email">
		                    <a href="#">
								<button class="search">
									Sign Up
									<!-- <?php echo __('labels.search_for_my_language_partner'); ?> -->
								</button>
								</a>
		                </div>
		            </div>
		        </div>	
			</div>
		</div>
	</div>

@endsection
