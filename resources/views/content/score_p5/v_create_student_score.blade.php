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
                            @if (!empty($biodate_siswa))
                                <div class="widget-content widget-content-area br-8">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="text-right " scope="row">Nama : </td>
                                                <td class="text-left"> {{ $biodate_siswa['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" scope="row">NIS : </td>
                                                <td class="text-left"> {{ $biodate_siswa['nis'] }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" scope="row">NISN : </td>
                                                <td class="text-left"> {{ $biodate_siswa['nisn'] }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" scope="row">Kelas : </td>
                                                <td class="text-left"> {{ $biodate_siswa['kelas'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('setting_scores.score.storeOrUpdate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <div class="table-responsive">
                                    <input type="hidden" name="type" value="uas">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Jenis Nilai</th>
                                                <th scope="col">Nilai</th>
                                                <th scope="col">Rata-rata</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" name="average_formative" class="average-formative-input"
                                                value="{{ old('average_formative', $result['average_formative']) }}">
                                            <input type="hidden" name="average_summative" class="average-summative-input"
                                                value="{{ old('average_summative', $result['average_summative']) }}">
                                            <input type="hidden" name="final_score" class="final-score-input"
                                                value="{{ old('final_score', $result['final_score']) }}">
                                            <input type="hidden" name="id_student_class"
                                                value="{{ old('id_student_class', $result['id_student_class']) }}">
                                            <input type="hidden" name="id_course"
                                                value="{{ old('id_course', $result['id_course']) }}">
                                            <input type="hidden" name="id_study_class"
                                                value="{{ old('id_study_class', $result['id_study_class']) }}">
                                            <input type="hidden" name="id_teacher"
                                                value="{{ old('id_teacher', $result['id_teacher']) }}">
                                            <input type="hidden" name="id_school_year"
                                                value="{{ old('id_school_year', $result['id_school_year']) }}">
                                            <tr>
                                                <td>1</td>
                                                <td>Nilai Formatif</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <select name="id_competency[]" id=""
                                                                class="form-control">
                                                                <option value="" selected disabled>Pilih Kompetensi
                                                                </option>
                                                                @foreach ($competence_achievement as $competency)
                                                                    <option value="{{ $competency['id'] }}"
                                                                        {{ !empty($result['score_formative']) && $result['score_formative'][0]->id_competency == $competency['id'] ? 'selected' : '' }}>
                                                                        {{ $competency['achievement'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control formative"
                                                                    placeholder="Formative 1" name="formative[]"
                                                                    value="{{ !empty($result['score_formative']) && isset($result['score_formative'][0]->score) ? $result['score_formative'][0]->score : '0' }}"
                                                                    {{ $result['status_form'] == false ? 'readonly' : '' }}>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary add-formative"
                                                                        type="button"
                                                                        {{ $result['status_form'] == false ? 'disabled' : '' }}><i
                                                                            class="fas fa-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="formative-inputs mt-2"></div>
                                                </td>
                                                <td class="average-formatif">{{ $result['average_formative'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Nilai Sumatif</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control sumatif"
                                                            placeholder="Sumatif 1" name="sumatif[]"
                                                            value="{{ $result['score_summative'] != null ? $result['score_summative'][0] : '0' }}"
                                                            {{ $result['status_form'] == false ? 'readonly' : '' }}>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary add-sumatif"
                                                                type="button"
                                                                {{ $result['status_form'] == false ? 'disabled' : '' }}><i
                                                                    class="fas fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="sumatif-inputs mt-2"></div>
                                                    <table class="table table-borderless">
                                                        <thead>
                                                            <tr>
                                                                <th>UTS</th>
                                                                <th>UAS</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="text" class="form-control uts"
                                                                        name="uts" placeholder="Nilai UTS"
                                                                        value="{{ old('uts', $result['score_uts']) }}"
                                                                        {{ $result['status_form'] == false ? 'readonly' : '' }}>
                                                                </td>
                                                                <td><input type="text" class="form-control uas"
                                                                        name="uas" placeholder="Nilai UAS"
                                                                        value="{{ old('uas', $result['score_uas']) }}"
                                                                        {{ $result['status_form'] == false ? 'readonly' : '' }}>
                                                                </td>
                                                                <td><button class="btn btn-outline-danger remove-uas"
                                                                        type="button"
                                                                        {{ $result['status_form'] == false ? 'disabled' : '' }}><i
                                                                            class="fas fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td class="average-sumatif">{{ $result['average_summative'] }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"> Nilai Akhir
                                                </td>
                                                <td class="nilai-akhir">{{ $result['final_score'] }}</td>
                                            </tr>
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
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                var scoreFormative = {!! json_encode($result['score_formative']) !!};
                var scoreSummative = {!! json_encode($result['score_summative']) !!};

                if (scoreFormative) {
                    for (var i = 1; i < scoreFormative.length; i++) {
                        var formativeInput = `
            <div class="row my-1">
                <div class="col-md-6">
                    <select name="id_competency[]" class="form-control">
                        <option value="" selected disabled>Pilih Kompetensi</option>
                        @foreach ($competence_achievement as $competency)
                        <option value="{{ $competency['id'] }}" ${scoreFormative[i].id_competency == {{ $competency['id'] }} ? 'selected' : ''}>{{ $competency['achievement'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control formative" placeholder="Formative" name="formative[]" value="${scoreFormative[i].score}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary remove-formative" type="button"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        `;
                        $('.formative-inputs').append(formativeInput);
                    }
                }
                if (scoreSummative) {
                    for (var i = 1; i < scoreSummative.length; i++) {
                        var summativeInput = `
                        <div class="input-group mt-2">
        <input type="text" class="form-control sumatif" placeholder="Sumatif" name="sumatif[]" value="${scoreSummative[i]}">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary remove-sumatif" type="button"><i class="fas fa-trash"></i></button>
        </div>
      </div>
      `;
                        $('.sumatif-inputs').append(summativeInput);
                    }
                }

                $(document).on("click", ".add-formative", function() {
                    const formativeInput = `
                        <div class="row">
                            <div class="col-md-6">
                                <select name="id_competency[]" class="form-control">
                                    <option value="" selected disabled>Pilih Kompetensi</option>
                                    @foreach ($competence_achievement as $competency)
                                    <option value="{{ $competency['id'] }}">{{ $competency['achievement'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control formative" placeholder="Formative" name="formative[]">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary remove-formative" type="button"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $(this).closest("td").find(".formative-inputs").append(formativeInput);
                });

                $(document).on("click", ".remove-formative", function() {
                    $(this).closest(".row").remove();
                    hitungRataRataFormatif();
                    hitungNilaiAkhir();
                });

                $(document).on("click", ".add-sumatif", function() {
                    const sumatifInput = `
      <div class="input-group mt-2">
        <input type="text" class="form-control sumatif" placeholder="Sumatif" name="sumatif[]">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary remove-sumatif" type="button"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    `;
                    $(this).closest("tbody").find(".sumatif-inputs").append(sumatifInput);
                });

                $(document).on("click", ".remove-sumatif", function() {
                    $(this).closest(".input-group").remove();
                    hitungRataRataSumatif();
                    hitungNilaiAkhir();
                });

                $(document).on("click", ".remove-uas", function() {
                    $('.uas').val('');
                    $('.uts').val('');
                    hitungRataRataSumatif();
                    hitungNilaiAkhir();
                });

                $(document).on("keyup", ".formative", function() {
                    hitungRataRataFormatif();
                    hitungNilaiAkhir();
                });

                $(document).on("keyup", ".sumatif, .uts, .uas", function() {
                    hitungRataRataSumatif();
                    hitungNilaiAkhir();
                });


            });

            function hitungRataRataFormatif() {
                let sumFormative = 0;
                let countFormative = 0;
                $(".formative").each(function() {
                    const value = parseInt($(this).val());
                    if (!isNaN(value)) {
                        sumFormative += value;
                        countFormative++;
                    }
                });
                const averageFormatif = countFormative > 0 ? sumFormative / countFormative : 0;
                $(".average-formatif").text(averageFormatif.toFixed(2));
            }

            function hitungRataRataSumatif() {
                let sumSumatif = 0;
                let countSumatif = 0;
                $(".sumatif").each(function() {
                    const value = parseInt($(this).val());
                    if (!isNaN(value)) {
                        sumSumatif += value;
                        countSumatif++;
                    }
                });
                const averageSumatif = countSumatif > 0 ? sumSumatif / countSumatif : 0;
                $(".average-sumatif").text(averageSumatif.toFixed(2));
            }

            function hitungNilaiAkhir() {
                console.log("tes");
                let sumFormative = 0;
                let countFormative = 0;
                $(".formative").each(function() {
                    const value = parseInt($(this).val());
                    if (!isNaN(value)) {
                        sumFormative += value;
                        countFormative++;
                    }
                });
                const averageFormatif = countFormative > 0 ? sumFormative / countFormative : 0;
                $(".average-formatif").text(averageFormatif.toFixed(2));

                let sumSumatif = 0;
                let countSumatif = 0;
                $(".sumatif").each(function() {
                    const value = parseInt($(this).val());
                    if (!isNaN(value)) {
                        sumSumatif += value;
                        countSumatif++;
                    }
                });
                const averageSumatif = countSumatif > 0 ? sumSumatif / countSumatif : 0;
                $(".average-sumatif").text(averageSumatif.toFixed(2));

                const uts = parseInt($(".uts").val());
                const uas = parseInt($(".uas").val());
                let bobotFormative = '{{ $weight['formative_weight'] }}' * 0.01;
                let bobotSumative = '{{ $weight['sumative_weight'] }}' * 0.01;
                let bobotUts = '{{ $weight['uts_weight'] }}' * 0.01;
                let bobotUas = '{{ $weight['uas_weight'] }}' * 0.01;
                console.table([bobotFormative, bobotSumative,bobotUts, bobotUas]);
                let nilaiAkhir = (bobotFormative * averageFormatif) + (bobotSumative * averageSumatif) + (bobotUts * uts) + (
                    bobotUas * uas);
                if (isNaN(nilaiAkhir)) {
                    nilaiAkhir = 0;
                }
                $(".nilai-akhir").text(nilaiAkhir.toFixed(2));
                $('.average-formative-input').val($(".average-formatif").text());
                $('.average-summative-input').val($(".average-sumatif").text());
                $('.final-score-input').val($(".nilai-akhir").text());
            }


            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
