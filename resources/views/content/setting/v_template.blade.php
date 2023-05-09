@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>

            <div class="row" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                    <h4>{{ session('title') }}</h4>
                                    <div class="form-group my-auto">
                                        <select name="id_school_year" class="form-control">
                                            <option value="" selected disabled>-- Pilih Tahun Ajaran --</option>
                                            @foreach ($school_years as $school_year)
                                                @php
                                                    $semester = substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap';
                                                @endphp
                                                <option value="{{ $school_year->slug }}"
                                                    {{ $school_year->slug == $_GET['year'] ? 'selected' : '' }}>
                                                    {{ substr($school_year->name, 0, 9) . ' ' . $semester }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('templates.updateOrCreate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <table class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Jurusan</th>
                                            <th>Jenis</th>
                                            <th>Template</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($templates as $index => $template)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $template['major'] }}</td>
                                                <td>
                                                    <input type="hidden" name="id_school_year[]"
                                                        value="{{ $template['id_school_year'] }}">

                                                    <select name="type[]" class="form-control"
                                                        id="type_{{ $index + 1 }}">
                                                        <option value="" selected disabled>Pilih Jenis</option>
                                                        <option value="uts"
                                                            {{ old('type', $template['type']) == 'uts' ? 'selected' : (old('type') == 'uts' ? 'selected' : '') }}>
                                                            Penilaian Tengah Semester</option>
                                                        <option value="uas"
                                                            {{ old('type', $template['type']) == 'uas' ? 'selected' : (old('type') == 'uas' ? 'selected' : '') }}>
                                                            Penilaian Akhir Semester</option>
                                                    </select>
                                                    @error('type.' . $index)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="hidden" name="id_major[]"
                                                        value="{{ $template['id_major'] }}">
                                                    <select name="template[]" class="form-control"
                                                        id="template_{{ $index + 1 }}">
                                                        <option value="" selected disabled>Pilih Template</option>
                                                        {{-- <option value="kd"
                                                            {{ old('template', $template['template']) == 'kd' ? 'selected' : (old('template') == 'kd' ? 'selected' : '') }}>
                                                            Kompetensi Dasar</option> --}}
                                                        <option value="manual"
                                                            {{ old('template', $template['template']) == 'manual' ? 'selected' : (old('template') == 'manual' ? 'selected' : '') }}>
                                                            Input Manual</option>
                                                        <option value="manual2"
                                                            {{ old('template', $template['template']) == 'manual2' ? 'selected' : (old('template') == 'manual2' ? 'selected' : '') }}>
                                                            Input Manual V2</option>
                                                        <option value="k13"
                                                            {{ old('template', $template['template']) == 'k13' ? 'selected' : (old('template') == 'k13' ? 'selected' : '') }}>
                                                            Kurikulum 13</option>
                                                        <option value="merdeka"
                                                            {{ old('template', $template['template']) == 'merdeka' ? 'selected' : (old('template') == 'merdeka' ? 'selected' : '') }}>
                                                            Kurikulum Merdeka</option>
                                                    </select>
                                                    @error('template.' . $index)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);"
                                                        onclick="previewTemplate({{ $index + 1 }})"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-check-circle text-primary">
                                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                        </svg>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

            function previewTemplate(params) {
                let template = $('#template_' + params).val();
                let type = $('#type_' + params).val();
                window.open('preview/sample?template=' + template + '&type=' + type, '_blank');
            }
        </script>
    @endpush
@endsection
