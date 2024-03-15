@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/dashboard.css') }}">
    @endpush

   <br><br> <div class="layout-px-spacing">
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
                        </div>
                    </div>
                </div>
            </div>


        <div class="row layout-top-spacing">

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">

                <div class="infobox-3 widget widget-account-invoice-one">
                    <div class="info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>

                    <h5 class="info-heading text-center">Jumlah Siswa Aktif</h5>
                    <div class="invoice-box ">
                        <p class="acc-amount">{{ $statistic['students'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="infobox-3 widget widget-account-invoice-one">
                    <div class="info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h5 class="info-heading text-center">Jumlah Guru Aktif</h5>
                    <div class="invoice-box ">
                        <p class="acc-amount">{{ $statistic['teachers'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="infobox-3 widget widget-account-invoice-one">
                    <div class="info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                    </div>
                    <h5 class="info-heading text-center">Jumlah Orang Tua Aktif</h5>
                    <div class="invoice-box ">
                        <p class="acc-amount">{{ $statistic['parents'] }}</p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">Revenue</h5>
                        <ul class="tabs tab-pills">
                            <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Monthly</a></li>
                        </ul>
                    </div>

                    <div class="widget-content">
                        <div class="tabs tab-content">
                            <div id="content_1" class="tabcontent">
                                <div id="revenueMonthly"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-one">
                    <div class="widget-heading d-flex justify-content-between">
                        <h5 class="my-auto">Nilai Siswa</h5>
                        <div class="form-group my-auto">
                            <select name="id_school_year" class="form-control">
                                <option value="" selected>Tertinggi</option>
                                <option value="">Terendah</option>

                            </select>
                        </div>
                    </div>

                    <div class="widget-content">
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-home">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>Electricity Bill</h4>
                                        <p class="meta-date">4 Aug 1:00PM</p>
                                    </div>

                                </div>
                                <div class="t-rate rate-dec">
                                    <p><span>-$16.44</span> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-down">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <polyline points="19 12 12 19 5 12"></polyline>
                                        </svg></p>
                                </div>
                            </div>
                        </div>

                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">SP</span>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>Shaun Park</h4>
                                        <p class="meta-date">4 Aug 1:00PM</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-inc">
                                    <p><span>+$66.44</span> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-up">
                                            <line x1="12" y1="19" x2="12" y2="5"></line>
                                            <polyline points="5 12 12 5 19 12"></polyline>
                                        </svg></p>
                                </div>
                            </div>
                        </div>

                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">AD</span>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>Amy Diaz</h4>
                                        <p class="meta-date">4 Aug 1:00PM</p>
                                    </div>

                                </div>
                                <div class="t-rate rate-inc">
                                    <p><span>+$66.44</span> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-up">
                                            <line x1="12" y1="19" x2="12" y2="5"></line>
                                            <polyline points="5 12 12 5 19 12"></polyline>
                                        </svg></p>
                                </div>
                            </div>
                        </div>

                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-home">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="t-name">
                                        <h4>Netflix</h4>
                                        <p class="meta-date">4 Aug 1:00PM</p>
                                    </div>

                                </div>
                                <div class="t-rate rate-dec">
                                    <p><span>-$32.00</span> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-down">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <polyline points="19 12 12 19 5 12"></polyline>
                                        </svg></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
