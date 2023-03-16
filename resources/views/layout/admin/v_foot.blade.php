<script src="{{ asset('asset/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('asset/js/popper.min.js') }}"></script>
<script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('asset/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('asset/js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{ asset('asset/js/custom.js') }}"></script>
@include('sweetalert::alert')
@stack('scripts')
