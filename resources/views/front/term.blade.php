@extends('front.master')


@section('content')

<section class="breadcrumb-section set-bg" data-setbg="{{ URL::to('front/img/s1.jpg') }}">
    <div id="color-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>{{ $setting['term_title'] }}</h2>
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

            <div class="col-lg-12">
                <div class="about-text">
                    <h2>{{ $setting['term_title'] }}</h2>
                    <p class="first-para">{!! $setting['term_description']  !!}</p>


                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')


@endsection
