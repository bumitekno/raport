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
            padding: 8px;
            text-align: center;
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
            writing-mode: vertical-lr;
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
                    <th>Nama</th>
                    @foreach ($results['course'] as $course)
                        <th class="text-center vertical-text">
                            <span>{{ $course['code'] }}</span>
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
</body>

</html>
