@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <link href="{{ asset('asset/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <div class="container layout-px-spacing">
        <div class="container">

            <div id="navSection" data-spy="affix" class="nav sidenav">
                <div class="sidenav-content">
                    <a href="#tableSimple" class="active nav-link">Tahun Ajaran</a>
                    <a href="{{ route('majors.index') }}" class="nav-link">Jurusan</a>
                    <a href="{{ route('levels.index') }}" class="nav-link">Tingkat</a>
                    <a href="#tableDark" class="nav-link">Rombel</a>
                    <a href="#tableCaption" class="nav-link">Mata Pelajaran</a>
                </div>
            </div>

            <div class="row layout-top-spacing">
                @yield('master')
            </div>

        </div>
    </div>
@endsection
