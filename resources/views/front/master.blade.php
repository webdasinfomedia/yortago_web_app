<!DOCTYPE html>
<html lang="zxx">
<head>  
  {{-- <link href="{{ URL::to('front/landing/images/images/favicon.png')}}" rel="icon" sizes="32x32" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" /> 
    <link href="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/css/libs/animate.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet" />
    <link href="https://kenwheeler.github.io/slick/slick/slick-theme.css" rel="stylesheet" />
    <link href="{{ URL::to('front/landing/style.css')}}" rel="stylesheet" />
</head>
@include('front.layouts.head')

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
  {{-- @include('front.layouts.header') --}}
  @include('front.layouts.nav')

    <!-- Header End -->



  @yield('content')



  {{-- <a href="" class="c-btn c-fill-color-btn float" style="padding: 10px 18px;">Submit Request</a> --}}




    <!-- Footer Section Begin -->
 @include('front.layouts.footer')   
    <!-- Footer Section End -->

  


    @include('front.layouts.script')

</body>

</html>
