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
                                        <th>Mapel</th>
                                        <th>Kelas</th>
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
    @push('modals')
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importExportModalLabel">Import / Export Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('setting_scores.competence.import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="code_course">
                            <input type="hidden" name="code_study_class">
                            <input type="hidden" name="code_teacher">
                            <div class="form-group">
                                <label for="importTemplate">Download Template Excel</label>
                                <a href="{{ route('setting_scores.competence.export') }}" class="btn btn-success btn-sm"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                                    </svg> Download</a>
                            </div>
                            <div class="form-group">
                                <label for="importFile">Select Excel File to Import</label>
                                <input type="file" name="file" class="form-control-file" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        <script>
            $(function() {
                var table = $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "", // URL untuk permintaan Ajax
                        data: function(d) {
                            d.course = $('#id_course option:selected').data('slug-course');
                            d.study_class = $('#id_course option:selected').data('slug-study-class');
                            d.teacher = $('#id_course option:selected').data('slug-teacher');
                        }
                    },
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
                        },
                        {
                            text: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="8" x2="8" y2="8"></line><line x1="16" y1="16" x2="8" y2="16"></line><line x1="10" y1="12" x2="3" y2="12"></line></svg>',
                            className: 'btn btn-success importData',
                            action: function(e, dt, node, config) {
                                var selectedOption = $('#id_course option:selected');
                                $('[name="code_course"]').val(selectedOption.data('slug-course'));
                                $('[name="code_study_class"]').val(selectedOption.data(
                                    'slug-study-class'));
                                $('[name="code_teacher"]').val(selectedOption.data('slug-teacher'));
                                $('#importModal').modal('show');
                            }
                        }
                    ],
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
                        data: 'course.name',
                        name: 'course.name',
                    }, {
                        data: 'study_class.name',
                        name: 'study_class.name',
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
                const tambahBaruBtn = $('button.addData, button.importData');

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
                    table.ajax.reload();
                });

            });
        </script>
    @endpush
@endsection
