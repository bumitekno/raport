<!DOCTYPE html>
<html>

<head>
    <style>
        .widget-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .widget-header h4 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .widget-header p {
            font-size: 16px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            height: 30px;
            /* Tinggi baris */
        }

        th {
            background-color: #f2f2f2;
        }

        .vertical-text {
            text-align: center;
            white-space: nowrap;
        }

        .vertical-text span {
            display: inline-block;
            transform: rotate(90deg);
            width: 13px;
            writing-mode: vertical-lr;
        }

        /* Mengurangi ukuran font pada kolom nilai dan nama mata pelajaran */
        td.score,
        th.vertical-text span {
            font-size: 8px;
        }

        /* Mengatur lebar kolom agar tidak terpotong */
        .student-column {
            width: 100px;
            /* Sesuaikan lebar kolom siswa */
        }

        .score-column {
            width: 15px;
            /* Sesuaikan lebar kolom nilai */
        }
    </style>
</head>

<body>
    <div class="widget-header">
        <h4>DAFTAR KUMPULAN NILAI SEMESTER {{ session('semester') == 1 ? 'GANJIL' : 'GENAP' }}</h4>
        <p>{{ strtoupper($results['setting']['name_school']) }}</p>
        <p>TAHUN AJARAN {{ session('school_year') }}</p>
    </div>


    <div class="widget-content">
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
                        <th style="border: 1px solid black;" rowspan="4" align="center" valign="center">No</th>
                        <th style="border: 1px solid black;" rowspan="4" align="center" valign="center" width="30">NIS / NISN</th>
                        <th style="border: 1px solid black;" rowspan="4" align="center" valign="center" width="30">Nama</th>
                        <th style="border: 1px solid black;" rowspan="4" align="center" valign="center" width="20">Jenis Penilaian</th>
                        @forelse ( $group_course as $gc )
                            <th style="border: 1px solid black;" align="center" valign="center" colspan="{{ 2*$gc['count'] }}">
                                Kelompok {{$gc['category']}} {{ $gc['category'] != 'C' ? 'Umum' : 'Peminatan' }}
                            </th>                       
                        @empty
                        @endforelse
                        
                        <th style="border: 1px solid black;" align="center" valign="center" colspan="2">Sikap</th>
                        <th style="border: 1px solid black;" align="center" valign="center" colspan="3">Absensi</th>
                        <th style="border: 1px solid black;" rowspan="4" align="center" valign="center" class="vertical-text text-center">Naik</th>
                        {{-- <th style="border: 1px solid black;" rowspan="4" class="px-5" style="width: 30%; vertical-align: middle">Keterangan dari Guru</th> --}}
                        
                    </tr>
                    <tr>
                        {{-- Kode Mapel --}}
                        @foreach ($results['course'] as $course)
                            <th style="border: 1px solid black;" align="center" colspan="2">
                                <b>{{ $course['code'] }}</b>
                            </th>
                        @endforeach
                       
                        
                       
                        <th style="border: 1px solid black;" rowspan="3" align="center" valign="center"><b>Spriritual</b></th>
                        <th style="border: 1px solid black;" rowspan="3" align="center" valign="center"><b>Sosial</b></th>

                        <th style="border: 1px solid black;" rowspan="3" align="center" valign="center"><b>Sakit</b></th>
                        <th style="border: 1px solid black;" rowspan="3" align="center" valign="center"><b>Izin</b></th>
                        <th style="border: 1px solid black;" rowspan="3" align="center" valign="center"><b>Alpha</b></th>

                       
                    </tr>

                    <tr>
                        {{-- KKM --}}
                        @foreach ($results['course'] as $course)
                            <td style="border: 1px solid black;" align="center" valign="center"><b>KKM</b></td>
                            <td style="border: 1px solid black;" align="center" valign="center"><b>{{ $course['score'] }}</b></td>
                        @endforeach
                        

                    </tr>
                    <tr>
                        @foreach ($results['course'] as $course)
                            <td style="border: 1px solid black;" align="center" valign="center"><b>NP</b></td>
                            <td style="border: 1px solid black;" align="center" valign="center"><b>NK</b></td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- Baris 1 --}}
                    @foreach ($results['score'] as $score)
                        <tr>
                            <td style="border: 1px solid black;" rowspan="5" align="center" valign="center">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid black;" rowspan="5" align="center" valign="center">
                                <small>{{ $score['nis'] }}/{{ $score['nisn'] }}</small>
                                
                            </td>
                            <td style="border: 1px solid black;" rowspan="5" align="center" valign="center">{{ $score['name'] }}</td>
                            <td style="border: 1px solid black;">HPH</td>

                            @foreach ($score['score'] as $score_student)
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    @if (is_array($score_student['score']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['score'] }}
                                    @endif
                                </td>    
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    @if (is_array($score_student['keterampilan']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['keterampilan'] }}
                                    @endif
                                </td>   
                            @endforeach

                            @forelse ( $score['sikap'] as $sikap )
                                <td style="border: 1px solid black;" align="center" valign="center">
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
                                <td style="border: 1px solid black;" style="border: 1px solid black;"></td> 
                                <td style="border: 1px solid black;" style="border: 1px solid black;"></td> 
                            @endforelse

                            @forelse ( $score['absensi'] as $absensi )
                                <td style="border: 1px solid black;" rowspan="5" align="center" valign="center">
                                   {{$absensi['ill']}}
                                </td> 
                                <td style="border: 1px solid black;" rowspan="5" align="center" valign="center">
                                    {{$absensi['excused']}}
                                 </td> 
                                 <td style="border: 1px solid black;" rowspan="5" align="center" valign="center">
                                    {{$absensi['unexcused']}}
                                 </td> 
                                 <td style="border: 1px solid black;" rowspan="5" align="center" valign="center">
                                    {{$absensi['promotion']}}
                                 </td>      
                            @empty  
                            @endforelse  
                        </tr>

                        <tr>
                            <td style="border: 1px solid black;">HPTS</td>
                            @foreach ($score['score'] as $score_student)
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    @if (is_array($score_student['uts']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['uts'] }}
                                    @endif
                                </td>    
                                <td style="border: 1px solid black;" align="center" valign="center">
                                   
                                </td>   
                            @endforeach
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;"></td>
                            
                        </tr>

                        <tr>
                            <td style="border: 1px solid black;">HPAS</td>
                            @foreach ($score['score'] as $score_student)
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    @if (is_array($score_student['uas']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['uas'] }}
                                    @endif
                                </td>    
                                <td style="border: 1px solid black;" align="center" valign="center">
                                   
                                </td>   
                            @endforeach
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;"></td>
                            
                        </tr>

                        <tr>
                            <td style="border: 1px solid black;">HPA</td>
                            @foreach ($score['score'] as $score_student)
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    @if (is_array($score_student['nilai_akhir']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['nilai_akhir'] }}
                                    @endif
                                </td>    
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    @if (is_array($score_student['keterampilan']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['keterampilan'] }}
                                    @endif
                                </td>
                            @endforeach
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;"></td>
                            
                        </tr>

                        <tr>
                            <td style="border: 1px solid black;">PRE</td>
                            @foreach ($score['score'] as $score_student)
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    {{ $score_student['predikat_nilai_akhir'] }}
                                </td>    
                                <td style="border: 1px solid black;" align="center" valign="center">
                                    {{ $score_student['predikat_nilai_keterampilan'] }}
                                </td>   
                            @endforeach
                            <td style="border: 1px solid black;"></td>
                            <td style="border: 1px solid black;"></td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
