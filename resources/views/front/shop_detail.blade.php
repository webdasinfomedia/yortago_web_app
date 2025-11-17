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

    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb my-4 py-1 wow animated fadeInDown">
                <li class="breadcrumb-item"><a class="text-black fs-20" href="in-person.html">Home</a></li>
                <li class="breadcrumb-item"><a class="text-black fs-20" href="shop.html">Shop</a></li>
                <li class="breadcrumb-item active text-black fs-20" aria-current="page">Full Sleeve Black Compression Tee</li>
            </ol>
        </div>
    </nav>

    <section class="product-detail py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="thumbnails h-100 mt-4 wow animated fadeInDown">
                            <div class="thumb-box transition my-3 active rounded-3 d-flex justify-content-center align-items-center overflow-hidden">
                                <img src="{{ URL::to('front/landing/images/thumbnail1.png')}}" alt="Thumbnail" class="img-fluid w-100 h-100 object-fit-cover" />
                            </div>
                            <div class="thumb-box transition my-3 rounded-3 d-flex justify-content-center align-items-center overflow-hidden">
                                <img src="{{ URL::to('front/landing/images/thumbnail2.png')}}" alt="Thumbnail" class="img-fluid w-100 h-100 object-fit-cover" />
                            </div>
                            <div class="thumb-box transition my-3 rounded-3 d-flex justify-content-center align-items-center overflow-hidden">
                                <img src="{{ URL::to('front/landing/images/thumbnail3.png')}}" alt="Thumbnail" class="img-fluid w-100 h-100 object-fit-cover" />
                            </div>
                            <div class="thumb-box transition my-3 rounded-3 d-flex justify-content-center align-items-center overflow-hidden">
                                <img src="{{ URL::to('front/landing/images/thumbnail4.png')}}" alt="Thumbnail" class="img-fluid w-100 h-100 object-fit-cover" />
                            </div>
                            <div class="thumb-box transition my-3 rounded-3 d-flex justify-content-center align-items-center overflow-hidden">
                                <img src="{{ URL::to('front/landing/images/thumbnail5.png')}}" alt="Thumbnail" class="img-fluid w-100 h-100 object-fit-cover" />
                            </div>
                        </div>
                        <div class="preview radius overflow-hidden p-5 wow animated fadeInDown">
                            <img src="{{ URL::to('front/landing/images/main.png')}}" alt="Main Preview" class="img-fluid w-100 h-100 object-fit-cover" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 px-xl-5">
                    <div class="px-xl-4 py-4">
                        <h1 class="fs-50 fw-medium text-black wow animated fadeInDown">Full Sleeve Black  Compression Tee</h1>
                        <h3 class="fs-4 fw-normal pt-3 pb-1 wow animated fadeInDown"><span class="fw-light text-decoration-line-through">$90.00</span>  <b class="fw-semibold">$80.00</b>  Save  <span class="text-danger">$10.00</span></h3>
                        <p class="d-block lh-125 fs-20 wow animated fadeInDown">Tax included. Shipping calculated at checkout.</p>
                        <p class="d-block lh-125 fs-20 pt-4 wow animated fadeInDown">Color: <b class="fw-semibold">Black</b></p>
                        <div class="d-flex gap-2 colors wow animated fadeInDown">
                            <a href="javascript:;" class="color-box mt-2 transition active d-flex justify-content-center align-content-center"><img src="{{ URL::to('front/landing/images/black.png')}}" alt="Color" /></a>
                            <a href="javascript:;" class="color-box mt-2 transition d-flex justify-content-center align-content-center"><img src="{{ URL::to('front/landing/images/white.png')}}" alt="Color" /></a>
                        </div>
                        <p class="d-block lh-125 fs-20 pt-3 wow animated fadeInDown">Size: <b class="fw-semibold">Medium</b></p>
                        <ul class="size d-flex gap-2 wow animated fadeInDown">
                            <li><a href="javascript:;" class="rounded-circle text-center d-block mt-2 text-black transition">S</a></li>
                            <li><a href="javascript:;" class="rounded-circle text-center d-block mt-2 text-black transition active">M</a></li>
                            <li><a href="javascript:;" class="rounded-circle text-center d-block mt-2 text-black transition">L</a></li>
                            <li><a href="javascript:;" class="rounded-circle text-center d-block mt-2 text-black transition">XL</a></li>
                            <li><a href="javascript:;" class="rounded-circle text-center d-block mt-2 text-black transition">2XL</a></li>
                        </ul>
                        <p class="d-block lh-125 fs-20 pt-3 wow animated fadeInDown">Quantity:</p>
                        <div class="wrap rounded-pill overflow-hidden border mt-2 d-flex mb-2 wow animated fadeInDown">
                            <button type="button" id="sub" class="sub btn btn-light bg-white roudned-0 border-0"><i class="fa fa-minus"></i></button>
                            <input class="count text-center form-control rounded-0 fs-20 fw-medium border-top-0 border-bottom-0 shadow-none" type="text" id="1" value="1" min="1" max="999" />
                            <button type="button" id="add" class="add btn btn-light bg-white roudned-0 border-0"><i class="fa fa-plus"></i></button>
                        </div>
                        <a href="javascript:;" class="btn btn-secondary-y w-100 text-uppercase fw-medium p-0 mt-4 shop-btns wow animated fadeInDown"><span class="p-2">Add To Cart</span></a>
                        <a href="javascript:;" class="btn btn-primary-y w-100 text-uppercase fw-medium mt-3 shop-btns p-3 mb-2 wow animated fadeInDown">Buy It Now</a>
                        <h3 class="text-white text-center text-uppercase fw-medium bg-black px-3 py-2 mt-4 wow animated fadeInDown">Compression Tee Size Chart</h3>
                        <table class="table table-bordered size-t wow animated fadeInDown">
                            <tr>
                                <td class="bg-info">Size Chart</td>
                                <td class="bg-info">Small</td>
                                <td class="bg-info">Medium</td>
                                <td class="bg-info">Large</td>
                                <td class="bg-info">X Large</td>
                                <td rowspan="3" class="text-center align-middle p-0 bg-black">
                                    <img src="{{ URL::to('front/landing/images/table.png')}}" alt="Table" class="img-fluid w-100" />
                                </td>
                            </tr>
                            <tr class="choose1">
                                <td>Chest</td>
                                <td class="fw-medium selectable active">17</td>
                                <td class="fw-medium selectable">18</td>
                                <td class="fw-medium selectable">19</td>
                                <td class="fw-medium selectable">20</td>
                            </tr>
                            <tr class="choose2">
                                <td>Length</td>
                                <td class="fw-medium selectable2">26.5</td>
                                <td class="fw-medium selectable2 active">27</td>
                                <td class="fw-medium selectable2">28</td>
                                <td class="fw-medium selectable2">29</td>
                            </tr>
                        </table>
                        <p class="d-block lh-125 fs-20 pt-3 wow animated fadeInDown"><b>Product Details:</b></p>
                        <p class="d-block lh-125 fs-20 pt-3 wow animated fadeInDown">Made with our unique combination of 4-way stretch polyester + Spandex material, these tees are going to become yourÂ irreplaceable attire for the gym. Once you have worked out in these, you would not want to workout in any other garment!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products-sec my-5">
        <div class="container pb-5">
            <h3 class="fs-1 text-center fw-medium text-uppercase wow animated fadeInDown">Related Products</h3>
            <div class="slider testimonials-slider px-0 pb-5">
                <div class="wow animated fadeInDown mt-4 mb-2 px-3">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="product-detail.html"><img src="{{ URL::to('front/landing/images/product9.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="product-detail.html" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Bosu Ball</a>
                    <span class="fw-semibold fs-20 text-primary-y">$100.00</span>
                </div>
                <div class="wow animated fadeInDown mt-4 mb-2 px-3">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="product-detail.html"><img src="{{ URL::to('front/landing/images/product10.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="product-detail.html" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Cable Jumping Rope</a>
                    <span class="fw-semibold fs-20 text-primary-y">$50.00</span>
                </div>
                <div class="wow animated fadeInDown mt-4 mb-2 px-3">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="product-detail.html"><img src="{{ URL::to('front/landing/images/product11.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="product-detail.html" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Dips Push Up Z</a>
                    <span class="fw-semibold fs-20 text-primary-y">$49.99</span>
                </div>
                <div class="wow animated fadeInDown mt-4 mb-2 px-3">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="product-detail.html"><img src="{{ URL::to('front/landing/images/product12.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="product-detail.html" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Kettlebells</a>
                    <span class="fw-semibold fs-20 text-primary-y">$400.00</span>
                </div>
                <div class="wow animated fadeInDown mt-4 mb-2 px-3">
                    <div class="p-box overflow-hidden radius d-flex justify-content-center align-items-center p-3 transition">
                        <a href="product-detail.html"><img src="{{ URL::to('front/landing/images/product11.png')}}" alt="product" class="img-fluid transition" /></a>
                    </div>
                    <a href="product-detail.html" class="text-black fs-20 fw-medium d-block mt-4 mb-3 lh-125 p-tiel transition">Bosu Ball</a>
                    <span class="fw-semibold fs-20 text-primary-y">$100.00</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')


@endsection