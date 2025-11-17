<!DOCTYPE html>
<html lang="zxx">

@include('front.layouts.head')

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

@include('front.layouts.header')

    <div class="page-wrapper p-t-60 p-b-100 font-poppins" style="background-color: #f5f5f5;	margin-top: 78px;">
        <div class="">
            <div class="row" style="margin-right: 0px;">
        <div class="wrapper wrapper--w400">
             <div class="card" style="border: none; background-color: #f5f5f5;">
                <img src="{{ URL::to('front/img/login.webp') }}" alt="" width="280"
                height="250" style="margin: 0 auto">
                <h3 class="mt-3 mb-2" style="text-align: center;">Get Started. LOG IN!.</h3>
                {{-- <ul style="margin-left: 37px; margin-right: 20px;margin-bottom: 20px;
                margin-top: 10px; font-size: 18px;">
                    <li class="mb-2">
                        Up to 20 daily LIVE classes & more than 6,000 on-demand classes
                    </li>
                    <li class="mb-2">
                        Choose from a huge variety of workouts like Sculpt, Dance HIIT, Strength, Pilates, and Yoga.  Our instructors will TRULY get you results—and make it fun!
                    </li>
                </ul> --}}
            </div>
            </div>
            <div class="wrapper wrapper--w680">
            <div class="card card-4 ">
                <div class="card-body">
                    <h2 class="title">Sign In Now</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input class="input--style-4" type="email" required placeholder="Email" name="email">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input class="input--style-4" type="password" required placeholder="Password" name="password">
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="register-btnn mt-4">Login</button>
                        </div>
                        <div class="row row-space mt-4 pt-2">
                            <div class="col-md-12">
                                <span>Don`t have an account? <a href="{{ route('register') }}"> Sign Up </a></span>  <a href="{{ route('password.request') }}" style="float: right" class="forgot" bis_skin_checked="1">Forget Password?</a><br>
                                {{-- <a href="#">Forget your password?</a> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div></div></div>
    </div>


    @include('front.layouts.footer')
    @include('front.layouts.script')

</body>

</html>