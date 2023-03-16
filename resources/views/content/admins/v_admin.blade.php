@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.datatable.datatable_css')
    @endpush
    <div class="middle-content container-xxl p-0">

        <!-- BREADCRUMB -->
        <div class="page-meta mt-3">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item"><a href="#">App</a></li>
                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
        <!-- /BREADCRUMB -->

        <div class="row" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                <div class="widget-content widget-content-area br-8">

                    <table id="table-list" class="table dt-table-hover w-100">
                        <thead>
                            <tr>
                                <th class="checkbox-column"></th>
                                <th>Posts</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="no-content text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
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
                    processing: false,
                    serverSide: false,
                    ajax: "",
                    dom: "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
                        "<'table-responsive'tr>" +
                        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",
                    buttons: [{
                        text: 'Tambah Baru',
                        className: 'btn btn-primary',
                        action: function(e, dt, node, config) {
                            window.location = '{{ route('admins.create') }}';
                        }
                    }],
                    columns: [{
                        data: 'name',
                        name: 'name',
                    }, {
                        data: 'phone',
                        name: 'phone',
                    }, {
                        data: 'phone',
                        name: 'phone',
                    }, {
                        data: 'email',
                        name: 'email',
                    }, {
                        data: 'last_login',
                        name: 'last_login',
                    }, ]
                });

            });
        </script>
    @endpush
@endsection
