@extends('layout.admin.v_main')
@section('content')
    @push('styles')
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
                        <div class="row">
                            <div id="tabsVerticalWithIcon" class="col-lg-12 col-12">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div
                                                class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                                <h4>{{ session('title') }}</h4>
                                                <div class="form-group my-auto">
                                                    <select name="id_school_year" class="form-control" id="school_year">
                                                        <option value="" selected disabled>-- Pilih Tahun Ajaran --
                                                        </option>
                                                        @foreach ($school_years as $school_year)
                                                            <option value="{{ $school_year['slug'] }}"
                                                                {{ $school_year['slug'] == $_GET['year'] ? 'selected' : '' }}>
                                                                {{ $school_year['school_year'] . ' ' . $school_year['semester']['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content widget-content-area rounded-vertical-pills-icon">

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
                                                                <circle cx="11" cy="11" r="8">
                                                                </circle>
                                                                <line x1="21" y1="21" x2="16.65"
                                                                    y2="16.65"></line>
                                                            </svg></span>
                                                    </div>
                                                    <input type="text" id="input-search" class="form-control"
                                                        placeholder="Let's find your question in fast way"
                                                        aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                                <form action="" method="post">
                                                    @csrf
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="align-middle text-center">No</th>
                                                                    <th class="align-middle">Nama</th>
                                                                    <th class="align-middle">NIS</th>
                                                                    <th class="align-middle text-center">Sampul</th>
                                                                    <th class="align-middle text-center">Raport</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="class-table">
                                                                @foreach ($student_class as $student)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                                        <td>{{ $student['name'] }}</td>
                                                                        <td>{{ $student['nis'] }}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{ route('previews.print_cover', ['student' => $student['slug'], 'year' => $_GET['year']]) }}" target="_blank" class="text-primary">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <path
                                                                                        d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                                                                                </svg>
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="{{ route('previews.print_other', ['student' => $student['slug'], 'year' => $_GET['year']]) }}" target="_blank" class="text-primary">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <path
                                                                                        d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#input-search').on('keyup', function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('#class-table tr').hide();
                    $('#class-table tr').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                });

                $('#school_year').change(function() {
                    var year = $(this).val();
                    var query_string = location.search;
                    var study_class = query_string.match(/study_class=([^&]+)/) ? RegExp.$1 : '';
                    var url = "prev-classes?study_class=" + study_class + "&year=" + year;
                    location.href = url;
                });

            });
        </script>
    @endpush
@endsection
