@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.bootstrap-select.bootstrap-select_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    @php
        if (array_key_exists('student', $_GET)) {
            $selectedStudentSlug = $_GET['student'];
        } else {
            $selectedStudentSlug = null;
        }
    @endphp
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
            <form action="{{ route('score_p5.storeOrUpdate') }}" method="post">
                @csrf
                <div class="row mb-4 layout-spacing layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="statbox widget box box-shadow">

                            <div class="widget-header" style="border-radius: 8px !important;">
                                <div class="row">
                                    <input type="hidden" name="id_p5" value="{{ $p5->id }}">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                        <h4>{{ $p5->tema->name }}</h4>
                                        <div class="form-group row my-auto mx-3">
                                            <label for="inputUsername" class="col-auto col-form-label my-auto">Pilih
                                                Siswa</label>
                                            <div class="col">
                                                <select name="id_student" id="" class="form-control">
                                                    <option value="" selected disabled>-- Pilih Siswa --</option>
                                                    @foreach ($students as $student)
                                                        <option value="{{ $student->slug }}"
                                                            {{ $selectedStudentSlug == $student->slug ? 'selected' : '' }}>
                                                            {{ $student->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="info widget-content widget-content-area">
                                <input type="hidden" name="id_student_class"
                                    value="{{ isset($_GET['student']) ? $detail_student->id_student_class : '' }}">
                                <input type="hidden" name="id_school_year" value="{{ session('id_school_year') }}">
                                <input type="hidden" name="id_subject_teacher" value="{{ $p5->id_subject_teacher }}">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="nama_siswa" class="col-form-label font-weight-bold">Nama Siswa</label>
                                        <p class="form-control-plaintext">
                                            {{ !isset($_GET['student']) ? '-' : $detail_student->name }}</p>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="nisn" class="col-form-label font-weight-bold">Kelas</label>
                                        <p class="form-control-plaintext">{{ $p5->study_class->name }}</p>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="kelas" class="col-form-label font-weight-bold">NISN</label>
                                        <p class="form-control-plaintext">
                                            {{ !isset($_GET['student']) ? '-' : $detail_student->nisn }}</p>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="alamat_siswa" class="col-form-label font-weight-bold">Alamat
                                            Siswa</label>
                                        <p class="form-control-plaintext">
                                            {{ !isset($_GET['student']) ? '-' : $detail_student->address }}</p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="nama_sekolah" class="col-form-label font-weight-bold">Nama
                                            Sekolah</label>
                                        <p class="form-control-plaintext">SMA Negeri 1</p>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="semester" class="col-form-label font-weight-bold">Semester</label>
                                        <p class="form-control-plaintext">
                                            {{ session('semester') == 1 ? 'Ganjil' : 'Genap' }}</p>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tahun_ajaran" class="col-form-label font-weight-bold">Tahun
                                            Ajaran</label>
                                        <p class="form-control-plaintext">{{ session('school_year') }}</p>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fase" class="col-form-label font-weight-bold">Fase</label>
                                        <p class="form-control-plaintext">{{ $p5->study_class->level->fase }}</p>
                                    </div>
                                </div>
                                <hr>
                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        @foreach ($errors->all() as $error)
                                            <div class="invalid-feedback d-block">{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Dimensi dan Sub Element</th>
                                            <th scope="col">Belum</th>
                                            <th scope="col">Mulai</th>
                                            <th scope="col">Berkembang Sesuai</th>
                                            <th scope="col">Sangat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['subElements'] as $elements)
                                            <tr class="table-active">
                                                <td colspan="5">{{ $elements['name'] }}</td>
                                            </tr>
                                            @foreach ($elements['sub_elements'] as $sub_element)
                                                <tr>
                                                    <td>{{ $sub_element['name'] }}</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="sub_element[{{ $elements['id'] . ',' . $sub_element['id'] }}]"
                                                                id="sub_element_belum" value="belum"
                                                                {{ $sub_element['score'] == 'belum' ? 'checked' : '' }}
                                                                {{ !isset($_GET['student']) ? 'disabled' : '' }}>
                                                            <label class="form-check-label" for="sub_element_belum"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="sub_element[{{ $elements['id'] . ',' . $sub_element['id'] }}]"
                                                                id="sub_element_mulai" value="mulai"
                                                                {{ $sub_element['score'] == 'mulai' ? 'checked' : '' }}
                                                                {{ !isset($_GET['student']) ? 'disabled' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sub_element_mulai"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="sub_element[{{ $elements['id'] . ',' . $sub_element['id'] }}]"
                                                                id="sub_element_berkembang" value="berkembang"
                                                                {{ $sub_element['score'] == 'berkembang' ? 'checked' : '' }}
                                                                {{ !isset($_GET['student']) ? 'disabled' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sub_element_berkembang"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="sub_element[{{ $elements['id'] . ',' . $sub_element['id'] }}]"
                                                                id="sub_element_sangat" value="sangat"
                                                                {{ $sub_element['score'] == 'sangat' ? 'checked' : '' }}
                                                                {{ !isset($_GET['student']) ? 'disabled' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sub_element_sangat"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label for="inputAddress">Catatan</label>
                                    <textarea name="description" rows="3" class="form-control" {{ empty($_GET['student']) ? 'disabled' : '' }}>{{ !empty($_GET['student']) ? $data['description'] : '' }}</textarea>
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
                <button class="btn btn-primary" id="btnSubmit" {{ empty($_GET['student']) ? 'disabled' : '' }}
                    onclick="submitForm()">Simpan
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

                $('select[name="id_student"]').on('change', function() {
                    var selectedStudentSlug = $(this).val(); // ambil slug siswa yang dipilih
                    var currentUrl = window.location.href; // ambil URL saat ini
                    var newUrl = currentUrl.split('?')[0] + '?student=' +
                        selectedStudentSlug; // tambahkan query parameter student ke URL

                    // Muat ulang halaman dengan URL baru
                    window.location.href = newUrl;
                });
            });



            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
