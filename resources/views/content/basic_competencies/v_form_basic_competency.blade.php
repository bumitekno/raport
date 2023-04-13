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
            <form
                action="{{ route('basic_competencies.storeOrUpdate', ['id' => isset($basic_competency) ? $basic_competency->id : null]) }}"
                method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">{{ session('title') }}</h6>
                            @if (Auth::guard('teacher')->check())
                                <input type="hidden" name="id_course" value="{{ session('teachers.id_course') }}">
                                <input type="hidden" name="id_level" value="{{ session('teachers.id_level') }}">
                            @else
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Mapel</label>
                                        <select name="id_course" id="" class="form-control selectpicker"
                                            data-live-search="true">
                                            <option value="" selected disabled>Pilih Mapel</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}"
                                                    {{ isset($basic_competency) && old('id_course', $basic_competency->id_course) == $course->id ? 'selected' : (old('id_course') == $course->id ? 'selected' : '') }}>
                                                    {{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Tingkat</label>
                                        <select name="id_level" id="id_level" class="form-control">
                                            <option value="" selected disabled>Pilih Tingkat</option>
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}"
                                                    {{ isset($basic_competency) && old('id_level', $basic_competency->id_level) == $level->id ? 'selected' : (old('id_level') == $level->id ? 'selected' : '') }}>
                                                    {{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_level')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            @php
                                if (isset($basic_competency)) {
                                    $name = json_decode($basic_competency->name);
                                }
                            @endphp
                            <div class="form-group">
                                <label for="profession">Kode Kompetensi Dasar</label>
                                <input type="text" class="form-control" name="code"
                                    placeholder="Kode Kompetensi Dasar"
                                    value="{{ isset($basic_competency) ? old('code', $name->code) : old('code') }}">
                            </div>
                            <div class="form-group">
                                <label for="profession">Kompetensi Dasar</label>
                                <textarea name="name" rows="3" class="form-control" placeholder="Masukan Kompetensi Dasar">{{ isset($basic_competency) ? old('name', $name->name) : old('name') }}</textarea>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
