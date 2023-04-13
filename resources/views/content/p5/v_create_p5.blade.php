@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.bootstrap-select.bootstrap-select_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
        <style>
            input[type="checkbox"] {
                margin-left: 0.25rem;
                margin-right: 0.25rem;
                margin-top: 0;
                margin-bottom: 0;
                padding: 0;
                width: 1.25rem;
                height: 1.25rem;
            }

            .pointer {
                cursor: pointer;
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
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($teacher) ? 'Edit' : 'Tambah' }}
                        </li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('manages.updateOrCreate', ['id' => isset($p5) ? $p5->id : null]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">{{ session('title') }}</h6>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Tema</label>
                                    <select name="id_tema" class="form-control selectpicker" data-live-search="true">
                                        <option value="" selected disabled>-- Pilih Tema -- </option>
                                        @foreach ($temas as $tema)
                                            <option value="{{ $tema['id'] }}"
                                                {{ isset($p5) && old('id_tema', $p5->id_tema) == $tema->id ? 'selected' : (old('id_tema') == $tema->id ? 'selected' : '') }}>
                                                {{ $tema['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Judul Proyek</label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ isset($p5) ? old('title', $p5->title) : old('title') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Deskripsi Proyek</label>
                                <textarea name="description" rows="3" class="form-control">{{ isset($p5) ? old('description', $p5->description) : old('description') }}</textarea>
                            </div>
                            @if (Auth::guard('teacher')->check())
                                <input type="hidden" name="id_study_class" value="{{ session('teachers.id_study_class') }}">
                                <input type="hidden" name="id_subject_teacher" value="{{ session('teachers.id_subject_teacher') }}">
                            @else
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Kelas</label>
                                        <select name="id_study_class" class="form-control">
                                            <option value="" selected disabled>Pilih Kelas</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ isset($p5) && old('id_study_class', $p5->id_study_class) == $class->id ? 'selected' : (old('id_study_class') == $class->id ? 'selected' : '') }}>
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Penanggung Jawab</label>
                                        <select name="id_subject_teacher" class="form-control selectpicker"
                                            data-live-search="true" {{ !isset($p5) ? 'disabled' : '' }}>
                                            <option value="" selected disabled>-- Pilih Penanggung Jawab -- </option>
                                            @if (isset($p5))
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}"
                                                        {{ old('id_subject_teacher', $p5->id_subject_teacher) == $teacher->id ? 'selected' : '' }}>
                                                        {{ $teacher->teacher->name . ' - ' . $teacher->course->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
                <div class="row mb-4">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">Pilih Sub Element</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Dimensi</th>
                                        <th>Element</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dimensions as $index => $dimension)
                                        <tr data-toggle="collapse" data-target="#sub_element_{{ $dimension->id }}"
                                            aria-expanded="false" aria-controls="sub_element_{{ $dimension->id }}"
                                            class="accordion-toggle">
                                            <td class="pointer">{{ $index + 1 }}</td>
                                            <td class="pointer">{{ $dimension->name }}</td>
                                            <td class="pointer">
                                                @foreach ($dimension->elements as $elemen)
                                                    <span class="badge badge-primary my-1"> {{ $elemen->name }} </span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0">
                                                <div class="collapse" id="sub_element_{{ $dimension->id }}"
                                                    aria-labelledby="sub_element_{{ $dimension->id }}">
                                                    <table class="table mb-0 table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="form-check">
                                                                    <input type="checkbox"
                                                                        class="form-check-input parent-checkbox"
                                                                        id="parent-checkbox-{{ $index }}"
                                                                        data-subelement="#sub_element_{{ $dimension->id }} input[type='checkbox']">
                                                                </th>
                                                                <th>Sub Element</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($subElements as $sub_element)
                                                                @if ($sub_element->id_dimension == $dimension->id)
                                                                    @php
                                                                        $isChecked = false;
                                                                        if (isset($p5)) {
                                                                            $subElementArr = json_decode($p5->sub_element);
                                                                            foreach ($subElementArr as $subElem) {
                                                                                if ($sub_element->id == $subElem->id_sub_element && $sub_element->id_dimension == $subElem->id_dimension) {
                                                                                    $isChecked = true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <tr>
                                                                        <td class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input child-checkbox"
                                                                                name="sub_element[]"
                                                                                value="{{ $sub_element->id }}-{{ $dimension->id }}"
                                                                                id="checkbox{{ $index }}"
                                                                                {{ $isChecked ? 'checked' : '' }}>
                                                                        </td>
                                                                        <td>{{ $sub_element->name }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
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


                {{-- <button id="btnLoader" class="btn btn-primary" onclick="">Save Changes</button> --}}

            </div>

        </div>
    </div>
    @push('scripts')
        @include('package.bootstrap-select.bootstrap-select_js')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                $('.parent-checkbox').change(function() {
                    var subElement = $(this).data('subelement');
                    $(subElement).prop('checked', this.checked);
                });

                $('.child-checkbox').change(function() {
                    var parentCheckbox = $(this).closest('.collapse').prev('.accordion-toggle').find(
                        '.parent-checkbox');
                    var subElement = $(this).closest('tbody').find('.child-checkbox');
                    parentCheckbox.prop('checked', subElement.length == subElement.filter(':checked').length);
                });

                $('select[name="id_study_class"]').on('change', function() {
                    // Mengambil id_study_class yang dipilih
                    var id_study_class = $(this).val();

                    // Jika belum memilih id_study_class, maka select id_subject_teacher di-disabled dan kosongkan nilainya
                    if (!id_study_class) {
                        $('select[name="id_subject_teacher"]').prop('disabled', true).empty();
                        return;
                    }

                    // Memuat data guru pelajaran berdasarkan id_study_class yang dipilih
                    $.ajax({
                        url: "{{ route('subject_teachers.study_class') }}",
                        data: {
                            id_study_class
                        },
                        success: function(response) {
                            // Mengisi select id_subject_teacher dengan data guru pelajaran yang telah dimuat
                            var options =
                                '<option value="" selected disabled>-- Pilih Penanggung Jawab --</option>';
                            $.each(response, function(key, value) {
                                options += '<option value="' + value.id + '">' + value
                                    .teacher.name + ' - ' + value.course.name + '</option>';
                            });
                            $('select[name="id_subject_teacher"]').prop('disabled', false).html(
                                options).selectpicker('refresh');
                        },
                        error: function(xhr, status, error) {
                            // code to handle error
                        }
                    });
                });
            });




            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
