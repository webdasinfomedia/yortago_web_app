<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" id="csrf" content="{{ csrf_token() }}">
    <title>Yortago -Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::to($setting['favIcon'])}}">	<link rel="stylesheet" href="{{ URL::to('front/dashboard/vendor/chartist/css/chartist.min.css') }}">
    @if(Route::currentRouteName() != "admin.new.exercise.create_exercise")
    <link href="{{ URL::to('front/dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    @endif
    @if(strpos($_SERVER['REQUEST_URI'], "/nutrition/program/edit") !== false)

    <link href="{{ URL::to('front/dashboard/css/style-admin.css') }}" rel="stylesheet">
    @else
    <link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">

    @endif
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
	<link href="{{ URL::to('front/dashboard/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/vendor/toastr/css/toastr.min.css') }}">

    <link href="{{ URL::to('front/dashboard/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

    @yield('css')

    <style>
    .nav-header .brand-title {
            margin-left: -15px;
            max-width: 238px;
            margin-top: 5px;
        }
        @media only screen and (min-width: 768px){
 .deznav .metismenu li a {
    padding: 0.613rem 0.79em!important;
    padding-right: 1em!important;
    padding-left: 1em!important;
}
}
.accordion-primary .accordion__header {
    
    background: linear-gradient(to right, #d38d49, #d76e33)!important;
}
.btn-primary{
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
    {{-- Livewire Styles via CDN for v3.x (minimal styling needed) --}}
    <style>
        [wire\:loading], [wire\:loading\.delay], [wire\:loading\.inline-block], [wire\:loading\.inline], [wire\:loading\.block], [wire\:loading\.flex], [wire\:loading\.table], [wire\:loading\.grid], [wire\:loading\.inline-flex] {
            display: none;
        }
        [wire\:loading\.delay\.shortest], [wire\:loading\.delay\.shorter], [wire\:loading\.delay\.short], [wire\:loading\.delay\.long], [wire\:loading\.delay\.longer], [wire\:loading\.delay\.longest] {
            display: none;
        }
        [wire\:offline] {
            display: none;
        }
        [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }
    </style>
</head>