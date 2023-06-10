@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/search.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
        <style>
            .rounded-vertical-pills-icon .nav-pills a {
                -webkit-border-radius: 0.625rem !important;
                -moz-border-radius: 0.625rem !important;
                -ms-border-radius: 0.625rem !important;
                -o-border-radius: 0.625rem !important;
                border-radius: 0.625rem !important;
                background-color: #ffffff;
                border: solid 1px #e4e2e2;
                padding: 11px 23px;
                text-align: center;
                width: 100px;
                padding: 8px;
            }

            .rounded-vertical-pills-icon .nav-pills a svg {
                display: block;
                text-align: center;
                margin-bottom: 10px;
                margin-top: 5px;
                margin-left: auto;
                margin-right: auto;
            }

            .rounded-vertical-pills-icon .nav-pills .nav-link.active,
            .rounded-vertical-pills-icon .nav-pills .show>.nav-link {
                box-shadow: 0px 5px 15px 0px rgba(0, 0, 0, 0.3);
                background-color: #009688;
                border-color: transparent;
            }
        </style>
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
                        <div class="row">
                            <div id="tabsVerticalWithIcon" class="col-lg-12 col-12">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4 class="text-capitalize">{{ session('title') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content widget-content-area rounded-vertical-pills-icon">

                                        <div class="row mb-4 mt-3">
                                            <div class="col-sm-4 col-12">
                                                <div class="nav flex-column nav-pills mb-sm-0 mb-3"
                                                    id="rounded-vertical-pills-tab" role="tablist"
                                                    aria-orientation="vertical">
                                                    @foreach ($extras as $extra)
                                                        <a class="nav-link mb-2 {{ $extra->slug == $slug ? 'active' : '' }} mx-auto"
                                                            id="rounded-vertical-pills-profile-tab"
                                                            href="{{ route('score_extras.index', $extra->slug) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <line x1="12" y1="2" x2="12"
                                                                    y2="6"></line>
                                                                <line x1="12" y1="18" x2="12"
                                                                    y2="22"></line>
                                                                <line x1="4.93" y1="4.93" x2="7.76"
                                                                    y2="7.76"></line>
                                                                <line x1="16.24" y1="16.24" x2="19.07"
                                                                    y2="19.07"></line>
                                                                <line x1="2" y1="12" x2="6"
                                                                    y2="12"></line>
                                                                <line x1="18" y1="12" x2="22"
                                                                    y2="12"></line>
                                                                <line x1="4.93" y1="19.07" x2="7.76"
                                                                    y2="16.24"></line>
                                                                <line x1="16.24" y1="7.76" x2="19.07"
                                                                    y2="4.93"></line>
                                                            </svg> {{ $extra->name }}</a>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-12">
                                                <div class="tab-content" id="rounded-vertical-pills-tabContent">
                                                    <div class="tab-pane fade show active" id="rounded-vertical-pills-home"
                                                        role="tabpanel" aria-labelledby="rounded-vertical-pills-home-tab">
                                                        <div class="search-input-group-style input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-search">
                                                                        <circle cx="11" cy="11"
                                                                            r="8"></circle>
                                                                        <line x1="21" y1="21"
                                                                            x2="16.65" y2="16.65"></line>
                                                                    </svg></span>
                                                            </div>
                                                            <input type="text" id="input-search" class="form-control"
                                                                placeholder="Let's find your question in fast way"
                                                                aria-label="Username" aria-describedby="basic-addon1">
                                                        </div>
                                                        <form action="{{ route('score_extras.storeOrUpdate', $slug) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="table-responsive">
                                                                <input type="hidden" name="id_extra"
                                                                    value="{{ $detail_extra['id'] }}">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="align-middle">No</th>
                                                                            <th class="align-middle">Siswa</th>
                                                                            <th class="align-middle text-center">NIS</th>
                                                                            <th class="align-middle">Predikat</th>
                                                                            <th class="align-middle">Keterangan</th>
                                                                        </tr>

                                                                    </thead>
                                                                    <tbody id="student-table">
                                                                        @foreach ($result as $index => $student)
                                                                            <tr>
                                                                                <td>{{ $index + 1 }}</td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <div
                                                                                            class="usr-img-frame mr-2 rounded-circle">
                                                                                            <img alt="avatar"
                                                                                                class="img-fluid rounded-circle"
                                                                                                src="{{ $student['file'] != null ? asset($row['file']) : asset('asset/img/90x90.jpg') }}">
                                                                                        </div>
                                                                                        <p
                                                                                            class="align-self-center mb-0 admin-name">
                                                                                            {{ $student['name'] }}</p>
                                                                                    </div>
                                                                                </td>
                                                                                <input type="hidden"
                                                                                    name="id_student_class[]"
                                                                                    value="{{ $student['id_student_class'] }}">
                                                                                <td>{{ $student['nis'] }}</td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="score[]" {{ $student['status_form'] == false ? 'readonly' : '' }} value="{{ $student['score'] }}">
                                                                                    @error('score.' . $index)
                                                                                        <div class="invalid-feedback d-block">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </td>
                                                                                <td>
                                                                                    <textarea name="description[]" rows="2" class="form-control" {{ $student['status_form'] == false ? 'readonly' : '' }}>{{ $student['description'] }}</textarea>
                                                                                    @error('description.' . $index)
                                                                                        <div class="invalid-feedback d-block">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
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
                                    </div>
                                </div>
                            </div>
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
