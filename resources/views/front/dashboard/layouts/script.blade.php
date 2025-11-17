<script src="{{ URL::to('front/dashboard/vendor/global/global.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/custom.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/deznav-init.js') }}"></script>
{{-- <script src="{{ URL::to('front/dashboard/vendor/owl-carousel/owl.carousel.js') }}"></script> --}}

<!-- Chart piety plugin files -->
<script src="{{ URL::to('front/dashboard/vendor/peity/jquery.peity.min.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ URL::to('front/dashboard/vendor/apexchart/apexchart.js') }}"></script>

<!-- Dashboard 1 -->
<script src="{{ URL::to('front/dashboard/js/dashboard/workout-statistic.js') }}"></script>

<!--===============================================================================================-->
<script src="{{ URL::to('front/dashboard/vendor/countdowntime/moment.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/countdowntime/moment-timezone.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/countdowntime/moment-timezone-with-data.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/countdowntime/countdowntime.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/toastr/js/toastr.min.js') }}"></script>

<!-- All init script -->
<script src="{{ URL::to('front/dashboard/js/plugins-init/toastr-init.js') }}"></script>


<script>
 @if(session('message'))
    // alert(1);
    toastr.success("{{ session('message') }}",{
        timeOut: 500000000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-top-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: !1
    });
    @elseif(session('error'))
    toastr.error("{{ session('error') }}",{
        timeOut: 500000000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-top-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: !1
    });
    @endif



</script>
@yield('script')
