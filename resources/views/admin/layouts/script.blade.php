<!-- jQuery MUST be loaded FIRST before any Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (depends on jQuery) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-iT3xMv2h6MJN8W58OvH2outJaYbafN5HLGvB9HwZ5T6HkCKyC/VJ4A3oRpv/N1YqMnVxg/xYdOxs5plRYqKp/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Now load other vendor scripts -->
<script src="{{ URL::to('front/dashboard/vendor/global/global.min.js') }}"></script>

@if(Route::currentRouteName() != "admin.new.exercise.create_exercise")
<script src="{{ URL::to('front/dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
@endif

<script src="{{ URL::to('front/dashboard/vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/custom.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/deznav-init.js') }}"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Chart piety plugin files -->
<script src="{{ URL::to('front/dashboard/vendor/peity/jquery.peity.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ URL::to('front/dashboard/vendor/toastr/js/toastr.min.js') }}"></script>

<!-- All init script -->
<script src="{{ URL::to('front/dashboard/js/plugins-init/toastr-init.js') }}"></script>

<script src="{{ URL::to('front/dashboard/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>

@yield('script')

<script>
    @if(session('message') && !request()->routeIs('admin.new.exercise.unified_exercise_management') && !request()->routeIs('admin.new.exercise.create_exercise_list') && !request()->routeIs('admin.new.exercise.edit_exercise_list'))
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

    function deleteAlert(url) {
        $url=url;

        swal({
            title: "Are you sure to delete ?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: !1
        })
        .then((willDelete) => {
            if (willDelete.value) {
                window.location.href = $url;
            }
        });
    }
</script>