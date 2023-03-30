@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.dropify.dropify_css')
        @include('package.switches.switches_css')
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
            @if (isset($user))
                {{ Form::model($user, ['route' => ['users.update', $user->slug], 'method' => 'patch', 'files' => true]) }}
            @else
                {{ Form::open(['route' => 'users.store', 'files' => true]) }}
            @endif
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <div class="info widget-content widget-content-area ecommerce-create-section">
                        <h6 class="">Informasi Umum</h6>
                        <div class="row">
                            <div class="col-lg-11 mx-auto">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-12 col-md-4">
                                        <div class="upload mt-4 pr-md-4">
                                            <input type="file" id="input-file-max-fs" class="dropify"
                                                data-default-file="{{ asset('asset/img/200x200.jpg') }}"
                                                data-max-file-size="2M" />
                                            <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>
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
                                                            value="{{ isset($user) ? old('name', $user->name) : old('name') }}">
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
                                                                        {{ isset($user) && old('day', date('d', strtotime($user->date_of_birth))) == $i ? 'selected' : (old('day') == $i ? 'selected' : '') }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                            @error('day')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mr-1">
                                                            <select class="form-control" name="month">
                                                                <option selected disabled>Bulan</option>
                                                                <option value="01"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '01' ? 'selected' : (old('month') == '01' ? 'selected' : '') }}>
                                                                    Januari</option>
                                                                <option value="02"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '02' ? 'selected' : (old('month') == '02' ? 'selected' : '') }}>
                                                                    Februari</option>
                                                                <option value="03"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '03' ? 'selected' : (old('month') == '03' ? 'selected' : '') }}>
                                                                    Maret</option>
                                                                <option value="04"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '04' ? 'selected' : (old('month') == '04' ? 'selected' : '') }}>
                                                                    April</option>
                                                                <option value="05"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '05' ? 'selected' : (old('month') == '05' ? 'selected' : '') }}>
                                                                    Mei</option>
                                                                <option value="06"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '06' ? 'selected' : (old('month') == '06' ? 'selected' : '') }}>
                                                                    Juni</option>
                                                                <option value="07"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '07' ? 'selected' : (old('month') == '07' ? 'selected' : '') }}>
                                                                    Juli</option>
                                                                <option value="08"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '08' ? 'selected' : (old('month') == '08' ? 'selected' : '') }}>
                                                                    Agustus</option>
                                                                <option value="09"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '09' ? 'selected' : (old('month') == '09' ? 'selected' : '') }}>
                                                                    September</option>
                                                                <option value="10"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '10' ? 'selected' : (old('month') == '10' ? 'selected' : '') }}>
                                                                    Oktober</option>
                                                                <option value="11"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '11' ? 'selected' : (old('month') == '11' ? 'selected' : '') }}>
                                                                    November</option>
                                                                <option value="12"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '12' ? 'selected' : (old('month') == '12' ? 'selected' : '') }}>
                                                                    Desember</option>
                                                            </select>
                                                            @error('month')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                                                        {{ isset($user) && old('year', date('Y', strtotime($user->date_of_birth))) == $year ? 'selected' : (old('year') == $year ? 'selected' : '') }}>
                                                                        {{ $year }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                            @error('year')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="profession">Email</label>
                                                <input type="text" class="form-control" name="email"
                                                    placeholder="Email"
                                                    value="{{ isset($user) ? old('email', $user->email) : old('email') }}">
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
                                            <input type="text" class="form-control" name="phone" placeholder="Telepon"
                                                value="{{ isset($user) ? old('phone', $user->phone) : old('phone') }}">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Jenis Kelamin</label>
                                            <select class="form-control" name="gender">
                                                <option value="male">Laki - laki</option>
                                                <option value="female">Perempuan</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">NIS</label>
                                            <input type="text" class="form-control" name="nis" placeholder="NIS"
                                                value="{{ isset($user) ? old('nis', $user->nis) : old('nis') }}">
                                            @error('nis')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">NISN</label>
                                            <input type="text" class="form-control" name="nisn" placeholder="NISN"
                                                value="{{ isset($user) ? old('nisn', $user->nisn) : old('nisn') }}">
                                            @error('nisn')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="location">Agama</label>
                                            <select class="form-control" name="religion">
                                                <option value="islam">Islam</option>
                                                <option value="kristen">Kristen</option>
                                                <option value="hindu">Hindu</option>
                                                <option value="budha">Budha</option>
                                                <option value="katolik">Katolik</option>
                                                <option value="konghucu">Konghucu</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                            @error('religion')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="place_of_birth"
                                                placeholder="Tempat lahir"
                                                value="{{ isset($user) ? old('place_of_birth', $user->place_of_birth) : old('place_of_birth') }}">
                                            @error('place_of_birth')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Tahun Angkatan</label>
                                            <input type="text" class="form-control" name="entry_year"
                                                placeholder="Tahun Angkatan"
                                                value="{{ isset($user) ? old('entry_year', $user->entry_year) : old('entry_year') }}">
                                            @error('entry_year')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website1">Alamat</label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="Alamat"
                                                value="{{ isset($user) ? old('address', $user->address) : old('address') }}">
                                            @error('address')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;" name="password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="return showPassword('#password')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <circle cx="12" cy="12" r="3">
                                                            </circle>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website1">Konfirmasi Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirm_password"
                                                    placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;"
                                                    name="password_confirmation">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="return showPassword('#confirm_password')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <circle cx="12" cy="12" r="3">
                                                            </circle>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('confirm_password')
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
            {{-- <div class="row mb-4">
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <div class="info widget-content widget-content-area ecommerce-create-section">
                    <h6 class="">Keluarga Siswa</h6>
                    <div class="row">
                        <div class="col-md-12 text-right mb-3">
                            <a href="javascript:void(0)" id="add-education" class="btn btn-primary">Tambah</a>
                        </div>
                        <div class="col-md-11 mx-auto form-parent">

                            <div class="edu-section">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-12 col-md-4">
                                        <div class="upload mt-4 pr-md-4">
                                            <input type="file" id="input-file-max-fs" class="dropify"
                                                data-default-file="{{ asset('asset/img/200x200.jpg') }}"
                                                data-max-file-size="2M" />
                                            <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-12 col-md-6 mt-md-0 mt-4">
                                        <div class="form">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="fullName">Nama Lengkap</label>
                                                        <input type="text" class="form-control mb-4"
                                                            name="parent_name[]" placeholder="Nama Lengkap">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="fullName">Status Keluarga</label>
                                                    <select name="parent_type[]" class="form-control" id="">
                                                        <option value="father">Ayah</option>
                                                        <option value="mother">Ibu</option>
                                                        <option value="guardian">Wali</option>
                                                        <option value="other">Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="fullName">Email</label>
                                                        <input type="text" class="form-control mb-4"
                                                            name="parent_email[]" placeholder="Email Keluarga">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="fullName">Password</label>
                                                    <input type="password" class="form-control mb-4"
                                                        name="parent_password[]" placeholder="Passwordss">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-12 col-md-2 my-auto">
                                        <center>
                                            <button class="btn btn-danger text-center btn-lg remove">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="69" height="69"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg>
                                            </button>
                                        </center>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div> --}}
            {{ Form::close() }}
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


                {{-- <button id="btnLoader" class="btn btn-primary" onclick="">Save Changes</button> --}}

            </div>

        </div>
    </div>
    @push('scripts')
        @include('package.dropify.dropify_js')
        <script>
            $(function() {
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
