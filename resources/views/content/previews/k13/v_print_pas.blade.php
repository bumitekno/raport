<!DOCTYPE html>
<html>

<head>
    <title>Laporan Hasil Belajar</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap');
        @import url('https://fonts.cdnfonts.com/css/aguafina-script');

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 10pt;
            color: #333;
        }

        .header {
            width: 100%;
            text-align: center;
            font-weight: 500;
            font-size: 11pt;
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
            font-size: 11pt;
        }

        .table td p {
            margin: 0px;
            text-align: justify;
            font-size: 10pt;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: 500;
            font-size: 11pt;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .text-center {
            text-align: center !important;
            font-size: 11pt;
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
            font-size: 12px;
        }

        .b-0 {
            border: 0 !important;
            font-size: 10px;
        }

        .signature p {
            margin: 0;
        }

        table tr.page-break{
            page-break-after:always
        }

       
        tfoot {
            position: fixed;
            bottom: 0;
        }
        

    </style>
</head>

<body>
    <table class="table">
        <tr>
            <td colspan="10" style="font-size: 15pt !important" class="mb-4 b-0 text-bold text-uppercase text-center">
                PENCAPAIAN KOMPETENSI PESERTA DIDIK
            </td>
        </tr>
        
        <thead>
        <tr>
            <td colspan="10" class="b-0">
                <table class="table b-0">
                    <tr class="b-0">
                        <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold;" width="15%">Nama Sekolah</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top" width="35%">
                            {{ $result_profile['school'] }}
                        </td>
                        <td class="b-0" width="15%"></td>
                        
                        <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold;" width="15%">Kelas</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top" width="25%">
                            {{ $result_profile['study_class'] }}
                        </td>
                    </tr>

                    <tr>
                        <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold;">Alamat</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                        <td class="b-0" style="padding: 0px;">
                            {{ $result_profile['address_school'] }}
                        </td>

                        <td class="b-0"></td>

                        
                        <td class="b-0" style="padding: 0px; font-weight: bold; vertical-align: top;">Semester</td>
                        <td class="b-0" style="padding: 0px;vertical-align: top;">:</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top;">
                            {{ $result_profile['semester_number'] . ' (' . $result_profile['semester'] . ')' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold; ">Nama</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                        <td class="b-0" style="padding: 0px;">
                            {{ $result_profile['name'] }}
                        </td>
                        <td class="b-0"></td>
                        <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold;vertical-align: top;">Tahun Pelajaran</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top;vertical-align: top;">:</td>
                        <td class="b-0" style="padding: 0px; vertical-align: top;vertical-align: top;">
                            {{ $result_profile['school_year'] }}</td>
                    </tr>

                    <tr>
                        <td class="b-0" style="padding: 0px; font-weight: bold;">NISN</td>
                        <td class="b-0" style="padding: 0px">:</td>
                        <td class="b-0" style="padding: 0px">
                            {{ $result_profile['nisn'] }}
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
                    <td colspan="10" class="b-0" style="padding: 0px !important">
                        <table class="table">
                            <tr>
                                <td class="b-0" colspan="2" style="font-size: 11pt">A. SIKAP
                                </td>
                            </tr>

                            {{-- SPIRITUAL --}}
                            <tr>
                                <td class="b-0" colspan="2" style="font-size: 11pt">1. Sikap Spiritual
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="font-size: 11pt">
                                    Predikat
                                </th>
                                <th class="text-center" style="font-size: 11pt">
                                    Deskripsi
                                </th>
                            </tr>
                                
                            <tr>
                                <td class="text-center" style="width: 150px; font-size: 11pt" >
                                    <b>
                                        {{ $result_attitude['spiritual']['predicate'] }}
                                    </b>
                                </td>
                                <td>{{ $result_profile['name'] }} memiliki sikap
                                    {{ $result_attitude['spiritual']['type'] == 'social' ? 'Sosial' : 'Spiritual' }}
                                    {{ $result_attitude['spiritual']['predicate'] }}, antara lain
                                    {{ implode(', ', $result_attitude['spiritual']['attitudes']) }}
                                </td>
                            </tr>

                            {{-- SOSIAL --}}
                            <tr>
                                <td class="b-0" colspan="2" style="font-size: 11pt">2. Sikap Sosial
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="font-size: 11pt">
                                    Predikat
                                </th>
                                <th class="text-center" style="font-size: 11pt">
                                    Deskripsi
                                </th>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 150px; font-size: 11pt" >
                                    <b>
                                        {{ $result_attitude['social']['predicate'] }}
                                    </b>
                                </td>
                                <td>{{ $result_profile['name'] }} memiliki sikap
                                    {{ $result_attitude['social']['type'] == 'social' ? 'Sosial' : 'Spiritual' }}
                                    {{ $result_attitude['social']['predicate'] }}, antara lain
                                    {{ implode(', ', $result_attitude['social']['attitudes']) }}
                                </td>
                            </tr>
                        
                        
                            </table>
                    </td>
                </tr>

                <tr>
                    <td style="height: 10px" colspan="4" class="b-0" style="font-size: 11pt"></td>
                </tr>
            @endif

            {{-- PENGETAHUAN --}}

            <tr>
                
                <td class="b-0" colspan="10" style="font-size: 11pt;font-weight: bold;">B. PENGETAHUAN</td>
                
            </tr>

            
            <tr>
                <td class="b-0" colspan="10" style="font-size: 12pt">Ketuntasan Belajar Minimal
                    70</td>
                </tr>
            <tr>
                <th class="text-center vertical-middle" font-size= "11pt">
                    No
                </th>
                <th class="text-center" font-size= "11pt">
                    Mata Pelajaran</th>
                <th class="text-center" font-size= "11pt">
                    Angka</th>
                <th class="text-center" font-size= "11pt">
                    Predikat</th>
                <th colspan="6" class="text-center" font-size= "11pt">
                        Deskripsi</th>
            </tr>
           
            @if (!empty($result_score))
                @foreach ( $result_score as $key => $group )
                    <tr>
                        <td colspan="10" style="font-weight: bold;"> Kelompok {{$key}} </td>
                    </tr>

                    @foreach ( $group as $keys => $groups )
                        @if ($keys != '' || $keys != null)
                            <tr>
                                <td colspan="10"> {{$keys}} </td>
                            </tr>  
                        @endif

                        @foreach ($groups as $score)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    {{ $score['course'] }}</td>
                                <td class="text-center">
                                    {{ $score['final_assessment'] }}</td>
                                <td class="text-center">
                                    {{ $score['predicate_assessment'] }}
                                </td>
                                <td colspan="6">
                                    @if ($score['description_assessment'])
                                        <p>Penguasaan pengetahuan {{ $score['description_assessment'] }}
                                            dalam {{ implode(', ', $score['kd_assessment']) }}</p>
                                    @endif
                                </td>
                                
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center">Belum ada mapel yang dinilai</td>
                </tr>
            @endif
            

            <tr>
                <td style="height: 10px" colspan="10" class="b-0"></td>
            </tr>

            <tr class="page-break"></tr>


            {{-- KETERAMPILAN --}}

            <tr>
                <td class="b-0" colspan="8" style="font-size: 11pt">C. KETERAMPILAN</td>
            </tr>
            <tr>
                <td class="b-0" colspan="8" style="font-size: 12pt">Kriteria Ketuntasan Minimal Satuan
                    Pendidikan
                    70</td>
                </tr>
            <tr>
                <th class="text-center vertical-middle" font-size="11pt">
                    No
                </th>
                <th class="text-center" font-size= "11pt">
                    Mata Pelajaran</th>
                    <th class="text-center" font-size= "11pt">
                        Angka</th>
                    <th class="text-center" font-size= "11pt">
                        Predikat</th>
                    <th class="text-center" colspan="6" font-size= "11pt">
                        Deskripsi</th>
            </tr>
           
            @if (!empty($result_score))
                @foreach ( $result_score as $key => $group )
                    <tr>
                        <td colspan="10"> Kelompok {{$key}} </td>
                    </tr>

                    @foreach ( $group as $keys => $groups )
                        @if ($keys != '' || $keys != null)
                            <tr>
                                <td colspan="10"> {{$keys}} </td>
                            </tr>  
                        @endif
                        @foreach ($groups as $score)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    {{ $score['course'] }}</td>
                                <td class="text-center">{{ $score['final_skill'] }}</td>
                                <td class="text-center">{{ $score['predicate_skill'] }}</td>
                                <td colspan="6">
                                    @if ($score['description_skill'])
                                        <p>Penguasaan ketrampilan {{ $score['description_skill'] }}
                                            dalam {{ implode(', ', $score['kd_skill']) }}</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center">Belum ada mapel yang dinilai</td>
                </tr>
            @endif

            <tr>
                <td style="height: 10px" colspan="10" class="b-0"></td>
            </tr>

            

            {{-- Predikat Nilai --}}
            <tr>
                <td colspan="10" class="b-0" style="padding: 0px !important; font-size: 10pt">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="3" style="font-size: 11pt">Tabel interval predikat berdasarkan KKM
                            </td>
                        </tr>

                        <tr>
                            <th class="text-center vertical-middle" rowspan="2" font-size= "11pt">
                                KKM
                            </th>
                            <th  class="text-center" colspan="{{ count($predicate_score) }}">Predikat</th>
                            
                        </tr>
                        <tr>
                            @forelse ($predicate_score as $ps)
                                <th class="text-center" font-size= "11pt">
                                {{$ps->description}} 
                                ({{$ps->name}})</th>
                            @empty
                                
                            @endforelse
                           
                        </tr>
                        <tr>
                            <td class="text-center">70</td>
                            @forelse ($predicate_score as $ps)
                                <td class="text-center" font-size= "11pt">
                                {{$ps->score}}</td>
                            @empty
                                
                            @endforelse
                        </tr>


                        
                    </table>
                </td>
            </tr>




            {{-- Ekstrakulikuler --}}
            <tr>
                <td colspan="10" class="b-0" style="padding: 0px !important; font-size: 10pt">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="3" style="font-size: 11pt">D. EKSTRAKURIKULER
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" style="font-size: 11pt">
                                No</th>
                            <th class="text-center" style="font-size: 11pt">
                                Kegiatan Ekstrakurikuler</th>
                            <th class="text-center" style="font-size: 11pt">
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
                <td style="height: 10px; font-size: 10pt" colspan="10" class="b-0"></td>
            </tr>

            
            <!--<tr>-->
            <!--    <td style="height: 10px" colspan="8" class="b-0"></td>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--    <td colspan="8" class="b-0" style="padding: 0px !important">-->
            <!--        <table class="table">-->
            <!--            <tr>-->
            <!--                <td class="b-0" colspan="3" style="font-size: 12pt">E. TINGGI DAN BERAT BADAN-->
            <!--                </td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <th class="text-center" rowspan="2" style="width: 50px">-->
            <!--                    No</th>-->
            <!--                <th class="text-center" rowspan="2" style="width: 150px">-->
            <!--                    Aspek Yang Dinilai</th>-->
            <!--                <th class="text-center" colspan="2">-->
            <!--                    Semester</th>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <th class="text-center">1 (Satu)</th>-->
            <!--                <th class="text-center">2 (Dua)</th>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td class="text-center">-->
            <!--                    1</td>-->
            <!--                <td>Tinggi Badan</td>-->
            <!--                <td class="text-center"></td>-->
            <!--                <td class="text-center"></td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td class="text-center">-->
            <!--                    2</td>-->
            <!--                <td>Berat Badan</td>-->
            <!--                <td class="text-center"></td>-->
            <!--                <td class="text-center"></td>-->
            <!--            </tr>-->
            <!--        </table>-->
            <!--    </td>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--    <td style="height: 10px" colspan="8" class="b-0"></td>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--    <td colspan="8" class="b-0" style="padding: 0px !important">-->
            <!--        <table class="table">-->
            <!--            <tr>-->
            <!--                <td class="b-0" colspan="3" style="font-size: 12pt">F. KONDISI KESEHATAN-->
            <!--                </td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <th class="text-center" style="width: 50px">-->
            <!--                    No</th>-->
            <!--                <th class="text-center" style="width: 150px">-->
            <!--                    Aspek Yang Dinilai</th>-->
            <!--                <th class="text-center">-->
            <!--                    Keterangan</th>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td class="text-center">-->
            <!--                    1</td>-->
            <!--                <td>Pendengaran</td>-->
            <!--                <td></td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td class="text-center">-->
            <!--                    2</td>-->
            <!--                <td>Penglihatan</td>-->
            <!--                <td></td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td class="text-center">-->
            <!--                    3</td>-->
            <!--                <td>Gigi</td>-->
            <!--                <td></td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td class="text-center">-->
            <!--                    4</td>-->
            <!--                <td>Lainnya</td>-->
            <!--                <td></td>-->
            <!--            </tr>-->
            <!--        </table>-->
            <!--    </td>-->
            <!--</tr>-->
            <tr>
                <td style="height: 10px; font-size: 10pt" colspan="8" class="b-0"></td>
            </tr>
            <tr>
                <td colspan="8" class="b-0" style="padding: 0px !important; font-size: 10pt">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="3" style="font-size: 11pt">E. PRESTASI
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" style="font-size: 11pt">
                                No</th>
                            <th class="text-center" style="font-size: 11pt">
                                Jenis Prestasi</th>
                            <th class="text-center" style="font-size: 11pt">
                                Keterangan</th>
                        </tr>
                        @for ($i = 1; $i <= 3; $i++)
                            <tr>
                                <td class="text-center" style="font-size: 11pt">{{ $i }}</td>
                                <td>{{ $result_achievement[$i - 1]['name'] ?? '' }}</td>
                                <td>{{ $result_achievement[$i - 1]['description'] ?? '' }}</td>
                            </tr>
                        @endfor
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px; font-size: 11pt" colspan="8" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="5" class="b-0" style="padding: 0px !important; font-size: 10pt">
                    <table class="table">
                        <tr>
                            <td class="b-0" colspan="2" style="font-size: 11pt">F. KETIDAKHADIRAN</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11pt">
                                Sakit</td>
                            <td class="text-center">
                                {{ $result_attendance['ill'] }} Hari
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 11pt">
                                Izin</td>
                            <td class="text-center">
                                {{ $result_attendance['excused'] }} Hari
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 11pt">
                                Tanpa Keterangan</td>
                            <td class="text-center">
                                {{ $result_attendance['unexcused'] }} Hari
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="height: 10px; font-size: 11pt" colspan="8" class="b-0"></td>
            </tr>

            <tr>
                <td colspan="10" class="b-0" style="padding: 0px !important">
                    <table class="table">
                        <tr>
                            <td class="b-0" style="font-size: 11pt">G. TANGGAPAN WALIKELAS</td>
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
        </tbody>

        {{-- <tfoot>
            <tr>
                <td style="height: 10px" colspan="4" class="b-0" style="font-size: 11pt"></td>
            </tr>
            <tr>
              <td>Sum</td>
              <td>$180</td>
            </tr>
          
        </tfoot> --}}

        
    </table>

    <table style="width:100%">
        @if ($type_template == 'uas')
            <tr>
                <td>
                    <div style="height: 10px"></div>
                    <!--<table class="table">-->
                    <!--    <tr>-->
                    <!--        <td class="b-0">Diberikan di</td>-->
                    <!--        <td class="b-0">: {{ $result_other['place'] ?? 'Tidak diketahui' }}</td>-->
                    <!--        <td class="b-0" style="width: 50px"></td>-->
                    <!--        <td class="b-0" colspan="2">KEPUTUSAN</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--        <td class="b-0">tanggal</td>-->
                    <!--        <td class="b-0">:-->
                    <!--            {{ isset($result_other['date']) ? DateHelper::getTanggal($result_other['date']) : '' }}-->
                    <!--        </td>-->
                    <!--        <td class="b-0"></td>-->
                    <!--        <td class="b-0" colspan="2">Dengan memperhatikan hasil yang dicapai</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--        <td colspan="3" class="b-0"></td>-->
                    <!--        <td class="b-0" colspan="2">semester 1 dan 2, maka peserta didik ini ditetapkan-->
                    <!--        </td>-->
                    <!--    </tr>-->
                    <!--    @if ($result_other['promotion'] == 'Y')-->
                    <!--        <tr>-->
                    <!--            <td colspan="3" class="b-0"></td>-->
                    <!--            <td class="b-0" style="width: 80px">Naik kelas</td>-->
                    <!--            <td class="b-0">: {{ $result_profile['level'] + 1 }}</td>-->
                    <!--        </tr>-->
                    <!--        <tr>-->
                    <!--            <td colspan="3" class="b-0"></td>-->
                    <!--            <td class="b-0" colspan="2"><s>Tinggal di Kelas</s></td>-->
                    <!--        </tr>-->
                    <!--    @else-->
                    <!--        <tr>-->
                    <!--            <td colspan="3" class="b-0"></td>-->
                    <!--            <td class="b-0" style="width: 80px"><s>Naik kelas</s></td>-->
                    <!--            <td class="b-0">: </td>-->
                    <!--        </tr>-->
                    <!--        <tr>-->
                    <!--            <td colspan="3" class="b-0"></td>-->
                    <!--            <td class="b-0">Tinggal di Kelas</td>-->
                    <!--            <td class="b-0">: {{ $result_profile['level'] }}</td>-->
                    <!--        </tr>-->
                    <!--    @endif-->

                    <!--</table>-->
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

                    <div style="float: right; width: 20%;">
                        <p>
                            {{ $result_other['place'] ?? 'Tidak diketahui' }},
                            {{ isset($result_other['date']) ? DateHelper::getTanggal($result_other['date']) : '' }}
                        </p>
                        <p>Wali Kelas</p>
                        <p style="margin-bottom: 0; margin-top: 80px">
                            {{ $result_other['teacher'] }}</p>
                        <p style="margin-top : -15px">______________________</p>
                        <p>NAK {{ $result_other['nip_teacher'] }}</p>
                    </div>

                    <div style="margin: 0 auto; width: 40%;">
                        <p class="text-center">Mengetahui,</p>
                        <p class="text-center">Kepala Sekolah</p>
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
                        <p style="text-align: center">NAK {{ $result_other['nip_headmaster'] }}</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
