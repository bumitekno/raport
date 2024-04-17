@extends('layout.admin.v_main')
@section('content')
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
                                    <h4 class="pb-0">DAFTAR KUMPULAN NILAI {{ session('semester') == 1 ? 'GANJIL' : 'GENAP' }}
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
                            
                            <div class="table-responsive">
                                <table class="table table-bordered mb-4" id="table-list">
                                    <thead>
                                        <tr>
                                            <th rowspan="4" class="text-center" style="vertical-align: middle;">No</th>
                                            <th rowspan="4" style="vertical-align: middle;">NIS / NISN</th>
                                            <th rowspan="4" style="vertical-align: middle;">Nama</th>
                                            <th rowspan="4" style="vertical-align: middle;">Jenis Penilaian</th>
                                            @forelse ( $group_course as $gc )
                                                <th class="text-center" colspan="{{ 2*$gc['count'] }}">
                                                    Kelompok {{$gc['category']}} {{ $gc['category'] != 'C' ? 'Umum' : 'Peminatan' }}
                                                </th>                       
                                            @empty
                                            @endforelse
                                            <th class="text-center" colspan="2">Sikap</th>
                                            <th class="text-center" colspan="3">Absensi</th>
                                            <th rowspan="4" style="vertical-align: middle;" class="vertical-text text-center">Naik/Tidak Naik</th>
                                            {{-- <th rowspan="4" class="px-5" style="width: 30%; vertical-align: middle">Keterangan dari Guru</th> --}}
                                            
                                        </tr>
                                        <tr>
                                            {{-- Kode Mapel --}}
                                            @foreach ($results['course'] as $course)
                                                <th class="text-center vertical-text" colspan="2">
                                                    <div class="rotate-text text-center">{{ $course['code'] }}</div>
                                                </th>
                                            @endforeach
                                           
                                            
                                           
                                            <th rowspan="3" class="text-center vertical-text rotate-text"><b>Spriritual</b></th>
                                            <th rowspan="3" class="text-center vertical-text rotate-text"><b>Sosial</b></th>

                                            <th rowspan="3" class="text-center vertical-text rotate-text"><b>Sakit</b></th>
                                            <th rowspan="3" class="text-center vertical-text rotate-text"><b>Izin</b></th>
                                            <th rowspan="3" class="text-center vertical-text rotate-text"><b>Alpha</b></th>

                                           
                                        </tr>

                                        <tr>
                                            {{-- KKM --}}
                                            @foreach ($results['course'] as $course)
                                                <td class="text-center"><b>KKM</b></td>
                                                <td class="text-center"><b>{{ $course['score'] }}</b></td>
                                            @endforeach
                                            

                                        </tr>
                                        <tr>
                                            @foreach ($results['course'] as $course)
                                                <td class="text-center"><b>NP</b></td>
                                                <td class="text-center"><b>NK</b></td>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Baris 1 --}}
                                        @foreach ($results['score'] as $score)
                                            <tr>
                                                <td rowspan="5" class="text-center" style="border-bottom: 1px solid black;">{{ $loop->iteration }}</td>
                                                <td rowspan="5" style="border-bottom: 1px solid black;">
                                                    <small>{{ $score['nis'] }} <br> /{{ $score['nisn'] }}</small>
                                                    
                                                </td>
                                                <td rowspan="5" style="border-bottom: 1px solid black;">{{ $score['name'] }}</td>
                                                <td>HPH</td>

                                                @foreach ($score['score'] as $score_student)
                                                    <td class="text-center">
                                                        @if (is_array($score_student['score']))
                                                            {{ '--' }}
                                                        @else
                                                            {{ $score_student['score'] }}
                                                        @endif
                                                    </td>    
                                                    <td class="text-center">
                                                        @if (is_array($score_student['keterampilan']))
                                                            {{ '--' }}
                                                        @else
                                                            {{ $score_student['keterampilan'] }}
                                                        @endif
                                                    </td>   
                                                @endforeach

                                                @forelse ( $score['sikap'] as $sikap )
                                                    <td class="text-center">
                                                        @switch($sikap['predicate'])
                                                            @case('sangat baik')
                                                                A
                                                                @break
                                                            @case('baik')
                                                                B
                                                                @break
                                                            @case('cukup')
                                                                C
                                                                @break
                                                        
                                                            @default
                                                                D
                                                        @endswitch
                                                    </td> 
                                                @empty  
                                                    <td style="border: 1px solid black;"></td> 
                                                    <td style="border: 1px solid black;"></td> 
                                                @endforelse

                                                @forelse ( $score['absensi'] as $absensi )
                                                    <td rowspan="5" class="text-center">
                                                       {{$absensi['ill']}}
                                                    </td> 
                                                    <td rowspan="5" class="text-center">
                                                        {{$absensi['excused']}}
                                                     </td> 
                                                     <td rowspan="5" class="text-center">
                                                        {{$absensi['unexcused']}}
                                                     </td> 
                                                     <td rowspan="5" class="text-center">
                                                        {{$absensi['promotion']}}
                                                     </td> 
                                                     {{-- <td rowspan="5" style="font-size: 10px">
                                                        {{$absensi['description']}}
                                                     </td>  --}}
                                                @empty  
                                                    {{-- <td style="border: 1px solid black;"></td> 
                                                    <td style="border: 1px solid black;"></td> 
                                                    <td style="border: 1px solid black;"></td>  --}}
                                                @endforelse

                                               

                                               
                                            </tr>

                                            <tr>
                                                <td>HPTS</td>
                                                @foreach ($score['score'] as $score_student)
                                                    <td class="text-center">
                                                        @if (is_array($score_student['uts']))
                                                            {{ '--' }}
                                                        @else
                                                            {{ $score_student['uts'] }}
                                                        @endif
                                                    </td>    
                                                    <td class="text-center">
                                                       
                                                    </td>   
                                                @endforeach
                                                <td></td>
                                                <td></td>
                                                
                                            </tr>

                                            <tr>
                                                <td>HPAS</td>
                                                @foreach ($score['score'] as $score_student)
                                                    <td class="text-center">
                                                        @if (is_array($score_student['uas']))
                                                            {{ '--' }}
                                                        @else
                                                            {{ $score_student['uas'] }}
                                                        @endif
                                                    </td>    
                                                    <td class="text-center">
                                                       
                                                    </td>   
                                                @endforeach
                                                <td></td>
                                                <td></td>
                                                
                                            </tr>

                                            <tr>
                                                <td>HPA</td>
                                                @foreach ($score['score'] as $score_student)
                                                    <td class="text-center">
                                                        @if (is_array($score_student['nilai_akhir']))
                                                            {{ '--' }}
                                                        @else
                                                            {{ $score_student['nilai_akhir'] }}
                                                        @endif
                                                    </td>    
                                                    <td class="text-center">
                                                        @if (is_array($score_student['keterampilan']))
                                                            {{ '--' }}
                                                        @else
                                                            {{ $score_student['keterampilan'] }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td></td>
                                                <td></td>
                                                
                                            </tr>

                                            <tr>
                                                <td style="border-bottom: 1px solid black;">PRE</td>
                                                @foreach ($score['score'] as $score_student)
                                                    <td class="text-center" style="border-bottom: 1px solid black;">
                                                        {{ $score_student['predikat_nilai_akhir'] }}
                                                    </td>    
                                                    <td class="text-center" style="border-bottom: 1px solid black;">
                                                        {{ $score_student['predikat_nilai_keterampilan'] }}
                                                    </td>   
                                                @endforeach
                                                <td></td>
                                                <td></td>
                                                
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
