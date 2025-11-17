<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" id="csrf" content="{{ csrf_token() }}">
    <title>Yortago - User Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::to($setting['favIcon'])}}">
    <link href="{{ URL::to('front/dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
	<link href="{{ URL::to('front/dashboard/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/vendor/toastr/css/toastr.min.css') }}">
    @yield('css')
    <style>
    .nav-header .brand-title {
            margin-left: -30px;
            max-width: 238px;
            margin-top: 5px;
        }
        @media only screen and (max-width: 768px){
            .dropify-infos{
                display: none!important;
            }
            table td{
                display: inline-block;
                margin-left: 10px;
                margin-right: 10px;
            }
            .nav-control {
              right: -2.75rem;
            }
        }
     .accordion-primary .accordion__header {
    
    background: linear-gradient(to right, #d38d49, #d76e33)!important;
}
.deznav{
    background: #1e1e1e!important;
}
.nav-header{
     background: #1e1e1e!important;
}
.deznav .metismenu > li.mm-active > a{
    background: linear-gradient(to right, #d38d49, #d76e33)!important;
    color: white!important;
}
.deznav .metismenu > li.mm-active > a i {
    color: white!important;
}
    </style>
</head>