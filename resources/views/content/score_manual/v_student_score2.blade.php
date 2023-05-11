@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.fonts.fontawesome_css')
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
                        <div class="widget-header">
                            <h4>{{ session('title') }}</h4>
                        </div>
                        <form action="{{ route('manual2s.scores.storeOrUpdate') }}" method="post">
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
                                                    <td>{{ $student['kkm'] }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="final_assegment[]"
                                                            value="{{ $student['final_assegment'] != null ? $student['final_assegment'] : '0' }}"
                                                            {{ $student['status_form'] == false ? 'readonly' : '' }}>
                                                    </td>
                                                    <td class="text-center predicate_assegement">{{ $student['predicate_assegment'] }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="final_skill[]"
                                                            value="{{ $student['final_skill'] != null ? $student['final_skill'] : '0' }}"
                                                            {{ $student['status_form'] == false ? 'readonly' : '' }}>
                                                    </td>
                                                    <td class="text-center predicate_skill">{{ $student['predicate_skill'] }}</td>
                                                    <input type="hidden" name="predicate_skill[]" value="{{ $student['predicate_skill'] }}">
                                                    <input type="hidden" name="predicate_assegment[]" value="{{ $student['predicate_assegment'] }}">
                                                    <input type="hidden" name="id_student_class[]" value="{{ $student['id_student_class'] }}">
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
    @push('scripts')
        <script>
            $(document).ready(function() {
                var predicated = @json($predicated);
                // console.log(predicated);
                // saat nilai diinputkan
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
