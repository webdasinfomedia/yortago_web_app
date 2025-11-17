<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.head')
<style>
    .deznav .metismenu ul a.mm-active {
    text-decoration: none;
    color: #B9732F!important;
}
    .deznav .metismenu ul a.mm-hover {

    color: #B9732F!important;
}
.deznav .metismenu ul a:hover, .deznav .metismenu ul a:focus, .deznav .metismenu ul a.mm-active {
    text-decoration: none;
    color: #B9732F!important;
}
.page-titles .breadcrumb li.active a {
    color: #B9732F;
    font-weight: 600;
}
.btn-primary:hover {
    color: #fff;
    background-color: #d6d3d0!important;
    border-color: #B9732F!important;
}
.btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #d6d3d0!important;
    border-color: #d6d3d0!important;
}
.footer{
    position: absolute;
    bottom: 0px;
    width: 100%;
}
.select2-container--default .select2-selection--single .select2-selection__rendered{
    color:#6e6e6e !important;
    line-height: 51px !important;
}
.select2-container--default .select2-selection--single .select2-selection__clear{
    height: 51px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
    height: 51px !important;
}
[data-header-position="fixed"] .content-body {
    padding-top: 2.5rem !important;
}
@media only screen and (min-width: 1300px) {
    .page-titles {
    margin-top: 35px !important;
}
}
.dataTables_wrapper .dataTables_paginate {
    /*background: #B9732F !important;*/
    /*opacity:30% !important;*/
    background-color:rgba(185, 115, 47, 0.3);
    
}
.dataTables_wrapper .dataTables_paginate .paginate_button.previous, .dataTables_wrapper .dataTables_paginate .paginate_button.next {
    background: transparent !important;
    color: #B9732F !important;
   padding: 10px 16px 10px 18px !important;
    font-size:14px !important;
    font-weight:400 !important;
}
.dataTables_wrapper .paginate_button.previous , .dataTables_wrapper .paginate_button.next, .dataTables_wrapper .paginate_button{
   margin-top: 10px !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.next:hover,.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    color: #fff !important;
    background: #B9732F !important;
    text-align: center !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
    color: #fff !important;
    background: #B9732F !important;
    text-align: center !important;
    padding-top: 15px !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current{
     padding-top: 15px !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover{
    color: #fff !important;
    background: #B9732F !important;
    text-align: center !important;
    
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: white !important;
    border: 1px solid #979797;
    background-color: white;
    text-align: center !important;

}
.breadcrumb-item a{
    text-decoration:underline !important;
}
 .breadcrumb li.active a{
    text-decoration:none !important;
}
.content-body{
    background-color: #fff !important;
}
.btn:hover {
    /* color: white; */
    text-decoration: underline !important;
}

.table-responsive tbody tr td, .text-muted{
    color: #333333 !important;
}
/* @media only screen and (min-width: 767px) and (max-width: 1300px) {
   .hamburger {
    display: inline-block !important;
    left: 0px;
    position: relative;
    top: 3px;
    -webkit-transition: all 0.3s 
ease-in-out 0s;
    transition: all 0.3s 
ease-in-out 0s;
    width: 26px;
    z-index: 999;
}
} */
</style>
 
<body>


    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="#" class="brand-logo">
                <img class="logo-abbr" src="{{ URL::to('front/dashboard/images/logo-2.png') }}" alt="">
                <img class="logo-compact" src="{{ URL::to('front/dashboard/images/logo.png') }}" alt="">
                <img class="brand-title" src="{{ URL::to('front/dashboard/images/logo.png') }}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

		<!--**********************************
            Chat box start
        ***********************************-->

		<!--**********************************
            Chat box End
        ***********************************-->

		<!--**********************************
            Header start
        ***********************************-->
     @include('admin.layouts.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->

        @include('admin.layouts.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
      @include('admin.layouts.footer')
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

		<!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->

    @include('admin.layouts.script')
    
    {{-- Livewire Scripts via CDN for v3.x --}}
    <script src="https://cdn.jsdelivr.net/gh/livewire/livewire@v3.x.x/dist/livewire.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/livewire@v3.x.x/dist/livewire-upload.js"></script>
    
    {{-- Custom page scripts --}}
    @yield('scripts')
   
</body>
</html>