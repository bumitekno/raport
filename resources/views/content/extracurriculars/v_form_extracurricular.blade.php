@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        {{-- @include('package.datatable.datatable_css') --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($teacher) ? 'Edit' : 'Tambah' }}
                        </li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('extracurriculars.updateOrCreate', ['id' => isset($extra) ? $extra->id : null]) }}"
                method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">{{ session('title') }}</h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fullName">Ekstrakurikuler</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ isset($extra) ? old('name', $extra->name) : old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fullName">Penanggung Jawab</label>
                                        <input type="text" class="form-control" name="person_responsible"
                                            placeholder="Penanggung Jawab"
                                            value="{{ isset($extra) ? old('person_responsible', $extra->person_responsible) : old('person_responsible') }}">
                                        @error('person_responsible')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                {{-- <input type="hidden" name="id_studenst_classes" id="selected-rows-data"> --}}
                            </div>
                            {{-- <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <h6 class="mb-2">Cari Siswa</h6>
                                    <table id="student-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>NIS</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Tampilkan data siswa yang dicari -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="mb-2">Siswa Terpilih</h6>
                                <table id="selected-students-table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>NIS</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Tampilkan data siswa yang sudah dipilih -->
                                    </tbody>
                                </table>
                            </div>

                        </div> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="account-settings-footer">

            <div class="as-footer-container">

                <button id="multiple-reset" class="btn btn-warning">Reset All</button>
                <div class="blockui-growl-message">
                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                </div>


                <button class="btn btn-primary d-none" id="btnLoader">
                    <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                        Loading...</div>
                    Loading
                </button>
                <button class="btn btn-primary" id="btnSubmit" onclick="submitForm()">Simpan
                    Data</button>


                {{-- <button id="btnLoader" class="btn btn-primary" onclick="">Save Changes</button> --}}

            </div>

        </div>
    </div>
    @push('scripts')
        @include('package.datatable.datatable_js')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                // var table = $('#table-list').DataTable({
                //     processing: true,
                //     serverSide: true,
                //     responsive: true,
                //     ajax: "",
                //     columns: [{
                //             data: 'DT_RowIndex',
                //             name: 'DT_RowIndex',
                //             orderable: false,
                //             searchable: false,
                //             className: 'align-middle',
                //             checkboxes: {
                //                 selectRow: true,
                //                 selected: []
                //             }
                //         },
                //         {
                //             data: 'student.nis',
                //             name: 'student.nis',
                //         },
                //         {
                //             data: 'student.name',
                //             name: 'student.name',
                //         },
                //         {
                //             data: 'study_class.name',
                //             name: 'study_class.name',
                //         },
                //         {
                //             data: 'action',
                //             name: 'action',
                //         },
                //     ]
                // });
            });


            function submitForm() {

                var selectedRowsData = [];
                $('#table-list tbody input[type="checkbox"]:checked').each(function(index, checkbox) {
                    var rowId = $(checkbox).val();
                    selectedRowsData.push(rowId);
                });
                $('#selected-rows-data').val(JSON.stringify(selectedRowsData));
                $('form').submit();
            }
        </script>
    @endpush
@endsection
