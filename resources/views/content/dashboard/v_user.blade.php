@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/dashboard.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <div class="jumbotron">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">

                        <div class="widget widget-account-invoice-one">
                            <div class="widget-content">
                                <div class="invoice-box">

                                    <div class="acc-total-info text-center">
                                        <h5>Selamat Datang, {{ Auth::user()->name }}!</h5>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                            viewBox="0 0 24 24" fill="none" stroke="#67d321" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <p class="acc-amount">Berikut adalah settingan raport anda.</p>
                                    </div>

                                    <div class="inv-detail">
                                        <div class="info-detail-1">
                                            <p>Tahun Ajaran</p>
                                            <p>{{ session('school_year') }}</p>
                                        </div>
                                        <div class="info-detail-2">
                                            <p>Semester</p>
                                            <p>{{ session('semester') == 1 ? 'Ganjil' : 'Genap' }}</p>
                                        </div>
                                        <div class="info-detail-3 info-sub">
                                            <div class="info-detail">
                                                <p>Kurikulum</p>
                                                <p class="text-capitalize">{{ session('templates.template') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
