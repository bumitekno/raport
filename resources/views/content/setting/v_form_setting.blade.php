@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.dropify.dropify_css')
        @include('package.tagsinput.tags_input_css')
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
            <form action="{{ route('settings.updateOrCreate') }}" method="post" enctype="multipart/form-data">
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
                                                <input type="file" id="input-file-max-fs" name="logo" class="dropify"
                                                    data-default-file="{{ $setting['logo'] ? asset($setting['logo']) : asset('asset/img/200x200.jpg') }}"
                                                    data-max-file-size="2M" />
                                                <p class="mt-2 text-center"><i class="flaticon-cloud-upload mr-1"></i> Logo
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
                                                            <label for="fullName">Nama Sekolah</label>
                                                            <input type="text" class="form-control" name="name_school"
                                                                placeholder="Nama Sekolah"
                                                                value="{{ old('name_school', $setting['name_school']) }}">
                                                            @error('name_school')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="fullName">Nama Aplikasi</label>
                                                            <input type="text" class="form-control"
                                                                name="name_application" placeholder="Nama Aplikasi"
                                                                value="{{ old('name_application', $setting['name_application']) }}">
                                                            @error('name_application')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="profession">NPSN</label>
                                                    <input type="text" class="form-control" name="npsn"
                                                        placeholder="NPSN Sekolah"
                                                        value="{{ old('npsn', $setting['npsn']) }}">
                                                    @error('npsn')
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
                                    <div class="form-group">
                                        <label for="profession">Alamat</label>
                                        <textarea name="address" rows="3" class="form-control" placeholder="Alamat Sekolah">{{ old('address', $setting['address']) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="profession">Telepon</label>
                                            <input type="text" class="form-control" name="phone"
                                                placeholder="Telepon Sekolah"
                                                value="{{ old('phone', $setting['phone']) }}">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="profession">Email</label>
                                            <input type="text" class="form-control" name="email"
                                                placeholder="Email Sekolah" value="{{ old('email', $setting['email']) }}">
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="profession">Maksimal Upload</label>
                                            <input type="number" class="form-control" name="max_upload"
                                                placeholder="Batas Maksimal Upload"
                                                value="{{ old('max_upload', $setting['max_upload']) }}">
                                            @error('max_upload')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="profession">Ukuran Kompress</label>
                                            <input type="number" class="form-control" name="size_compress"
                                                placeholder="Resolusi Gambar Upload"
                                                value="{{ old('size_compress', $setting['size_compress']) }}">
                                            @error('size_compress')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="profession">Website</label>
                                            <input type="text" class="form-control" name="website"
                                                placeholder="Website Sekolah"
                                                value="{{ old('website', $setting['website']) }}">
                                            @error('website')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 ">
                                            <label for="profession">Format Gambar</label>
                                            <input type="text" class="form-control" name="format_image"
                                                data-role="tagsinput"
                                                value="{{ old('format_image', $setting['format_image']) }}">
                                            @error('format_image')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="profession">Footer</label>
                                        <input type="text" class="form-control" name="footer"
                                            placeholder="Footer Program" value="{{ old('footer', $setting['footer']) }}">
                                        @error('footer')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
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
        @include('package.tagsinput.tags_input_js')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
