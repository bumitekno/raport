{{-- <meta charset="utf-8" />
<title>Metronic | Inner Page</title>
<meta name="description" content="Blank inner page examples">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!--begin::Web font -->
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>
<link href="{{ asset('asset/css/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('asset/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="assets/demo/demo12/media/img/logo/favicon.ico" /> --}}


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
@php
    $setting = json_decode(file_get_contents(storage_path('app/settings.json')), true);
@endphp
<title>{{ isset($setting['name_application']) ? $setting['name_application'] : 'E-Raport' }} - {{ session('title') }}
</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('asset/css/plugins.css') }}" rel="stylesheet" type="text/css" />


<style>
    .layout-px-spacing {
        min-height: calc(100vh - 140px) !important;
    }
</style>
@stack('styles')
