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

        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>NIS</th>
                    <th class="student-column">Nama</th>
                    @foreach ($results['course'] as $course)
                        <th class="text-center vertical-text">
                            <span style="font-size: 8px;">{{ $course['code'] }}</span>
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><b>KKM</b></td>
                    @foreach ($results['course'] as $course)
                        <td class="text-center" style="font-size: 8px;"><b>{{ $course['score'] }}</b></td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($results['score'] as $score)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $score['nis'] }}</td>
                        <td class="student-column">{{ $score['name'] }}</td>

                        @foreach ($score['score'] as $score_student)
                            <td class="text-center score-column score">
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
</body>

</html>
