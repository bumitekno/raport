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

                            <div id="progressbar" style="border:2px solid #cbc; border-radius: 6px; "></div>
                            <p id="loadarea_show" style="display:none;" class="cst-md"></p>
                            <div id="loading" style="display:none;">Loading ....</div>

                            <table id="table-list" class="table dt-table-hover w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nama Ekskul</th>
                                        <th>Penanggung Jawab</th>
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var counter = 0;
                var handle;

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
                            window.location = '{{ route('extracurriculars.create') }}';
                        }
                    }, , {
                        text: 'Sync',
                        className: 'btn btn-warning',
                        action: function(e, dt, node, config) {
                            syncData(table);
                        }
                    }, ],
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
                        data: 'person_responsible',
                        name: 'person_responsible',
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });

            });

            function syncData(table) {
                $.ajax({
                    url: "{{ route('extracurriculars.sync_getdata') }}",
                    method: 'GET',
                    beforeSend: function() {
                        $("#loading").show();
                        counter = 0;
                        $('#loadarea_show').html(counter + '%');
                        $('#progressbar').attr('style',
                            'background:linear-gradient(to bottom, rgba(126,126,126,1) 0%,rgba(15,15,15,1) 100%);height:10px;width:' +
                            counter + '%');
                    },
                    complete: function() {
                        $("#loading").hide();
                        counter = 100;
                        $('#loadarea_show').html(counter + '%');
                        $('#progressbar').attr('style',
                            'background:linear-gradient(to bottom, rgba(126,126,126,1) 0%,rgba(15,15,15,1) 100%);height:10px;width:' +
                            counter + '%');
                    },
                });

                handle = setInterval(() => {

                    $("#loading").show();
                    $('#loadarea_show').html(counter + '%');
                    $('#progressbar').attr('style',
                        'background:linear-gradient(to bottom, rgba(126,126,126,1) 0%,rgba(15,15,15,1) 100%);height:10px;width:' +
                        counter + '%');

                    $.getJSON('{{ route('extracurriculars.getProgess') }}',
                        function(
                            data) {

                            counter = data[0];

                            $('#progressbar').attr('style',
                                'background:linear-gradient(to bottom, rgba(126,126,126,1) 0%,rgba(15,15,15,1) 100%);height:10px;width:' +
                                counter + '%');

                            $('#loadarea_show').show();
                            $('#loadarea_show').html(counter + '%');

                            if (counter == 100) {
                                clearInterval(handle);
                                table.ajax.reload();
                                counter = 0;
                                $("#loading").hide();
                            }

                        });
                }, 1000);
            }
        </script>
    @endpush
@endsection
