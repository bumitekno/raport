@extends('layout.admin.v_main')
@section('content')
    @push('styles')
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
                        <div class="widget-content widget-content-area">
                            <div class="d-flex justify-content-between">
                                <h5 class=""></h5>
                                <div class="dropdown custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1"
                                        style="will-change: transform;">
                                        <a class="dropdown-item" href="{{ url('/leger/prev-classes/' . $slug . '?pdf=1') }}"
                                            target="_blank">Download
                                            PDF</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                                    <h4 class="pb-0">LEGER SEMESTER {{ session('semester') == 1 ? 'GANJIL' : 'GENAP' }}
                                    </h4>
                                    <h4 class="py-1">{{ strtoupper($results['setting']['name_school']) }}</h4>
                                    <h4 class="py-0">TAHUN AJARAN {{ session('school_year') }}</h4>
                                </div>
                            </div>
                            <table>
                                <tr>
                                    <td>Kelas</td>
                                    <td>: {{ $results['setting']['study_class'] }}</td>
                                </tr>
                                <tr>
                                    <td>Wali Kelas</td>
                                    <td>: {{ $results['setting']['teacher'] }}</td>
                                </tr>
                            </table>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-4" id="table-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">No</th>
                                            <th rowspan="2">NIS</th>
                                            <th rowspan="2">Nama</th>
                                            @foreach ($results['course'] as $course)
                                                <th class="text-center vertical-text" colspan="2">
                                                    <div class="rotate-text">{{ $course['code'] }}</div>
                                                </th>
                                            @endforeach
                                            <th rowspan="2">Jumlah</th>
                                            <th rowspan="2">Ranking</th>
                                        </tr>
                                        <tr>
                                            @foreach ($results['course'] as $course)
                                                <th class="text-center vertical-text">P</th>
                                                <th class="text-center vertical-text">K</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalScores = [];
                                        @endphp
                                        @foreach ($results['score'] as $score)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $score['nis'] }}</td>
                                                <td>{{ $score['name'] }}</td>

                                                @php
                                                    $totalScore = 0;
                                                    foreach ($score['score'] as $score_student) {
                                                        $assigmentScore = $score_student['score']['assigment'];
                                                        $skillScore = $score_student['score']['skill'];
                                                        $totalScore += ($assigmentScore !== null ? $assigmentScore : 0) + ($skillScore !== null ? $skillScore : 0);
                                                    }
                                                    $totalScores[] = $totalScore;
                                                @endphp

                                                @foreach ($score['score'] as $score_student)
                                                    <td class="text-center">
                                                        @if ($score_student['score']['assigment'] === null)
                                                            -
                                                        @else
                                                            {{ $score_student['score']['assigment'] }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($score_student['score']['skill'] === null)
                                                            -
                                                        @else
                                                            {{ $score_student['score']['skill'] }}
                                                        @endif
                                                    </td>
                                                @endforeach

                                                <td class="text-center">{{ $totalScore }}</td>
                                                <td class="text-center">{{ array_search($totalScore, $totalScores) + 1 }}
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
@endsection
