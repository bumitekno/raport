@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.datatable.datatable_css')
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

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                    <h4>{{ session('title') }}</h4>
                                    <div class="form-group row my-auto mx-3">
                                        <label for="inputUsername" class="col-auto col-form-label my-auto">Pilih
                                            Mapel</label>
                                        <div class="col">
                                            <select name="id_course" id="id_course" class="form-control">
                                                <option value="" selected disabled>-- Pilih Mapel --</option>
                                                @foreach ($courses as $course)
                                                    <option data-slug-course="{{ $course['slug_mapel'] }}"
                                                        data-slug-study-class="{{ $course['slug_class'] }}"
                                                        data-slug-teacher="{{ $course['slug_teacher'] }}"
                                                        value="{{ $course['id_course'] }}">
                                                        {{ $course['name_mapel'] . ', ' . $course['name_class'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area br-8">
                            <table id="table-list" class="table dt-table-hover w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tipe</th>
                                        <th>Kode</th>
                                        <th>Capaian Kompetensi</th>
                                        <th>Deskripsi</th>
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
        </div>
    </div>
    @push('scripts')
        @include('package.datatable.datatable_js')
        <script>
            $(function() {
                var table = $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "",
                    dom: "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
                        "<'table-responsive'tr>" +
                        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",
                    buttons: [{
                        text: 'Tambah Baru',
                        className: 'btn btn-primary addData',
                        action: function(e, dt, node, config) {


                            var selectedOption = $('#id_course option:selected');
                            var course = selectedOption.data('slug-course');
                            var studyClass = selectedOption.data('slug-study-class');
                            var teacher = selectedOption.data('slug-teacher');
                            var url = '{{ route('setting_scores.competence.create') }}' +
                                '?course=' + course +
                                '&study_class=' + studyClass + '&teacher=' + teacher;
                            window.location = url;


                        }
                    }],
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                    }, {
                        data: 'type.name',
                        name: 'type.name',
                    }, {
                        data: 'code',
                        name: 'code',
                    }, {
                        data: 'achievement',
                        name: 'achievement',
                    }, {
                        data: 'description',
                        name: 'description',
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });


                // Simpan tombol Tambah Baru ke variabel
                const tambahBaruBtn = $('button.addData');

                // Dapatkan select dropdown
                const mapelDropdown = $('select#id_course');

                // Sembunyikan tombol Tambah Baru secara default
                tambahBaruBtn.hide();

                // Tambahkan event listener untuk dropdown
                mapelDropdown.change(function() {
                    // Jika dropdown dipilih, tampilkan tombol Tambah Baru
                    if ($(this).val() !== null) {
                        tambahBaruBtn.show();
                    } else {
                        tambahBaruBtn.hide();
                    }
                });

            });
        </script>
    @endpush
@endsection
