<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sampul Raport</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        .sampul-awal {
            margin: auto;
            padding: 30px;
            /* border: 1px solid #ccc; */
            max-width: 600px;
            text-align: center;
        }

        .sampul-awal img {
            margin-bottom: 20px;
        }

        .sampul-awal h1,
        .sampul-awal h2,
        .sampul-awal h3 {
            margin: 0;
            font-weight: normal;
        }

        .sampul-awal h1 {
            font-size: 30px;
        }

        .sampul-awal h2 {
            font-size: 24px;
        }

        .sampul-awal h3 {
            font-size: 18px;
        }

        .sampul-awal b {
            font-weight: bold;
        }

        .sampul-awal .logo {
            margin-bottom: 20px;
        }

        .sampul-awal .logo img {
            max-height: 150px;
            display: block;
            margin: auto;
        }

        .sampul-awal .nama-siswa {
            margin-bottom: 20px;
        }

        .sampul-awal .nama-siswa h2 {
            font-size: 28px;
        }

        .sampul-awal .nama-siswa .nisn-nis {
            margin-top: 10px;
            font-size: 20px;
        }

        .sampul-awal .nama-siswa .nisn-nis span {
            display: inline-block;
            margin: 0 5px;
        }

        .sampul-awal .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            width: 100%;
            border-top: 1px solid #ccc;
            font-size: 18px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="sampul-awal">
        <div class="logo">
            <img src="{{ $cover->top_logo }}" alt="Logo" />
        </div>
        <h1>{!! $cover->title !!}</h1>
        <h2>{!! $cover->sub_title !!}</h2>
        <div class="logo">
            <img src="{{ $cover->middle_logo }}" alt="Logo" />
        </div>
        <div class="nama-siswa">
            <h2>{{ strtoupper($student_class->student->name) }}</h2>
            <div class="nisn-nis">
                <span>NISN: {{ $student_class->student->nisn ?? '-' }}</span>
                <span>|</span>
                <span>NIS: {{ $student_class->student->nis ?? '-' }}</span>
            </div>
        </div>
        <div class="footer">{!! $cover->footer !!}</div>
    </div>
    <div style="page-break-before: always;"></div>
    @if ($cover['instruction'])
        <div class="sampul-awal">
            <div class="instruksi" style="text-align: justify">
                {!! $cover['instruction'] !!}
            </div>
        </div>
        <div style="page-break-before: always;"></div>
    @endif
    <div class="sampul-awal">
        <div style="font-family: Arial, sans-serif; font-size: 16px;">
            <div style="vertical-align: top; margin-right: 5%;">
                <h2 style="margin: 0;">RAPOR SISWA</h2>
                <h2 style="margin: 0;">{!! $cover['sub_title'] !!}</h2>
            </div>
            <div style="vertical-align: top; margin-top: 20px">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="width: 170px; padding-right: 10px; vertical-align: top;">Nama Sekolah</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>{{ strtoupper($setting['name_school']) }}</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">NPSN</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>{{ $setting['npsn'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">NIS/NSS/NDS</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">Alamat Sekolah</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>{{ $sekolah['address'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">Kelurahan / Desa</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">Kecamatan</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">Kota/Kabupaten</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">Provinsi</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">Website</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>{{ $setting['website'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 10px; vertical-align: top;">Email</td>
                        <td style="padding-right: 10px; vertical-align: top;">:</td>
                        <td>{{ $setting['email'] ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div style="page-break-before: always;"></div>
    <div class="sampul-awal">
        <div>
            <h3 class="text-center">KETERANGAN TENTANG DIRI SISWA</h3>
            <div class="data-diri" style="text-align: justify">
                <table style="border-collapse: separate; border-spacing: 0 9px;">
                    <tr>
                        <td style="width: 25px">1.</td>
                        <td>Nama Peserta Didik (Lengkap)</td>
                        <td style="width: 20px">:</td>
                        <td>{{ strtoupper($student_class->student->name) }}</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Nomor Induk/NISN</td>
                        <td>:</td>
                        <td>{{ $student_class->student->nis ?? '-' }}/{{ $student_class->student->nis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Tempat ,Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ ucwords($student_class->student->place_of_birth) }},
                            {{ DateHelper::getTanggal($student_class->student->date_of_birth) }}</td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ $student_class->student->gender ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Agama/Kepercayaan</td>
                        <td>:</td>
                        <td>{{ ucwords($student_class->student->religion) ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Status dalam Keluarga</td>
                        <td>:</td>
                        {{-- <td>{{ $siswa['status_keluarga'] ?? '-' }}</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>7.</td>
                        <td>Anak ke</td>
                        <td>:</td>
                        {{-- <td>{{ $siswa['anak_ke'] ?? '-' }}</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">8.</td>
                        <td style="vertical-align: top">Alamat Peserta Didik</td>
                        <td style="vertical-align: top">:</td>
                        <td>{{ $student_teacher->student->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>9.</td>
                        <td>Nomor Telepon Rumah</td>
                        <td>:</td>
                        <td>{{ $student_class->student->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>10.</td>
                        <td>Sekolah Asal</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>11.</td>
                        <td>Diterima di sekolah ini</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Di kelas</td>
                        <td>:</td>
                        {{-- <td>{{ $siswa['kls_diterima'] ?? '-' }}</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Pada tanggal</td>
                        <td>:</td>
                        {{-- <td>{{ $siswa['tgl_diterima'] == null ? '-' : (new \App\Helpers\Help())->getTanggal($siswa['tgl_diterima']) }} --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>12.</td>
                        <td>Nama Orang Tua</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>a. Ayah</td>
                        <td>:</td>
                        {{-- <td>{{ strtoupper($siswa['nama_ayah']) ?? '-' }}</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>b. Ibu</td>
                        <td>:</td>
                        <td>-</td>
                        {{-- <td>{{ strtoupper($siswa['nama_ibu']) ?? '-' }}</td> --}}
                    </tr>
                    <tr>
                        <td>13.</td>
                        <td>Alamat Orang Tua</td>
                        <td>:</td>
                        <td>-</td>
                        {{-- <td>{{ $siswa['alamat_wali'] ?? '-' }}</td> --}}
                    </tr>
                    <tr>
                        <td></td>
                        <td>Nomor Telepon Rumah</td>
                        <td>:</td>
                        {{-- <td>{{ $siswa['telp_wali'] ?? '-' }}</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>14.</td>
                        <td>Pekerjaan Orang Tua</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>a. Ayah</td>
                        <td>:</td>
                        {{-- <td>{{ $siswa['pekerjaan_ayah'] ?? '-' }}</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>b. Ibu</td>
                        <td>:</td>
                        {{-- <td>{{ $siswa['pekerjaan_ibu'] ?? '-' }}</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>15.</td>
                        <td>Nama Wali Peserta Didik</td>
                        <td>:</td>
                        <td>-</td>
                        {{-- <td>{{ strtoupper($siswa['nama_wali']) }}</td> --}}
                    </tr>

                </table>
                <br>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div
                                style="display: inline; float: right; width: 3cm; height: 3.7cm; border: solid 1px #000; margin-right: 120px; margin-top: 30px">
                        </td>
                        <td style="width: 500px">
                            <div
                                @if ($result_other['signature'] != null) style="background: url('{{ $result_other['signature'] }}') no-repeat left; background-size: 200px" @endif>
                                <p> Kepala Sekolah</p>

                                <br><br><br><br>
                                <b>{{ $result_other['headmaster'] }}</b> <br>
                                NIP. {{ $result_other['nip_headmaster'] }}
                            </div>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div style="page-break-before: always;"></div>
    {{-- <div class="sampul-awal"> --}}
    <div>
        <h3 style="text-align: center;">KETERANGAN PINDAH SEKOLAH</h3>
        <p>Nama Peserta Didik : .....................................</p>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan="4" style="border: 2px solid black; text-align: center;">KELUAR</th>
                </tr>
                <tr>
                    <th style="width: 15%; border: 2px solid black;">Tanggal</th>
                    <th style="width: 15%; border: 2px solid black;">Kelas yang ditinggalkan</th>
                    <th style="width: 30%; border: 2px solid black;">Sebab-sebab Keluar atau Atas
                        Permintaan(Tertulis)</th>
                    <th style="width: 40%; border: 2px solid black;">Tanda Tangan Kepala Sekolah, Stempel Sekolah,
                        dan Tanda Tangan Orang Tua/Wali</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black; padding: 10px;">
                        <div>
                            ................, .............................
                            <br>
                            Kepala Sekolah<br>
                            <br>
                            <br>
                            <br>
                            <b><u>....................................................</u></b><br>
                            NIP.
                        </div>
                        <div>
                            ................, .............................
                            <br>
                            Orang Tua/Wali<br>
                            <br>
                            <br>
                            <br>
                            <b><u>....................................................</u></b><br>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black; padding: 10px;">
                        <div>
                            ................, .............................
                            <br>
                            Kepala Sekolah<br>
                            <br>
                            <br>
                            <br>
                            <b><u>....................................................</u></b><br>
                            NIP.
                        </div>
                        <div>
                            ................, .............................
                            <br>
                            Orang Tua/Wali<br>
                            <br>
                            <br>
                            <br>
                            <b><u>....................................................</u></b><br>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black; padding: 10px;">
                        <div>
                            ................, .............................
                            <br>
                            Kepala Sekolah<br>
                            <br>
                            <br>
                            <br>
                            <b><u>....................................................</u></b><br>
                            NIP.
                        </div>
                        <div>
                            ................, .............................
                            <br>
                            Orang Tua/Wali<br>
                            <br>
                            <br>
                            <br>
                            <b><u>....................................................</u></b><br>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- </div> --}}
</body>

</html>
