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
    </style>
</head>

<body>
    <table class="table">
       
        <tr>
            <td colspan="14" class="text-center b-0" >
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGY9VSLlJUhitwD6iLseOrD17n40SmZp-vQpN4MyHR-Q&s" alt="" width="60px">
            </td>
        </tr>
        <tr>
            
            <td colspan="14" style="font-size: 12pt !important" class="b-0 text-bold text-uppercase text-center">
                KUMPULAN NILAI TENGAH SEMESTER
            </td>
        </tr>
        <thead>
            <tr>
                <td colspan="14" class="b-0">
                    <table class="table b-0">
                        <tr class="b-0">
                            <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold;" width="15%">Nama Sekolah</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top" width="35%">
                                {{ $result_profile['school'] }}
                            </td>
                            
                            <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold;" width="25%">Kelas</td>
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

                            
                            <td class="b-0" style="padding: 0px; font-weight: bold;">Semester</td>
                            <td class="b-0" style="padding: 0px;">:</td>
                            <td class="b-0" style="padding: 0px;">
                                {{ $result_profile['semester_number'] . ' (' . $result_profile['semester'] . ')' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold; ">Nama</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px;">
                                {{ $result_profile['name'] }}
                            </td>
                            <td class="b-0" style="padding: 0px; vertical-align: top; font-weight: bold;">Tahun Pelajaran</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">:</td>
                            <td class="b-0" style="padding: 0px; vertical-align: top">
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
           
            {{-- PENGETAHUAN --}}

            
            <tr>
                <th class="text-center vertical-middle" rowspan="3" font-size= "11pt">
                    No
                </th>
                <th class="text-center" rowspan="3" font-size= "11pt">
                    Mata Pelajaran
                </th>
                <th class="text-center vertical-middle" rowspan="3" font-size= "11pt">
                    KKM
                </th>
                <th class="text-center" colspan="10" font-size= "11pt">
                    HPH (Hasil Penilaian Harian)
                </th>
                <th class="text-center" rowspan="3" font-size= "11pt">
                    HPTS
                </th>
               
            </tr>

            <tr>
                <th class="text-center" colspan="5">
                    Pengetahuan
                </th>
                <th class="text-center" colspan="5">
                    Ketrampilan
                </th>
            </tr>

            <tr>
                @for ($i = 1; $i <=5; $i++)
                <th class="text-center" font-size= "11pt">
                    {{ $i}}
                </th>
                @endfor

                @for ($i = 1; $i <=5; $i++)
                <th class="text-center" font-size= "11pt">
                    {{ $i}}
                </th>
                @endfor
                
                
            </tr>
           
            @if (!empty($result_score))
                @foreach ( $result_score as $key => $group )
                    <tr>
                        <th colspan="14"> Kelompok {{$key}} </th>
                    </tr>

                    @foreach ( $group as $keys => $groups )
                        @if ($keys != '' || $keys != null)
                            <tr>
                                <td colspan="14"> {{$keys}} </td>
                            </tr>  
                        @endif
                        
                        @foreach ( $groups as $score )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $score['course'] }}</td>
                                <td>70</td>

                                @for ($i = 1; $i <=5; $i++)
                                
                                    @if (array_key_exists($i,$score['kd_assessment_score'] ))
                                        <td>{{ $score['kd_assessment_score'][$i] }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endfor

                                @for ($i = 1; $i <=5; $i++)
                                
                                    @if (array_key_exists($i,$score['kd_skill_score'] ))
                                        <td>{{ $score['kd_skill_score'][$i] }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endfor

                                <td>{{ $score['uts'] }}</td>

                            </tr>


                        @endforeach
                        


                    @endforeach

                    
                @endforeach

                <small style="font-size: 8px; font-style: italic;" >HPTS = Hasil penilaian tengah semester</small>

                {{-- @foreach ($result_score as $score)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            {{ $score['course'] }}</td>
                        <td class="text-center">
                            {{ $score['final_assessment'] }}</td>
                        <td class="text-center">
                            {{ $score['predicate_assessment'] }}
                        </td>
                        
                        
                    </tr>
                @endforeach --}}
            @else
                <tr>
                    <td class="text-center">Belum ada mapel yang dinilai</td>
                </tr>
            @endif
            

            <tr>
                <td style="height: 10px" class="b-0"></td>
            </tr>

            

            {{-- Predikat Nilai --}}
            <tr>
                <td colspan="14" class="b-0" style="padding: 0px !important; font-size: 10pt">
                    <table class="table">
                       

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




            
        </tbody>
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

                    <div style="float: right; width: 40%;">
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

                    {{-- <div style="margin: 0 auto; width: 40%;">
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
                    </div> --}}
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
