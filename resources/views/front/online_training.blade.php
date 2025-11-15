@extends('front.layouts.landing')
@section('style')
    <style>
        .inner-banner {
            background: url({{ URL::to('front/landing/images/inner-pages-banner.png')}}) repeat-x;
            min-height: 280px;
        }

        .training-types em {
            background: url({{ URL::to('front/landing/images/curve4.png')}}) repeat-x;
            height: 51px;
            bottom: -51px;
        }

        .down em {
            background: url({{ URL::to('front/landing/images/curve3.jpg')}}) repeat-x;
            height: 50px;
        }
        .testimonials-slider img{
            max-height: 400px;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    @include('front.layouts.nav')
    <section class="inner-banner py-5 wow animated fadeInDown mb-4">
        <div class="container mb-5">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 text-black fw-medium py-5 wow animated fadeInDown text-uppercase">Online
                        Training</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="welcome pb-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-9 col-lg-10 col-md-11 px-xl-5">
                    <strong class="text-primary-y fs-4 ls-2 text-uppercase fw-medium wow animated fadeInDown">{{$online?->top_section_small_heading}}</strong>
                    <h2 class="fs-50 text-black fw-medium py-4 mb-2 mt-0 wow animated fadeInDown text-uppercase">{{$online?->top_section_large_heading}}</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="training-types pt-3 pb-5 position-relative z-1">
        <div class="container">
            <div class="row align-items-stretch">
                <div class="col-lg-6 pe-lg-4">
                    <div class="orange new radius p-4 wow animated slideInLeft mb-4 mt-1">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <img src="{{ URL::to($online?->left_card_image)}}" alt="Online" class="img-fluid my-2"/>
                            </div>
                            <div class="col-md-8 ps-lg-5">
                                <h3 class="text-uppercase fw-medium h3">{{$online?->left_card_heading}}</h3>
                                <p class="d-block py-2 lh-125 fs-20">{{$online?->left_card_description}}</p>
                                <a href="javascript:;" class="btn btn-secondary-y p-0 mt-2" onclick="window.location.href='https://booking.yortago.com/book-now'"><span
                                            class="py-2 px-4 text-dark">Sign Up</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pslg-4">
                    <div class="orange radius p-4 wow animated slideInRight mb-4 mt-1">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <img src="{{ URL::to($online?->right_card_image)}}" alt="Online"
                                     class="img-fluid my-2"/>
                            </div>
                            <div class="col-md-8 ps-lg-5">
                                <h3 class="text-uppercase fw-medium h3">{{$online?->right_card_heading}}</h3>
                                <p class="d-block py-2 lh-125 fs-20">{{$online?->right_card_description}}</p>
                                <a href="javascript:;" class="btn btn-secondary-y p-0 mt-2" onclick="window.location.href='https://booking.yortago.com/book-now'"><span
                                            class="py-2 px-4 text-dark">Sign Up</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/><br/>
        <em class="d-block position-absolute end-0 start-0"></em>
    </section>

    <section class="orange py-5 position-relative down">
        <div class="container py-5">
            <div class="row py-md-4">
                <div class="col-lg-6 my-4 pe-lg-5">
                    <div class="pelg-5">
                        <strong class="text-primary-y d-block fw-medium fs-20 wow animated slideInLeft text-uppercase ls-2">{{$online?->middle_section_small_heading}}</strong>
                        <h2 class="h1 fw-medium mb-0 text-black text-uppercase py-4 wow animated slideInLeft">{{$online?->middle_section_large_heading}}</h2>
                        <div class="position-relative wow animated slideInRight hide-desktop mb-5">
                            <div class="p-lg-5 p-4">
                                <div class="video-box position-relative">
                                    <a href="javascript:;"
                                       class="btn rounded-circle position-absolute top-50 start-50 translate-middle"
                                       data-bs-toggle="modal"  data-bs-target="#videoModal2"><i
                                                class="fa fa-play fa-2x"></i></a>
                                    <img src="{{ URL::to($online?->middle_section_left_big_image)}}" alt="Online"
                                         class="img-fluid v w-100"/>
                                    <img src="{{ URL::to($online?->middle_section_left_small_image)}}" alt="iPhone"
                                         class="img-fluid position-absolute mobile" width="280"/>

                                </div>
                            </div>
                            <br/><br/>
                        </div>
                        <p class="lh-150 text-black wow animated slideInLeft fs-20">
                            {!! preg_replace('/<p>/', '<p class="lh-150 text-black wow animated slideInRight fs-20">', preg_replace('/<\/?div>/', '', $online?->middle_section_description)) !!}
                        </p>
                        <div class="d-flex gap-2">
                            <a href="javascript:;" class="mt-4 wow animated slideInLeft"><img
                                        src="{{ URL::to('front/landing/images/playstore.png')}}" alt="Play Store"/></a>
                            <a href="javascript:;" class="mt-4 wow animated slideInLeft"><img
                                        src="{{ URL::to('front/landing/images/app-store.png')}}" alt="App Store"/></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 my-4 ps-lg-5">
                    <div class="position-relative wow animated slideInRight hide-mobile">
                        <div class="p-lg-5 p-4">
                            <div class="video-box position-relative">
                                <a href="javascript:;"
                                   class="btn rounded-circle position-absolute top-50 start-50 translate-middle"
                                   data-bs-toggle="modal" data-bs-target="#videoModal2"><i class="fa fa-play fa-2x"></i></a>
                                <img src="{{ URL::to($online?->middle_section_left_big_image)}}" alt="Online"
                                     class="img-fluid v w-100"/>
                                <img src="{{ URL::to($online?->middle_section_left_small_image)}}" alt="iPhone"
                                     class="img-fluid position-absolute mobile" width="280"/>

                            </div>
                        </div>
                        <br/><br/>
                    </div>
                </div>
            </div>
        </div>
        <br/><br/><br/>
        <em class="d-block position-absolute end-0 start-0"></em>
    </section>


    <section class="app pb-5 bg-white">
        <div class="container pb-5 mb-4">
            <div class="row justify-content-center text-center">
                <div class="col-12 mt-5">
                    <strong class="text-primary-y d-block fw-medium fs-4 wow animated fadeInDown text-uppercase ls-2">Features</strong>
                    <h2 class="h1 text-black fw-medium pt-4 mb-1 wow animated fadeInDown text-uppercase">What’s inside
                        the app</h2>
                </div>
            </div>
            <div class="row wow animated fadeInDown">
                <div class="col-12">
                    <div class="slider testimonials-slider px-0">
                        @foreach($onlineSlider as $slider)
                            <div class="app-box">
                                <img src="{{ URL::to($slider->image)}}" alt="App" class="img-fluid w-100"/>
                                <h3 class="h3 fw-medium text-uppercase px-lg-4 px-0">{{$slider->title}}</h3>
                                <p class="fs-20 d-block lh-125 px-lg-4 px-0 d-block">{{$slider->description}}</p>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faqs bg-white">
        <div class="container pb-5 mb-5">
            <div class="row justify-content-center text-center">
                <div class="col-12 mt-5">
                    <strong class="text-primary-y d-block fw-medium fs-20 wow animated fadeInDown text-uppercase ls-2">FAQS</strong>
                    <h2 class="h1 text-black fw-medium pt-4 my-1 wow animated fadeInDown text-uppercase">Some Common
                        Questions</h2>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="accordion" id="accordionExample">
                        @foreach($faqs as $faq)
                            <div class="accordion-item border-0 wow">
                                <h2 class="accordion-header">
                                    <button class="accordion-button shadow-none fs-4 text-black bg-transparent fw-medium collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_{{$faq->id}}"
                                            aria-expanded="false" aria-controls="collapseOne_{{$faq->id}}">
                                        {{$faq->faq_title}}
                                    </button>
                                </h2>
                                <div id="collapseOne_{{$faq->id}}" class="accordion-collapse collapse"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body p-4 border-0 orange radius my-4 fs-20">
                                        <p class="fs-20 lh-150 text-black">{{$faq->faq_description}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script>
        $('.testimonials-slider').slick({
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 3,
            dots: false,
            responsive: [
                {
                    breakpoint: 900,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '100px',
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 574,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '0',
                        dots: true,
                        slidesToShow: 1
                    }
                }
            ]
        });

        new WOW().init();
    </script>
@endsection