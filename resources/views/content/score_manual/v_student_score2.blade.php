@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.fonts.fontawesome_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
        @include('package.modal.modal_css')
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
                            <div class="d-flex justify-content-between">
                                <h4>{{ session('title') }}</h4>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#importModal"
                                    class="mx-3 text-info my-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2"
                                            ry="2"></rect>
                                        <line x1="16" y1="8" x2="8" y2="8"></line>
                                        <line x1="16" y1="16" x2="8" y2="16"></line>
                                        <line x1="10" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <form action="{{ route('manual2s.scores.storeOrUpdate') }}" id="formUpdate" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="align-middle">No</th>
                                                <th rowspan="2" class="align-middle">Siswa</th>
                                                <th rowspan="2" class="align-middle">NIS</th>
                                                <th rowspan="2" class="align-middle">KKM</th>
                                                <th colspan="4" class="align-middle text-center">Nilai</th>
                                            </tr>
                                            <tr>
                                                <th class="align-middle">Pengetahuan</th>
                                                <th class="align-middle">Predikat</th>
                                                <th class="align-middle">Ketrampilan</th>
                                                <th class="align-middle">Predikat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($result as $student)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $student['name'] }}</td>
                                                    <td>{{ $student['nis'] }}</td>
                                                    <td>{{ $student['kkm'] }}
                                                        @error('kkm.*')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="final_assegment[]"
                                                            value="{{ $student['final_assegment'] != null ? $student['final_assegment'] : '0' }}"
                                                            {{ $student['status_form'] == false ? 'readonly' : '' }}>
                                                        @error('final_assegment.*')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="text-center predicate_assegement">
                                                        {{ $student['predicate_assegment'] }}
                                                        @error('predicate_assegment.*')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="final_skill[]"
                                                            value="{{ $student['final_skill'] != null ? $student['final_skill'] : '0' }}"
                                                            {{ $student['status_form'] == false ? 'readonly' : '' }}>
                                                        @error('final_skill.*')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="text-center predicate_skill">
                                                        {{ $student['predicate_skill'] }}
                                                        @error('predicate_skill.*')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <input type="hidden" name="predicate_skill[]"
                                                        value="{{ $student['predicate_skill'] }}">
                                                    <input type="hidden" name="kkm[]" value="{{ $student['kkm'] }}">
                                                    <input type="hidden" name="predicate_assegment[]"
                                                        value="{{ $student['predicate_assegment'] }}">
                                                    <input type="hidden" name="id_student_class[]"
                                                        value="{{ $student['id_student_class'] }}">
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="account-settings-footer">

            <div class="as-footer-container">

                <button id="multiple-reset" class="btn btn-warning">Reset All</button>
                <div class="blockui-growl-message">
                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                </div>
                <button class="btn btn-primary d-none" id="btnLoader">
                    <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                        Loading...</div>
                    Loading
                </button>
                <button class="btn btn-primary" id="btnSubmit" onclick="submitForm()">Simpan
                    Data</button>

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
                        <form action="{{ route('manual2s.scores.import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="importTemplate">Download Template Excel</label>
                                <a href="{{ route('manual2s.scores.export') }}" class="btn btn-success btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                                    </svg>
                                    Download</a>
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
        <script>
            $(document).ready(function() {
                var predicated = @json($predicated);
                $("input[name='final_assegment[]']").keyup(function() {
                    // ambil nilai-nilai yang dibutuhkan
                    var final_assegment = parseFloat($(this).closest("tr").find(
                        "input[name='final_assegment[]']").val()) || 0;

                    $(this).closest("tr").find("td:eq(5)").text(final_assegment);

                    var predikat_assegement;
                    $.each(predicated, function(index, item) {
                        // console.log(item.name);
                        var score_range = item.score.split("-");
                        var score_min = parseInt(score_range[0]);
                        var score_max = parseInt(score_range[1]);
                        if (final_assegment >= score_min && final_assegment <= score_max) {
                            predikat_assegement = item.name;
                        }
                    });
                    $(this).closest("tr").find(".predicate_assegement").text(predikat_assegement);
                    $(this).closest("tr").find("input[name='predicate_assegment[]']").val(predikat_assegement);
                });

                $("input[name='final_skill[]']").keyup(function() {
                    // ambil nilai-nilai yang dibutuhkan
                    var final_skill = parseFloat($(this).closest("tr").find(
                        "input[name='final_skill[]']").val()) || 0;

                    $(this).closest("tr").find("td:eq(7)").text(final_skill);

                    var predikat_skill;
                    $.each(predicated, function(index, item) {
                        var score_range = item.score.split("-");
                        var score_min = parseInt(score_range[0]);
                        var score_max = parseInt(score_range[1]);
                        if (final_skill >= score_min && final_skill <= score_max) {
                            predikat_skill = item.name;
                        }
                    });

                    // tampilkan predikat skill
                    $(this).closest("tr").find(".predicate_skill").text(predikat_skill);
                    $(this).closest("tr").find("input[name='predicate_skill[]']").val(predikat_skill);
                });

                $("#formUpdate").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function submitForm() {
                $('#formUpdate').submit();
            }
        </script>
    @endpush
@endsection
