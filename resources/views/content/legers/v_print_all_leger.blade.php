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
        <h4>LEGER SEMUA SEMESTER</h4>
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
                    {{-- <th>NO</th> --}}
                    {{-- <th rowspan="2">Nama</th> --}}
                    <th rowspan="2">NIS</th>

                    @forelse ( $mapel as $mpl )    
                    <th colspan="{{ count($semester) }}">{{ $mpl }}</th>
                    @empty   
                    @endforelse

                </tr>
                <tr>
                    @forelse ( $mapel as $mp2) 
                        @forelse ($semester as $sem)
                        @php
                            $tahun = substr($sem, 0, -1);
                            $sem = substr($sem, -1);
                        @endphp
                        <th>
                            <p style="margin: 0">{{$tahun}}</p>
                            {{ $sem == 1 ? 'ganjil' : 'genap'}}

                        </th>
                        {{-- <th>{{$sem}}</th>     --}}
                        @empty 
                        @endforelse    
                    @empty  
                    @endforelse
                </tr>

                @forelse ($dataBaru as $name => $siswa)
                <tr>
                    <td>
                        {{$name}}
                        
                    </td>
                    {{-- <td>
                        
                    </td> --}}
                    {{-- @forelse ( $siswa as $mapels ) --}}

                        @forelse ( $mapel as $mp)


                            @for ( $i=0; $i < count($semester); $i++ )
                                @if(isset($siswa[$mp][$i]))
                                <td>{{$siswa[$mp][$i]->final_score}}</td>
                                @else
                                <td></td>
                                @endif
                            @endfor     
                        @empty    
                        @endforelse


                        
                        {{-- @forelse ( $mapel as $nilai )
                            <td>{{$nilai->final_score}}</td>
                        @empty --}}
                        
                        
                    {{-- @empty   
                    @endforelse --}}

                </tr>
                @empty     
                
                @endforelse
  
                <tr>
                    
                    
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</body>

</html>
