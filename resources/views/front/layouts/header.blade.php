<header class="header-section fixed-top">
    <div class="container">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ URL::to($setting['header_logo']) }}" alt="" width="190" height="70">
            </a>
        </div>
        <div class="nav-menu">
            <nav class="mainmenu mobile-menu">
                <ul>
                    <li class="{{  request()->routeIs('index') ||  request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}" class="">Home</a></li>
                    @if(\Request::route()->getName()=="home")
                    <li class="{{  request()->routeIs('about.us') ? 'active' : '' }}"><a href="{{ route('about.us') }}">About</a></li>
                    @else
                    <li class="{{  request()->routeIs('about.us') ? 'active' : '' }}"><a href="{{ route('about.us') }}">About</a></li>
                    @endif
                    <li  class="{{  request()->routeIs('online.training') ? 'active' : (request()->routeIs('in.person') ? 'active' : '') }}"><a href="{{ route('home') }}#services">Services</a>
                        <ul class="dropdown">
                            <li class="li-hover"><a href="{{ route('online.training') }}">Online Training</a></li>
                            <li class=""><a href="{{ route('in.person') }}">In Person</a></li>
                            @auth
                            <li class=""><a href="{{ route('dashboard') }}">Live Streaming</a></li>
                            @else

                            <li class=""><a href="{{ route('register') }}">Live Streaming</a></li>
                            @endauth
                        </ul>
                    </li>
                    {{-- <li><a href="{{ route('in.person') }}#contact">Contacts</a></li> --}}

                    @guest
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                    <li><a href="{{ route('sign.up') }}" class="primary-btn signup-btn">Sign Up Today</a></li>
                    @else
                    <li><a></a></li>
                    @if(auth()->user()->user_type!=="Stream")
                    <li><a href="{{ route('online.training.all') }}" class="primary-btn signup-btn">Dashborad</a></li>
                    @else
                    <li><a href="{{ route('dashboard') }}" class="primary-btn signup-btn">Dashborad</a></li>
                    @endif

                    @endguest

                </ul>
            </nav>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
