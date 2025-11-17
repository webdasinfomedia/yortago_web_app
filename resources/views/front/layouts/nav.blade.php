{{--@if(Route::currentRouteName() == 'home')--}}
{{--<nav class="--}}

{{--navbar navbar-expand-lg bg-none py-4--}}

{{-- ">--}}

{{--    <a class="navbar-brand" href="{{route('home')}}"><img src="{{ URL::to('front/landing/images/logo.png')}}"--}}
{{--                                                   alt="Logo Yortago" class="img-fluid"/></a>--}}
{{--    <button class="navbar-toggler btn bg-white p-2" type="button" data-bs-toggle="collapse"--}}
{{--            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"--}}
{{--            aria-label="Toggle navigation">--}}
{{--        <i class="fa fa-bars"></i>--}}
{{--    </button>--}}
{{--    <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 ps-lg-4">--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link transition text-uppercase px-3 active" aria-current="page" href="{{route('home')}}">Home</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link transition text-uppercase px-3" href="{{route('in.person')}}">In Person</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link transition text-uppercase px-3" href="{{route('online.training')}}">Online</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link transition text-uppercase px-3" href="{{route('shop')}}">Shop</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link transition text-uppercase px-3" href="{{route('blog')}}">Blog</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <div class="d-flex gap-3 align-items-center" role="search">--}}
{{--            <a href="{{route('login')}}" class="btn btn-secondary-y p-0"><span class="py-2 px-4 text-white">Login</span></a>--}}
{{--            <a href="{{'sign.up'}}" class="btn btn-primary-y py-2 px-4">Register</a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}
{{--@else--}}
{{--    <nav class="navbar navbar-expand-lg bg-white inner-bar py-4 sticky-top wow animated fadeInDown">--}}
{{--        <div class="container">--}}
{{--            <a class="navbar-brand" href="{{route('home')}}"><img src="{{ URL::to('front/landing/images/logo-inner-pages.png')}}" alt="Logo Yortago" class="img-fluid" /></a>--}}
{{--            <button class="navbar-toggler btn bg-white p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--                <i class="fa fa-bars"></i>--}}
{{--            </button>--}}
{{--            <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 ps-lg-4">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link transition text-uppercase px-3" href="{{route('home')}}">Home</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link transition text-uppercase px-3 active" aria-current="page" href="{{route('in.person')}}">In Person</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link transition text-uppercase px-3" href="{{route('online.training')}}">Online</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link transition text-uppercase px-3" href="{{route('shop')}}">Shop</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link transition text-uppercase px-3" href="{{route('blog')}}">Blog</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--                <div class="d-flex gap-3 align-items-center" role="search">--}}
{{--                    <a href="{{route('login')}}" class="btn btn-secondary-y p-0"><span class="py-2 px-4 text-dark">Login</span></a>--}}
{{--                    <a href="{{'sign.up'}}" class="btn btn-primary-y py-2 px-4">Register</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </nav>--}}
{{--@endif--}}

<nav class="navbar navbar-expand-lg bg-white inner-bar py-4 sticky-top wow animated fadeInDown">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{ URL::to('front/landing/images/logo-inner-pages.png')}}" alt="Logo Yortago" class="img-fluid" /></a>
        <button class="navbar-toggler btn bg-white p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 ps-lg-4">
                <li class="nav-item">
                    <a class="nav-link transition text-uppercase px-3 {{Route::currentRouteName() == "home"?'active':''}}" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link transition text-uppercase px-3 {{Route::is('*person*')?'active':''}}" aria-current="page" href="{{route('in.person')}}">In Person</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link transition text-uppercase px-3 {{Route::is('*online*')?'active':''}}" href="{{route('online.training')}}">Online</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link transition text-uppercase px-3 " aria-current="page" href="https://booking.yortago.com/" target="_blank">Performance Training</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link transition text-uppercase px-3 {{Route::is('*shop*')?'active':''}}" href="{{route('shop')}}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link transition text-uppercase px-3 {{Route::is('*blog*')?'active':''}}" href="{{route('blog')}}">Blog</a>
                </li>
            </ul>
            <div class="d-flex gap-3 align-items-center" role="search">
{{--                <a href="javascript:;" class="btn btn-secondary-y p-0"><span class="py-2 px-4 text-dark">Login</span></a>--}}
                <a href="{{route('login')}}" class="btn btn-primary-y py-2 px-4">Login</a>
            </div>
        </div>
    </div>
</nav>