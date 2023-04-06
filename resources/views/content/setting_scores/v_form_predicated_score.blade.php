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
                        <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Guru</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($teacher) ? 'Edit' : 'Tambah' }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <h4>{{ session('title') }}</h4>
                        </div>
                        <div class="widget-content widget-content-area">
                            @if (isset($major))
                                {{ Form::model($major, ['route' => ['majors.update', $major->slug], 'method' => 'patch']) }}
                            @else
                                {{ Form::open(['route' => 'majors.store']) }}
                            @endif
                            <div class="form-group">
                                <label for="fullName">Predikat</label>
                                <input type="text" class="form-control"
                                    placeholder="Masukan predikat raport, contoh : A, B"
                                    value="{{ isset($major) ? old('name', $major->name) : old('name') }}" name="name">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Skor Minimal</label>
                                    <input type="number" name="score[]" class="form-control" required placeholder="Masukan nilai minimal">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Skor Maksimal</label>
                                    <input type="number" class="form-control" name="score[]"  required placeholder="Masukan nilai maksimal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fullName">Bobot Nilai</label>
                                <input type="text" class="form-control" placeholder="Masukan bobot nilai, contoh: 3.6" name="grade_weight">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fullName">Deskripsi</label>
                                <textarea name="description" rows="3" class="form-control" placeholder="Masukan deskripsi predikat"></textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-primary mt-2 d-none" id="btnLoader">
                                <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                                    Loading...</div>
                                Loading
                            </button>

                            {{ Form::close() }}
                        </div>
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
        </script>
    @endpush
@endsection
