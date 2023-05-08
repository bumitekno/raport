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
                                    <table style="width: 100%">
                                        <tr>
                                            @if (!empty($kop) && $kop['left_logo'])
                                                <td class="b-0">
                                                    <img alt="logo kiri" id="prev-left-logo"
                                                        src="{{ !empty($kop) && $kop['left_logo'] ? asset($kop['left_logo']) : asset('asset/img/90x90.jpg') }}"
                                                        style="width: 85%;">
                                                </td>
                                            @endif
                                            <td style="width:70%; text-align: center;" class="b-0">
                                                <div class="text-uppercase" id="prev-header-1"
                                                    style="line-height: 1.1; font-family: 'Arial'; font-size: 12pt">
                                                    {{ !empty($kop) ? $kop['text1'] : 'HEADER 1' }}
                                                </div>
                                                <div id="prev-header-2"
                                                    style="line-height: 1.1; font-family: 'Arial'; font-size: 16pt"
                                                    class="text-uppercase">
                                                    {{ !empty($kop) ? $kop['text2'] : 'HEADER 2' }}
                                                </div>
                                                <div style="line-height: 1.2; font-family: 'Arial'; font-size: 16pt"
                                                    class="text-uppercase text-bold" id="prev-header-3">
                                                    {{ !empty($kop) ? $kop['text3'] : 'HEADER 3' }}
                                                </div>
                                                <div style="line-height: 1.2; font-family: 'Arial'; font-size: 8pt"
                                                    id="prev-header-5">
                                                    {{ !empty($kop) ? $kop['text5'] : 'HEADER 5' }}
                                                </div>
                                            </td>
                                            @if (!empty($kop) && $kop['right_logo'])
                                                <td class="b-0">
                                                    <img alt="logo kiri" id="prev-right-logo"
                                                        src="{{ !empty($kop) && $kop['right_logo'] ? asset($kop['right_logo']) : asset('asset/img/90x90.jpg') }}"
                                                        style="width: 85%;">
                                                </td>
                                            @endif

                                        </tr>

                                    </table>
                                    <hr style="border: 1px solid; margin-bottom: 6px">


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="about" action="{{ route('letterheads.updateOrCreate') }}" method="POST"
                        class="section about" enctype="multipart/form-data">
                        @csrf
                        <div class="info">
                            <h5 class="">Modifikasi KOP Surat</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="l30">Header 1</label>
                                            <input class="form-control" id="text1" name="text1"
                                                value="{{ isset($kop) ? old('text1', $kop->text1) : old('text1') }}"
                                                placeholder="HEADER 1" type="text">
                                            @error('text1')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="l30">Header 2</label>
                                            <input class="form-control" id="text2" name="text2"
                                                value="{{ isset($kop) ? old('text2', $kop->text2) : old('text2') }}"
                                                placeholder="HEADER 2" type="text">
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
                                                placeholder="HEADER 3" type="text">
                                            @error('text3')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="l30">Header 4</label>
                                            <input class="form-control" id="text4" name="text4"
                                                value="{{ isset($kop) ? old('text4', $kop->text4) : old('text4') }}"
                                                placeholder="HEADER 4" type="text">
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
                                                    if (isset($kop) && $kop->left_logo != null) {
                                                        $left_logo = asset($kop->left_logo);
                                                    } else {
                                                        $left_logo = asset('asset/img/200x200.jpg');
                                                    }
                                                @endphp
                                                <input type="file" name="left_logo" id="input-left-logo"
                                                    class="dropify"
                                                    data-default-file="{{ isset($kop) ? old('left_logo', $left_logo) : old('left_logo', asset('asset/img/200x200.jpg')) }}"
                                                    data-max-file-size="2M" />
                                                <div class="d-flex justify-content-between">
                                                    <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>
                                                        Logo Kiri
                                                    </p>
                                                    @if (isset($kop) && $kop->left_logo != null)
                                                        <a href="{{ route('letterheads.removeImage', 'left_logo') }}"
                                                            class="my-auto">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="#d32121" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="10">
                                                                </circle>
                                                                <line x1="15" y1="9" x2="9"
                                                                    y2="15"></line>
                                                                <line x1="9" y1="9" x2="15"
                                                                    y2="15"></line>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            @error('left_logo')
                                                <div class="invalid-feedback d-block">{{ $message }}
                                                </div>
                                            @enderror
                                            <div class="upload mt-4 pr-md-4">
                                                @php
                                                    if (isset($kop) && $kop->right_logo != null) {
                                                        $right_logo = asset($kop->right_logo);
                                                    } else {
                                                        $right_logo = asset('asset/img/200x200.jpg');
                                                    }
                                                @endphp
                                                <input type="file" name="right_logo" id="input-right-logo"
                                                    class="dropify"
                                                    data-default-file="{{ isset($kop) ? old('right_logo', $right_logo) : old('right_logo', asset('asset/img/200x200.jpg')) }}"
                                                    data-max-file-size="2M" />
                                                <div class="d-flex justify-content-between">
                                                    <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>
                                                        Logo Kanan
                                                    </p>
                                                    @if (isset($kop) && $kop->right_logo != null)
                                                        <a href="{{ route('letterheads.removeImage', 'right_logo') }}"
                                                            class="my-auto">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="#d32121" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="10">
                                                                </circle>
                                                                <line x1="15" y1="9" x2="9"
                                                                    y2="15"></line>
                                                                <line x1="9" y1="9" x2="15"
                                                                    y2="15"></line>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
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

                bindInputChange("#text1", "#prev-header-1");
                bindInputChange("#text2", "#prev-header-2");
                bindInputChange("#text3", "#prev-header-3");
                bindInputChange("#text4", "#prev-header-4");
                bindInputChange("#text5", "#prev-header-5");

                $('#input-left-logo').on('change', function() {
                    readURL(this, '#prev-left-logo');
                });

                $('#input-right-logo').on('change', function() {
                    readURL(this, '#prev-right-logo');
                });

                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function bindInputChange(selector, previewSelector) {
                var oldVal = $(selector).val();
                $(selector).on("change keyup paste", function() {
                    var currentVal = $(this).val();
                    if (currentVal === oldVal) {
                        return;
                    }

                    oldVal = currentVal;
                    $(previewSelector).text(currentVal);
                });
            }

            function readURL(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewId).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }


            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
