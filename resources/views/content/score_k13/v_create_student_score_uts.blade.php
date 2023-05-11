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
                        <form action="{{ route('k13.scores.update') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Pengetahuan</th>
                                                <th scope="col">Ketrampilan</th>
                                                <th scope="col">Hasil Akhir</th>
                                            </tr>
                                        </thead>
                                        <input type="hidden" name="id_school_year" value="{{ $result['id_school_year'] }}">
                                        <input type="hidden" name="id_student_class"
                                            value={{ $result['id_student_class'] }}>
                                        <input type="hidden" name="id_subject_teacher"
                                            value="{{ $result['id_subject_teacher'] }}">
                                        <input type="hidden" name="id_study_class" value="{{ $result['id_study_class'] }}">
                                        <input type="hidden" name="average_assesment" id="average-assesment-input"
                                            value="{{ $result['average_assesment'] }}">
                                        <input type="hidden" name="average_skill" id="average-skill-input"
                                            value="{{ $result['average_skill'] }}">
                                        <input type="hidden" name="final_assesment" id="hasil-akhir-assesment-input"
                                            value="{{ $result['final_assesment'] }}">
                                        <input type="hidden" name="type" value="uts">
                                        <input type="hidden" name="final_skill" id="hasil-akhir-ketrampilan-input"
                                            value="{{ $result['final_skill'] }}">
                                        <tbody>
                                            @if (empty($result['assessment_score']))
                                                <tr>
                                                    <td>
                                                        <button class="btn btn-outline-primary add-row" type="button">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <select name="id_kd_assesment[]" id=""
                                                            class="form-control">
                                                            <option value="" disabled>Pilih KD</option>
                                                            @foreach ($basic_competencies as $basic_competency)
                                                                @php
                                                                    $name = json_decode($basic_competency->name);
                                                                @endphp
                                                                <option value="{{ $basic_competency->id }}">
                                                                    {{ $name->code . ' ' . $name->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" class="form-control mt-2"
                                                            name="nilai_pengetahuan[]" placeholder="Nilai Pengetahuan"
                                                            min="0" max="100">
                                                    </td>
                                                    <td>
                                                        <select name="id_kd_skill[]" id="" class="form-control">
                                                            <option value="" disabled>Pilih KD</option>
                                                            @foreach ($basic_competencies as $basic_competency)
                                                                @php
                                                                    $name = json_decode($basic_competency->name);
                                                                @endphp
                                                                <option value="{{ $basic_competency->id }}">
                                                                    {{ $name->code . ' ' . $name->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" class="form-control mt-2"
                                                            name="nilai_ketrampilan[]" placeholder="Nilai Ketrampilan"
                                                            min="0" max="100">
                                                    </td>
                                                    <td>
                                                        <p class="hasil-akhir-assesment">0
                                                        </p>
                                                        <p class="hasil-akhir-ketrampilan">0</p>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($result['assessment_score'] as $index => $assessment)
                                                    <tr>
                                                        <td>
                                                            @if ($index == 0)
                                                                <button class="btn btn-outline-primary add-row"
                                                                    type="button" {{ $result['status_form'] == false ? 'disabled' : '' }}>
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-outline-danger remove-row"
                                                                    type="button" {{ $result['status_form'] == false ? 'disabled' : '' }}>
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select name="id_kd_assesment[]" id=""
                                                                class="form-control" {{ $result['status_form'] == false ? 'disabled' : '' }}>
                                                                <option value="" disabled>Pilih KD</option>
                                                                @foreach ($basic_competencies as $basic_competency)
                                                                    @php
                                                                        $name = json_decode($basic_competency->name);
                                                                    @endphp
                                                                    <option value="{{ $basic_competency->id }}"
                                                                        {{ $basic_competency->id == $assessment->id_kd ? 'selected' : '' }}>
                                                                        {{ $name->code . ' ' . $name->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="number" class="form-control mt-2"
                                                                name="nilai_pengetahuan[]" placeholder="Nilai Pengetahuan"
                                                                min="0" max="100"
                                                                value="{{ $assessment->score }}" {{ $result['status_form'] == false ? 'readonly' : '' }}>
                                                        </td>
                                                        <td>
                                                            <select name="id_kd_skill[]" id=""
                                                                class="form-control" {{ $result['status_form'] == false ? 'disabled' : '' }}>
                                                                <option value="" disabled>Pilih KD</option>
                                                                @foreach ($basic_competencies as $basic_competency)
                                                                    @php
                                                                        $name = json_decode($basic_competency->name);
                                                                    @endphp
                                                                    <option value="{{ $basic_competency->id }}"
                                                                        {{ $basic_competency->id == $result['skill_score'][$index]->id_kd ? 'selected' : '' }}>
                                                                        {{ $name->code . ' ' . $name->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="number" class="form-control mt-2"
                                                                name="nilai_ketrampilan[]" placeholder="Nilai Ketrampilan"
                                                                min="0" max="100"
                                                                value="{{ $result['skill_score'][$index]->score }}" {{ $result['status_form'] == false ? 'readonly' : '' }}>
                                                        </td>
                                                        <td>
                                                            <p class="hasil-akhir-assesment">
                                                                {{ $result['final_assesment'] }}
                                                            </p>
                                                            <p class="hasil-akhir-ketrampilan">
                                                                {{ $result['final_skill'] }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td>Rata-rata</td>
                                                <td class="average-assesment">{{ $result['average_assesment'] }}</td>
                                                <td class="average-skill">{{ $result['average_skill'] }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>UTS</td>
                                                <td colspan="2">
                                                    <input type="number" class="form-control uts" name="uts"
                                                        placeholder="Nilai UTS" min="0" max="100"
                                                        value="{{ $result['score_uts'] }}" {{ $result['status_form'] == false ? 'readonly' : '' }}>
                                                </td>
                                                <td></td>
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
                function updateAverage() {
                    let sum_assesment = 0;
                    let sum_skill = 0;
                    let count = 0;

                    $("input[name='nilai_pengetahuan[]']").each(function() {
                        sum_assesment += parseInt($(this).val()) || 0;
                        count += 1;
                    });

                    $("input[name='nilai_ketrampilan[]']").each(function() {
                        sum_skill += parseInt($(this).val()) || 0;
                    });

                    let average_assesment = sum_assesment / count;
                    let average_skill = sum_skill / count;

                    $('.average-assesment').text(average_assesment.toFixed(2));
                    $('.average-skill').text(average_skill.toFixed(2));

                    let uts = parseInt($("input[name='uts']").val()) || 0;


                    let bobotAssesment = '{{ $weight['score_weight'] }}' * 0.01;
                    let bobotUts = '{{ $weight['uts_weight'] }}' * 0.01;

                    let hasil_akhir_assesment = (average_assesment * bobotAssesment) + (uts * bobotUts);
                    let hasil_akhir_ketrampilan = average_skill;

                    $('.hasil-akhir-assesment').text(hasil_akhir_assesment.toFixed(2));
                    $('.hasil-akhir-ketrampilan').text(hasil_akhir_ketrampilan.toFixed(2));
                    $('#average-assesment-input').val(average_assesment.toFixed(2));
                    $('#average-skill-input').val(average_skill.toFixed(2));
                    $('#hasil-akhir-assesment-input').val(hasil_akhir_assesment.toFixed(2));
                    $('#hasil-akhir-ketrampilan-input').val(hasil_akhir_ketrampilan.toFixed(2));
                }

                function newRow() {
                    let row = `
                <tr>
                    <td>
                        <button class="btn btn-outline-danger remove-row" type="button">
                            <i class="fas fa-minus"></i>
                        </button>
                    </td>
                    <td>
                        <select name="id_kd_assesment[]" id="" class="form-control">
                        </select>
                        <input type="number" class="form-control mt-2" name="nilai_pengetahuan[]" placeholder="Nilai Pengetahuan" min="0" max="100">
                    </td>
                    <td>
                        <select name="id_kd_skill[]" id="" class="form-control">
                        </select>
                        <input type="number" class="form-control mt-2" name="nilai_ketrampilan[]" placeholder="Nilai Ketrampilan" min="0" max="100">
                    </td>
                    <td class="hasil-akhir">
                    </td>
                </tr>
            `;
                    let newRow = $(row);
                    newRow.find("select[name='id_kd_assesment[]']").replaceWith($("select[name='id_kd_assesment[]']")
                        .eq(0).clone());
                    newRow.find("select[name='id_kd_skill[]']").replaceWith($("select[name='id_kd_skill[]']").eq(0)
                        .clone());
                    $('.average-assesment').closest('tr').before(newRow);

                    // Sembunyikan hasil akhir pada semua baris kecuali baris terakhir
                    $('.hasil-akhir').not(':last').empty();

                    // Tampilkan label atau ikon pada baris terakhir
                    let lastRow = $('.hasil-akhir:last');
                    if (lastRow.find('.label-akhir').length === 0) {
                        lastRow.html(`
                    <div class="label-akhir">
                        <p><strong>Pengetahuan:</strong> <span class="hasil-akhir-assesment">{{ $result['final_assesment'] }}</span></p>
                        <p><strong>Ketrampilan:</strong> <span class="hasil-akhir-ketrampilan">{{ $result['final_skill'] }}</span></p>
                    </div>
                `);
                    }
                }

                $('body').on('click', '.add-row', function() {
                    newRow();
                });

                $('body').on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                    updateAverage();
                });

                $('body').on('input',
                    "input[name='nilai_pengetahuan[]'], input[name='nilai_ketrampilan[]'], input[name='uts'], input[name='uas']",
                    function() {
                        updateAverage();
                    });

                // Menambahkan baris baru saat halaman dimuat (opsional)
                // newRow();



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
