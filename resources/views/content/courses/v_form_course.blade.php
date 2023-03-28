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
                @if (isset($course))
                    {{ Form::model($course, ['route' => ['courses.update', $course->slug], 'method' => 'patch']) }}
                @else
                    {{ Form::open(['route' => 'courses.store']) }}
                @endif
                <div class="form-group mb-4">
                    <label for="inputAddress">Nama Mata Pelajaran</label>
                    <input type="text" placeholder="Nama Mata Pelajaran" class="form-control" name="name"
                        value="{{ isset($course) ? old('name', $course->name) : old('name') }}">
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-row mb-4">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Kode Mapel</label>
                        <input type="text" class="form-control" name="code" placeholder="Kode Mapel"
                            value="{{ isset($course) ? old('code', $course->code) : old('code') }}">
                        @error('code')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Kelompok Mapel</label>
                        <input type="text" class="form-control" name="group" placeholder="Kelompok Mapel"
                            value="{{ isset($course) ? old('group', $course->group) : old('group') }}">
                        @error('group')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
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
            });
        </script>
    @endpush
@endsection
