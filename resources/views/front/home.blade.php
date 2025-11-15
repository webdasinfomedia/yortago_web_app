@extends('front.layouts.landing')
@section('style')
    <style>
        .main-banner {
            background: url({{ URL::to($home_page?->slider_image)}}) no-repeat center top;
            min-height: 792px;
            background-size: cover;
        }
        .main-banner em {
            background: url({{ URL::to('front/landing/images/curve.png')}}) repeat-x;
            height: 51px;
        }
        .newsletter {
            background: url({{ URL::to('front/landing/images/newsletter.jpg')}}) no-repeat center center;
            background-size: cover;
        }
        .client-box{
            height: 400px;
            overflow-y: scroll;
            scrollbar-width: none;
        }
        /* Optional: hide scrollbar in Webkit (Chrome, Edge, Safari) */
        .client-box::-webkit-scrollbar {
            width: 6px;
        }

        .client-box::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .client-box::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection
@section('content')
    <section class="main-banner position-relative wow animated fadeInDown">
            @include('front.layouts.nav')
        <div class="container position-relative z-1 b-text d-flex align-items-center">
            <div class="banner-text d-flex align-items-center h-100">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-7 col-md-9 text-white pe-xl-5">
                        <strong class="text-uppercase fs-20 fw-medium d-block py-4">{{$home_page?->slider_small_heading}}</strong>
                        <h1 class="display-4 fw-medium pb-4">{{$home_page?->slider_large_heading}}</h1>
                        <p class="d-block fs-20 lh-125">{{$home_page?->slider_short_description}}</p>
                    </div>
                    <div class="d-flex gap-3 align-items-center"  style="margin-top: 50px; margin-left: 10px;" role="search">
                    <a href="https://booking.yortago.com/book-now/" target="_blank" class="btn btn-primary-y py-2 px-4">Get Started Now</a>                    


                    </div>
                </div>
            </div>
        </div>
        <em class="d-block position-relative z-1 w-100"></em>
    </section>

    <section class="welcome py-5">
        <div class="container pt-4">
            <div class="row justify-content-center text-center">
                <div class="col-xl-9 col-lg-10 col-md-11 px-xl-5">
                    <strong class="text-primary-y fs-20 ls-2 text-uppercase fw-medium wow animated fadeInDown">{{$home_page?->page_heading_small}}</strong>
                    <h2 class="fs-50 text-black fw-medium py-4 my-2 wow animated fadeInDown">{{$home_page?->page_heading_large}}</h2>
                    <p class="lh-150 fs-20 text-black wow animated fadeInDown">{{$home_page?->page_heading_short_description}}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="same-sec position-relative z-1">
        <div class="container">
            <div class="row align-items-center overflow-hidden">
                <div class="col-lg-6 mb-4 order-lg-1 order-2">
                    <div class="position-relative wow animated slideInLeft hide-mobile">
                        <div class="orange-box position-absolute start-0 bottom-0 top-0"></div>
                        <div class="p-lg-5 p-4">
                            <div class="overflow-hidden video-box position-relative">
                                <a href="javascript:;"
                                   class="btn rounded-circle position-absolute top-50 start-50 translate-middle"
                                   data-bs-toggle="modal" data-bs-target="#videoModal"><i class="fa fa-play fa-2x"></i></a>
                                <img src="{{ URL::to($home_page?->section_1_image)}}" alt="In Person"
                                     class="img-fluid v w-100"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 order-lg-2 order-1">
                    <strong class="text-primary-y d-block fw-medium fs-20 wow animated slideInRight">01</strong>
                    <h2 class="h2 fw-medium mb-0 text-black text-uppercase py-4 wow animated slideInRight">{{$home_page?->section_1_heading}}</h2>
                    <div class="position-relative wow animated slideInLeft hide-desktop mb-4">
                        <div class="orange-box position-absolute start-0 bottom-0 top-0"></div>
                        <div class="p-lg-5 p-4">
                            <div class="overflow-hidden video-box position-relative">
                                <a href="javascript:;"
                                   class="btn rounded-circle position-absolute top-50 start-50 translate-middle"
                                   data-bs-toggle="modal" data-bs-target="#videoModal"><i class="fa fa-play fa-2x"></i></a>
                                <img src="{{ URL::to($home_page?->section_1_image)}}" alt="In Person"
                                     class="img-fluid v w-100"/>
                            </div>
                        </div>
                    </div>
                    <p class="lh-150 text-black wow animated slideInRight fs-20"> {!! preg_replace('/<p>/', '<p class="lh-150 text-black wow animated slideInRight fs-20">', preg_replace('/<\/?div>/', '', $home_page?->section_1_text)) !!}</p>
                    <div class="d-flex gap-3 align-items-center wow animated slideInRight">
                        <a href="javascript:;" onclick="window.open('https://booking.yortago.com/book-now', '_blank')" class="btn btn-primary-y px-4 mt-4">&nbsp; Contact Us &nbsp;</a>
                        <a href="{{route('in.person')}}" class="btn btn-secondary-y p-0 mt-4"><span class="px-4 py-2">&nbsp; Learn More &nbsp;</span></a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-2 overflow-hidden">
                <div class="col-lg-6 pe-lg-5">
                    <strong class="text-primary-y d-block fw-medium fs-20 wow animated slideInLeft">02</strong>
                    <h2 class="h2 fw-medium mb-0 text-black text-uppercase py-4 wow animated slideInLeft">{{$home_page?->section_2_heading}}</h2>
                    <div class="position-relative wow animated slideInRight hide-desktop mb-4">
                        <div class="orange-box position-absolute end-0 bottom-0 top-0"></div>
                        <div class="p-lg-5 p-4">
                            <div class="video-box position-relative">
                                <a href="javascript:;"
                                   class="btn rounded-circle position-absolute top-50 start-50 translate-middle"
                                   data-bs-toggle="modal" data-bs-target="#videoModal2"><i class="fa fa-play fa-2x"></i></a>
                                <img src="{{ URL::to($home_page?->section_1_image)}}" alt="Online"
                                     class="img-fluid v w-100"/>
                                <img src="{{ URL::to($home_page?->section_2_left_image)}}" alt="iPhone"
                                     class="img-fluid position-absolute mobile" width="280"/>
                            </div>
                        </div>
                        <br/><br/><br/><br/><br/>
                    </div>
                    <p class="lh-150 text-black wow animated slideInLeft pe-lg-5 fs-20">{!! preg_replace('/<p>/', '<p class="lh-150 text-black wow animated slideInRight fs-20">', preg_replace('/<\/?div>/', '', $home_page?->section_2_text)) !!}</p>
                    <div class="d-flex gap-3 align-items-center wow animated slideInLeft">
                        <a href="javascript:;" onclick="window.open('https://booking.yortago.com/book-now', '_blank')" class="btn btn-primary-y px-4 mt-4">&nbsp; Sign Up Now! &nbsp;</a>
                        <a href="{{route('online.training')}}" class="btn btn-secondary-y p-0 mt-4"><span class="px-4 py-2">&nbsp; Learn More &nbsp;</span></a>
                    </div>
                </div>
                <div class="col-lg-6 mb-4 ps-lg-5">
                    <div class="position-relative wow animated slideInRight hide-mobile">
                        <div class="orange-box position-absolute end-0 bottom-0 top-0"></div>
                        <div class="p-lg-5 p-4">
                            <div class="video-box position-relative">
                                <a href="javascript:;"
                                   class="btn rounded-circle position-absolute top-50 start-50 translate-middle"
                                   data-bs-toggle="modal" data-bs-target="#videoModal2"><i class="fa fa-play fa-2x"></i></a>
                                <img src="{{ URL::to($home_page?->section_1_image)}}" alt="Online"
                                     class="img-fluid v w-100"/>
                                <img src="{{ URL::to($home_page?->section_2_left_image)}}" alt="iPhone"
                                     class="img-fluid position-absolute mobile" width="280"/>
                            </div>
                        </div>
                        <br/><br/><br/><br/><br/>
                    </div>
                </div>
            </div>
        </div>
        <br/><br/><br/>
        <em class="d-block position-absolute end-0 start-0"></em>
    </section>

    <section class="testimonials pt-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-9 col-lg-10 col-md-11 px-xl-5">
                    <img src="{{ URL::to('front/landing/images/quote.png')}}" alt="Quote"
                         class="wow animated fadeInDown mt-5"/>
                    <h2 class="fs-50 text-black fw-medium pt-4 my-1 wow animated fadeInDown">What our Client Say About
                        Us</h2>
                </div>
            </div>
            <div class="row wow animated fadeInDown">
                <div class="col-12">
                    <div class="slider testimonials-slider px-0">
                        @foreach ($testimonials as $testimonial)
                            <div class="client-box text-center p-4 bg-white">
                                <img src="{{ URL::to($testimonial['image']) }}" alt="User"
                                     class="img-fluid rounded-circle mx-auto"/>
                                <p class="text-black lh-150 d-block pt-3">{{ $testimonial['description'] }} </p>
                                <strong class="d-block fw-bold pt-4 pb-2">{{ $testimonial['author_name'] }}</strong>
                                <span>{{ $testimonial['author_designation'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <br/><br/>
            <div class="newsletter rounded-5 text-white p-lg-5 p-4 overflow-hidden mt-5 wow animated fadeInUp position-relative z-1">
                <div class="row align-items-center position-relative z-1">
                    <div class="col-md-6 my-2 pe-lg-5">
                        <h3 class="display-5 fw-medium mb-3">Newsletter</h3>
                        <p class="d-block lh-150 fs-20">Subscribe to our mailing list to receive updates on new
                            arrivals, special offers and other discount information.</p>
                    </div>
                    <div class="col-md-6 my-2">
                        <form method="post" action="{{ route('contact.news.letter') }}">
                            @csrf
                            <input name="email" type="email" class="form-control rounded-pill py-2 px-4 fs-20 shadow-none text-white"
                                   placeholder="Email address . . . " required />
                            <button type="submit"
                                    class="btn btn-light text-primary-y fw-medium fs-20 text-uppercase px-4 rounded-pill mt-4">
                                &nbsp; Subscribe &nbsp;
                            </button>
                        </form>
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
            dots: true,
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
                        slidesToShow: 1
                    }
                }
            ]
        });

        new WOW().init();
    </script>
@endsection