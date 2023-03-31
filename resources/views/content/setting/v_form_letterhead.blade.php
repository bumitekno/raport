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
                        <li class="breadcrumb-item"><a href="#">Setelan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Konfigurasi</li>
                    </ol>
                </nav>
            </div>

            <div class="row mb-4 layout-spacing layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="general-info" class="section general-info">
                        <div class="info">
                            <h6 class="">KOP Surat</h6>
                            <div class="row">
                                <div class="col-lg-11 mx-auto">
                                    <table id="table-header-print" style="width: 100%; border: 0;">
                                        <tr>
                                            <td style="width:15%;">
                                                <img alt="logo kiri" id="prev-logo-kiri-print"
                                                    src="{{ !empty($kop) ? $kop['file'] : '' }}"
                                                    style="width:85px; height:85px; margin: 6px;">
                                            </td>
                                            <td style="width:70%; text-align: center;">
                                                <div id="prev-header-1"
                                                    style="line-height: 1.1; font-family: 'Times New Roman'; font-size: 16pt">
                                                    {{ !empty($kop) ? $kop['teks1'] : '' }}
                                                </div>
                                                <div id="prev-header-2"
                                                    style="line-height: 1.1; font-family: 'Times New Roman'; font-size: 12pt">
                                                    {{ !empty($kop) ? $kop['teks2'] : '' }}
                                                </div>
                                                <div
                                                    style="line-height: 1.2; font-family: 'Times New Roman'; font-size: 18pt">
                                                    <b id="prev-header-3">{{ !empty($kop) ? $kop['teks3'] : '' }}</b>
                                                </div>
                                                <div id="prev-header-4"
                                                    style="line-height: 1.2; font-family: 'Times New Roman'; font-size: 13pt">
                                                    {{ !empty($kop) ? $kop['teks4'] : '' }}
                                                </div>
                                                <div id="prev-header-5"
                                                    style="line-height: 1.2; font-family: 'Times New Roman'; font-size: 10pt">
                                                    {{ !empty($kop) ? $kop['teks5'] : '' }}
                                                </div>
                                            </td>
                                            <td style="width:15%;">
                                                <img alt="logo kanan" id="prev-logo-kanan-print"
                                                    src="{{ !empty($kop) ? $kop['file1'] : '' }}"
                                                    style="width:85px; height:85px; margin: 6px; border-style: none">
                                            </td>
                                        </tr>
                                    </table>
                                    <hr style="border: 1px solid; margin-bottom: 6px">


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="about" class="section about">
                        <div class="info">
                            <h5 class="">Modifikasi KOP Surat</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="l30">Header 1</label>
                                            <input class="form-control" id="text1" name="text1"
                                                value="{{ isset($kop) ? old('text1', $kop->text1) : old('text1') }}"
                                                placeholder="RAPOR" type="text">
                                            @error('text1')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="l30">Header 2</label>
                                            <input class="form-control" id="text2" name="text2"
                                                value="{{ isset($kop) ? old('text2', $kop->text2) : old('text2') }}"
                                                placeholder="RAPOR" type="text">
                                            @error('text2')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="l30">Header 3</label>
                                            <input class="form-control" id="text3" name="text3"
                                                value="{{ isset($kop) ? old('text3', $kop->text3) : old('text3') }}"
                                                placeholder="RAPOR" type="text">
                                            @error('text3')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="l30">Header 4</label>
                                            <input class="form-control" id="text4" name="text4"
                                                value="{{ isset($kop) ? old('text4', $kop->text4) : old('text4') }}"
                                                placeholder="RAPOR" type="text">
                                            @error('text4')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="l30">Header 5</label>
                                        <textarea name="text5" id="text5" rows="3" class="form-control">{{ isset($kop) ? old('text5', $kop->text5) : old('text5') }}</textarea>
                                        @error('text5')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-row mb-4">
                                        <div
                                            class="col-xl-12 col-lg-12 col-md-12 text-center d-flex justify-content-between">
                                            <div class="upload mt-4 pr-md-4">
                                                @php
                                                    if (isset($cover) && $cover->left_logo != null) {
                                                        $left_logo = asset($cover->left_logo);
                                                    } else {
                                                        $left_logo = asset('asset/img/200x200.jpg');
                                                    }
                                                @endphp
                                                <input type="file" name="left_logo" id="input-file-max-fs"
                                                    class="dropify"
                                                    data-default-file="{{ isset($cover) ? old('left_logo', $left_logo) : old('left_logo', asset('asset/img/200x200.jpg')) }}"
                                                    data-max-file-size="2M" />
                                                <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>
                                                    Logo Kiri
                                                </p>
                                            </div>
                                            @error('left_logo')
                                                <div class="invalid-feedback d-block">{{ $message }}
                                                </div>
                                            @enderror
                                            <div class="upload mt-4 pr-md-4">
                                                @php
                                                    if (isset($cover) && $cover->right_logo != null) {
                                                        $right_logo = asset($cover->right_logo);
                                                    } else {
                                                        $right_logo = asset('asset/img/200x200.jpg');
                                                    }
                                                @endphp
                                                <input type="file" name="right_logo" id="input-file-max-fs"
                                                    class="dropify"
                                                    data-default-file="{{ isset($cover) ? old('right_logo', $right_logo) : old('right_logo', asset('asset/img/200x200.jpg')) }}"
                                                    data-max-file-size="2M" />
                                                <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>
                                                    Logo Kanan
                                                </p>
                                            </div>
                                            @error('right_logo')
                                                <div class="invalid-feedback d-block">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
        @include('package.editor.editor_js')
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

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
