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
                        <li class="breadcrumb-item"><a href="#">Setelan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Konfigurasi</li>
                    </ol>
                </nav>
            </div>

            <div class="row mb-4 layout-spacing layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <div id="general-info" class="section general-info">
                        <div class="info">
                            <h6 class="">{{ session('title') }}</h6>
                            <form action="">
                                <div class="form-row align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <label class="sr-only" for="inlineFormInput">Tahun Ajaran</label>
                                        <select name="year" id="school_year" class="form-control">
                                            <option value="" selected disabled>Pilih Tahun Ajaran</option>
                                            @foreach ($school_years as $school_year)
                                                @php
                                                    $semester = substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap';
                                                @endphp
                                                <option value="{{ $school_year->slug }}"
                                                    {{ $_GET['year'] == $school_year->slug ? 'selected' : '' }}>
                                                    {{ substr($school_year->name, 0, 9) . ' ' . $semester }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label class="sr-only" for="inlineFormInputGroup">Kelas</label>
                                        <select name="class" id="study_class" class="selectpicker form-control"
                                            data-live-search="true">
                                            <option value="">Pilih kelas</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->slug }}"
                                                    {{ isset($_GET['class']) && $_GET['class'] == $class->slug ? 'selected' : '' }}>
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="about" class="section about" action="{{ route('setting_scores.kkm.storeOrUpdate') }}"
                        method="POST">
                        @csrf
                        <div class="info">
                            <h5 class="">{{ Str::upper($name_class) }}</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru</th>
                                        <th>Semester</th>
                                        <th>KKM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (empty($result))
                                    <tr>
                                        <td colspan="5" class="text-center">Data belum tersedia</td>
                                    </tr>
                                    @else
                                        @foreach ($result as $index => $kkm)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $kkm['course'] }}</td>
                                                <td>{{ $kkm['teacher'] }}</td>
                                                <td>{{ $kkm['school_year'] }}</td>
                                                <td>
                                                    <input type="hidden" name="id_course[]"
                                                        value="{{ $kkm['id_course'] }}">
                                                    <input type="hidden" name="id_study_class[]"
                                                        value="{{ $kkm['id_study_class'] }}">
                                                    <input type="hidden" name="id_school_year[]"
                                                        value="{{ $kkm['id_school_year'] }}">
                                                    <input type="number" name="score[]" class="form-control"
                                                        value="{{ old('score.' . $index, $kkm['score']) }}">
                                                    @error('score.' . $index)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
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
        @include('package.bootstrap-select.bootstrap-select_js')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("#about").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function submitForm() {
                $('#about').submit();
            }
        </script>
    @endpush
@endsection
