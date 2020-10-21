<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<header>
    <div class="row">
        <div class="col-md-8 col-8 logo">
            <img src="{{ asset('images/OneCoinEnglishJapanese.png') }}" alt="logo">
            <label>One Coin English</label>
        </div>

        <div class="col-md-4 col-4 flag align-right">
            <div>
                <!-- <img src="{{ asset('images/OCEEnglishFlag.png') }}">
                
                <div class="dropdown language">
                    <button class="dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">
                        EN
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">EN</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JP</a></li>
                    </ul>
                </div> -->

                <!--img src="{{ asset('images/OCEEnglishFlag.png') }}">
                <label>English</label-->
				
				@if (Auth::guest())
					<div class="nav-wrapper">
						<div class="dropdown language">
							<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								@if(App::isLocale('en'))
									<i class="flag-icon flag-icon-us"></i> EN
								@else
									<i class="flag-icon flag-icon-jp"></i> JP
								@endif
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="{{ url('locale/en') }}"><i
											class="flag-icon flag-icon-us"></i> EN</a>
								<a class="dropdown-item" href="{{ url('locale/jp') }}"><i
											class="flag-icon flag-icon-jp"></i> JP</a>
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
										<i class="flag-icon flag-icon-jp"></i> JP
									@endif
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item" href="{{ url('locale/en') }}"><i
												class="flag-icon flag-icon-us"></i> EN</a>
									<a class="dropdown-item" href="{{ url('locale/jp') }}"><i
												class="flag-icon flag-icon-jp"></i> JP</a>
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

            
        </div>
    </div>
</header>