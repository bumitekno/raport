@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/search.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
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
                                                <h4 class="text-capitalize">{{ session('title') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content widget-content-area rounded-vertical-pills-icon">

                                        <div class="tab-content" id="rounded-vertical-pills-tabContent">
                                            <div class="tab-pane fade show active" id="rounded-vertical-pills-home"
                                                role="tabpanel" aria-labelledby="rounded-vertical-pills-home-tab">
                                                <div class="search-input-group-style input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-search">
                                                                <circle cx="11" cy="11" r="8">
                                                                </circle>
                                                                <line x1="21" y1="21" x2="16.65"
                                                                    y2="16.65"></line>
                                                            </svg></span>
                                                    </div>
                                                    <input type="text" id="input-search" class="form-control"
                                                        placeholder="Let's find your question in fast way"
                                                        aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                                <form action="" method="post">
                                                    @csrf
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="align-middle text-center">No</th>
                                                                    <th class="align-middle">Kelas</th>
                                                                    <th class="align-middle">Tingkat</th>
                                                                    <th class="align-middle">Jurusan</th>
                                                                    <th class="align-middle text-center">Jumlah Siswa</th>
                                                                    <th class="align-middle"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="class-table">
                                                                @foreach ($results as $result)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                                        <td>{{ $result['name'] }}</td>
                                                                        <td>{{ $result['level'] }}</td>
                                                                        <td>{{ $result['major'] }}</td>
                                                                        <td class="text-center">{{ $result['amount'] }}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{ route('raports.by_classes', ['study_class' => $result['slug'], 'year' => session('slug_year')]) }}">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <circle cx="11" cy="11"
                                                                                        r="8"></circle>
                                                                                    <line x1="21" y1="21"
                                                                                        x2="16.65" y2="16.65">
                                                                                    </line>
                                                                                    <line x1="11" y1="8"
                                                                                        x2="11" y2="14">
                                                                                    </line>
                                                                                    <line x1="8" y1="11"
                                                                                        x2="14" y2="11">
                                                                                    </line>
                                                                                </svg>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </form>
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
        <script>
            $(document).ready(function() {
                $('#input-search').on('keyup', function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('#class-table tr').hide();
                    $('#class-table tr').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                });

                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
