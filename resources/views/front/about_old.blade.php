@extends('front.master')


@section('content')

<section class="breadcrumb-section set-bg" data-setbg="{{ URL::to('front/img/s1.jpg') }}">
    <div id="color-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>About Us</h2>
                    <!-- <div class="breadcrumb-option">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>In Person</span>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-section spad" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-pic" style="margin-top: 100px;">
                    <img src="{{ URL::to($setting['about_image']) }}" alt="">
                    <a href="{{ $setting['about_url'] }}" class="play-btn video-popup">
                        <img src="{{ URL::to('front/img/play.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-text">
                    <!--<h2>{{ $setting['about_title'] }}</h2>-->
                    <p class="first-para">{!! $setting['about_description']  !!}</p>


                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')


@endsection