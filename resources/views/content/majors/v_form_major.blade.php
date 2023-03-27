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
                @if (isset($major))
                    {{ Form::model($major, ['route' => ['majors.update', $major->slug], 'method' => 'patch']) }}
                @else
                    {{ Form::open(['route' => 'majors.store']) }}
                @endif
                <div class="form-row">
                    <div class="col-md-12 mb-4">
                        <label for="fullName">Nama</label>
                        <input type="text" class="form-control" placeholder="Nama Jurusan"
                            value="{{ isset($major) ? old('name', $major->name) : old('name') }}" name="name">
                        @error('name')
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
                {{-- <button class="btn btn-primary submit-fn mt-2" type="submit">Tambah Data</button> --}}
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
