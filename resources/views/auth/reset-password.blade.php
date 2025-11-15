{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
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
                    <h2 class="title">Reset Password</h2>

                    <form method="post" action="{{ route('password.update') }}" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input class="input--style-4" type="email" value="{{ old('email', $request->email) }}" required placeholder="Email" name="email">
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
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input class="input--style-4" type="password" required placeholder="Confirm Password" name="password_confirmation" autocomplete="new-password">
                                    @error('password_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="register-btnn mt-4">
                                Reset Password
                            </button>
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

