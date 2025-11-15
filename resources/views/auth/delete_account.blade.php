@extends('front.layouts.landing')
@section('style')
    <style>
        .inner-banner {
            background: url({{ URL::to('front/landing/images/inner-pages-banner.png')}}) repeat-x;
            min-height: 280px;
        }
        
        /* <link rel="stylesheet" href="{{ URL::to('front/css/style.css') }}" type="text/css"> */
        
   
    /* Styles for the login wrapper and card */
    .wrapper--w680 {
        margin: auto;
        max-width: 500px;
        padding: 20px;
        /* background-color: #f9f9f9; */
        border-radius: 8px;
        /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
    }

    .card-4 {
        /* background-color: #ffffff; */
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        text-align: center;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input--style-4 {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.3s;
    }

    .input--style-4:focus {
        border-color: #a16eff;
    }

    .text-danger {
        font-size: 12px;
        color: #d9534f;
        margin-top: 5px;
        display: block;
    }

    .register-btnn {
        background-color: #a16eff;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .register-btnn:hover {
        background-color: #8c5be6;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .row-space {
        margin-bottom: 20px;
    }

    a {
        text-decoration: none;
        color: #a16eff;
        transition: color 0.3s;
    }

    a:hover {
        color: #8c5be6;
    }

    .forgot {
        font-size: 14px;
    }

    /* Ensure styles are scoped to this page */
    body > .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f1f1f1;
    }
</style>

@endsection

@section('content')

    @include('front.layouts.nav')

    
        <div class="">
        <div class="row" style="margin-right: 0px; padding: 20px;">
       
            <div class="wrapper wrapper--w680">
            <div class="card card-4 ">
                <div class="card-body">
                    <h2 class="title">Delete Account</h2>
                    <p class="text-danger">Enter your login details to delete your account</p>
                    <form method="POST" action="{{ route('delete_account') }}">
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
                            <button type="submit" class="register-btnn mt-4 btn-danger">Delete My Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div></div>
    </div>



@endsection
@include('front.layouts.script')
