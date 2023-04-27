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
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>{{ session('title') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area br-8">
                            <div class="table-responsive">
                                <table id="table-list" class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Siswa</th>
                                            <th>Email</th>
                                            <th>Tempat, Tanggal lahir</th>
                                            <th>Nilai Akhir</th>
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
                        data: 'email',
                        name: 'email',
                    }, {
                        data: null,
                        name: 'place_and_date_of_birth',
                        render: function(data, type, row) {
                            return row.place_of_birth + ', ' + row.date_of_birth;
                        }
                    }, {
                        data: 'score',
                        name: 'score',
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });

            });
        </script>
    @endpush
@endsection
