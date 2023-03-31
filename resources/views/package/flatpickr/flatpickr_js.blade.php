<script src="{{ asset('asset/js/flatpickr.js') }}" defer></script>
<script>
    flatpickr(document.getElementsByClassName('basicPicker'));
    flatpickr(".formatYear", {
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        language: "id",
        autoclose: true,
    });
</script>
