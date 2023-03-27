@extends('layout.admin.v_master')
@section('master')
    @push('styles')
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
                                <th>Nama</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
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
                        className: 'btn btn-primary',
                        action: function(e, dt, node, config) {
                            window.location = '{{ route('classes.create') }}';
                        }
                    }],
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
                        data: 'level.name',
                        name: 'level.name',
                    }, {
                        data: 'major.name',
                        name: 'major.name',
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
