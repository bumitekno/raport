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
            <form action="{{ route('families.updateOrCreate', ['id' => isset($parent) ? $parent->id : null]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">Informasi Umum</h6>
                            <div class="row">
                                <div class="col-lg-11 mx-auto">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @error('id_user')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                            <div class="upload mt-4 pr-md-4">
                                                <input type="file" name="file" id="input-file-max-fs" class="dropify"
                                                    data-default-file="{{ Auth::user()->file ? asset(Auth::user()->file) : asset('asset/img/200x200.jpg') }}"
                                                    data-max-file-size="2M" />
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
                                                        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                                                        <div class="form-group">
                                                            <label for="fullName">Nama Lengkap</label>
                                                            <input type="text" class="form-control" name="name"
                                                                placeholder="Nama Lengkap"
                                                                value="{{ isset($parent) ? old('name', $parent->name) : old('name') }}">
                                                            @error('name')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="fullName">NIK</label>
                                                            <input type="text" class="form-control" name="nik"
                                                                placeholder="Nama Lengkap"
                                                                value="{{ isset($parent) ? old('nik', $parent->nik) : old('nik') }}">
                                                            @error('nik')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="profession">Email</label>
                                                    <input type="text" class="form-control" name="email"
                                                        placeholder="Email"
                                                        value="{{ isset($parent) ? old('email', $parent->email) : old('email') }}">
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
                                                <label for="nik">Agama</label>
                                                <select name="religion" id="religion" class="form-control">
                                                    <option value="" selected disabled>Pilih Agama</option>
                                                    <option value="islam"
                                                        {{ isset($parent) && old('religion', $parent->religion) == 'islam' ? 'selected' : (old('religion') == 'islam' ? 'selected' : '') }}>
                                                        Islam</option>
                                                    <option value="protestan"
                                                        {{ isset($parent) && old('religion', $parent->religion) == 'protestan' ? 'selected' : (old('religion') == 'protestan' ? 'selected' : '') }}>
                                                        Protestan</option>
                                                    <option value="katholik"
                                                        {{ isset($parent) && old('religion', $parent->religion) == 'katholik' ? 'selected' : (old('religion') == 'katholik' ? 'selected' : '') }}>
                                                        Katholik</option>
                                                    <option value="budha"
                                                        {{ isset($parent) && old('religion', $parent->religion) == 'budha' ? 'selected' : (old('religion') == 'budha' ? 'selected' : '') }}>
                                                        Budha</option>
                                                    <option value="hindu"
                                                        {{ isset($parent) && old('religion', $parent->religion) == 'hindu' ? 'selected' : (old('religion') == 'hindu' ? 'selected' : '') }}>
                                                        Hindu</option>
                                                    <option value="konghucu"
                                                        {{ isset($parent) && old('religion', $parent->religion) == 'konghucu' ? 'selected' : (old('religion') == 'konghucu' ? 'selected' : '') }}>
                                                        Konghucu</option>
                                                </select>
                                                @error('religion')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">Status Keluarga</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="" selected disabled>Pilih Status Keluarga</option>
                                                    <option value="father"
                                                        {{ isset($parent) && old('type', $parent->type) == 'father' ? 'selected' : (old('type') == 'father' ? 'selected' : '') }}>
                                                        Ayah</option>
                                                    <option value="mother"
                                                        {{ isset($parent) && old('type', $parent->type) == 'mother' ? 'selected' : (old('type') == 'mother' ? 'selected' : '') }}>
                                                        Ibu</option>
                                                    <option value="guardian"
                                                        {{ isset($parent) && old('type', $parent->type) == 'guardian' ? 'selected' : (old('type') == 'guardian' ? 'selected' : '') }}>
                                                        Wali</option>
                                                    <option value="other"
                                                        {{ isset($parent) && old('type', $parent->type) == 'other' ? 'selected' : (old('type') == 'other' ? 'selected' : '') }}>
                                                        Lainnya</option>
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Telepon</label>
                                                <input type="text" class="form-control" name="phone"
                                                    placeholder="Telepon"
                                                    value="{{ isset($parent) ? old('phone', $parent->phone) : old('phone') }}">
                                                @error('phone')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Pekerjaan</label>
                                                @php
                                                    $jobs = json_decode(Storage::get('profession.json'), true);
                                                @endphp
                                                <select name="job" id="job" class="form-control">
                                                    <option value="" selected disabled>Pilih Pekerjaan</option>
                                                    @foreach ($jobs as $job)
                                                        <option value="{{ $job }}" {{ isset($parent) && old('job', $parent->job) == $job ? 'selected' : (old('job') == $job ? 'selected' : '') }}>{{ $job }}</option>
                                                    @endforeach
                                                </select>
                                                @error('job')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website1">Alamat</label>
                                                <input type="text" class="form-control" name="address"
                                                    placeholder="Alamat"
                                                    value="{{ isset($parent) ? old('address', $parent->address) : old('address') }}">
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
