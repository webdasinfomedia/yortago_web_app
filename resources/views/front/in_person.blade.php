@extends('front.layouts.landing')
@section('style')
    <style>
        .inner-banner {
            background: url({{ URL::to('front/landing/images/inner-pages-banner.png')}}) repeat-x;
            min-height: 280px;
        }
    </style>
@endsection

@section('content')

    @include('front.layouts.nav')

    <section class="inner-banner py-5 wow animated fadeInDown mb-5">
        <div class="container mb-5">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 text-black fw-medium py-5 wow animated fadeInDown text-uppercase">InPerson Training</h1>
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
                                <img src="{{ URL::to($in_person?->slider_image)}}" alt="In Person" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 order-lg-2 order-1">
                    <strong class="text-primary-y d-block fw-medium fs-20 wow animated slideInRight text-uppercase ls-2">{{$in_person?->slider_small_heading}}</strong>
                    <h2 class="fs-50 fw-medium mb-0 text-black text-uppercase py-4 wow animated slideInRight">{{$in_person?->slider_large_heading}}</h2>
                    <div class="position-relative wow animated slideInLeft hide-desktop mb-4">
                        <div class="orange-box position-absolute start-0 bottom-0 top-0"></div>
                        <div class="p-lg-5 p-4">
                            <div class="overflow-hidden video-box position-relative">
                                <img src="{{ URL::to($in_person?->slider_image)}}" alt="In Person" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                    <p class="lh-150 text-black wow animated slideInRight fs-20"{!! preg_replace('/<p>/', '<p class="lh-150 text-black wow animated slideInRight fs-20">', preg_replace('/<\/?div>/', '', $in_person?->slider_short_description)) !!}</p>
                    <a href="javascript:;" class="btn btn-primary-y px-4 mt-4 wow animated slideInRight">&nbsp; Contact Us &nbsp;</a>
                </div>
            </div>
            <div class="row align-items-stretch mt-5 overflow-hidden">
                <div class="col-lg-6 my-5">
                    <div class="form-box h-100 wow animated slideInLeft">
                        <h3 class="h3 fw-medium text-center">Apply Now</h3>
                        <p class="d-block text-center lh-125 py-2 fs-20">Apply by filling out the details below and we will respond at our earliest convenience .</p>
                        <form action="{{ route('contact.save') }}" class="register-form apply" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <input name="name" type="text" 
                                        class="form-control bg-transparent shadow-none fs-20 rounded-0 mt-4 ps-2 mb-2 @error('name') is-invalid @enderror" 
                                        placeholder="First name" value="{{ old('name') }}" />
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input name="last_name" type="text" 
                                        class="form-control bg-transparent shadow-none fs-20 rounded-0 mt-4 ps-2 mb-2 @error('last_name') is-invalid @enderror" 
                                        placeholder="Last name" value="{{ old('last_name') }}" />
                                    @error('last_name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <input name="email" type="email" 
                                        class="form-control bg-transparent shadow-none fs-20 rounded-0 mt-4 ps-2 mb-2 @error('email') is-invalid @enderror" 
                                        placeholder="Email" value="{{ old('email') }}" />
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <input name="mobile_no" type="text" 
                                        class="form-control bg-transparent shadow-none fs-20 rounded-0 mt-4 ps-2 mb-2 @error('mobile_no') is-invalid @enderror" 
                                        placeholder="Phone" value="{{ old('mobile_no') }}" />
                                    @error('mobile_no')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <textarea name="message" 
                                            class="form-control bg-transparent shadow-none fs-20 rounded-0 mt-4 ps-2 mb-2 @error('message') is-invalid @enderror" 
                                            placeholder="Message" rows="3">{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary-y py-2 px-4">Get Started</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="position-relative wow animated slideInRight h-100">
                        <div class="p-lg-5 pb-lg-4 p-4 h-100">
                            <div class="video-box position-relative h-100">
                                <a href="javascript:;" class="btn rounded-circle position-absolute top-50 start-50 translate-middle" data-bs-toggle="modal" data-bs-target="#videoModal2"><i class="fa fa-play fa-2x"></i></a>
                                <img src="{{ URL::to($in_person?->form_right_image)}}" alt="In Person Video" class="img-fluid v w-100 h-100 object-fit-cover" />
                            </div>
                        </div>
                        <br /><br /><br /><br /><br />
                    </div>InPerson Training
                </div>
            </div>
        </div>
        <br /><br /><br />
        <em class="d-block position-absolute end-0 start-0 new"></em>
    </section>


    <section class="py-5 new-sec mt-4">
        <div class="welcome">
            <div class="container pt-5">
                <div class="row justify-content-center text-center">
                    <div class="col-12">
                        <strong class="text-primary-y fs-20 ls-2 text-uppercase fw-medium wow animated fadeInDown">{{$in_person?->benefits_small_heading}}</strong>
                        <h2 class="fs-50 text-black fw-medium py-4 my-2 wow animated fadeInDown">{{$in_person?->benefits_large_heading}}</h2>
                        <p class="lh-150 fs-20 text-black wow animated fadeInDown">{{$in_person?->benefits_short_description}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center overflow-hidden">
                <div class="col-lg-6 mb-4 order-lg-1 order-2">
                    <div class="position-relative wow animated slideInLeft hide-mobile">
                        <div class="p-lg-5 p-1 pb-lg-4">
                            <div class="overflow-hidden video-box position-relative">
                                <img src="{{ URL::to($in_person?->benefits_1_image)}}" alt="Testing" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 order-lg-2 order-1">
                    <strong class="text-primary-y d-block fw-medium fs-20 wow animated slideInRight text-uppercase ls-2">{{$in_person?->benefits_1_heading}}</strong>
                    <h2 class="fs-1 fw-medium mb-0 text-black text-uppercase py-4 wow animated slideInRight">{{$in_person?->benefits_1_large_heading}}</h2>
                    <div class="position-relative wow animated slideInLeft hide-desktop mb-4">
                        <div class="p-lg-5 p-1 pb-lg-4">
                            <div class="overflow-hidden video-box position-relative">
                                <img src="{{ URL::to($in_person?->benefits_1_image)}}" alt="Testing" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                    <p class="lh-125 text-black wow animated slideInRight fs-20">{!! preg_replace('/<p>/', '<p class="lh-150 text-black wow animated slideInRight fs-20">', preg_replace('/<\/?div>/', '', $in_person?->benefits_1_short_description)) !!}</p>
                </div>
            </div>
            <div class="row align-items-center overflow-hidden">
                <div class="col-lg-6 ps-lg-5 order-lg-1 order-1">
                    <strong class="text-primary-y d-block fw-medium fs-20 wow animated slideInLeft text-uppercase ls-2">{{$in_person?->benefits_2_heading}}</strong>
                    <h2 class="fs-1 fw-medium mb-0 text-black text-uppercase py-4 wow animated slideInLeft">{{$in_person?->benefits_2_large_heading}}</h2>
                    <div class="position-relative wow animated slideInRight hide-desktop mb-4">
                        <div class="p-lg-5 p-1 pb-lg-4">
                            <div class="overflow-hidden video-box position-relative">
                                <img src="{{ URL::to($in_person?->benefits_2_image)}}" alt="Training" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                    <p class="lh-125 text-black wow animated slideInLeft fs-20">{!! preg_replace('/<p>/', '<p class="lh-150 text-black wow animated slideInRight fs-20">', preg_replace('/<\/?div>/', '', $in_person?->benefits_2_short_description)) !!}</p>
                </div>
                <div class="col-lg-6 mb-4 order-lg-2 order-1">
                    <div class="position-relative wow animated slideInRight hide-mobile">
                        <div class="p-lg-5 p-1 pb-lg-4">
                            <div class="overflow-hidden video-box position-relative">
                                <img src="{{ URL::to($in_person?->benefits_2_image)}}" alt="Training" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center overflow-hidden">
                <div class="col-lg-6 mb-4 order-lg-1 order-2">
                    <div class="position-relative wow animated slideInLeft hide-mobile">
                        <div class="p-lg-5 p-1 pb-lg-4">
                            <div class="overflow-hidden video-box position-relative">
                                <img src="{{ URL::to($in_person?->benefits_3_image)}}" alt="Regeneration" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 order-lg-2 order-1">
                    <strong class="text-primary-y d-block fw-medium fs-20 wow animated slideInRight text-uppercase ls-2">{{$in_person?->benefits_3_heading}}</strong>
                    <h2 class="fs-1 fw-medium mb-0 text-black text-uppercase py-4 wow animated slideInRight">{{$in_person?->benefits_3_large_heading}}</h2>
                    <div class="position-relative wow animated slideInLeft hide-desktop mb-4">
                        <div class="p-lg-5 p-1 pb-lg-4">
                            <div class="overflow-hidden video-box position-relative">
                                <img src="{{ URL::to($in_person?->benefits_3_image)}}" alt="Regeneration" class="img-fluid v w-100" />
                            </div>
                        </div>
                    </div>
                    
                    <p class="lh-125 text-black wow animated slideInRight fs-20">{!! preg_replace('/<p>/', '<p class="lh-150 text-black wow animated slideInRight fs-20">', preg_replace('/<\/?div>/', '', $in_person?->benefits_3_short_description)) !!}</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.register-form');
        const inputs = form.querySelectorAll('input, textarea');

        // Add event listeners to validate fields on input
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                validateField(input);
            });
        });

        form.addEventListener('submit', function (e) {
            let isValid = true;

            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });

        function validateField(input) {
            const name = input.name;
            const value = input.value.trim();
            let errorMessage = '';

            // Validation rules
            if (name === 'name' && !value) {
                errorMessage = 'First name is required.';
            } else if (name === 'last_name' && !value) {
                errorMessage = 'Last name is required.';
            } else if (name === 'email' && !validateEmail(value)) {
                errorMessage = 'Enter a valid email address.';
            } else if (name === 'mobile_no' && (!value || !/^\d{10}$/.test(value))) {
                errorMessage = 'Enter a valid 10-digit phone number.';
            } else if (name === 'message' && !value) {
                errorMessage = 'Message is required.';
            }

            // Show or hide error message
            const errorElement = input.nextElementSibling;
            if (errorMessage) {
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.textContent = errorMessage;
                } else {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message text-danger small mt-1';
                    errorDiv.textContent = errorMessage;
                    input.insertAdjacentElement('afterend', errorDiv);
                }
                input.classList.add('is-invalid');
                return false;
            } else {
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.remove();
                }
                input.classList.remove('is-invalid');
                return true;
            }
        }

        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
    });
</script>
@endsection

