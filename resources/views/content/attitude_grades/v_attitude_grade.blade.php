@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/search.css') }}">
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
                        <form action="{{ route('attitude_grades.storeOrUpdate', $type) }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <div class="search-input-group-style input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg></span>
                                    </div>
                                    <input type="text" id="input-search" class="form-control"
                                        placeholder="Let's find your question in fast way" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>

                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">No</th>
                                                <th class="align-middle">Siswa</th>
                                                <th class="align-middle text-center">NIS</th>
                                                <th class="align-middle">Predikat</th>
                                                <th class="align-middle">Sikap yang sudah dilakukan</th>
                                            </tr>

                                        </thead>
                                        <tbody id="student-table">
                                            @foreach ($result as $index => $student)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="usr-img-frame mr-2 rounded-circle">
                                                                <img alt="avatar" class="img-fluid rounded-circle"
                                                                    src="{{ $student['file'] != null ? asset($row['file']) : asset('asset/img/90x90.jpg') }}">
                                                            </div>
                                                            <p class="align-self-center mb-0 admin-name">
                                                                {{ $student['name'] }}</p>
                                                        </div>
                                                    </td>
                                                    <input type="hidden" name="id_student_class[]"
                                                        value="{{ $student['id_student_class'] }}">
                                                    <td>{{ $student['nis'] }}</td>
                                                    <td>
                                                        <select name="predicate[]" class="form-control">
                                                            <option value="sangat baik" {{ $student['predicate'] == 'sangat baik' ? 'selected' : '' }}>Sangat baik</option>
                                                            <option value="baik" {{ $student['predicate'] == 'baik' ? 'selected' : '' }}>Baik</option>
                                                            <option value="cukup" {{ $student['predicate'] == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                                            <option value="kurang" {{ $student['predicate'] == 'kurang' ? 'selected' : '' }}>Kurang</option>
                                                        </select>
                                                        @error('predicate.' . $index)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        @foreach ($student['attitudes'] as $attitude)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="attitudes{{ $student['id_student_class'] }}[]" {{ $attitude['checked'] == true ? 'checked' : '' }}
                                                                    id="customCheck{{ $student['id_student_class'] . $attitude['id'] }}"
                                                                    value="{{ $attitude['id'] }}">
                                                                <label class="custom-control-label"
                                                                    for="customCheck{{ $student['id_student_class'] . $attitude['id'] }}">{{ $attitude['name'] }}</label>
                                                            </div>
                                                        @endforeach
                                                        @error('attitudes.' . $index)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
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
                $('#input-search').on('keyup', function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('#student-table tr').hide();
                    $('#student-table tr').filter(function() {
                        return rex.test($(this).text());
                    }).show();
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
