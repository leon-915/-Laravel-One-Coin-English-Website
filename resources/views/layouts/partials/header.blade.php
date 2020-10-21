<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<header>
    <div class="row">
        <div class="col-md-8 col-8 logo">

            <a href="{{ url('/') }}"><img src="{{ asset('images/OneCoinEnglishJapanese.png') }}" alt="logo"></a>
            <!-- <label>One Coin English</label> -->

        </div>

        <div class="col-md-4 col-4 flag align-right">
            <div>
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
                

                <div class="login">
					@if (Auth::guest())
						<a href="{{ url('/login') }}">Log in</a>
					@else
						<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }} </a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
					@endif
                </div>
            </div>

            
        </div>
    </div>

</header>