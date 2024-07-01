<!DOCTYPE html>
<html>

<head>
    <title>Laporan Hasil Belajar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            font-size: 11pt;
        }

        .table tbody tr.bg-color {
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

        {{-- <thead>

        </thead> --}}
        <tbody>
            @foreach ($result_score as $index => $score)
            <tr>
                <th colspan="5" style="font-size: 14pt !important" class="b-0 text-bold text-uppercase text-center">
                    RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA
                </th>
            </tr>
            <tr>
                <th colspan="5" class="b-0">
                    <table class="table b-0" style="margin-bottom:0">
                        <tr class="b-0">
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Nama Peserta Didik</b>
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px">
                                {{ $result_profile['name'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Kelas</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ $result_profile['study_class'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px"><b>NISN</b></td>
                            <td class="b-0" style="padding: 0px">:</td>
                            <td class="b-0" style="padding: 0px">
                                {{ $result_profile['nisn'] }}
                            </td>
                            <td class="b-0" style="padding: 0px"><b>Fase</b></td>
                            <td class="b-0" style="padding: 0px">:</td>
                            <td class="b-0" style="padding: 0px">{{ $result_profile['fase'] }}</td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Sekolah</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ $result_profile['school'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Semester</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ $result_profile['semester_number'] . ' (' . $result_profile['semester'] . ')' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Alamat</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; max-width: 250px">
                                {{ $result_profile['address_school'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Tahun Pelajaran</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                {{ $result_profile['school_year'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="b-0" style="padding: 0 0 2px 0">
                                <div style="border: solid 1px #000; margin-top: 0px"></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 10px" class="b-0"></td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <td colspan="5" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="text-left vertical-middle">
                                <div style="width: 100%; min-height: 60px">
                                    <b style="font-size: 13pt">Projek Profil 2 | {{ $score['tema'] }}</b>
                                    <p style="margin-top: 15px; margin-bottom: 0px">{{ $score['title'] }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="5" class="b-0"></td>
            </tr>
            <tr>
                <td class="text-center">{{ $score['tema'] }}</td>
                <td class="text-center" style="width: 40px">Belum Berkembang</td>
                <td class="text-center" style="width: 40px">Mulai Berkembang</td>
                <td class="text-center" style="width: 40px">Berkembang Sesuai Harapan</td>
                <td class="text-center" style="width: 40px">Sangat Berkembang</td>
            </tr>
            <tr>
                <td colspan="5" style="height: 10px"></td>
            </tr>
            @foreach ($score['dimensi'] as $dimensi)
            @if (count($dimensi['sub_elements']) > 0)
            <tr class="bg-color">
                <td style="font-weight: bold;">{{ $dimensi['name'] }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @foreach ($dimensi['sub_elements'] as $sub_element)
            @if ($sub_element['score'] != '')
            <tr>
                <td>
                    <span>&bull;</span> {{ $sub_element['name'] }}
                </td>
                <td class="text-center">
                    @if ($sub_element['score'] == 'belum')
                    <i class="fa fa-check"></i>
                    @endif
                </td>
                <td class="text-center">
                    @if ($sub_element['score'] == 'mulai')
                    <i class="fa fa-check"></i>
                    @endif
                </td>
                <td class="text-center">
                    @if ($sub_element['score'] == 'berkembang')
                    <i class="fa fa-check"></i>
                    @endif
                </td>
                <td class="text-center">
                    @if ($sub_element['score'] == 'sangat')
                    <i class="fa fa-check"></i>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
            @endforeach
            <tr>
                <td style="height: 10px" colspan="5" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="5" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="text-left vertical-middle">
                                <div style="width: 100%; min-height: 60px">
                                    <b style="font-size: 13pt">Catatan Proses</b>
                                    <p style="margin-top: 15px; margin-bottom: 0px">{{ $score['description'] }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="5" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="8" class="b-0">
                    <div class="signature">
                        <div style="float: left; width: 40%;">
                            <p>Mengetahui,</p>
                            <p>Orang tua peserta didik</p>
                            <p style="margin-top: 80px;">___________________</p>
                        </div>

                        <div style="float: right; width: 35%;">
                            <p>
                                {{ $result_other['place'] ?? 'Tidak diketahui' }},
                                {{ isset($result_other['date']) ? DateHelper::getTanggal($result_other['date']) : '' }}
                            </p>
                            <p>Wali Kelas</p>
                            <p style="margin-bottom: 0; margin-top: 80px; text-transform: ucwords;">
                                {{ $result_other['teacher'] }}
                            </p>
                            <!--<p style="margin-top : -15px">__________________________________________</p>-->
                            <p><b>NAK {{ $result_other['nip_teacher'] }}</b></p>
                        </div>

                        <div style="margin: 0 auto; width: 45%;">
                            <p class="text-center">Mengetahui,</p>
                            <p class="text-center">Kepala Sekolah</p>
                            @if ($result_other['signature'] != null)
                            <center>
                                <img src="{{ $result_other['signature'] }}" alt="" srcset="" style="height: 150px ">
                            </center>
                            @endif
                            <p
                                style="text-align: center; margin-bottom: 0; {{ $result_other['signature'] == null ? 'margin-top: 80px;' : '' }}">
                                {{ $result_other['headmaster'] }}
                            </p>
                            <!--<p style="text-align: center; margin-top : -15px">______________________________________</p>-->
                            <p style="text-align: center"><b>NAK {{ $result_other['nip_headmaster'] }}</b></p>
                        </div>
                    </div>
                </td>
            </tr>
            @if ($loop->last && $index == count($result_score) - 1)
            {{-- Kondisi untuk menghilangkan baris kosong pada akhir pengulangan --}}
            @else
            <tr>
                <td colspan="5" class="b-0">
                    <div style="page-break-before: always;"></div>
                </td>
            </tr>
            @endif
            @endforeach

        </tbody>
    </table>
</body>


</html>