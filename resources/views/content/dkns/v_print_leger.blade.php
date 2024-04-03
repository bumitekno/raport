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
            <table style="border:#000 solid" id="table-list">
                <thead>
                    <tr>
                        <th rowspan="3" align="center" valign="center" style="border: 2px solid black; background:grey"><b>No</b></th>
                        <th rowspan="3" align="center" valign="center" style="border: 2px solid black;"><b>NIS</b></th>
                        <th rowspan="3" align="center" valign="center" style="border: 2px solid black;" width="30"><b>Nama</b></th>
                        <th align="center" valign="center" style="border: 2px solid black;" colspan="{{ count($results['course']) }}"><b>Pengetahuan</b></th>
                        
                        <th align="center" valign="center" style="border: 2px solid black;" colspan="{{ count($results['course']) }}"><b>Keterampilan</b></th>
                        <th align="center" valign="center" style="border: 2px solid black;" colspan="2" width="30"><b>Sikap</b></th>
                        <th align="center" valign="center" style="border: 2px solid black;" colspan="2" width="30"><b>Jumlah</b></th>
                        <th rowspan="3" align="center" valign="center" style="border: 2px solid black;" width="12">Jumlah Nilai</th>
                        <th rowspan="3" align="center" valign="center" style="border: 2px solid black;" width="12">Ranking</th>
                        
                    </tr>
                    <tr>
                        @foreach ($results['course'] as $course)
                            <th align="center" style="border: 1px solid black;">
                                <div class="rotate-text"><b>{{ $course['code'] }}</b></div>
                            </th>
                        @endforeach
                        @foreach ($results['course'] as $course)
                            <th align="center" style="border: 1px solid black;">
                                <div class="rotate-text"><b>{{ $course['code'] }}</b></div>
                            </th>
                        @endforeach
                        
                       
                        <th rowspan="2" align="center" valign="center" style="border: 1px solid black;" width="15"><b>Spriritual</b></th>
                        <th rowspan="2" align="center" valign="center" style="border: 1px solid black;" width="15"><b>Sosial</b></th>

                        <th align="center" style="border: 1px solid black;" width="15"><b>Pengetahuan</b></th>
                        <th align="center" style="border: 1px solid black;" width="15"><b>Ketrampilan</b></th>
                    </tr>

                    <tr>
                        @foreach ($results['course'] as $course)
                            <td align="center" style="border: 1px solid black;"><b>{{ $course['score'] }}</b></td>
                        @endforeach
                        @foreach ($results['course'] as $course)
                            <td align="center" style="border: 1px solid black;"><b>{{ $course['score'] }}</b></td>
                        @endforeach

                        <th align="center" style="border: 1px solid black;"><b>YA</b></th>
                        <th align="center" style="border: 1px solid black;"><b>YA</b></th>

                       
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results['score'] as $score)
                        <tr>
                            <td align="center" style="border: 1px solid black;">{{ $loop->iteration }}</td>
                            <td align="center" style="border: 1px solid black;">{{ $score['nis'] }}</td>
                            <td style="border: 1px solid black;">{{ $score['name'] }}</td>

                            @foreach ($score['score'] as $score_student)
                                <td align="center" style="border: 1px solid black;">
                                    @if (is_array($score_student['score']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['score'] }}
                                    @endif
                                </td>

                                <td align="center" style="border: 1px solid black;">
                                    @if (is_array($score_student['keterampilan']))
                                        {{ '--' }}
                                    @else
                                        {{ $score_student['keterampilan'] }}
                                    @endif
                                </td>   
                            @endforeach

                            @forelse ( $score['sikap'] as $sikap )
                                <td align="center" style="border: 1px solid black;">
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

                            <td align="center" style="border: 1px solid black;">
                                {{ $score['jml_score'] }}
                            </td>
                            <td align="center" style="border: 1px solid black;">
                                {{ $score['jml_keterampilan'] }}
                            </td>
                            <td align="center" style="border: 1px solid black;">
                                {{ $score['jml_nilai'] }}
                            </td>
                            <td align="center" style="border: 1px solid black;">
                                {{ $loop->iteration }}
                            </td>


                            

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
