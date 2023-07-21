@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.datatable.datatable_css')
        <style>
            .progress {
                display: block;
                text-align: center;
                width: 0;
                height: 3px;
                background: red;
                transition: width .3s;
            }

            .progress.hide {
                opacity: 0;
                transition: opacity 1.3s;
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

            <div class="progress"></div>

            <div class="row" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>{{ session('title') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area br-8">
                            <table id="table-list" class="table dt-table-hover w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
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
                        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="importTemplate">Download Template Excel</label>
                                <a href="{{ route('users.export') }}" class="btn btn-success btn-sm"><svg
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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
                            className: 'btn btn-primary',
                            action: function(e, dt, node, config) {
                                window.location = '{{ route('users.create') }}';
                            }
                        },
                        {
                            text: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="8" x2="8" y2="8"></line><line x1="16" y1="16" x2="8" y2="16"></line><line x1="10" y1="12" x2="3" y2="12"></line></svg>',
                            className: 'btn btn-success',
                            action: function(e, dt, node, config) {
                                $('#importModal').modal('show');
                            }
                        }, {
                            text: 'Sync',
                            className: 'btn btn-warning',
                            action: function(e, dt, node, config) {
                                //syncData();
                            }
                        },
                    ],
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                    }, {
                        data: 'name',
                        name: 'name',
                    }, {
                        data: 'nisn',
                        name: 'nisn',
                    }, {
                        data: 'email',
                        name: 'email',
                    }, {
                        data: 'phone',
                        name: 'phone',
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });

            });

            function syncData() {
                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                console.log(percentComplete);
                                $('.progress').css({
                                    width: percentComplete * 100 + '%'
                                });
                            }
                        }, false);
                        return xhr;
                    },
                    type: 'GET',
                    url: "{{ route('users.sync_get_user') }}",
                    success: function(data) {
                        //Do something on success
                        table.ajax.reload();
                    }
                });
                return false;
            }
        </script>
    @endpush
@endsection
