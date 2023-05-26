<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.admin.v_head')
    {{-- @push('styles') --}}
    <link href="{{ asset('asset/css/form-1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/switches.css') }}" rel="stylesheet" type="text/css" />
    {{-- @endpush --}}


</head>

<body class="form">
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        @php
                            $setting = json_decode(file_get_contents(storage_path('app/settings.json')), true);
                        @endphp

                        <h1 class=""><a href="{{ route('first_page') }}"><span
                                    class="brand-name text-uppercase">{{ isset($setting['name_school']) ? $setting['name_school'] : 'E-Raport' }}</span></a>
                        </h1>
                        <form class="text-left" action="{{ route('auth.verify') }}" method="POST">
                            @csrf
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="username" name="username" type="text" class="form-control"
                                        placeholder="Username" value="{{ old('username') }}">
                                    @error('username')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2"
                                            ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="Password">
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>

                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                            <input type="checkbox" class="new-control-input">
                                            <span class="new-control-indicator"></span>Keep me logged in
                                        </label>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    <a href="auth_pass_recovery.html" class="forgot-pass-link">Forgot Password?</a>
                                </div>

                            </div>
                        </form>
                        <p class="terms-conditions">{{ isset($setting['footer']) ? $setting['footer'] : '© 2020 All Rights Reserved. <a href="index.html">CORK</a> is a
                            product of Designreset.' }}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image"
                style="background-image: url({{ isset($setting['logo']) ? asset($setting['logo']) : 'https://cdn.pixabay.com/photo/2015/12/10/16/39/shield-1086703_960_720.png' }})">
            </div>
        </div>
    </div>
    @include('layout.admin.v_foot')
    <script src="{{ asset('asset/js/form-1.js') }}"></script>

</body>

</html>
