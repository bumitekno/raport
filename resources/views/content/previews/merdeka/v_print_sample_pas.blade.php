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
            <td colspan="4" class="b-0">
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
            <td colspan="4" class="b-0" style="padding: 0px !important">
                <hr style="border: solid 2px #000">
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-size: 14pt !important" class="b-0 text-bold text-uppercase text-center">
                LAPORAN HASIL BELAJAR
            </td>
        </tr>
        <thead>
            <tr>
                <td colspan="4" class="b-0">
                    <table class="table b-0">
                        <tr class="b-0">
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Nama Peserta Didik</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px">John Doe</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Kelas</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">12A</td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px"><b>NISN</b></td>
                            <td class="b-0" style="padding: 0px">:</td>
                            <td class="b-0" style="padding: 0px">1234567890</td>
                            <td class="b-0" style="padding: 0px"><b>Fase</b></td>
                            <td class="b-0" style="padding: 0px">:</td>
                            <td class="b-0" style="padding: 0px">B</td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Sekolah</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">SMA Negeri 1</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Semester</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">2</td>
                        </tr>
                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Alamat</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; max-width: 250px">Jl. Jendral Sudirman No. 123, Kota ABC</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top"><b>Tahun Pelajaran</b></td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">2022/2023</td>
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
                <td class="b-0" colspan="2" style="font-size: 12pt">A. NILAI AKADEMIK</td>
            </tr>
            <tr>
                <th class="text-center vertical-middle">
                    No
                </th>
                <th class="text-center">
                    Mata Pelajaran
                </th>
                <th class="text-center">
                    Nilai Akhir
                </th>
                <th class="text-center vertical-middle" style="min-width: 300px">
                    Capaian Kompetensi
                </th>
            </tr>

            <tr>
                <td class="text-center">1</td>
                <td class="text-center">Matematika</td>
                <td class="text-center">90</td>
                <td>
                    <p>Kompetensi A, B, C telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi D</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">2</td>
                <td class="text-center">Bahasa Inggris</td>
                <td class="text-center">85</td>
                <td>
                    <p>Kompetensi A, B, D telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi C</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">3</td>
                <td class="text-center">IPA</td>
                <td class="text-center">92</td>
                <td>
                    <p>Kompetensi A, C, D telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi B</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">4</td>
                <td class="text-center">Sejarah</td>
                <td class="text-center">78</td>
                <td>
                    <p>Kompetensi A, B telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi C, D</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">5</td>
                <td class="text-center">Seni Budaya</td>
                <td class="text-center">88</td>
                <td>
                    <p>Kompetensi A, C telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi B, D</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">6</td>
                <td class="text-center">Pendidikan Jasmani</td>
                <td class="text-center">95</td>
                <td>
                    <p>Kompetensi A, D telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi B, C</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">7</td>
                <td class="text-center">Geografi</td>
                <td class="text-center">82</td>
                <td>
                    <p>Kompetensi A, C telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi B, D</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">8</td>
                <td class="text-center">Ekonomi</td>
                <td class="text-center">90</td>
                <td>
                    <p>Kompetensi A, B, D telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi C</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">9</td>
                <td class="text-center">Kimia</td>
                <td class="text-center">87</td>
                <td>
                    <p>Kompetensi A, B telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi C, D</p>
                </td>
            </tr>

            <tr>
                <td class="text-center">10</td>
                <td class="text-center">Fisika</td>
                <td class="text-center">91</td>
                <td>
                    <p>Kompetensi A, C, D telah tercapai</p>
                    <p>Perlu peningkatan dalam Kompetensi B</p>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="4" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="4" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="4" style="font-size: 12pt">B. KEGIATAN EKSTRAKURIKULER
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Kegiatan Ekstrakurikuler</th>
                            <th class="text-center">Predikat</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Futsal</td>
                            <td class="text-center">Baik</td>
                            <td>Kegiatan rutin dilakukan setiap Jumat sore</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Pramuka</td>
                            <td class="text-center">Sangat Baik</td>
                            <td>Meraih penghargaan dalam lomba kebersihan lingkungan</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Paskibra</td>
                            <td class="text-center">Cukup</td>
                            <td>Partisipasi dalam upacara bendera setiap hari Senin</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Band</td>
                            <td class="text-center">Kurang</td>
                            <td>Belum memiliki penampilan publik</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px" colspan="4" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="3" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="2" style="font-size: 12pt">C. KETIDAK HADIRAN</td>
                        </tr>
                        <tr>
                            <td>
                                Sakit</td>
                            <td class="text-center">
                                2 Hari
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Izin</td>
                            <td class="text-center">
                                1 Hari
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
                <td style="height: 10px" colspan="4" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="4" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" style="font-size: 12pt">D. CATATAN WALIKELAS</td>
                        </tr>
                        <tr>
                            <td class="text-left vertical-middle">
                                <div style="width: 100%; min-height: 60px">
                                    <p class="m-0">Siswa yang aktif dalam kegiatan kelas dan memiliki partisipasi yang baik.</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tr>
            <td>
                <div class="signature">
                    <div style="float: left; width: 40%;">
                        <p>Mengetahui,</p>
                        <p>Orang tua peserta didik</p>
                        <p style="margin-top: 80px;">___________________</p>
                    </div>

                    <div style="float: right; width: 40%;">
                        <p>Temanggung, 20 Mei 2023
                        </p>
                        <p>TTD Wali Kelas</p>
                        <p style="margin-top: 80px;">___________________</p>
                    </div>

                    <div style="margin: 0 auto; width: 40%;">
                        <p class="text-uppercase text-center">TTD Kepala Sekolah</p>
                        <p
                            style="text-align: center; margin-bottom: 0; margin-top: 80px">
                            Prof. Dr. Ir. Novi Wahyuningsih M. Kom., S.Kom., M.Sc., Ph.D., D.Kom., CFA, CPA, CFP, CFE, CFM</p>
                        <p style="text-align: center; margin-top : -15px">___________________</p>
                        <p style="text-align: center">NIP 342343445</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>


</body>

</html>
