<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.admin.v_head')
    <link href="{{ asset('asset/custom/error.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="error404 text-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mr-auto mt-5 text-md-left text-center">
                <a href="index.html" class="ml-md-5">
                    <img alt="image-404" src="{{ asset(session('logo')) }}" class="theme-logo">
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid error-content">
        <div class="">
            <h1 class="error-number">Error</h1>
            <p class="mini-text">Ooops!</p>
            <p class="error-text mb-4 mt-1">{{ session('message') }}</p>
            <a href="{{ URL::previous() }}" class="btn btn-primary mt-5">Go Back</a>
        </div>
    </div>
    @include('layout.admin.v_foot')
</body>

</html>
