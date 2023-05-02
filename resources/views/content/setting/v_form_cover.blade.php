@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.dropify.dropify_css')
        @include('package.editor.editor_css')
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
                <div class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form action="{{ route('covers.updateOrCreate') }}" method="post" enctype="multipart/form-data">
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

                                <div class="parent ex-4">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div id="left-rollbacks" class="dragula">

                                                <div class="card post text-post" style="">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="l30">Title 1</label>
                                                            <input class="form-control" id="header1" name="title"
                                                                value="{{ isset($cover) ? old('title', $cover['title']) : old('title') }}"
                                                                placeholder="RAPOR" type="text">
                                                            @error('title')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="l30">Title 2</label>
                                                            <input class="form-control" id="header2" name="sub_title"
                                                                placeholder="SEKOLAH MENENGAH KEJURUAN <br> (SMK)"
                                                                value="{{ isset($cover) ? old('sub_title', $cover['sub_title']) : old('sub_title') }}"
                                                                type="text">
                                                            @error('sub_title')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="l30">Footer</label>
                                                            <input class="form-control" id="footer"
                                                                placeholder="KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN <br> REPUBLIK INDONESIA"
                                                                name="footer"
                                                                value="{{ isset($cover) ? old('footer', $cover['footer']) : old('footer') }}"
                                                                type="text">
                                                            @error('footer')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="l30">Petunjuk Pengisian</label>
                                                            <textarea name="instruction" class="editor d-none">{!! isset($cover) ? old('instruction', $cover['instruction']) : old('instruction') !!}</textarea>
                                                            <div id="content-container">
                                                                <div id="toolbar-container">
                                                                    <button class="ql-bold" data-toggle="tooltip"
                                                                        data-placement="bottom" title="Bold"></button>
                                                                    <button class="ql-underline" data-toggle="tooltip"
                                                                        data-placement="bottom" title="Underline"></button>
                                                                    <button class="ql-italic" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Add italic text <cmd+i>"></button>
                                                                    <button class="ql-image" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Upload image"></button>
                                                                    <button class="ql-code-block" data-toggle="tooltip"
                                                                        data-placement="bottom" title="Show code"></button>
                                                                </div>
                                                                <div id="editor">
                                                                    {!! isset($cover) ? old('instruction', $cover['instruction']) : old('instruction') !!}
                                                                </div>
                                                            </div>
                                                            @error('instruction')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-row mb-4">
                                                            <div
                                                                class="col-xl-12 col-lg-12 col-md-12 text-center d-flex justify-content-between">
                                                                <div class="upload mt-4 pr-md-4">
                                                                    @php
                                                                        if (isset($cover) && $cover['top_logo'] != null) {
                                                                            $top_logo = asset($cover['top_logo']);
                                                                        } else {
                                                                            $top_logo = asset('asset/img/200x200.jpg');
                                                                        }
                                                                    @endphp
                                                                    <input type="file" name="top_logo"
                                                                        id="input-top-logo" class="dropify"
                                                                        data-default-file="{{ isset($cover) ? old('top_logo', $top_logo) : old('top_logo', asset('asset/img/200x200.jpg')) }}"
                                                                        data-max-file-size="2M" />
                                                                    <p class="mt-2"><i
                                                                            class="flaticon-cloud-upload mr-1"></i>
                                                                        Logo Atas
                                                                    </p>
                                                                </div>
                                                                @error('top_logo')
                                                                    <div class="invalid-feedback d-block">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <div class="upload mt-4 pr-md-4">
                                                                    @php
                                                                        if (isset($cover) && $cover['middle_logo'] != null) {
                                                                            $middle_logo = asset($cover['middle_logo']);
                                                                        } else {
                                                                            $middle_logo = asset('asset/img/200x200.jpg');
                                                                        }
                                                                    @endphp
                                                                    <input type="file" name="middle_logo"
                                                                        id="input-middle-logo" class="dropify"
                                                                        data-default-file="{{ isset($cover) ? old('middle_logo', $middle_logo) : old('middle_logo', asset('asset/img/200x200.jpg')) }}"
                                                                        data-max-file-size="2M" />
                                                                    <p class="mt-2"><i
                                                                            class="flaticon-cloud-upload mr-1"></i>
                                                                        Logo Tengah
                                                                    </p>
                                                                </div>
                                                                @error('middle_logo')
                                                                    <div class="invalid-feedback d-block">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div id="right-rollbacks" class="dragula">
                                                <div class="card post text-post mb-2" style="">
                                                    <div class="card-body">
                                                        <div
                                                            style="display: flex; justify-content: center; align-items: center;">
                                                            <div style="width: 21cm; height: 17cm; padding: 1cm">
                                                                <br>
                                                                <center>
                                                                    <img class="logo-expand" id="prev-logo-top"
                                                                        alt=""
                                                                        src="{{ !empty($cover) ? $cover['top_logo'] : asset('asset/img/sma.png') }}"
                                                                        style="max-height: 59px;">
                                                                    <br><br>
                                                                    <h5 class="my-0"><b
                                                                            id="prevHeader1">{!! !empty($cover) ? $cover['title'] : '' !!}</b>
                                                                    </h5>
                                                                    <h5 class="my-0"><b
                                                                            id="prevHeader2">{!! !empty($cover) ? $cover['sub_title'] : '' !!}</b>
                                                                    </h5>
                                                                    <br>
                                                                    <img class="logo-expand" id="prev-logo-middle"
                                                                        alt=""
                                                                        src="{{ !empty($cover) ? $cover['middle_logo'] : asset('asset/img/sma.png') }}"
                                                                        style="max-height: 59px;">
                                                                    <br><br>
                                                                    <h6><b>Nama Peserta Didik</b></h6>
                                                                    <div style="border: 1px solid black; padding: 12px">
                                                                        <h6 class="m-0"><b>AKHMAD SAFI'I</b></h6>
                                                                    </div>
                                                                    <br>
                                                                    <h6><b>NISN/NIS</b></h6>
                                                                    <div style="border: 1px solid black; padding: 12px">
                                                                        <h6 class="m-0"><b>123232434/13123244</b></h6>
                                                                    </div>
                                                                    <br><br><br>

                                                                    <h6 class="my-0"><b
                                                                            id="prevFooter">{!! !empty($cover) ? $cover['footer'] : '' !!}</b>
                                                                    </h6>
                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card post text-post mt-2" style="">
                                                    <div class="card-body">
                                                        <div id="instructions">
                                                            @if (!empty($cover))
                                                                {!! $cover['instruction'] !!}
                                                            @else
                                                                <ol>
                                                                    <li>Rapor merupakan ringkasan hasil penilaian terhadap
                                                                        seluruh aktivitas pembelajaran yang dilakukan
                                                                        peserta didik dalam kurun waktu tertentu;</li>
                                                                    <li>Rapor dipergunakan selama siswa yang bersangkutan
                                                                        mengikuti seluruh program pembelajaran di Sekolah
                                                                        Menengah Kejuruan tersebut;</li>
                                                                    <li>Identitas Sekolah diisi dengan data yang sesuai
                                                                        dengan keberadaan Sekolah Menengah Kejuruan;</li>
                                                                    <li>Keterangan tentang diri Peserta didik diisi lengkap
                                                                        sesuai ijazah sebelumnya atau akta kelahiran;</li>
                                                                    <li>Rapor harus dilengkapi dengan pas foto berwarna
                                                                        dengan latar belakang merah (3 x 4) serta
                                                                        menggunakan baju putih seragam dan pengisiannya
                                                                        dilakukan oleh Wali Kelas;</li>
                                                                    <li>Capaian peserta didik dalam kompetensi pengetahuan
                                                                        dan kompetensi keterampilan ditulis dalam bentuk
                                                                        angka dan predikat untuk masing-masing mata
                                                                        pelajaran;</li>
                                                                    <li>Predikat ditulis dalam bentuk huruf sesuai kriteria;
                                                                    </li>
                                                                    <li>Catatan akademik ditulis dengan kalimat positif
                                                                        sesuai capaian yang diperoleh peserta didik;</li>
                                                                    <li>Penjelasan lebih detil mengenai capaian kompetensi
                                                                        peserta didik dapat dilihat pada leger;</li>
                                                                    <li>Laporan Praktik Kerja Lapangan diisi berdasarkan
                                                                        kegiatan praktik kerja yang diikuti oleh peserta
                                                                        didik di industri/perusahaan mitra;</li>
                                                                    <li>Laporan Ekstrakurikuler diisi berdasarkan kegiatan
                                                                        ekstrakurikuler yang diikuti oleh peserta didik;
                                                                    </li>
                                                                    <li>Ketidakhadiran diisi dengan data akumulasi
                                                                        ketidakhadiran peserta didik karena sakit, izin,
                                                                        atau tanpa keterangan selama satu semester;</li>
                                                                    <li>Keterangan kenaikan kelas diisi dengan putusan
                                                                        apakah peserta didik naik kelas yang ditentukan
                                                                        melalui rapat dewan guru;</li>
                                                                    <li>Deskripsi perkembangan karakter diisi dengan
                                                                        simpulan perkembangan peserta didik terkait
                                                                        penumbuhan karakter baik yang dilakukan secara
                                                                        terprogram oleh sekolah maupun yang muncul secara
                                                                        spontan dari peserta didik;</li>
                                                                    <li>Catatan perkembangan karakter diisikan hal-hal yang
                                                                        tidak tercantum pada deskripsi perkembangan karakter
                                                                        termasuk prestasi yang diraih peserta didik pada
                                                                        semester berjalan dan simpulan dari perkembangan
                                                                        karakter peserta didik pada semester berjalan jika
                                                                        dikomparasikan dengan semester sebelumnya;</li>
                                                                    <li>Keterangan pindah keluar sekolah diisi dengan alasan
                                                                        kepindahan. Sedangkan pindah masuk diisi dengan
                                                                        sekolah asal.</li>
                                                                </ol>
                                                            @endif
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

                bindInputChange("#header1", "#prevHeader1");
                bindInputChange("#header2", "#prevHeader2");
                bindInputChange("#footer", "#prevFooter");


                var quill = new Quill('#content-container #editor', {
                    modules: {
                        toolbar: '#toolbar-container'
                    },
                    placeholder: 'Compose an epic...',
                    theme: 'snow'
                });

                var editor = document.querySelector('#editor');
                var instructions = document.querySelector('#instructions');

                // Update value of the textarea on every change in the editor
                quill.on('text-change', function() {
                    var contents = quill.root.innerHTML;
                    $('.editor').val(contents);
                    instructions.innerHTML = editor.firstChild.innerHTML;
                });

                bindInputChange("#editor", "#instructions");

                $('#id_school_year').change(function() {
                    window.location.href = "covers?year=" + $(this).val();
                });

                $('#input-top-logo').on('change', function() {
                    readURL(this, '#prev-logo-top');
                });
                $('#input-middle-logo').on('change', function() {
                    readURL(this, '#prev-logo-middle');
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
