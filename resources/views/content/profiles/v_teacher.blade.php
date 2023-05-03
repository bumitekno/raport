@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.dropify.dropify_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($teacher) ? 'Edit' : 'Tambah' }}
                        </li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('profiles.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">Informasi Umum</h6>
                            <div class="row">
                                <div class="col-lg-11 mx-auto">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                            <div class="upload mt-4 pr-md-4">
                                                <input type="file" name="file" id="input-file-max-fs" class="dropify"
                                                    data-default-file="{{ Auth::user()->file ? asset(Auth::user()->file) : asset('asset/img/200x200.jpg') }}"
                                                    data-max-file-size="2M"  />
                                                <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture
                                                </p>
                                            </div>
                                            @error('file')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                            <div class="form">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="fullName">Nama Lengkap</label>
                                                            <input type="text" class="form-control" name="name"
                                                                placeholder="Nama Lengkap"
                                                                value="{{ old('name', Auth::user()->name) }}">
                                                            @error('name')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="dob-input">Tanggal Lahir</label>
                                                        <div class="d-sm-flex d-block">
                                                            <div class="form-group mr-1">
                                                                <select class="form-control" name="day"
                                                                    id="exampleFormControlSelect1">
                                                                    <option selected disabled>Hari</option>
                                                                    @for ($i = 1; $i <= 31; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ old('day', date('d', strtotime(Auth::user()->date_of_birth))) == $i ? 'selected' : (old('day') == $i ? 'selected' : '') }}>
                                                                            {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                                @error('day')
                                                                    <div class="invalid-feedback d-block">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mr-1">
                                                                <select class="form-control" name="month">
                                                                    <option selected disabled>Bulan</option>
                                                                    <option value="01"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '01' ? 'selected' : (old('month') == '01' ? 'selected' : '') }}>
                                                                        Januari</option>
                                                                    <option value="02"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '02' ? 'selected' : (old('month') == '02' ? 'selected' : '') }}>
                                                                        Februari</option>
                                                                    <option value="03"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '03' ? 'selected' : (old('month') == '03' ? 'selected' : '') }}>
                                                                        Maret</option>
                                                                    <option value="04"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '04' ? 'selected' : (old('month') == '04' ? 'selected' : '') }}>
                                                                        April</option>
                                                                    <option value="05"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '05' ? 'selected' : (old('month') == '05' ? 'selected' : '') }}>
                                                                        Mei</option>
                                                                    <option value="06"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '06' ? 'selected' : (old('month') == '06' ? 'selected' : '') }}>
                                                                        Juni</option>
                                                                    <option value="07"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '07' ? 'selected' : (old('month') == '07' ? 'selected' : '') }}>
                                                                        Juli</option>
                                                                    <option value="08"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '08' ? 'selected' : (old('month') == '08' ? 'selected' : '') }}>
                                                                        Agustus</option>
                                                                    <option value="09"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '09' ? 'selected' : (old('month') == '09' ? 'selected' : '') }}>
                                                                        September</option>
                                                                    <option value="10"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '10' ? 'selected' : (old('month') == '10' ? 'selected' : '') }}>
                                                                        Oktober</option>
                                                                    <option value="11"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '11' ? 'selected' : (old('month') == '11' ? 'selected' : '') }}>
                                                                        November</option>
                                                                    <option value="12"
                                                                        {{ old('month', date('m', strtotime(Auth::user()->date_of_birth))) == '12' ? 'selected' : (old('month') == '12' ? 'selected' : '') }}>
                                                                        Desember</option>
                                                                </select>
                                                                @error('month')
                                                                    <div class="invalid-feedback d-block">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mr-1">
                                                                <select class="form-control" name="year">
                                                                    <option selected disabled>Tahun</option>
                                                                    @php
                                                                        $current_year = (int) date('Y');
                                                                        $start_year = (int) date('Y') - 60;
                                                                    @endphp
                                                                    @for ($year = $current_year; $year >= $start_year; $year--)
                                                                        <option value="{{ $year }}"
                                                                            {{ old('year', date('Y', strtotime(Auth::user()->date_of_birth))) == $year ? 'selected' : (old('year') == $year ? 'selected' : '') }}>
                                                                            {{ $year }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                                @error('year')
                                                                    <div class="invalid-feedback d-block">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="profession">Email</label>
                                                    <input type="text" class="form-control" name="email"
                                                        placeholder="Email"
                                                        value="{{ old('email', Auth::user()->email) }}">
                                                    @error('email')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">Informasi Tambahan</h6>
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Telepon</label>
                                                <input type="text" class="form-control" name="phone"
                                                    placeholder="Telepon"
                                                    value="{{ old('phone', Auth::user()->phone) }}">
                                                @error('phone')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Jenis Kelamin</label>
                                                <select class="form-control" name="gender">
                                                    <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : (old('gender') == 'male' ? 'selected' : '') }}>Laki - laki</option>
                                                    <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : (old('gender') == 'female' ? 'selected' : '') }}>Perempuan</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Tempat Lahir</label>
                                                <input type="text" class="form-control" name="place_of_birth"
                                                    placeholder="Tempat lahir"
                                                    value="{{ old('place_of_birth', Auth::user()->place_of_birth) }}">
                                                @error('place_of_birth')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website1">Alamat</label>
                                                <input type="text" class="form-control" name="address"
                                                    placeholder="Alamat"
                                                    value="{{ old('address', Auth::user()->address) }}">
                                                @error('address')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password"
                                                        placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;" name="password">
                                                    <button class="btn btn-outline-secondary password-toggle"
                                                        type="button" onclick="return showPassword('#password')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-eye">
                                                            <path
                                                                d="M22.239 11.984c-1.395-3.795-5.232-7.984-10.239-7.984s-8.844 4.189-10.239 7.984c1.395 3.795 5.232 7.984 10.239 7.984s8.844-4.189 10.239-7.984zm-10.239 5.016c-2.916 0-5.283-2.368-5.283-5.283s2.368-5.283 5.283-5.283 5.283 2.368 5.283 5.283-2.368 5.283-5.283 5.283z">
                                                            </path>
                                                            <circle cx="12" cy="12" r="2">
                                                            </circle>
                                                        </svg>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation"
                                                        placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;"
                                                        name="password_confirmation">
                                                    <button class="btn btn-outline-secondary password-toggle"
                                                        type="button" onclick="return showPassword('#confirm_password')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-eye">
                                                            <path
                                                                d="M22.239 11.984c-1.395-3.795-5.232-7.984-10.239-7.984s-8.844 4.189-10.239 7.984c1.395 3.795 5.232 7.984 10.239 7.984s8.844-4.189 10.239-7.984zm-10.239 5.016c-2.916 0-5.283-2.368-5.283-5.283s2.368-5.283 5.283-5.283 5.283 2.368 5.283 5.283-2.368 5.283-5.283 5.283z">
                                                            </path>
                                                            <circle cx="12" cy="12" r="2">
                                                            </circle>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="account-settings-footer">

            <div class="as-footer-container">

                <button id="multiple-reset" class="btn btn-warning">Reset All</button>
                <div class="blockui-growl-message">
                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                </div>


                <button class="btn btn-primary d-none" id="btnLoader">
                    <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                        Loading...</div>
                    Loading
                </button>
                <button class="btn btn-primary" id="btnSubmit" onclick="submitForm()">Simpan
                    Data</button>
            </div>

        </div>
    </div>
    @push('scripts')
        @include('package.dropify.dropify_js')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function showPassword(element) {
                if ('password' == $(element).attr('type')) {
                    $(element).prop('type', 'text');
                } else {
                    $(element).prop('type', 'password');
                }
            }

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
