@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.bootstrap-select.bootstrap-select_css')
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
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <div class="info widget-content widget-content-area ecommerce-create-section">
                        <h6 class="">{{ session('title') }}</h6>
                        <form
                            action="{{ route('achievements.storeOrUpdate', ['id' => isset($achievement) ? $achievement->id : null]) }}"
                            method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="inputAddress">Pilih Siswa</label>
                                <select name="id_student_class" class="selectpicker form-control" data-live-search="true">
                                    <option value="" selected disabled>Pilih Siswa</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student['id'] }}"
                                            {{ isset($achievement) && old('id_student_class', $achievement->id_student_class) == $student['id'] ? 'selected' : (old('id_student_class') == $student['id'] ? 'selected' : '') }}>
                                            {{ $student['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('id_student_class')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Juara ke</label>
                                    <select name="ranking" id="ranking" class="form-control">
                                        <option value="" selected disabled>Pilih Juara ke</option>
                                        <option value="1"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == '1' ? 'selected' : (old('ranking') == '1' ? 'selected' : '') }}>
                                            Juara 1</option>
                                        <option value="2"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == '2' ? 'selected' : (old('ranking') == '2' ? 'selected' : '') }}>
                                            Juara 2</option>
                                        <option value="3"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == '3' ? 'selected' : (old('ranking') == '3' ? 'selected' : '') }}>
                                            Juara 3</option>
                                        <option value="harapan 1"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == 'harapan 1' ? 'selected' : (old('ranking') == 'harapan 1' ? 'selected' : '') }}>
                                            Juara Harapan 1</option>
                                        <option value="harapan 2"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == 'harapan 2' ? 'selected' : (old('ranking') == 'harapan 2' ? 'selected' : '') }}>
                                            Juara Harapan 2</option>
                                        <option value="harapan 3"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == 'harapan 3' ? 'selected' : (old('ranking') == 'harapan 3' ? 'selected' : '') }}>
                                            Juara Harapan 3</option>
                                        <option value="favorit"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == 'favorit' ? 'selected' : (old('ranking') == 'favorit' ? 'selected' : '') }}>
                                            Juara Favorit</option>
                                        <option value="partisipasi"
                                            {{ isset($achievement) && old('ranking', $achievement->ranking) == 'partisipasi' ? 'selected' : (old('ranking') == 'partisipasi' ? 'selected' : '') }}>
                                            Partisipasi</option>
                                    </select>
                                    @error('ranking')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Cabang</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ isset($achievement) ? old('name', $achievement->name) : old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Tingkat</label>
                                    <select name="level" id="level" class="form-control">
                                        <option value="" selected disabled>Pilih Tingkat Kejuaraan</option>
                                        <option value="sekolah"
                                            {{ isset($achievement) && old('level', $achievement->level) == 'sekolah' ? 'selected' : (old('level') == 'sekolah' ? 'selected' : '') }}>
                                            Tingkat Sekolah</option>
                                        <option value="kecamatan"
                                            {{ isset($achievement) && old('level', $achievement->level) == 'kecamatan' ? 'selected' : (old('level') == 'kecamatan' ? 'selected' : '') }}>
                                            Tingkat Kecamatan</option>
                                        <option value="kabupaten"
                                            {{ isset($achievement) && old('level', $achievement->level) == 'kabupaten' ? 'selected' : (old('level') == 'kabupaten' ? 'selected' : '') }}>
                                            Tingkat Kabupaten/Kota</option>
                                        <option value="provinsi"
                                            {{ isset($achievement) && old('level', $achievement->level) == 'provinsi' ? 'selected' : (old('level') == 'provinsi' ? 'selected' : '') }}>
                                            Tingkat Provinsi</option>
                                        <option value="nasional"
                                            {{ isset($achievement) && old('level', $achievement->level) == 'nasional' ? 'selected' : (old('level') == 'nasional' ? 'selected' : '') }}>
                                            Tingkat Nasional</option>
                                        <option value="internasional"
                                            {{ isset($achievement) && old('level', $achievement->level) == 'internasional' ? 'selected' : (old('level') == 'internasional' ? 'selected' : '') }}>
                                            Tingkat Internasional</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Keterangan</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                        value="{{ isset($achievement) ? old('description', $achievement->description) : old('description') }}">
                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        @include('package.bootstrap-select.bootstrap-select_js')
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
