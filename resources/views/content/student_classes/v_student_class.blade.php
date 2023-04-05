@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.switches.switches_css')
        @include('package.datatable.datatable_css')
        <style>
            div.table-responsive>div.dataTables_wrapper>div.row {
                margin: 5px 0px;
            }
        </style>
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>

            <div class="row" id="cancel-row">

                <div class="col-xl-8 col-lg-8 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                    <h4 class="my-auto">Kelola Siswa</h4>
                                    <div class="form-group my-auto p-3 d-flex">
                                        <select name="student_origin" id="student_origin" class="form-control m-1">
                                            <option value="user" {{ $_GET['origin'] == 'user' ? 'selected' : '' }}>Siswa
                                                Baru</option>
                                            <option value="student" {{ $_GET['origin'] == 'student' ? 'selected' : '' }}>
                                                Kelas Siswa</option>
                                        </select>
                                        <select id="show-class"
                                            class="form-control m-1 {{ $_GET['origin'] == 'student' ? '' : 'd-none' }}">
                                            <option value="" selected disabled>Pilih Rombel</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->slug }}"
                                                    {{ $_GET['origin'] == 'student' && $_GET['class'] == $class->slug ? 'selected' : '' }}>
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        <select id="show-year"
                                            class="form-control m-1 {{ $_GET['origin'] == 'student' ? '' : 'd-none' }}">
                                            <option value="" selected disabled>Pilih Tahun Ajaran</option>
                                            @foreach ($years as $year)
                                                <option value="{{ substr($year['school_year'], 0, 4) }}"
                                                    {{ $_GET['origin'] == 'student' && $_GET['year'] == substr($year['school_year'], 0, 4) ? 'selected' : '' }}>
                                                    {{ $year['school_year'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="widget-content widget-content-area br-8">
                            <div class="table-responsive">
                                <table id="table-list" class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="switch s-icons s-outline s-outline-primary my-auto">
                                                    <input type="checkbox" class="check-all">
                                                    <span class="slider round"></span>
                                                </label>
                                            </th>
                                            <th></th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Email</th>
                                            <th>Tempat, Tanggal lahir</th>
                                            <th class="no-content text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area br-8">
                            <form id="form-move-class" action="{{ route('student_classes.storeOrUpdate') }}"
                                method="post">
                                @csrf
                                <input type="hidden" name="selected_siswa" id="selected_siswa" value="">
                                <input type="hidden" name="data_origin" id="data_origin" value="{{ $_GET['origin'] }}">
                                <div class="form-group">
                                    <label for="class_id">Pilih Aksi:</label>
                                    <select class="form-control" id="action" name="action" onchange="getAction(this)">
                                        <option value="move">Pindahkan ke Kelas</option>
                                        <option value="delete">Hapus </option>
                                        @if ($_GET['origin'] == 'student')
                                            <option value="alumni">Jadikan Alumni</option>
                                        @endif

                                    </select>
                                </div>
                                <div class="form-group" id="show-move">
                                    <label for="class_id">Pindah ke Kelas:</label>
                                    <select class="form-control" id="id_study_class" name="id_study_class">
                                        <option value="" selected disabled>-- Pilih Kelas --</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="show-years">
                                    <label for="class_id">Pilih Tahun:</label>
                                    <select class="form-control" id="year" name="year">
                                        @foreach ($years as $year)
                                            <option value="{{ $year['school_year'] }}">
                                                {{ $year['school_year'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" id="btn-move-class" disabled>Proses</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @include('package.datatable.datatable_js')
        <script>
            var selectedSiswa = [];
            $(function() {
                var table = $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "",
                    columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                    }, {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                    }, {
                        data: 'name',
                        name: 'name',
                    }, {
                        data: 'gender',
                        name: 'gender',
                        render: function(data, type, row) {
                            return data == 'male' ? 'Laki - laki' : 'Perempuan';
                        }
                    }, {
                        data: 'email',
                        name: 'email',
                    }, {
                        data: null,
                        name: 'birth_date',
                        render: function(data, type, full, meta) {
                            var birth_date = '';
                            if (full.place_of_birth) {
                                birth_date += full.place_of_birth + ', ';
                            }
                            if (full.date_of_birth) {
                                birth_date += full.date_of_birth;
                            }
                            return birth_date;
                        }
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });



                $('#table-list').on('change', 'tbody input[type="checkbox"]', function(e) {
                    var id_siswa = $(this).val();
                    if ($(this).is(':checked')) {
                        selectedSiswa.push(id_siswa);
                    } else {
                        var index = selectedSiswa.indexOf(id_siswa);
                        if (index > -1) {
                            selectedSiswa.splice(index, 1);
                        }
                    }
                    $('#selected_siswa').val(selectedSiswa.join(','));
                    checkSelectedSiswa();
                });


                // Meng-check atau uncheck semua siswa ketika checkbox check-all ditekan
                $('.check-all').on('change', function() {
                    $('tbody input[type="checkbox"]').prop('checked', $(this).prop('checked')).trigger(
                        'change');
                });

                $('#btn-move-class').on('click', function(e) {
                    e.preventDefault();
                    var selectedSiswa = $('#selected_siswa').val();

                    if (selectedSiswa.length > 0) {
                        var confirmation = confirm(
                            'Apakah anda yakin ingin mengeksekusi proses ini?');
                        if (confirmation) {
                            $('form').submit();
                        }
                    } else {
                        alert('Anda belum memilih siswa untuk diproses');
                    }
                });

                $('#student_origin').change(function() {
                    if ($(this).val() == 'user') {
                        $('#show-class').addClass('d-none');
                        $('#show-year').addClass('d-none');
                        window.location.href = "student-class?origin=" + $(this).val();
                    } else {
                        $('#show-class').removeClass('d-none');
                        $('#show-year').removeClass('d-none');
                        loadSiswa('student', $('#show-class').val(), $('#show-year').val());
                    }
                });

                $('#show-class').change(function() {
                    loadSiswa('student', $('#show-class').val(), $('#show-year').val());
                });
                $('#show-year').change(function() {
                    loadSiswa('student', $('#show-class').val(), $('#show-year').val());
                });



            });

            function checkSelectedSiswa() {
                var selectedCount = selectedSiswa.length;
                if (selectedCount > 0) {
                    $('#btn-move-class').removeAttr('disabled');
                } else {
                    $('#btn-move-class').attr('disabled', 'disabled');
                }
            }

            function getAction(val_action) {
                switch (val_action.value) {
                    case 'alumni':
                        $('#show-move').addClass('d-none');
                        $('#show-years').removeClass('d-none');
                        break;
                    case 'delete':
                        $('#show-move').addClass('d-none');
                        $('#show-years').addClass('d-none');
                        break;

                    default:
                        $('#show-move').removeClass('d-none');
                        $('#show-years').removeClass('d-none');
                        break;
                }
            }

            function loadSiswa(based, classes, year) {
                var notempty = based && classes && year;
                if (notempty) {
                    window.location.href = "student-class?origin=" + based + "&class=" + classes + "&year=" + year;
                }
            }
        </script>
    @endpush
@endsection
