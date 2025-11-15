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
                    <h1 class="display-4 text-black fw-medium py-5 wow animated fadeInDown text-uppercase">Blog</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="welcome pb-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-9 col-lg-10 col-md-11 px-xl-5">
                    <strong class="text-primary-y fs-20 ls-2 text-uppercase fw-medium wow animated fadeInDown">Yortago</strong>
                    <h2 class="fs-50 text-black fw-medium py-4 wow animated fadeInDown text-uppercase">Latest Articles</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="training-types pt-3 pb-5 position-relative z-1">
        <div class="container">
            <div class="row align-items-stretch">
                <div class="col-12">
                    @foreach($blogs as $blog)
                    <div class="orange radius p-4 wow animated fadeInDown mb-5 mt-1 post">
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-6 px-lg-5">
                                <strong class="text-primary-y fs-20 text-uppercase fw-medium">{{\Carbon\Carbon::parse($blog->created_at)->format('d M, Y')}}</strong>
                                <h3 class="fw-medium h3 mt-3">{{$blog->title}}</h3>
                                <img src="{{ URL::to($blog->image)}}" alt="Post Image" class="img-fluid mb-2 radius hide-desktop" />
                                @php
                                    $plainTextDescription = strip_tags($blog->description);
                                    // Truncate the plain text to 280 characters
                                    $truncatedDescription = Str::limit($plainTextDescription, 280);
                                @endphp
                                <p class="d-block py-2 lh-125 fs-20">{!! $blog->description !!}</p>
                                <a href="{{route('blog_detail',['id' => encrypt($blog->id)])}}" class="btn btn-secondary-y p-0 mt-2"><span class="py-2 px-4 text-dark">Read More</span></a>
                            </div>
                            <div class="col-lg-5 col-md-6 text-center">
                                <img src="{{ URL::to('front/landing/images/post1.png')}}" alt="Post Image" class="img-fluid my-2 radius hide-mobile" />
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="col-12 text-center mt-4 mb-5">
                    {{ $blogs->appends(request()->input())->links('vendor.pagination.bootstrap-cs') }}
{{--                    <nav class="wow animated fadeInDown align-items-center d-flex justify-content-center">--}}
{{--                        <ul class="pagination blog align-items-center">--}}
{{--                            <li class="page-item"><a class="page-link rounded-pill px-4 text-uppercase orange border-0 text-primary-y fw-medium mx-3" href="javascript:;"><i class="fa fa-arrow-left-long me-2"></i> <span>Back</span></a></li>--}}
{{--                            <li class="page-item"><a class="page-link border-0 text-primary-y fw-medium px-2 fs-4" href="javascript:;">1</a></li>--}}
{{--                            <li class="page-item"><a class="page-link border-0 text-black fw-medium px-2 fs-20" href="javascript:;">2</a></li>--}}
{{--                            <li class="page-item"><a class="page-link border-0 text-black fw-medium px-2 fs-20" href="javascript:;">3</a></li>--}}
{{--                            <li class="page-item"><a class="page-link border-0 text-black fw-medium px-2 fs-20" href="javascript:;">4</a></li>--}}
{{--                            <li class="page-item"><a class="page-link border-0 text-black fw-medium px-2 fs-20" href="javascript:;">...</a></li>--}}
{{--                            <li class="page-item"><a class="page-link btn btn-primary-y rounded-pill py-2 px-4 text-uppercase border-0 mx-3 border-0" href="javascript:;"><span>Next</span> <i class="fa fa-long-arrow-right ms-2"></i></a></li>--}}
{{--                        </ul>--}}
{{--                    </nav>--}}
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')


@endsection