@extends('layout.admin.v_master')
@section('master')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/avatar.css') }}">
        @include('package.switches.switches_css')
        @include('package.datatable.datatable_css')
    @endpush
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ session('title') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-bordered mb-4" id="table-list">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Mapel</th>
                                <th>Guru Mapel</th>
                                <th>Kelas yang diajarkan</th>
                                <th>Status</th>
                                <th class="no-content text-center"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
                        <form action="{{ route('courses.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="importTemplate">Download Template Excel</label>
                                <a href="{{ route('courses.export') }}" class="btn btn-success btn-sm"><svg
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
                    ajax: "",
                    dom: "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
                        "<'table-responsive'tr>" +
                        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",
                    buttons: [{
                            text: '<svg xmlns="http://www.w3.org/2000/svg" width="69" height="69" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
                            className: 'btn btn-primary mr-2',
                            action: function(e, dt, node, config) {
                                window.location = '{{ route('courses.create') }}';
                            }
                        },
                        {
                            text: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="8" x2="8" y2="8"></line><line x1="16" y1="16" x2="8" y2="16"></line><line x1="10" y1="12" x2="3" y2="12"></line></svg>',
                            className: 'btn btn-success',
                            action: function(e, dt, node, config) {
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
                        data: 'name',
                        name: 'name',
                        className: 'text-center'
                    }, {
                        data: 'teacher',
                        name: 'teacher',
                        className: 'text-center'
                    }, {
                        data: 'classes',
                        name: 'classes',
                        className: 'align-middle text-center'
                    }, {
                        data: 'status',
                        name: 'status',
                        className: 'align-middle text-center'
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });

            });
        </script>
    @endpush
@endsection
