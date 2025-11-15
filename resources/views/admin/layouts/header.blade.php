<style>
/*   @media only screen and (max-width: 575px) {*/
/*    .nav-control {*/
        right: 0.5rem !important; /* Keep visible */
/*    }*/
/*}*/
</style>
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @yield('admin_title')
                    </div>
                </div>

                <ul class="navbar-nav header-right">


                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            @if(auth()->user())
                            <img 
                                src="{{ auth()->user()?->profile_pic ? url(str_replace('admin/', '', auth()->user()->profile_pic)) : asset('front/img/about-pic.jpg') }}" 
                                width="20" 
                                alt="User Profile Picture"
                            />




                            @else
                                <img src="{{ URL::to('front/img/about-pic.jpg') }}" width="20" alt=""/>
                            @endif

                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('admin.profile') }}" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18"
                                     height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ml-2">Profile </span>
                            </a>

                            <a href="javascript:;" onclick="document.getElementById('logout-form').submit()"
                               class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18"
                                     height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ml-2">Logout </span>
                            </a>
                            <form id="logout-form" class="d-none" method="post"
                                  action="{{ route('logout') }}">@csrf</form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
