@extends('front.master')


@section('content')

<section class="breadcrumb-section set-bg" data-setbg="{{ asset($setting['in_person_page_banner'] ?? '') }}">
    <div id="color-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>In Person</h2>
                    <!-- <div class="breadcrumb-option">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>In Person</span>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Membership Section Begin -->
<section class="membership-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>APPLY BELOW!</h2>
                    <p class="mt-3">YOR Elite Performance Experience provides a unique opportunity to work directly with Darren. The Elite Performance Experience offers customized in season, off season, and year round training for professional, highly trained and aspiring individuals who are wanting to maximize their performance</p>
                </div>
            </div>
        </div>
        <div class="row"  style="margin: 0 auto; justify-content: center;">
            <div class="col-lg-12 flex">
                <h2 class="dotted"></h2>
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="font-size: 14px;">
                    <div class="card">
                    <span class="numberCircle set-bg" data-setbg="{{ URL::to('front/img/blog/blog-8.jpg') }}">
                        
                    </span>
                    <h3 style="text-align: center;">
                        ASSESS 
                    </h3>
                    <p class="mt-1" style="text-align: center;">Measure your progress</p> 
                </div></div>
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12"  style="font-size: 14px;">
                    <div class="card">
                    <span class="numberCircle set-bg" data-setbg="{{ URL::to('front/img/blog/blog-9.jpg') }}">
                        
                    </span>
                    <h3 style="text-align: center;">
                        TRAIN 
                    </h3>
                    <p class="mt-1" style="text-align: center;">Specialized and purposeful training </p> 
                </div></div>
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12"  style="font-size: 14px;">
                    <div class="card">
                    <span class="numberCircle set-bg" data-setbg="{{ URL::to('front/img/blog/blog-1.jpg') }}" style="margin-top: -9px;
    width: 229px;">
                       
                    </span>
                    <h3 style="text-align: center;">
                        PERFORM  
                    </h3>
                   <p class="mt-1" style="text-align: center;">Becoming performance ready</p> 
                </div></div>
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12"  style="font-size: 14px;">
                    <div class="card">
                        <span class="numberCircle set-bg" data-setbg="{{ URL::to('front/img/blog/blog-3.jpg') }}">
                        
                    </span>
                    <h3 style="text-align: center;">
                        REGENERATE
                    </h3>
                   <p class="mt-1" style="text-align: center;">The essence of optimal gains </p> 
                </div>  </div>

            </div>
        </div>
    </div>
</section>
<!-- Membership Section End -->

<!-- Banner Section Begin -->
<section class="banner-section set-bg" id="contact" data-setbg="{{ URL::to('front/img/banner-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="banner-text mb-3">
                    <h2>CONTACT US </h2>
                    <p>Apply by filling out the details below and we will respond at our earliest convenience .</p>

                    <form action="{{ route('contact.save') }}" class="register-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">First Name</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="last-name">Last Name</label>
                                <input type="text" id="last-name" name="last_name" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="email">Your email address</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="mobile">Mobile No*</label>
                                <input type="number" id="mobile" name="mobile_no" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="mobile">Message *</label>
                                <textarea type="text" id="mobile" name="message" required style="width: 100%"> </textarea>
                            </div>
                        </div>
                        <button type="submit" class="register-btn">Get Started</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ URL::to($setting['contact_form_person_image']) }}" class="ml-60" alt="">
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')


@endsection