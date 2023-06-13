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
            width: 8px;
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
        <h4>LEGER SEMESTER {{ session('semester') == 1 ? 'GANJIL' : 'GENAP' }}</h4>
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
        @php
            $totalScores = [];
            
            foreach ($results['score'] as $index => $score) {
                $totalScore = 0;
                foreach ($score['score'] as $score_student) {
                    $assigmentScore = $score_student['score']['assigment'] ?? 0;
                    $skillScore = $score_student['score']['skill'] ?? 0;
                    $totalScore += $assigmentScore + $skillScore;
                }
            
                $totalScores[$index] = $totalScore;
            }
            
            arsort($totalScores);
            $rankings = array_keys($totalScores);
        @endphp

        <table>
            <thead>
                <tr>
                    <th class="text-center" rowspan="2" style="width: 10px">No</th>
                    <th rowspan="2" style="font-size: 8px; width: 20px">NIS</th>
                    <th rowspan="2" class="student-column" style="font-size: 8px;">Nama</th>
                    @foreach ($results['course'] as $course)
                        <th class="text-center vertical-text" colspan="2" style="width: 10px">
                            <div class="rotate-text" style="font-size: 8px;">{{ $course['code'] }}</div>
                        </th>
                    @endforeach
                    <th rowspan="2" style="font-size: 8px;">Jumlah</th>
                    <th rowspan="2" style="font-size: 8px;">Ranking</th>
                </tr>
                <tr>
                    @foreach ($results['course'] as $course)
                        <th class="text-center vertical-text" style="font-size: 8px; width: 5px">P</th>
                        <th class="text-center vertical-text" style="font-size: 8px; width: 5px"">K</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($results['score'] as $index => $score)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td style="font-size: 8px;">{{ $score['nis'] }}</td>
                        <td style="font-size: 8px;">{{ $score['name'] }}</td>

                        @foreach ($score['score'] as $score_student)
                            <td class="text-center score-column score">
                                @if ($score_student['score']['assigment'] === null)
                                    -
                                @else
                                    {{ $score_student['score']['assigment'] }}
                                @endif
                            </td>
                            <td class="text-center score-column score">
                                @if ($score_student['score']['skill'] === null)
                                    -
                                @else
                                    {{ $score_student['score']['skill'] }}
                                @endif
                            </td>
                        @endforeach
                        <td class="text-center score-column score"> @php
                            $totalScore = 0;
                            foreach ($score['score'] as $score_student) {
                                $assigmentScore = $score_student['score']['assigment'] ?? 0;
                                $skillScore = $score_student['score']['skill'] ?? 0;
                                $totalScore += $assigmentScore + $skillScore;
                            }
                            
                            echo $totalScore;
                        @endphp</td>
                        <td class="text-center score-column score"> {{ array_search($index, $rankings) + 1 }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
