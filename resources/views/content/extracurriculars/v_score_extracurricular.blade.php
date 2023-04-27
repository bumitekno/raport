@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <style>
            .rounded-vertical-pills-icon .nav-pills a {
                -webkit-border-radius: 0.625rem !important;
                -moz-border-radius: 0.625rem !important;
                -ms-border-radius: 0.625rem !important;
                -o-border-radius: 0.625rem !important;
                border-radius: 0.625rem !important;
                background-color: #ffffff;
                border: solid 1px #e4e2e2;
                padding: 11px 23px;
                text-align: center;
                width: 100px;
                padding: 8px;
            }

            .rounded-vertical-pills-icon .nav-pills a svg {
                display: block;
                text-align: center;
                margin-bottom: 10px;
                margin-top: 5px;
                margin-left: auto;
                margin-right: auto;
            }

            .rounded-vertical-pills-icon .nav-pills .nav-link.active,
            .rounded-vertical-pills-icon .nav-pills .show>.nav-link {
                box-shadow: 0px 5px 15px 0px rgba(0, 0, 0, 0.3);
                background-color: #009688;
                border-color: transparent;
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

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="row">
                            <div id="tabsVerticalWithIcon" class="col-lg-12 col-12">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>{{ session()->put('title') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content widget-content-area rounded-vertical-pills-icon">

                                        <div class="row mb-4 mt-3">
                                            <div class="col-sm-4 col-12">
                                                <div class="nav flex-column nav-pills mb-sm-0 mb-3"
                                                    id="rounded-vertical-pills-tab" role="tablist"
                                                    aria-orientation="vertical">
                                                    @foreach ($extras as $extra)
                                                        <a class="nav-link mb-2 mx-auto"
                                                            id="rounded-vertical-pills-profile-tab" data-toggle="pill"
                                                            href="#rounded-vertical-pills-profile" role="tab"
                                                            aria-controls="rounded-vertical-pills-profile"
                                                            aria-selected="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg> {{ $extra->name }}</a>
                                                    @endforeach
                                                    {{-- <a class="nav-link mb-2 active mx-auto"
                                                        id="rounded-vertical-pills-home-tab" data-toggle="pill"
                                                        href="#rounded-vertical-pills-home" role="tab"
                                                        aria-controls="rounded-vertical-pills-home"
                                                        aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-home">
                                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                        </svg> Home</a>
                                                    <a class="nav-link mb-2 mx-auto" id="rounded-vertical-pills-profile-tab"
                                                        data-toggle="pill" href="#rounded-vertical-pills-profile"
                                                        role="tab" aria-controls="rounded-vertical-pills-profile"
                                                        aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-user">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg> Profile</a>
                                                    <a class="nav-link mb-2 mx-auto"
                                                        id="rounded-vertical-pills-messages-tab" data-toggle="pill"
                                                        href="#rounded-vertical-pills-messages" role="tab"
                                                        aria-controls="rounded-vertical-pills-messages"
                                                        aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-mail">
                                                            <path
                                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                            </path>
                                                            <polyline points="22,6 12,13 2,6"></polyline>
                                                        </svg> Messages</a> --}}
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-12">
                                                <div class="tab-content" id="rounded-vertical-pills-tabContent">
                                                    <div class="tab-pane fade show active"
                                                        id="rounded-vertical-pills-home" role="tabpanel"
                                                        aria-labelledby="rounded-vertical-pills-home-tab">
                                                        <h4 class="mb-4">We move your world!</h4>
                                                        <p class="mb-4">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                            enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                                            nisi ut aliquip ex ea commodo consequat.
                                                        </p>

                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                            enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                                            nisi ut aliquip ex ea commodo consequat.
                                                        </p>
                                                    </div>
                                                    <div class="tab-pane fade" id="rounded-vertical-pills-profile"
                                                        role="tabpanel"
                                                        aria-labelledby="rounded-vertical-pills-profile-tab">
                                                        <div class="media mt-4 mb-3 mr-2">
                                                            <img class="mr-3" src="assets/img/90x90.jpg"
                                                                alt="Generic placeholder image">
                                                            <div class="media-body">
                                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus
                                                                scelerisque ante sollicitudin. Cras purus odio, vestibulum
                                                                in vulputate at, tempus viverra turpis. Fusce condimentum
                                                                nunc ac nisi vulputate fringilla. Donec lacinia congue felis
                                                                in faucibus.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="rounded-vertical-pills-messages"
                                                        role="tabpanel"
                                                        aria-labelledby="rounded-vertical-pills-messages-tab">
                                                        <p class="dropcap  dc-outline-primary">
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                            eiusmod
                                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                                            minim veniam,
                                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                                            commodo
                                                            consequat. Duis aute irure dolor in reprehenderit in voluptate
                                                            velit esse
                                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                                                            cupidatat non
                                                            proident, sunt in culpa qui officia deserunt mollit anim id est
                                                            laborum.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    dom: "<'inv-list-top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l<'dt-action-buttons align-self-center'B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
                        "<'table-responsive'tr>" +
                        "<'inv-list-bottom-section d-sm-flex justify-content-sm-between text-center'<'inv-list-pages-count  mb-sm-0 mb-3'i><'inv-list-pagination'p>>",
                    buttons: [{
                        text: 'Tambah Baru',
                        className: 'btn btn-primary',
                        action: function(e, dt, node, config) {
                            window.location = '{{ route('extracurriculars.create') }}';
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
                        data: 'person_responsible',
                        name: 'person_responsible',
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });

            });
        </script>
    @endpush
@endsection
