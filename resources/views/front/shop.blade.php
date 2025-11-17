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

    <section class="inner-banner py-5 wow animated fadeInDown">
        <div class="container mb-5">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 text-black fw-medium pt-5 pb-4 wow animated fadeInDown text-uppercase">Shop</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="products-sec my-5">
        <div class="container d-none">
            <div class="d-sm-flex justify-content-between align-items-center filters">
                <div class="search-bar position-relative mt-4 wow animated fadeInDown">
                    <input type="text" class="form-control rounded-pill text-black py-2 px-4 fw-medium shadow-none" placeholder="SEARCH . . ." />
                    <button class="btn bg-none border-0 text-primary-y position-absolute end-0 top-0 mt-1 fs-5 me-1"><i class="fa fa-search"></i></button>
                </div>
                <div class="d-flex align-items-center gap-4 wow animated fadeInDown mt-4">
                    <div class="d-flex gap-4 btns-toggle">
                        <a href="javascript:;" class="fs-5 transition active position-relative mt-n1"><i class="fa fa-grip"></i><i class="fa fa-grip position-absolute start-0 mt-custom"></i></a>
                        <a href="javascript:;" class="fs-4 transition"><i class="fa fa-list"></i></a>
                    </div>
                    <select class="form-select rounded-pill px-4 py-2 fw-medium text-black text-uppercase fet shadow-none">
                        <option>Featured  &nbsp; &nbsp;</option>
                        <option>Latest  &nbsp; &nbsp;</option>
                        <option>Expensive  &nbsp; &nbsp;</option>
                        <option>Related  &nbsp; &nbsp;</option>
                        <option>Low  &nbsp; &nbsp;</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product1.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Foldable Pushup Board – Multi Level</a>
                    <span class="fw-semibold fs-20 text-primary-y">$49.99</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product2.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Mini Bike Pedal Exerciser, With  Out Meter for Legs Arms Physical Therapy Workout</a>
                    <span class="fw-semibold fs-20 text-primary-y">$199.99</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product3.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Slimpro Fitness EPE Foam Roller</a>
                    <span class="fw-semibold fs-20 text-primary-y">$19.99</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product4.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Slimpro Fitness Chin-up Bar</a>
                    <span class="fw-semibold fs-20 text-primary-y">$99.99</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product5.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Tummy Trimmer</a>
                    <span class="fw-semibold fs-20 text-primary-y">$49.99</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product6.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Ab Wheel</a>
                    <span class="fw-semibold fs-20 text-primary-y">$49.99</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product7.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Six Pack Care</a>
                    <span class="fw-semibold fs-20 text-primary-y">$500.00</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product8.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Thera Band (Set of 4)</a>
                    <span class="fw-semibold fs-20 text-primary-y">$60.00</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product9.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Bosu Ball</a>
                    <span class="fw-semibold fs-20 text-primary-y">$100.00</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product10.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Cable Jumping Rope</a>
                    <span class="fw-semibold fs-20 text-primary-y">$50.00</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product11.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Dips Push Up Z</a>
                    <span class="fw-semibold fs-20 text-primary-y">$49.99</span>
                </div>
                <div class="col-lg-3 wow animated fadeInDown col-md-6 col-sm-6 mt-4 mb-2">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="{{route('product_detail')}}"><img src="{{ URL::to('front/landing/images/product12.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="{{route('product_detail')}}" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Kettlebells</a>
                    <span class="fw-semibold fs-20 text-primary-y">$400.00</span>
                </div>
                <div class="col-12">
                    <nav class="my-5">
                        <ul class="pagination justify-content-center shop">
                            <li class="page-item"><a class="page-link rounded-circle transition p-0 m-1 fw-medium text-primary-y text-center shadow-none active" href="javascript:;">1</a></li>
                            <li class="page-item"><a class="page-link rounded-circle transition p-0 m-1 fw-medium text-primary-y text-center shadow-none" href="javascript:;">2</a></li>
                            <li class="page-item"><a class="page-link rounded-circle transition p-0 m-1 fw-medium text-primary-y text-center shadow-none" href="javascript:;">3</a></li>
                            <li class="page-item"><a class="page-link rounded-circle transition p-0 m-1 fw-medium text-primary-y text-center shadow-none" href="javascript:;">4</a></li>
                            <li class="page-item"><a class="page-link rounded-circle transition p-0 m-1 fw-medium text-primary-y text-center shadow-none" href="javascript:;">5</a></li>
                            <li class="page-item"><a class="page-link rounded-circle transition p-0 m-1 fw-medium text-primary-y text-center shadow-none" href="javascript:;"><i class="fa fa-angle-right fs-5"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-4 mb-4">
                <div class="col-12 text-center">
                    <h2 class="py-5" style="font-size: 30px">
                        <b>YORTAGO</b> online shop is coming soon, stay tuned!
                    </h2>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')


@endsection