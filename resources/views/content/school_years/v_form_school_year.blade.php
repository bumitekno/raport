@extends('layout.admin.v_master')
@section('master')
    @push('styles')
        @include('package.datepicker.datepicker_css')
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
                @if (isset($school_year))
                    {{ Form::model($school_year, ['route' => ['school-years.update', $school_year->slug], 'method' => 'patch']) }}
                @else
                    {{ Form::open(['route' => 'school-years.store']) }}
                @endif
                <div class="form-group">
                    <label>Tahun Ajar</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input class="form-control datepickerYear" type="text" name="year1"
                                value="{{ isset($school_year) ? old('year1', substr($school_year->name, 0, 4)) : old('year1', date('Y')) }}"
                                onchange="return getYear(this.value)" readonly autocomplete="off">
                            @error('year1')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <input class="form-control" type="text" name="year2" id="year2" readonly
                                value="{{ isset($school_year) ? old('year2', substr($school_year->name, -5, 4)) : old('year2', date('Y') + 1) }}">
                            @error('year2')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>
                <div class="form-group mb-4">
                    <label for="inputAddress">Semester</label>
                    <select name="semester" class="form-control">
                        <option value="1" {{ isset($school_year) && old('semester', substr($school_year->name, -1)) == 1 ? 'selected' : (old('semester') == 1 ? 'selected' : '') }}>Ganjil</option>
                        <option value="2" {{ isset($school_year) && old('semester', substr($school_year->name, -1)) == 2 ? 'selected' : (old('semester') == 2 ? 'selected' : '') }}>Genap</option>
                    </select>
                    @error('semester')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
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
        @include('package.datepicker.datepicker_js')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function getYear(value) {
                var yearsend = parseInt(value) + 1;
                $("#year2").val(yearsend);
            }
        </script>
    @endpush
@endsection
