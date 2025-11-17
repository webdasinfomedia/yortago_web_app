@extends('front.master')


@section('content')

<section class="breadcrumb-section set-bg" data-setbg="{{ URL::to('front/img/s2.jpg') }}">
    <div id="color-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Coming Soon</h2>
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
                    <h2>{{ $heading }}</h2>
                    <p class="mt-3">{!! $body !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection