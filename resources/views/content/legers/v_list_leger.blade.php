@extends('layout.admin.v_master')
@section('master')
    @push('styles')
        <style>
            .vertical-text {
                writing-mode: vertical-rl;
                text-orientation: mixed;
                white-space: nowrap;
            }

            .rotate-text {
                transform: rotate(178deg);
            }
        </style>
    @endpush
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">


            <div class="widget-content widget-content-area">
                <div class="d-flex justify-content-between">
                    <h5 class=""></h5>
                    <div class="dropdown custom-dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-1" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-more-horizontal">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1"
                            style="will-change: transform;">
                            <a class="dropdown-item" href="{{ url('/leger/prev-classes/' . $slug . '?pdf=1') }}" target="_blank">Download
                                PDF</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h4 class="pb-0">LEGER SEMESTER {{ session('semester') == 1 ? 'GANJIL' : 'GENAP' }}</h4>
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
                                <th class="text-center">No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                @foreach ($results['course'] as $course)
                                    <th class="text-center vertical-text">
                                        <div class="rotate-text">{{ $course['code'] }}</div>
                                    </th>
                                @endforeach
                            </tr>
                            <tr>
                                <td colspan="3" class="text-center"><b>KKM</b></td>
                                @foreach ($results['course'] as $course)
                                    <td class="text-center"><b>{{ $course['score'] }}</b></td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results['score'] as $score)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $score['nis'] }}</td>
                                    <td>{{ $score['name'] }}</td>

                                    @foreach ($score['score'] as $score_student)
                                        <td class="text-center">
                                            @if (is_array($score_student['score']))
                                                {{ '--' }}
                                            @else
                                                {{ $score_student['score'] }}
                                            @endif
                                        </td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
