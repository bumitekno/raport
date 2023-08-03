@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.flatpickr.flatpickr_css')
        @include('package.dropify.dropify_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">Setelan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Konfigurasi</li>
                    </ol>
                </nav>
            </div>

            <div class="row mb-4 layout-spacing layout-top-spacing">
                <div id="basic" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form action="{{ route('configs.updateOrCreate') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                        <h4>{{ session('title') }}</h4>
                                        <div class="form-group my-auto">
                                            <select name="id_school_year" id="id_school_year" class="form-control">
                                                <option value="" selected disabled>-- Pilih Tahun Ajaran --</option>
                                                @foreach ($years as $year)
                                                    <option value="{{ $year['slug'] }}"
                                                        {{ $_GET['year'] == $year['slug'] ? 'selected' : '' }}>
                                                        {{ $year['school_year'] . ' ' . $year['semester']['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_school_year')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info widget-content widget-content-area">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Tanggal PTS</label>
                                        <input
                                            value="{{ isset($config) ? old('pts_date', $config->pts_date) : old('pts_date', now()) }}"
                                            class="form-control basicPicker active" type="text" name="pts_date"
                                            placeholder="Select Date..">
                                        @error('pts_date')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Tanggal PTS Kelas Akhir</label>
                                        <input
                                            value="{{ isset($config) ? old('last_pts_date', $config->last_pts_date) : old('last_pts_date', now()) }}"
                                            class="form-control basicPicker active" type="text" name="last_pts_date"
                                            placeholder="Select Date..">
                                        @error('last_pts_date')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Tanggal Raport</label>
                                        <input
                                            value="{{ isset($config) ? old('report_date', $config->report_date) : old('report_date', now()) }}"
                                            class="form-control basicPicker active" type="text" name="report_date"
                                            placeholder="Select Date..">
                                        @error('report_date')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Tanggal Raport Kelas Akhir</label>
                                        <input
                                            value="{{ isset($config) ? old('final_report_date', $config->final_report_date) : old('final_report_date', now()) }}"
                                            class="form-control basicPicker active" type="text" name="final_report_date"
                                            placeholder="Select Date..">
                                        @error('final_report_date')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="col-xl-2 col-lg-12 col-md-4 text-center">
                                        <div class="upload mt-4 pr-md-4">
                                            <input type="file" name="signature" id="input-file-max-fs" class="dropify"
                                                data-default-file="{{ isset($config) && $config['signature'] != null ? old('signature', asset($config->signature)) : old('signature', asset('asset/img/200x200.jpg')) }}"
                                                data-max-file-size="2M" />
                                            <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Tanda Tangan Kepsek
                                            </p>
                                        </div>
                                        @error('signature')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="fullName">Kepala Sekolah</label>
                                                    <input type="text" class="form-control" name="headmaster"
                                                        placeholder="Nama Lengkap"
                                                        value="{{ isset($config) ? old('headmaster', $config->headmaster) : old('headmaster') }}">
                                                    @error('headmaster')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="fullName">Tempat Surat</label>
                                                    <input type="text" class="form-control" name="place" id="place"
                                                        placeholder="Lokasi Surat"
                                                        value="{{ isset($config) ? old('place', $config->place) : old('place') }}">
                                                    @error('place')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="profession">NIP Kepala Sekolah</label>
                                                    <input type="text" class="form-control" name="nip_headmaster"
                                                        placeholder="NIP Kepala Sekolah"
                                                        value="{{ isset($config) ? old('nip_headmaster', $config->nip_headmaster) : old('nip_headmaster') }}">
                                                    @error('nip_headmaster')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="profession">Tanggal Kunci Raport</label>
                                                    <div class="input-group mb-4">
                                                        <input
                                                            value="{{ isset($config) ? old('closing_date', $config->closing_date) : old('closing_date', now()) }}"
                                                            class="form-control basicPicker" type="text"
                                                            name="closing_date" placeholder="Select Date.."
                                                            id="closing_date">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-primary" id="nullButton"
                                                                type="button">Clear</button>
                                                        </div>
                                                    </div>
                                                    @error('closing_date')
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
        @include('package.dropify.dropify_js')
        @include('package.flatpickr.flatpickr_js')
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

                $('#id_school_year').change(function() {
                    window.location.href = "home?year=" + $(this).val();
                });

                const nullButton = document.getElementById("nullButton");
                nullButton.addEventListener("click", function() {
                    const flatpickrInput = document.getElementById("closing_date")._flatpickr;
                    flatpickrInput.clear();
                });
            });

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
