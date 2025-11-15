<script src="{{ URL::to('front/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ URL::to('front/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ URL::to('front/js/mixitup.min.js') }}"></script>
<script src="{{ URL::to('front/js/jquery.slicknav.js') }}"></script>
<script src="{{ URL::to('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::to('front/js/main.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>

@yield('script')

<script>

    $(window).on('load', function () {

    @if(session('message'))
    swal.fire({
        title: "Subscribed Successfully",
        text: "{{ session('success') }}",
        icon: "success"
    })
    @elseif(session('success'))
    swal.fire({
        title: "{{ session('success') }}",
        icon: "success"
    })
    @elseif(session('error'))
    swal.fire({
        title: "Error!",
        text: "{{ session('error') }}",
        icon: "error"
    })
    @endif
});
</script>
