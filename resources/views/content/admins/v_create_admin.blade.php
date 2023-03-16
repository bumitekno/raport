@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.preview.preview_css')
        @include('package.switches.switches_css')
        @include('package.flatpickr.flatpickr_css')
    @endpush
    <div class="middle-content container-xxl p-0">

        <!-- BREADCRUMB -->
        <div class="page-meta mt-3">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item"><a href="#">App</a></li>
                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('admins.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-md-9">

                    <div class="widget-content widget-content-area ecommerce-create-section">

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="inputEmail3" placeholder="Nama Admin"
                                    name="name">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="gender" id="exampleFormControlSelect1">
                                    <option value="male">Laki - laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" id="inputEmail3">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Telepon</label>
                                <input type="text" name="phone" class="form-control" id="inputEmail3">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Alamat</label>
                                <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control" name="place_of_birth" id="inputEmail3">
                            </div>
                            <div class="col-sm-6">
                                <label>Tanggal Lahir</label>
                                <input value="{{ now() }}" class="form-control basicPicker active" type="text"
                                    name="date_of_birth" placeholder="Select Date..">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="custom-file-container" data-upload-id="myFirstImage">
                                    <label class="d-flex justify-content-between" style="color: #acb0c3 !important">Profile
                                        <a href="javascript:void(0)" class="custom-file-container__image-clear text-red"
                                            title="Clear Image">x</a></label>
                                    <label class="custom-file-container__custom-file">
                                        <input type="file" class="custom-file-container__custom-file__custom-file-input"
                                            accept="image/*" name="file">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                <div class="field-wrapper toggle-pass d-flex justify-content-end">
                                    <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                        <input type="checkbox" name="status" checked>
                                        <span class="slider round"></span>
                                    </label>
                                    <p class="d-inline-block">Status Admin</p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget-content widget-content-area ecommerce-create-section">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="sale-price">Password</label>
                                        <div class="input-group mb-4">
                                            <input type="password" class="form-control"
                                                placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;" name="password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 mb-4">
                                        <label for="sale-price">Ulangi Password</label>
                                        <div class="input-group mb-4">
                                            <input type="password" class="form-control"
                                                placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;" name="confirm_password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-primary btn-lg w-100 d-none" id="btnLoader">
                                            <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                                                Loading...</div>
                                            Loading
                                        </button>
                                        <button class="btn btn-primary btn-lg w-100" type="submit" id="btnSubmit">Simpan
                                            Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    @push('scripts')
        @include('package.flatpickr.flatpickr_js')
        @include('package.preview.preview_js')
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
