@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.datatable.datatable_css')
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
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                    <h4>{{ session('title') }}</h4>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('setting_scores.score_competency.storeOrUpdate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <div class="table-responsive">
                                    <table id="table-list" class="table dt-table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Siswa</th>
                                                <th>NISN</th>
                                                <th>Nilai Akhir</th>
                                                <th>Tujuan Pembelajaran Tercapai</th>
                                                <th>Tujuan Pembelajaran Perlu Ditingkatkan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($result as $index => $student)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @php
                                                            $file = asset('asset/img/90x90.jpg');
                                                            if ($student['file'] != null) {
                                                                $file = asset($student['file']);
                                                            }
                                                        @endphp
                                                        <div class="d-flex">
                                                            <div class="usr-img-frame mr-2 rounded-circle">
                                                                <img alt="avatar" class="img-fluid rounded-circle"
                                                                    src="{{ $file }}">
                                                            </div>
                                                            <p class="align-self-center mb-0 admin-name">
                                                                {{ $student['name'] }}</p>
                                                        </div>
                                                    </td>
                                                    <td>{{ $student['nisn'] }}</td>
                                                    <td>{{ $student['score'] }}</td>
                                                    <input type="hidden" name="id_student_class_{{ $index + 1 }}"
                                                        value="{{ $student['id'] }}">
                                                    <input type="hidden" name="count_each[]" value="{{ $index + 1 }}">
                                                    <td>
                                                        <div class="form-group form-check pl-0 mb-0">
                                                            <div class="custom-control custom-checkbox checkbox-info">
                                                                <input type="checkbox"
                                                                    class="custom-control-input select-all-checkbox"
                                                                    id="check_all_archieved_{{ $index }}"
                                                                    data-student-index="{{ $index }}"
                                                                    data-competency-type="competency_archieved">
                                                                <label class="custom-control-label"
                                                                    for="check_all_archieved_{{ $index }}">Pilih
                                                                    Semua</label>
                                                            </div>
                                                        </div>
                                                        @foreach ($student['competency_archieved'] as $competency_archieved)
                                                            <div class="form-group form-check pl-0 mb-0">
                                                                <div class="custom-control custom-checkbox checkbox-info">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input competency-checkbox"
                                                                        id="competency_achieved_{{ $student['id'] . '_' . $competency_archieved['id'] }}"
                                                                        name="competency_achieved_{{ $index + 1 }}[]"
                                                                        data-student-index="{{ $index }}"
                                                                        data-competency-type="competency_archieved"
                                                                        value="{{ $competency_archieved['id'] }}"
                                                                        {{ $competency_archieved['checked'] == true ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="competency_achieved_{{ $student['id'] . '_' . $competency_archieved['id'] }}">{{ $competency_archieved['achievement'] }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-check pl-0 mb-0">
                                                            <div class="custom-control custom-checkbox checkbox-info">
                                                                <input type="checkbox"
                                                                    class="custom-control-input select-all-checkbox"
                                                                    id="check_all_improved_{{ $index }}"
                                                                    data-student-index="{{ $index }}"
                                                                    data-competency-type="competency_improved">
                                                                <label class="custom-control-label"
                                                                    for="check_all_improved_{{ $index }}">Pilih
                                                                    Semua</label>
                                                            </div>
                                                        </div>
                                                        @foreach ($student['competency_improved'] as $competency_improved)
                                                            <div class="form-group form-check pl-0 mb-0">
                                                                <div class="custom-control custom-checkbox checkbox-info">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input competency-checkbox"
                                                                        id="competency_improved_{{ $student['id'] . '_' . $competency_improved['id'] }}"
                                                                        name="competency_improved_{{ $index + 1 }}[]"
                                                                        value="{{ $competency_improved['id'] }}"
                                                                        data-student-index="{{ $index }}"
                                                                        data-competency-type="competency_improved"
                                                                        {{ $competency_improved['checked'] == true ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="competency_improved_{{ $student['id'] . '_' . $competency_improved['id'] }}">{{ $competency_improved['achievement'] }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
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
        @include('package.datatable.datatable_js')
        <script>
            $(document).ready(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                $('.select-all-checkbox').click(toggleSelectAllCheckbox);
            });

            function toggleCompetencyCheckboxes(studentIndex, competencyType, isChecked) {
                $('.competency-checkbox[data-student-index="' + studentIndex + '"][data-competency-type="' + competencyType +
                    '"]').prop('checked', isChecked);
            }

            function toggleSelectAllCheckbox() {
                var selectAllCheckbox = $(this);
                var studentIndex = selectAllCheckbox.data('student-index');
                var competencyType = selectAllCheckbox.data('competency-type');
                var isChecked = selectAllCheckbox.prop('checked');

                toggleCompetencyCheckboxes(studentIndex, competencyType, isChecked);
            }


            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
