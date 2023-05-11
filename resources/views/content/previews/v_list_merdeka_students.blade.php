@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/search.css') }}">
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
                                        <select name="id_school_year" class="form-control" id="school_year">
                                            <option value="" selected disabled>-- Pilih Tahun Ajaran --</option>
                                            @foreach ($years as $school_year)
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
                        <div class="widget-content widget-content-area br-8">
                            <div class="search-input-group-style input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-search">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg></span>
                                </div>
                                <input type="text" id="input-search" class="form-control"
                                    placeholder="Let's find your question in fast way" aria-label="Username"
                                    aria-describedby="basic-addon1">
                            </div>
                            <div class="table-responsive">
                                <table class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Siswa</th>
                                            <th>NIS</th>
                                            <th class="text-center">Sampul</th>
                                            <th class="text-center">UTS</th>
                                            <th class="text-center">UAS</th>
                                            <th class="text-center">P5</th>
                                        </tr>
                                    </thead>
                                    <tbody id="student-table">
                                        @foreach ($students as $student)
                                            <tr>
                                                <td class="text-enter">{{ $loop->iteration }}</td>
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
                                                <td>{{ $student->nis }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('previews.print_cover', ['student' => $student->slug, 'year' => $_GET['year']]) }}" target="_blank" class="text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="15" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65"></line>
                                                            <line x1="11" y1="8" x2="11"
                                                                y2="14"></line>
                                                            <line x1="8" y1="11" x2="14"
                                                                y2="11"></line>
                                                        </svg>
                                                        Lihat Sampul
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('previews.print_other', ['student' => $student['slug'], 'year' => $_GET['year'], 'type' => 'uts']) }}" target="_blank" class="text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="15" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65"></line>
                                                            <line x1="11" y1="8" x2="11"
                                                                y2="14"></line>
                                                            <line x1="8" y1="11" x2="14"
                                                                y2="11"></line>
                                                        </svg>
                                                        Lihat UTS
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('previews.print_other', ['student' => $student['slug'], 'year' => $_GET['year'], 'type' => 'uas']) }}" target="_blank" class="text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="15" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65"></line>
                                                            <line x1="11" y1="8" x2="11"
                                                                y2="14"></line>
                                                            <line x1="8" y1="11" x2="14"
                                                                y2="11"></line>
                                                        </svg>
                                                        Lihat UAS
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('previews.printp5', ['student' => $student['slug'], 'year' => $_GET['year']]) }}" target="_blank" class="text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="15" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65"></line>
                                                            <line x1="11" y1="8" x2="11"
                                                                y2="14"></line>
                                                            <line x1="8" y1="11" x2="14"
                                                                y2="11"></line>
                                                        </svg>
                                                        Lihat P5
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {

                $('#input-search').on('keyup', function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('#student-table tr').hide();
                    $('#student-table tr').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                });

                $('#school_year').change(function() {
                    window.location.href = "preview?template=merdeka&year=" + $(this).val();
                });
            });
        </script>
    @endpush
@endsection
