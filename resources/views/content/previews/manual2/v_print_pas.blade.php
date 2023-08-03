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
            /* font-size: 9pt; */
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
            <td colspan="7" class="b-0">
                <table style="width: 100%">
                    <tr>
                        @if ($result_kop['left_logo'] != null)
                            <td class="b-0">
                                <img alt="logo kiri" id="prev-logo-kiri-print"
                                    src="{{ public_path($result_kop['left_logo']) }}" style="width: 85%;">
                            </td>
                        @endif

                        <td style="width:75%; text-align: center;" class="b-0">
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
                <td colspan="7" class="b-0" style="padding: 0px !important">
                    <hr style="border: solid 2px #000">
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="7" style="font-size: 14pt !important" class="b-0 text-bold text-uppercase text-center">
                LAPORAN HASIL BELAJAR
            </td>
        </tr>
        <thead>
            <tr>
                <td colspan="7" class="b-0">
                    <table class="table b-0">
                        <tr class="b-0">
                            <td class="b-0" style="padding: 0px; vertical-align: top">Nama Peserta Didik</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px">
                                {{ $result_profile['name'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Tahun Pelajaran</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">2022/2023</td>
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
                            <td class="b-0" style="padding: 0px; vertical-align: top">Kelas</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ $result_profile['study_class'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Jurusan</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ ucwords($result_profile['major']) }}</td>
                        </tr>
                        <tr>
                            <td style="height: 10px" class="b-0"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="b-0" colspan="7" style="font-size: 12pt">A. NILAI AKADEMIK</td>
            </tr>
            <tr>
                <th class="text-center" rowspan="3" colspan="2">
                    Mata Pelajaran</th>
                <th class="text-center" rowspan="3" style="width: 70px">
                    Kriteria Ketuntasan Minimum (KKM)</th>
                <th class="text-center" colspan="4">
                    Nilai Hasil Belajar</th>
            </tr>
            <tr>
                <th class="text-center" colspan="2">
                    Pengetahuan</th>
                <th class="text-center" colspan="2">
                    Ketrampilan</th>
            </tr>
            <tr>
                <th class="text-center">
                    Angka</th>
                <th class="text-center">
                    Predikat</th>
                <th class="text-center">
                    Angka</th>
                <th class="text-center">
                    Predikat</th>
            </tr>
            @if (!empty($result_score))
                @php
                    $total_assegment = 0;
                    $total_skill = 0;
                    $jumlah_course = 0;
                @endphp
                @foreach ($result_score as $group => $scores)
                    <tr>
                        <td colspan="7"><b>{{ $group }}</b></td>
                    </tr>
                    @if (!empty($scores))
                        @php
                            $no_course = 1;
                            $sub_total_assegment = 0;
                            $sub_total_skill = 0;
                        @endphp
                        @foreach ($scores as $score)
                            @php
                                if (!empty($score['final_assegment']) && !empty($score['final_skill'])) {
                                    $sub_total_assegment += (float) $score['final_assegment'];
                                    $sub_total_skill += (float) $score['final_skill'];
                                    $no_course++;
                                }
                            @endphp
                            <tr>
                                <td colspan="2">
                                    {{ $score['course'] }}</td>
                                <td class="text-center">
                                    {{ $score['kkm'] }}</td>
                                <td class="text-center">
                                    {{ $score['final_assegment'] }}
                                </td>
                                <td class="text-center">
                                    {{ $score['predicate_assegment'] }}
                                </td>
                                <td class="text-center">
                                    {{ $score['final_skill'] }}
                                </td>
                                <td class="text-center">
                                    {{ $score['predicate_skill'] }}
                                </td>
                            </tr>
                        @endforeach
                        @php
                            if ($no_course > 1) {
                                $total_assegment += (float) $sub_total_assegment;
                                $total_skill += (float) $sub_total_skill;
                                $jumlah_course += $no_course - 1;
                            }
                        @endphp
                        <tr>
                            <td colspan="3" class="text-center"><b>Sub Total</b></td>
                            <td class="text-center">{{ $sub_total_assegment }}</td>
                            <td></td>
                            <td class="text-center">{{ $sub_total_skill }}</td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
                @php
                    $rata_assegment = $jumlah_course > 0 ? round($total_assegment / $jumlah_course, 1) : 0;
                    $rata_skill = $jumlah_course > 0 ? round($total_skill / $jumlah_course, 1) : 0;
                @endphp
                <tr>
                    <td colspan="3" class="text-center">
                        <b>Total</b>
                    </td>
                    <td class="text-center">{{ $total_assegment }}</td>
                    <td></td>
                    <td class="text-center">{{ $total_skill }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">
                        Rata-rata
                    </td>
                    <td colspan="2" class="text-center">{{ $rata_assegment }}</td>
                    <td colspan="2" class="text-center">{{ $rata_skill }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="b-0"></td>
                    <td colspan="2" class="text-center">
                        <b>PERINGKAT KE:</b><br><br><br>Dari .... Siswa
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="7" class="text-center">Belum ada mapel yang dinilai</td>
                </tr>
            @endif

            <tr>
                <td style="height: 10px" colspan="7" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="7" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="b-0" style="font-size: 12pt">B. CATATAN AKADEMIK</td>
                            </tr>
                            <tr>
                                <td class="text-left vertical-middle">
                                    <div style="width: 100%; min-height: 60px">
                                        <p class="m-0">{!! $result_other['note_teacher'] !!}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="7" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="7" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="b-0" colspan="5" style="font-size: 12pt">C. PRAKTIK KERJA INDUSTRI
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">
                                    No</th>
                                <th class="text-center">
                                    Mitra DU/DI</th>
                                <th class="text-center">
                                    Lokasi</th>
                                <th class="text-center">
                                    Lama (Bulan)</th>
                                <th class="text-center">
                                    Keterangan</th>
                            </tr>
                            <tr>
                                <td class="text-center">1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="7" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="7" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="b-0" colspan="3" style="font-size: 12pt">D. EKSTRAKURIKULER
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">
                                    No</th>
                                <th class="text-center">
                                    Kegiatan Ekstrakurikuler</th>
                                <th class="text-center">
                                    Predikat</th>
                                <th class="text-center">
                                    Keterangan</th>
                            </tr>
                            @if (!empty($result_extra))
                                @foreach ($result_extra as $extra)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $extra['name'] }}</td>
                                        <td class="text-center">{{ $extra['score'] }}</td>
                                        <td>{{ $extra['description'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Ekstrakurikuler belum tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="5" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="7" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="2" style="font-size: 12pt">E. KETIDAKHADIRAN</td>
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
            <tr>
                <td style="height: 10px" colspan="7" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="7" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0"style="font-size: 12pt">F. CATATAN PERKEMBANGAN KARAKTER
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left vertical-middle">
                                <div style="width: 100%; min-height: 60px">
                                    <p class="m-0">
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="7" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="7" class="b-0" style="padding: 0px !important">
                    {{-- <table class="table">
                        <tr>
                            <td class="b-0"style="font-size: 12pt">G. KEPUTUSAN
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left vertical-middle">
                                <div style="width: 100%; min-height: 60px">
                                    <p class="m-0">
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div style="height: 10px"></div> --}}
                    <table class="table">
                        @if ($type_template == 'uas')
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
                                    <td class="b-0" colspan="2">semester 1 dan 2, maka peserta didik ini
                                        ditetapkan
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
                        @endif

                    </table>
                    <table class="table">
                        <tr>
                            <td class="b-0" style="text-align: right" colspan="7">
                                {{ $result_other['place'] ?? 'Tidak diketahui' }},
                                {{ isset($result_other['date']) ? DateHelper::getTanggal($result_other['date']) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center b-0" style="vertical-align: top">
                                <p class="text-uppercase text-center">Orang Tua / Wali</p>
                                <br><br><br><br>
                                <p>&nbsp;</p>
                            </td>
                            <td colspan="3" class="b-0 text-center" style="vertical-align: top; width: 50%">
                                <div style="margin: 0 auto;">
                                    <p class="text-uppercase text-center">Kepala Sekolah</p>
                                    @if ($result_other['signature'] != null)
                                        <center>
                                            <img src="{{ $result_other['signature'] }}" alt=""
                                                srcset="" style="height: 80px">
                                        </center>
                                    @endif
                                    <p
                                        style="text-align: center; margin-bottom: 0; {{ $result_other['signature'] == null ? 'margin-top: 80px;' : '' }}">
                                        {{ $result_other['headmaster'] }}</p>
                                    <p style="text-align: center; margin-top : -15px">___________________</p>
                                    <p style="text-align: center">NIP {{ $result_other['nip_headmaster'] }}</p>
                                </div>

                            </td>
                            <td colspan="2" class="b-0 text-center" style="vertical-align: top">
                                <div style="margin: 0 auto;">
                                    <p class="text-uppercase text-center">Wali Kelas</p>
                                    <p style="text-align: center; margin-bottom: 0; margin-top: 80px;">
                                        {{ $result_other['teacher'] }}</p>
                                    <p style="text-align: center; margin-top : -15px">___________________</p>
                                    <p style="text-align: center">NIP {{ $result_other['nip_teacher'] }}</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
