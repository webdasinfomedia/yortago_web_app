{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="zxx">

@include('front.layouts.head')
<style>
    .text{
        position: relative;
    color: ##2b3248;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.8em;
    margin-top: -12px;
    margin-bottom: 10px;
    text-align: center;
    }
</style>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

@include('front.layouts.header')

    <div class="page-wrapper p-t-60 p-b-100 font-poppins" style="background-color: #f5f5f5;	margin-top: 78px;">
        <div class="">
            <div class="row" style="margin-right: 0px;">

            <div class="wrapper wrapper--w680">
            <div class="card card-4 ">
                <div class="card-body">
                    <h2 class="title">Forgot Password</h2>
                    @if (session('status'))
                    <div class="text text-success">{{ session('status') }} If you did not recieve email then Resend email</div>
                @else
                    <div class="text">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</div>
                @endif
                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div>
                            <button type="submit" class="register-btnn mt-4">
                                @if (session('status'))
                                Re Send Email
                            @else
                                Submit
                            @endif</button>
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

