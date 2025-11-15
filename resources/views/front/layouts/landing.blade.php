<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    @if(isset($meta))
        <meta name="description" content="{{ $setting[$meta.'_meta_description'] ?? '' }}">
        <meta name="keywords" content="{{ $setting[$meta.'_meta_keywords'] ?? '' }}">
        <title>{{ $setting[$meta.'_meta_title'] ?? 'Yortago' }}</title>
    @else
        <meta name="description" content="Yortago">
        <meta name="keywords" content="Yortago, unica, creative, html">
        <title>Yortago</title>
    @endif
    <link href="{{ URL::to('front/landing/images/images/favicon.png')}}" rel="icon" sizes="32x32" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/css/libs/animate.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet" />
    <link href="https://kenwheeler.github.io/slick/slick/slick-theme.css" rel="stylesheet" />
    <link href="{{ URL::to('front/landing/style.css')}}" rel="stylesheet" />
    
</head>

@yield('style')
<body>

@yield('content')

<footer class="bg-black @if(Route::currentRouteName() != 'home') mt-1 pt5 @endif">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="{{route('home')}}"><img src="{{ URL::to('front/landing/images/logo.png')}}" alt="Logo" class="img-fluid wow animated fadeInDown" /></a>
            </div>
            <div class="col-md-9 text-white">
                <div class="row">
                    <div class="col-md-3 wow animated fadeInDown">
                        <h3 class="fs-20 fw-600 mb-3">Quick Links</h3>
                        <ul class="d-block">
                            <!--<li class="d-block py-2"><a href="javascript:;">About Us</a></li>-->
                            <li class="d-block py-2"><a href="{{route('in.person')}}">In Person</a></li>
                            <li class="d-block py-2"><a href="{{route('online.training')}}">Online</a></li>
                            <li class="d-block py-2"><a href="{{route('shop')}}">Shop</a></li>
                            <li class="d-block py-2"><a href="{{route('blog')}}">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 wow animated fadeInDown">
                        <h3 class="fs-20 fw-600 mb-3">Contact</h3>
                        <ul class="d-block">
                            <li class="d-block py-2"><a href="tel: {{ $setting['phone_no'] }}"><i class="fa fa-phone me-1 text-primary-y"></i>  {{ $setting['phone_no'] }}</a></li>
                            <li class="d-block py-2"><a href="mailto: {{ $setting['email'] }}"><i class="fa fa-envelope me-1 text-primary-y"></i>  {{ $setting['email'] }}</a></li>
                            <li class="d-block py-2"><a><i class="fa fa-map-marker-alt me-1 text-primary-y"></i>   {{ $setting['address'] }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 wow animated fadeInDown">
                        <h3 class="fs-20 fw-600 mb-3">Follow Us</h3>
                        <ul class="d-block">
                            <li class="d-block py-2"><a href="{{ $setting['facebook'] }}"><i class="fab fa-facebook me-1 text-primary-y"></i> Facebook</a></li>
                            <li class="d-block py-2"><a href="{{ $setting['twitter'] }}"><i class="fab fa-twitter me-1 text-primary-y"></i> Twitter</a></li>
                            <li class="d-block py-2"><a href="{{ $setting['instagram'] }}"><i class="fab fa-instagram me-1 text-primary-y"></i> Instagram</a></li>
                            <li class="d-block py-2"><a href="{{ $setting['tiktok'] }}"><i class="fab fa-tiktok me-1 text-primary-y"></i> Tiktok</a></li>
                            <li class="d-block py-2"><a href="{{ $setting['linkdin'] }}"><i class="fab fa-linkedin me-1 text-primary-y"></i> Linkedin</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 wow animated fadeInDown">
                        <h3 class="fs-20 fw-600 mb-3">Download</h3>
                        <ul class="d-block btns">
                            <li class="d-block pt-2 pb-1"><a href="javascript:;"><img src="{{ URL::to('front/landing/images/playstore.png')}}" alt="Play Store" class="img-fluid" /></a></li>
                            <li class="d-block"><a href="javascript:;"><img src="{{ URL::to('front/landing/images/app-store.png')}}" alt="App Store" class="img-fluid" /></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-5" />
    <div class="copyright py-1 pb-4 text-white wow animated fadeInDown">
        <div class="container">
            <div class="d-md-flex justify-content-between">
                <p>&copy; 2024 Yortago Athletic Performance. All Rights Reserved.</p>
                <ul class="d-flex gap-3">
                    <li><a href="{{ route('term.condition') }}">Terms of Service</a></li>
                    <li><a href="javascript:;">Cookies Policy</a></li>
                    <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>



<!-- Modal In Person Training -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="videoModalLabel">In Person Training</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/h5YxEsY2vDI" title="Yortago Promo 02" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Modal Online Training -->
<div class="modal fade" id="videoModal2" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="videoModalLabel">Online Training</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/h5YxEsY2vDI" title="Yortago Promo 02" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('message'))
    $(document).ready(function(){
        Swal.fire({
          title: "Thank you!",
          text: "{{ session('message') }}",
          icon: "success"
        });
    })
    @endif
</script>
@yield('script')
</html>
