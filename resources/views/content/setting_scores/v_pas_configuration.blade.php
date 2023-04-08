@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
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
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>{{ session('title') }}</h4>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('setting_scores.pas_configurations.storeOrUpdate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <table class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tahun Ajaran</th>
                                            <th>Bobot Ulangan Harian (%)</th>
                                            <th>Bobot Tengah Semester (%)</th>
                                            <th>Bobot Akhir Semester (%)</th>
                                            <th>Total (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($configurations as $index => $configuration)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $configuration['school_year'] }}</td>
                                                <input type="hidden" name="id_school_year[]"
                                                    value="{{ $configuration['id_school_year'] }}">
                                                <td>
                                                    <input type="text" name="average_daily_rate[]"
                                                        value="{{ old('average_daily_rate.' . $index, $configuration['average_daily_rate']) }}"
                                                        class="form-control">
                                                    @error('average_daily_rate.' . $index)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" name="score_uts[]"
                                                        value="{{ old('score_uts.' . $index, $configuration['score_uts']) }}"
                                                        class="form-control">
                                                    @error('score_uts.' . $index)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" name="score_uas[]"
                                                        value="{{ old('score_uas.' . $index, $configuration['score_uas']) }}"
                                                        class="form-control">
                                                    @error('score_uas.' . $index)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    @php
                                                        $total = 0;
                                                        if ($configuration['average_daily_rate'] != null) {
                                                            $total += $configuration['average_daily_rate'];
                                                        }
                                                        if ($configuration['score_uts'] != null) {
                                                            $total += $configuration['score_uts'];
                                                        }
                                                        
                                                        if ($configuration['score_uas'] != null) {
                                                            $total += $configuration['score_uas'];
                                                        }
                                                    @endphp
                                                    {{ $total }}
                                                    @error('average_daily_rate_total.' . $index)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
            $(function() {
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
