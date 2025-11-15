<!DOCTYPE html>
<html lang="zxx">

@include('front.layouts.head')

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
@include('front.layouts.header')
<style>
    .h-4{
        margin-left: 63px;
        margin-top: -9px!important;
    }
    .p-1{
        padding-top: 31px!important;
    }
    @media only screen and (max-width: 479px){
        .h-4{
            margin-left: 59px;
    margin-top: -34px!important;
    font-size: 16px!important;
    }
    }
    .single-hero-item {
        height: 500px!important;
        margin-top: 78px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .sevices-wapper{
        background-size: cover;
        background-position: center;
    }
    .about-pic img {
      min-width: auto;
      max-height: 400px;
      margin: auto;
      display: block;
    }

</style>
    <!-- Header End -->

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
        @foreach ($sliders as $slider)
            <div class="single-hero-item set-bg" data-setbg="{{ URL::to($slider['image']) }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hero-text">
                                <h2>{{ $slider['heading'] }}</h2>
                                <h1>{{ $slider['sub_heading'] }}</h1>
                                <a href="{{ $slider['url'] }}" class="primary-btn">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </section>
    <!-- Hero End -->

        <!-- Feature Section Begin -->
        <section class="feature-section" id="services">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="sevices-wapper" style="background-image: url('{{ URL::to($setting['in_person_image']) }}')">
                            <div class="layer"></div>
                            <div class="services-content " >
                                <div class="intro-img">
                                    <img src="{{ URL::to('front/img/icon/chose-icon-3.png') }}" alt="" style="margin-top: 30px;">
                                </div>

                                <h3>In Person</h3>
                                <hr class="border-title-1">

                                <div class="actions">
                                    <p>The Elite Performance Experience offers athletes a unique and specialized environment to prime you for optimum performance. Inquire Now.</p>
                                    <a href="{{ route('in.person') }}">READ MORE</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sevices-wapper" style="background-image: url('{{ URL::to($setting['live_stream_image']) }}')">
                            <div class="layer"></div>
                            <div class="services-content" >
                                <div class="intro-img">
                                    <img src="{{ URL::to('front/img/icon/chose-icon-4.png') }}" alt="" style="margin-top: 30px;">
                                </div>
                                <h3>Live Streaming</h3>
                                <hr class="border-title-1">
                                <div class="actions">
                                    <p>20 minutes, no excuses, full body work out, 20TAGO is your only solution.  Sign Up.</p>
                                    <a href="{{ route('register') }}">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sevices-wapper" style="background-image: url('{{ URL::to($setting['online_training_image']) }}')">
                            <div class="layer"></div>
                            <div class="services-content" >
                                <div class="intro-img">
                                    <img src="{{ URL::to('front/img/icon/chose-icon-5.png') }}" alt="" style="margin-top: 30px;">
                                </div>
                                <h3>Online Training</h3>
                                <hr class="border-title-1">
                                <div class="actions">
                                    <p>Access the YORTAGO training system from anywhere in the world. Sign Up.</p>
                                    <a href="{{ route('online.training') }}">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Feature Section End -->

    <!-- About Section Begin -->
    <section class="about-section spad" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-pic">
                        <img src="{{ URL::to($setting['about_image']) }}" alt="">
                        <a href="{{ $setting['about_url'] }}" class="play-btn video-popup">
                            <img src="{{ URL::to('front/img/play.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-text">
                        <h2>{{ $setting['about_title'] }}</h2>
                        <p class="first-para"> {{ Str::limit(strip_tags($setting['about_description']), 150) }} </p>

                        <a href="{{route('about.us')}}" class="primary-btn about-btn">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Services Section Begin -->
    <section class="services-section" id="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="services-item bg-gray">
                        <img src="{{ URL::to('front/img/services/service-icon-1.png') }}" alt="">
                        <h4 class="h-4">SPEED & AGILITY</h4>
                        <p class="p-1">Be one step ahead of YOR competitors. Think smarter, react quicker and move faster.</p>
                        <!-- <a href="./live-streaming.html">READ MORE</a> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="services-pic">
                        <img src="{{ URL::to($setting['banner_one']) }}" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="services-item bg-gray">
                        <img src="{{ URL::to('front/img/services/service-icon-1.png') }}" alt="">
                        <h4 class="h-4">POWER & STRENGTH</h4>
                        <p class="p-1">Make YOR presence be known. Explode with force and become the strongest version of yourself.</p>
                        <!-- <a href="./in-person.html">READ MORE</a> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="services-pic">
                        <img src="{{ URL::to($setting['banner_two']) }}" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="services-item bg-gray">
                        <img src="{{ URL::to('front/img/services/service-icon-1.png') }}" alt="">
                        <h4 class="h-4">CONDITIONING & ENDURANCE</h4>
                        <p class="p-1">Outlast YOR opponent. Become the most resilient version of yourself.</p>
                        <!-- <a href="./online-training.html">READ MORE</a> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="services-pic">
                        <img src="{{ URL::to($setting['banner_three']) }}" alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Services Section End -->

        <!-- Newsletter Section Begin -->
        <section class="latest-blog-section spad" id="newsletter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Subscribe To Our Newsletter</h2>
                            <p class="mt-3">Subscribe to  our mailing list to receive updates on new arrivals, special offers and other discount information. </p>
                            <form action="{{ route('contact.news.letter') }}" method="POST">
                                @csrf
                            <div class="input-group">
                                    <input type="email" name="email" required class="form-control " placeholder="Enter your email" width="70%">
                                    <span class="input-group-btn">
                                    <button class="btn" type="submit">Subscribe</button>
                                    </span>
                                </div>
                            </form>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Newsletter Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial-section spad" id="testimonial" style="background: url({{ $setting['testimonial_image'] }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="testimonial-slider owl-carousel">
                        @foreach ($testimonials as $testimonial)
                        <div class="testimonial-item">
                            <div class="ti-pic">
                                <div class="quote">
                                    <img src="{{ URL::to('front/img/testimonial/quote-left.png') }}" alt="">
                                </div>
                            </div>
                            <p>{{ $testimonial['description'] }} </p>
                            <div class="ti-pic">
                                <img src="{{ URL::to($testimonial['image']) }}" alt="">

                            </div>
                            <div class="ti-author">
                                <h4>{{ $testimonial['author_name'] }}</h4>
                                <span>{{ $testimonial['author_designation'] }}</span>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

        <!-- Cta Section Begin -->
        <section class="cta-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cta-text">
                            <h3>GeT Started Today</h3>
                            <p>New student special  Sign up here to join our live streaming!</p>
                        </div>
                        <a href="{{ route('register') }}" class="primary-btn cta-btn">Sign Up Now</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Cta Section End -->

    <!-- Footer Section Begin -->

    @include('front.layouts.footer')
    <!-- Footer Section End -->

    <!-- Js Plugins -->
  @include('front.layouts.script')
</body>

</html>