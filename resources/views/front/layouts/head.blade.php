<head>
    <meta charset="UTF-8">
    @if(isset($meta))
    <meta name="description" content="{{ $setting[$meta.'_meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $setting[$meta.'_meta_keywords'] ?? '' }}">
    <title>{{ $setting[$meta.'_meta_title'] ?? 'Yortago' }}</title>
    @else
    <meta name="description" content="Yortago">
    <meta name="keywords" content="Yortago, unica, creative, html">
    <title>Yortago</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" id="csrf" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to($setting['favIcon']) }} ">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ URL::to('front/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('front/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ URL::to('front/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('front/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('front/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('front/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::to('front/css/style.css') }}" type="text/css">
    <link href="{{ URL::to('front/dashboard/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">


</head>

<style>
.signup-btn:hover {
    color: white!important;
}
.dropdown  li a:hover {
    color:white!important;
}
.dropdown  li:hover a {
    color:white!important;
    background: #B9732F;
}
    .nav-menu .mainmenu ul li a:after {
    position: absolute;
    left: 0;
    top: 40px;
    width: 100%;
    height: 2px;
    background: #B9732F;
    content: "";
    opacity: 0;
    -webkit-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}
.nav-menu .mainmenu ul li a:hover {
    color: #111;
}
.fixed-top{
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    z-index: 10300000000;
    background: white;
}
/* @media only screen and (min-width: 768px){ */



    .breadcrumb-section {
    padding-top: 160px;
    height: 300px;
    position: relative;
    /* margin-top: 78px; */
}

</style>


@yield('head')
