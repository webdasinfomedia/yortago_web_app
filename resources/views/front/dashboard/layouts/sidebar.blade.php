<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">

            @if (auth()->user()->user_type=="Stream")
            <li><a class="ai-icon" href="{{ route('dashboard') }}" aria-expanded="false">
                <i class="flaticon-381-networking"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

           <li><a class="ai-icon" href="{{ route('live.stream') }}" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Live Streaming</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('live.stream.recordings') }}" aria-expanded="false">
                    <i class="flaticon-381-list"></i>
                    <span class="nav-text">Training Videos</span>
                </a>
            </li>
            @else
            <li><a class="ai-icon" href="{{ route('online.training.all') }}" aria-expanded="false">
                <i class="la la-dumbbell"></i>
                <span class="nav-text">Online Training</span>
            </a>
        </li>
            <li><a class="ai-icon" href="{{ route('nutrition.all') }}" aria-expanded="false">
                <i class="flaticon-381-controls-3"></i>
                <span class="nav-text">Nutrition Program</span>
            </a>
        </li>
            @endif

            <li><a class="ai-icon" href="{{ route('profile') }}" aria-expanded="false">
                <i class="flaticon-381-settings-2"></i>
                <span class="nav-text">My Profile</span>
            </a>
        </li>



            <li><a href="javascript:;" onclick="document.getElementById('logout-form').submit()"  class="ai-icon" aria-expanded="false">
                    <i class="la la-sign-out"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
            <form id="logout-form" class="d-none" method="post" action="{{ route('logout') }}">@csrf</form>
        </ul>

    </div>
</div>
