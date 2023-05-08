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
                            <h4>{{ session('title') }}</h4>
                        </div>
                        <form action="{{ route('attendances.storeOrUpdate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Siswa</th>
                                                <th>NIS</th>
                                                <th>Sakit</th>
                                                <th>Izin</th>
                                                <th>Alfa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($result as $index => $student)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="usr-img-frame mr-2 rounded-circle">
                                                                <img alt="avatar" class="img-fluid rounded-circle"
                                                                    src="{{ $student['file'] != null ? asset($student['file']) : asset('asset/img/90x90.jpg') }}">
                                                            </div>
                                                            <p class="align-self-center mb-0 admin-name">
                                                                {{ $student['name'] }}</p>
                                                        </div>
                                                    </td>
                                                    <td>{{ $student['nis'] }}</td>
                                                    <input type="hidden" name="id_student_class[]"
                                                        value="{{ $student['id_student_class'] }}">
                                                    <td>
                                                        <input type="text" class="form-control" name="ill[]"
                                                            value="{{ $student['ill'] != null ? $student['ill'] : '0' }}" {{ $student['status_form'] == false ? 'readonly' : '' }}>
                                                        @error('ill.' . $index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td><input type="text" class="form-control" name="excused[]"
                                                            value="{{ $student['excused'] != null ? $student['excused'] : '0' }}" {{ $student['status_form'] == false ? 'readonly' : '' }}>
                                                        @error('excused.' . $index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td><input type="text" class="form-control" name="unexcused[]"
                                                            value="{{ $student['unexcused'] != null ? $student['unexcused'] : '0' }}" {{ $student['status_form'] == false ? 'readonly' : '' }}>
                                                        @error('unexcused.' . $index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
        <script>
            $(document).ready(function() {
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
