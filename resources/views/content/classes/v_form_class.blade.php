@extends('layout.admin.v_master')
@section('master')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.switches.switches_css')
    @endpush
    <div id="basic" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ session('title') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if (isset($class))
                    {{ Form::model($class, ['route' => ['classes.update', $class->slug], 'method' => 'patch']) }}
                @else
                    {{ Form::open(['route' => 'classes.store']) }}
                @endif

                <div class="form-row mb-4">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jurusan</label>
                        <select name="id_major" class="form-control" required>
                            <option value="" selected disabled>-- Pilih Jurusan --</option>
                            @foreach ($majors as $mj)
                                <option value="{{ $mj['id'] }}"
                                    {{ isset($class) && old('id_major', $class->id_major) == $mj->id ? 'selected' : (old('id_major') == $mj->id ? 'selected' : '') }}>
                                    {{ $mj['name'] }}</option>
                            @endforeach
                        </select>
                        @error('id_major')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Tingkat</label>
                        <select name="id_level" class="form-control" required>
                            <option value="" selected disabled>-- Pilih Tingkat --</option>
                            @foreach ($levels as $lv)
                                <option value="{{ $lv['id'] }}"
                                    {{ isset($class) && old('id_level', $class->id_level) == $lv->id ? 'selected' : (old('id_level') == $lv->id ? 'selected' : '') }}>
                                    {{ $lv['name'] }}</option>
                            @endforeach
                        </select>
                        @error('id_level')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-1">
                        <label for="fullName">Nama</label>
                        <input type="text" class="form-control" placeholder="Nama Kelas" required
                            value="{{ isset($class) ? old('name', $class->name) : old('name') }}" name="name[]">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="addonForm">
                </div>
                @if (!isset($class))
                    <div class="form-row">
                        <div class="col-md-12 mb-4">
                            <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="addRow()">Tambah Baris</a>
                        </div>
                    </div>
                @endif
                <button class="btn btn-primary mt-2 d-none" id="btnLoader">
                    <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                        Loading...</div>
                    Loading
                </button>
                <button class="btn btn-primary submit-fn mt-2" type="submit" id="btnSubmit">Simpan
                    Data</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                $(document).on('click', '.btn-remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });

            var i = 1;

            function addRow() {
                i++;
                $('.addonForm').append(`
                <div class="form-row" id="row${i}">
                        <div class="col-md-12 mt-3 mb-1">
                            <label for="fullName">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama Kelas" name="name[]" required>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger mt-1 btn-remove" id="${i}">Hapus</a>
                        </div>
                    </div>
                `);
            }
        </script>
    @endpush
@endsection
