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
                    <h1 class="display-4 text-black fw-medium pt-5 pb-4 wow animated fadeInDown text-uppercase">
                        Blog</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="welcome pb-5 mb-5">
        <div class="container mb-5 pb-lg-5 pb-0">
            <div class="row">
                <div class="col-12">
                    <strong class="text-primary-y fs-20 ls-2 text-uppercase fw-medium wow animated fadeInDown">{{\Carbon\Carbon::parse($blog->created_at)->format('d M, Y')}}</strong>
                    <h2 class="fs-50 text-black fw-medium pt-2 pb-4 wow animated fadeInDown">{{$blog->title}}</h2>
                    <img src="{{ URL::to($blog->image)}}" alt="Post Detail"
                         class="img-fluid radius my-4 wow animated fadeInDown"/>

                    <p class="d-block py-2 lh-125 fs-20 wow animated fadeInDown">{!! preg_replace('/<p>/', '<p class="d-block py-2 lh-125 fs-20 wow animated fadeInDown">', preg_replace('/<\/?div>/', '', $blog->full_description)) !!}</p>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')


@endsection