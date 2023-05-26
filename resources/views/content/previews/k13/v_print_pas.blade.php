<!DOCTYPE html>
<html>

<head>
    <title>Laporan Hasil Belajar</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 11pt;
            color: #333;
        }

        .header {
            width: 100%;
            text-align: center;
            font-weight: 500;
            font-size: 16pt;
            margin-bottom: 20px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }

        .table td p {
            margin: 0px;
            text-align: justify;
            font-size: 9pt;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: 500;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-bold {
            font-weight: bold;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .signature {
            margin-top: 30px;
        }

        .b-0 {
            border: 0 !important;
        }

        .signature p {
            margin: 0;
        }
    </style>
</head>

<body>
    <table class="table">
        <tr>
            <td colspan="8" class="b-0">
                <table style="width: 100%">
                    <tr>
                        @if ($result_kop['left_logo'] != null)
                            <td class="b-0">
                                <img alt="logo kiri" id="prev-logo-kiri-print"
                                    src="{{ public_path($result_kop['left_logo']) }}" style="width: 85%;">
                            </td>
                        @endif

                        <td style="width:70%; text-align: center;" class="b-0">
                            <div class="text-uppercase" style="line-height: 1.1; font-family: 'Arial'; font-size: 12pt">
                                {{ $result_kop['text1'] }}
                            </div>
                            <div style="line-height: 1.1; font-family: 'Arial'; font-size: 16pt" class="text-uppercase">
                                {{ $result_kop['text2'] }}
                            </div>
                            <div style="line-height: 1.2; font-family: 'Arial'; font-size: 16pt"
                                class="text-uppercase text-bold">
                                {{ $result_kop['text3'] }}
                            </div>
                            <div style="line-height: 1.2; font-family: 'Arial'; font-size: 8pt">
                                {{ $result_kop['text5'] }}
                            </div>
                        </td>
                        @if ($result_kop['right_logo'] != null)
                            <td class="b-0">
                                <img alt="logo kiri" id="prev-logo-kiri-print"
                                    src="{{ public_path($result_kop['right_logo']) }}" style="width: 85%;">
                            </td>
                        @endif
                    </tr>

                </table>
            </td>
        </tr>
        @if ($result_kop['text1'] != null)
            <tr>
                <td colspan="8" class="b-0" style="padding: 0px !important">
                    <hr style="border: solid 2px #000">
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="8" style="font-size: 14pt !important" class="b-0 text-bold text-uppercase text-center">
                RAPOR PESERTA DIDIK DAN PROFIL PESERTA DIDIK
            </td>
        </tr>
        <thead>
            <tr>
                <td colspan="8" class="b-0">
                    <table class="table b-0">
                        <tr class="b-0">
                            <td class="b-0" style="padding: 0px; vertical-align: top">Nama Peserta Didik</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px">
                                {{ $result_profile['name'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Kelas</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ $result_profile['study_class'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px">NISN</td>
                            <td class="b-0" style="padding: 0px">:</td>
                            <td class="b-0" style="padding: 0px">
                                {{ $result_profile['nisn'] }}
                            </td>
                            <td class="b-0" style="padding: 0px;">Semester</td>
                            <td class="b-0" style="padding: 0px;">:</td>
                            <td class="b-0" style="padding: 0px;">
                                {{ $result_profile['semester_number'] . ' (' . $result_profile['semester'] . ')' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Sekolah</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ $result_profile['school'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Tahun Pelajaran</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">2022/2023</td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Alamat</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px;" colspan="4">
                                {{ $result_profile['address_school'] }}
                            </td>
                        </tr>

                        <tr>
                            <td style="height: 10px" class="b-0"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody>
            @if (!empty($result_attitude))
                <tr>
                    <td colspan="8" class="b-0" style="padding: 0px !important">
                        <table class="table">
                            <tr>
                                <td class="b-0" colspan="2" style="font-size: 12pt">A. SIKAP
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" colspan="2">
                                    Deskripsi</th>
                            </tr>
                            @foreach ($result_attitude as $index => $attitude)
                                <tr>
                                    <td class="text-center" style="width: 150px">
                                        <b>{{ $loop->iteration }}. Sikap
                                            {{ $attitude['type'] == 'social' ? 'Sosial' : 'Spiritual' }}</b>
                                    </td>
                                    <td>{{ $result_profile['name'] }} memiliki sikap
                                        {{ $attitude['type'] == 'social' ? 'Sosial' : 'Spiritual' }}
                                        {{ $attitude['predicate'] }}, antara lain
                                        {{ implode(', ', $attitude['attitudes']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="height: 10px" colspan="4" class="b-0"></td>
                </tr>
            @endif

            <tr>
                <td class="b-0" colspan="8" style="font-size: 12pt">B. PENGETAHUAN DAN KETERAMPILAN</td>
            </tr>
            <tr>
                <td class="b-0" colspan="8" style="font-size: 12pt">Kriteria Ketuntasan Minimal Satuan
                    Pendidikan=
                    65</td>
            </tr>
            <tr>
                <th class="text-center vertical-middle" rowspan="2">
                    No
                </th>
                <th class="text-center" rowspan="2">
                    Mata Pelajaran</th>
                <th class="text-center" colspan="3">
                    Pengetahuan</th>
                <th class="text-center" colspan="3">
                    Ketrampilan</th>

            </tr>
            <tr>
                <th class="text-center">
                    Angka</th>
                <th class="text-center">
                    Predikat</th>
                <th class="text-center">
                    Deskripsi</th>
                <th class="text-center">
                    Angka</th>
                <th class="text-center">
                    Predikat</th>
                <th class="text-center">
                    Deskripsi</th>
            </tr>
            @if (!empty($result_score))
                @foreach ($result_score as $score)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            {{ $score['course'] }}</td>
                        <td class="text-center">
                            {{ $score['final_assessment'] }}</td>
                        <td class="text-center">
                            {{ $score['predicate_assessment'] }}
                        </td>
                        <td>
                            @if ($score['description_assessment'])
                                <p>Penguasaan pengetahuan {{ $score['description_assessment'] }}
                                    dalam {{ implode(', ', $score['kd_assessment']) }}</p>
                            @endif
                        </td>
                        <td class="text-center">{{ $score['final_skill'] }}</td>
                        <td class="text-center">{{ $score['predicate_skill'] }}</td>
                        <td>
                            @if ($score['description_skill'])
                                <p>Penguasaan ketrampilan {{ $score['description_skill'] }}
                                    dalam {{ implode(', ', $score['kd_skill']) }}</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">Belum ada mapel yang dinilai</td>
                </tr>
            @endif

            <tr>
                <td style="height: 10px" colspan="8" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="8" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="3" style="font-size: 12pt">C. EKSTRAKURIKULER
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">
                                No</th>
                            <th class="text-center">
                                Kegiatan Ekstrakurikuler</th>
                            <th class="text-center">
                                Keterangan</th>
                        </tr>
                        @if (!empty($result_extra))
                            @foreach ($result_extra as $extra)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $extra['name'] }}</td>
                                    <td>{{ $extra['description'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">Ekstrakurikuler belum tersedia</td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="4" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="8" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" style="font-size: 12pt">D. SARAN-SARAN</td>
                        </tr>
                        <tr>
                            <td class="text-left vertical-middle">
                                <div style="width: 100%; min-height: 60px">
                                    <p class="m-0">{!! $result_other['note_teacher'] !!}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="8" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="8" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="3" style="font-size: 12pt">E. TINGGI DAN BERAT BADAN
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" rowspan="2" style="width: 50px">
                                No</th>
                            <th class="text-center" rowspan="2" style="width: 150px">
                                Aspek Yang Dinilai</th>
                            <th class="text-center" colspan="2">
                                Semester</th>
                        </tr>
                        <tr>
                            <th class="text-center">1 (Satu)</th>
                            <th class="text-center">2 (Dua)</th>
                        </tr>
                        <tr>
                            <td class="text-center">
                                1</td>
                            <td>Tinggi Badan</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                2</td>
                            <td>Berat Badan</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="8" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="8" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="3" style="font-size: 12pt">F. KONDISI KESEHATAN
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 50px">
                                No</th>
                            <th class="text-center" style="width: 150px">
                                Aspek Yang Dinilai</th>
                            <th class="text-center">
                                Keterangan</th>
                        </tr>
                        <tr>
                            <td class="text-center">
                                1</td>
                            <td>Pendengaran</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                2</td>
                            <td>Penglihatan</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                3</td>
                            <td>Gigi</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                4</td>
                            <td>Lainnya</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="8" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="8" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="3" style="font-size: 12pt">G. PRESTASI
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">
                                No</th>
                            <th class="text-center">
                                Jenis Prestasi</th>
                            <th class="text-center">
                                Keterangan</th>
                        </tr>
                        @for ($i = 1; $i <= 3; $i++)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ $result_achievement[$i - 1]['name'] ?? '' }}</td>
                                <td>{{ $result_achievement[$i - 1]['description'] ?? '' }}</td>
                            </tr>
                        @endfor
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="8" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="5" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="2" style="font-size: 12pt">H. KETIDAK HADIRAN</td>
                        </tr>
                        <tr>
                            <td>
                                Sakit</td>
                            <td class="text-center">
                                {{ $result_attendance['ill'] }} Hari
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Izin</td>
                            <td class="text-center">
                                {{ $result_attendance['excused'] }} Hari
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tanpa Keterangan</td>
                            <td class="text-center">
                                {{ $result_attendance['unexcused'] }} Hari
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%">
        @if ($type_template == 'uas')
            <tr>
                <td>
                    <div style="height: 10px"></div>
                    <table class="table">
                        <tr>
                            <td class="b-0">Diberikan di</td>
                            <td class="b-0">: {{ $result_other['place'] ?? 'Tidak diketahui' }}</td>
                            <td class="b-0" style="width: 50px"></td>
                            <td class="b-0" colspan="2">KEPUTUSAN</td>
                        </tr>
                        <tr>
                            <td class="b-0">tanggal</td>
                            <td class="b-0">:
                                {{ isset($result_other['date']) ? DateHelper::getTanggal($result_other['date']) : '' }}
                            </td>
                            <td class="b-0"></td>
                            <td class="b-0" colspan="2">Dengan memperhatikan hasil yang dicapai</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="b-0"></td>
                            <td class="b-0" colspan="2">semester 1 dan 2, maka peserta didik ini ditetapkan
                            </td>
                        </tr>
                        @if ($result_other['promotion'] == 'Y')
                            <tr>
                                <td colspan="3" class="b-0"></td>
                                <td class="b-0" style="width: 80px">Naik kelas</td>
                                <td class="b-0">: {{ $result_profile['level'] + 1 }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="b-0"></td>
                                <td class="b-0" colspan="2"><s>Tinggal di Kelas</s></td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3" class="b-0"></td>
                                <td class="b-0" style="width: 80px"><s>Naik kelas</s></td>
                                <td class="b-0">: </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="b-0"></td>
                                <td class="b-0">Tinggal di Kelas</td>
                                <td class="b-0">: {{ $result_profile['level'] }}</td>
                            </tr>
                        @endif

                    </table>
                </td>
            </tr>
        @endif
        <tr>
            <td>
                <div class="signature">
                    <div style="float: left; width: 40%;">
                        <p>Mengetahui,</p>
                        <p>Orang tua peserta didik</p>
                        <p style="margin-top: 80px;">___________________</p>
                    </div>

                    <div style="float: right; width: 40%;">
                        <p>
                            {{ $result_other['place'] ?? 'Tidak diketahui' }},
                            {{ isset($result_other['date']) ? DateHelper::getTanggal($result_other['date']) : '' }}
                        </p>
                        <p>Wali Kelas</p>
                        <p style="margin-bottom: 0; margin-top: 80px">
                            {{ $result_other['teacher'] }}</p>
                        <p style="margin-top : -15px">______________________</p>
                        <p>NIP {{ $result_other['nip_teacher'] }}</p>
                    </div>

                    <div style="margin: 0 auto; width: 40%;">
                        <p class="text-uppercase text-center">Kepala Sekolah</p>
                        @if ($result_other['signature'] != null)
                            <center>
                                <img src="{{ $result_other['signature'] }}" alt="" srcset=""
                                    style="height: 150px">
                            </center>
                        @endif
                        <p
                            style="text-align: center; margin-bottom: 0; {{ $result_other['signature'] == null ? 'margin-top: 80px;' : '' }}">
                            {{ $result_other['headmaster'] }}</p>
                        <p style="text-align: center; margin-top : -15px">___________________</p>
                        <p style="text-align: center">NIP {{ $result_other['nip_headmaster'] }}</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
