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
            <td colspan="7" class="b-0">
                <table style="width: 100%">
                    <tr>
                        <td class="b-0">
                            <img alt="logo kiri" id="prev-logo-kiri-print" src="{{ public_path('asset/img/logo.png') }}"
                                style="width: 85%;">
                        </td>

                        <td style="width:70%; text-align: center;" class="b-0">
                            <div class="text-uppercase" style="line-height: 1.1; font-family: 'Arial'; font-size: 12pt">
                                BADAN PENGEMBANGAN SUMBER DAYA MANUSIA INDUSTRI
                            </div>
                            <div style="line-height: 1.1; font-family: 'Arial'; font-size: 16pt" class="text-uppercase">
                                SEKOLAH MENENGAH KEJURUAN
                            </div>
                            <div style="line-height: 1.2; font-family: 'Arial'; font-size: 16pt"
                                class="text-uppercase text-bold">
                                TEMANGGUNG
                            </div>
                            <div style="line-height: 1.2; font-family: 'Arial'; font-size: 8pt">
                                Jl. Jenderal Sudirman No. 43, Telp (0721) 4343245, NPSN 343243, Website :
                                www.sekolahku.sch.id
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td colspan="7" class="b-0" style="padding: 0px !important">
                <hr style="border: solid 2px #000">
            </td>
        </tr>
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
                                John Doe
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Tahun Pelajaran</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">2022/2023</td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px">NISN</td>
                            <td class="b-0" style="padding: 0px">:</td>
                            <td class="b-0" style="padding: 0px">
                                1234567890
                            </td>
                            <td class="b-0" style="padding: 0px;">Semester</td>
                            <td class="b-0" style="padding: 0px;">:</td>
                            <td class="b-0" style="padding: 0px;">
                                2 (Genap)
                            </td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Kelas</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                12A
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">Jurusan</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
                                IPA (Ilmu Pengetahuan Alam)
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
            <tr>
                <td class="b-0" colspan="7" style="font-size: 12pt">A. NILAI AKADEMIK</td>
            </tr>
            <tr>
                <th class="text-center vertical-middle" style="width: 45px" rowspan="3">
                    No
                </th>
                <th class="text-center" rowspan="3">
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
            <tr>
                <td colspan="7"><b>Kelompok 1</b></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td>
                    Matematika</td>
                <td class="text-center">
                    75</td>
                <td class="text-center">
                    80
                </td>
                <td class="text-center">
                    A
                </td>
                <td class="text-center">
                    85
                </td>
                <td class="text-center">
                    A
                </td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>
                    Bahasa Inggris</td>
                <td class="text-center">
                    70</td>
                <td class="text-center">
                    75
                </td>
                <td class="text-center">
                    A-
                </td>
                <td class="text-center">
                    80
                </td>
                <td class="text-center">
                    B+
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-center"><b>Sub Total</b></td>
                <td class="text-center">155</td>
                <td></td>
                <td class="text-center">165</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7"><b>Kelompok 2</b></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td>
                    Fisika</td>
                <td class="text-center">
                    70</td>
                <td class="text-center">
                    75
                </td>
                <td class="text-center">
                    A-
                </td>
                <td class="text-center">
                    80
                </td>
                <td class="text-center">
                    B+
                </td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>
                    Kimia</td>
                <td class="text-center">
                    75</td>
                <td class="text-center">
                    80
                </td>
                <td class="text-center">
                    A
                </td>
                <td class="text-center">
                    85
                </td>
                <td class="text-center">
                    A
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-center"><b>Sub Total</b></td>
                <td class="text-center">155</td>
                <td></td>
                <td class="text-center">165</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">
                    <b>Total</b>
                </td>
                <td class="text-center">310</td>
                <td></td>
                <td class="text-center">330</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">
                    Rata - rata
                </td>
                <td colspan="2" class="text-center">155</td>
                <td colspan="2" class="text-center">165</td>
            </tr>
            <tr>
                <td colspan="5" class="b-0"></td>
                <td colspan="2" class="text-center">
                    <b>PERINGKAT KE:</b><br><br><br>Dari .... Siswa
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
                                <td class="b-0" style="font-size: 12pt">B. CATATAN AKADEMIK</td>
                            </tr>
                            <tr>
                                <td class="text-left vertical-middle">
                                    <div style="width: 100%; min-height: 60px">
                                        <p class="m-0">Siswa yang aktif dalam kegiatan kelas dan memiliki
                                            partisipasi yang baik.</p>
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
                                    Keterangan</th>
                            </tr>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Futsal</td>
                                <td>Kegiatan olahraga sepak bola dalam ruangan</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Pramuka</td>
                                <td>Kegiatan kepramukaan yang meliputi kegiatan perkemahan dan keterampilan alam</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Basketball</td>
                                <td>Kegiatan olahraga bola basket</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>Paduan Suara</td>
                                <td>Kegiatan bermusik dalam bentuk paduan suara</td>
                            </tr>

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
                                1 Hari
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Izin</td>
                            <td class="text-center">
                                2 Hari
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tanpa Keterangan</td>
                            <td class="text-center">
                                - Hari
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
                    <table class="table">
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
                    <div style="height: 10px"></div>
                    <table class="table">
                        <tr>
                            <td class="b-0">Diberikan di</td>
                            <td class="b-0">: Temanggung</td>
                            <td class="b-0" style="width: 50px"></td>
                            <td class="b-0" colspan="2">KEPUTUSAN</td>
                        </tr>
                        <tr>
                            <td class="b-0">tanggal</td>
                            <td class="b-0">:
                                20 Mei 2023
                            </td>
                            <td class="b-0"></td>
                            <td class="b-0" colspan="2">Dengan memperhatikan hasil yang dicapai</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="b-0"></td>
                            <td class="b-0" colspan="2">semester 1 dan 2, maka peserta didik ini ditetapkan
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="b-0"></td>
                            <td class="b-0" style="width: 80px">Naik kelas</td>
                            <td class="b-0">: 3</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="b-0"></td>
                            <td class="b-0" colspan="2"><s>Tinggal di Kelas</s></td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td class="b-0" style="text-align: right" colspan="7">
                                Temangung, 20 Mei 2023
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center b-0" style="vertical-align: top">
                                Orang Tua / Wali <br> Peserta Didik
                                <br><br><br><br>
                                <p>&nbsp;</p>
                            </td>
                            <td colspan="3" class="b-0 text-center" style="vertical-align: top">
                                <div style="margin: 0 auto; width: 40%;">
                                    <p class="text-uppercase text-center">TTD Kepala Sekolah</p>
                                    <p style="text-align: center; margin-bottom: 0; margin-top: 80px;">
                                        Prof. Dr. Ir. Novi Wahyuningsih M. Kom., S.Kom., M.Sc., Ph.D., D.Kom., CFA, CPA,
                                        CFP, CFE, CFM</p>
                                    <p style="text-align: center; margin-top : -15px">___________________</p>
                                    <p style="text-align: center">NIP 344234234234</p>
                                </div>

                            </td>
                            <td colspan="2" class="b-0 text-center" style="vertical-align: top">
                                Wali Kelas
                                <br><br><br><br>
                                <b>Asep</b>
                                <p class="m-0">NIP. 7837538457</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
