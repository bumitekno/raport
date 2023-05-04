@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.dropify.dropify_css')
        @include('package.switches.switches_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
        @include('package.datatable.datatable_css')
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
            @if (isset($user))
                {{ Form::model($user, ['route' => ['users.update', $user->slug], 'method' => 'patch', 'files' => true, 'id' => 'formUser']) }}
            @else
                {{ Form::open(['route' => 'users.store', 'files' => true, 'id' => 'formUser']) }}
            @endif
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <div class="info widget-content widget-content-area ecommerce-create-section">
                        <h6 class="">Informasi Umum</h6>
                        <div class="row">
                            <div class="col-lg-11 mx-auto">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-12 col-md-4">
                                        <div class="upload mt-4 pr-md-4">
                                            <input type="file" id="input-file-max-fs" class="dropify"
                                                data-default-file="{{ asset('asset/img/200x200.jpg') }}"
                                                data-max-file-size="2M" />
                                            <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                        <div class="form">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="fullName">Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Nama Lengkap"
                                                            value="{{ isset($user) ? old('name', $user->name) : old('name') }}">
                                                        @error('name')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="dob-input">Tanggal Lahir</label>
                                                    <div class="d-sm-flex d-block">
                                                        <div class="form-group mr-1">
                                                            <select class="form-control" name="day"
                                                                id="exampleFormControlSelect1">
                                                                <option selected disabled>Hari</option>
                                                                @for ($i = 1; $i <= 31; $i++)
                                                                    <option value="{{ $i }}"
                                                                        {{ isset($user) && old('day', date('d', strtotime($user->date_of_birth))) == $i ? 'selected' : (old('day') == $i ? 'selected' : '') }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                            @error('day')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mr-1">
                                                            <select class="form-control" name="month">
                                                                <option selected disabled>Bulan</option>
                                                                <option value="01"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '01' ? 'selected' : (old('month') == '01' ? 'selected' : '') }}>
                                                                    Januari</option>
                                                                <option value="02"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '02' ? 'selected' : (old('month') == '02' ? 'selected' : '') }}>
                                                                    Februari</option>
                                                                <option value="03"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '03' ? 'selected' : (old('month') == '03' ? 'selected' : '') }}>
                                                                    Maret</option>
                                                                <option value="04"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '04' ? 'selected' : (old('month') == '04' ? 'selected' : '') }}>
                                                                    April</option>
                                                                <option value="05"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '05' ? 'selected' : (old('month') == '05' ? 'selected' : '') }}>
                                                                    Mei</option>
                                                                <option value="06"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '06' ? 'selected' : (old('month') == '06' ? 'selected' : '') }}>
                                                                    Juni</option>
                                                                <option value="07"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '07' ? 'selected' : (old('month') == '07' ? 'selected' : '') }}>
                                                                    Juli</option>
                                                                <option value="08"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '08' ? 'selected' : (old('month') == '08' ? 'selected' : '') }}>
                                                                    Agustus</option>
                                                                <option value="09"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '09' ? 'selected' : (old('month') == '09' ? 'selected' : '') }}>
                                                                    September</option>
                                                                <option value="10"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '10' ? 'selected' : (old('month') == '10' ? 'selected' : '') }}>
                                                                    Oktober</option>
                                                                <option value="11"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '11' ? 'selected' : (old('month') == '11' ? 'selected' : '') }}>
                                                                    November</option>
                                                                <option value="12"
                                                                    {{ isset($user) && old('month', date('m', strtotime($user->date_of_birth))) == '12' ? 'selected' : (old('month') == '12' ? 'selected' : '') }}>
                                                                    Desember</option>
                                                            </select>
                                                            @error('month')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group mr-1">
                                                            <select class="form-control" name="year">
                                                                <option selected disabled>Tahun</option>
                                                                @php
                                                                    $current_year = (int) date('Y');
                                                                    $start_year = (int) date('Y') - 60;
                                                                @endphp
                                                                @for ($year = $current_year; $year >= $start_year; $year--)
                                                                    <option value="{{ $year }}"
                                                                        {{ isset($user) && old('year', date('Y', strtotime($user->date_of_birth))) == $year ? 'selected' : (old('year') == $year ? 'selected' : '') }}>
                                                                        {{ $year }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                            @error('year')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="profession">Email</label>
                                                <input type="text" class="form-control" name="email"
                                                    placeholder="Email"
                                                    value="{{ isset($user) ? old('email', $user->email) : old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <div class="info widget-content widget-content-area ecommerce-create-section">
                        <h6 class="">Informasi Tambahan</h6>
                        <div class="row">
                            <div class="col-md-11 mx-auto">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Telepon</label>
                                            <input type="text" class="form-control" name="phone" placeholder="Telepon"
                                                value="{{ isset($user) ? old('phone', $user->phone) : old('phone') }}">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Jenis Kelamin</label>
                                            <select class="form-control" name="gender">
                                                <option value="male">Laki - laki</option>
                                                <option value="female">Perempuan</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">NIS</label>
                                            <input type="text" class="form-control" name="nis" placeholder="NIS"
                                                value="{{ isset($user) ? old('nis', $user->nis) : old('nis') }}">
                                            @error('nis')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">NISN</label>
                                            <input type="text" class="form-control" name="nisn" placeholder="NISN"
                                                value="{{ isset($user) ? old('nisn', $user->nisn) : old('nisn') }}">
                                            @error('nisn')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="location">Agama</label>
                                            <select class="form-control" name="religion">
                                                <option value="islam">Islam</option>
                                                <option value="kristen">Kristen</option>
                                                <option value="hindu">Hindu</option>
                                                <option value="budha">Budha</option>
                                                <option value="katolik">Katolik</option>
                                                <option value="konghucu">Konghucu</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                            @error('religion')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="place_of_birth"
                                                placeholder="Tempat lahir"
                                                value="{{ isset($user) ? old('place_of_birth', $user->place_of_birth) : old('place_of_birth') }}">
                                            @error('place_of_birth')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Tahun Angkatan</label>
                                            <input type="text" class="form-control" name="entry_year"
                                                placeholder="Tahun Angkatan"
                                                value="{{ isset($user) ? old('entry_year', $user->entry_year) : old('entry_year') }}">
                                            @error('entry_year')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website1">Alamat</label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="Alamat"
                                                value="{{ isset($user) ? old('address', $user->address) : old('address') }}">
                                            @error('address')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;" name="password">
                                                <button class="btn btn-outline-secondary password-toggle" type="button"
                                                    onclick="return showPassword('#password')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path
                                                            d="M22.239 11.984c-1.395-3.795-5.232-7.984-10.239-7.984s-8.844 4.189-10.239 7.984c1.395 3.795 5.232 7.984 10.239 7.984s8.844-4.189 10.239-7.984zm-10.239 5.016c-2.916 0-5.283-2.368-5.283-5.283s2.368-5.283 5.283-5.283 5.283 2.368 5.283 5.283-2.368 5.283-5.283 5.283z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                    </svg>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;"
                                                    name="password_confirmation">
                                                <button class="btn btn-outline-secondary password-toggle" type="button"
                                                    onclick="return showPassword('#confirm_password')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path
                                                            d="M22.239 11.984c-1.395-3.795-5.232-7.984-10.239-7.984s-8.844 4.189-10.239 7.984c1.395 3.795 5.232 7.984 10.239 7.984s8.844-4.189 10.239-7.984zm-10.239 5.016c-2.916 0-5.283-2.368-5.283-5.283s2.368-5.283 5.283-5.283 5.283 2.368 5.283 5.283-2.368 5.283-5.283 5.283z">
                                                        </path>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{ Form::close() }}
            @if (isset($user))
                <div class="row mb-4">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="info widget-content widget-content-area ecommerce-create-section">
                            <h6 class="">Keluarga Siswa</h6>
                            <div class="row">
                                <div class="col-md-11 mx-auto form-parent layout-spacing">
                                    <form action="javascript:void(0)" id="formParent" method="post">
                                        <div class="edu-section">
                                            <input type="hidden" name="id" id="id_parent">
                                            <div class="form-row align-items-center justify-content-center">
                                                <div class="col-auto">
                                                    <label class="sr-only" for="inlineFormInput">Nama Keluarga</label>
                                                    <input type="text" class="form-control" id="name-parent"
                                                        name="name" placeholder="Nama Keluarga">
                                                    <input type="hidden" name="id_user" value="{{ $user->id }}">
                                                </div>
                                                <div class="col-auto">
                                                    <label class="sr-only" for="inlineFormInputGroup">Email</label>
                                                    <input type="text" class="form-control" id="email-parent"
                                                        name="email" placeholder="Email Keluarga">
                                                </div>
                                                <div class="col-auto">
                                                    <label class="sr-only" for="inlineFormInputGroup">Status
                                                        Keluarga</label>
                                                    <select name="type" id="type-parent" class="form-control">
                                                        <option value="" selected disabled>Status Keluarga</option>
                                                        <option value="father">Ayah</option>
                                                        <option value="mother">Ibu</option>
                                                        <option value="guardian">Wali</option>
                                                        <option value="other">Lainnya</option>s
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <label class="sr-only" for="inlineFormInputGroup">Password</label>
                                                    <input type="password" name="password" id="password-parent"
                                                        class="form-control" placeholder="Password">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <table id="table-list" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Status Keluarga</th>
                                                <th>Email</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            @endif

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
        @include('package.datatable.datatable_js')
        @include('package.dropify.dropify_js')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("#formUser").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                var table = $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "",
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                    }, {
                        data: 'name',
                        name: 'name',
                    }, {
                        data: 'type',
                        name: 'type',
                    }, {
                        data: 'email',
                        name: 'email',
                    }, {
                        data: 'action',
                        name: 'action',
                    }, ]
                });

                $('#formParent').submit(function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: "{{ route('families.update') }}",
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            $('#formParent')[0].reset();
                            table.ajax.reload();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                });

                $('body').on('click', '.edit', function() {
                    let id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('families.edit') }}",
                        type: 'GET',
                        data: {
                            id
                        },
                        success: function(data) {
                            $('#id_parent').val(data.id);
                            $('#name-parent').val(data.name);
                            $('#email-parent').val(data.email);
                            $('#type-parent').val(data.type);
                            $('#password-parent').val('');
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                });

                $('body').on('click', '.delete', function() {
                    var id = $(this).data('id');

                    if (confirm('Are you sure you want to delete this parent?')) {
                        $.ajax({
                            url: "{{ route('families.destroy') }}",
                            data: {
                                id
                            },
                            success: function(data) {
                                table.ajax.reload();
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });

            function showPassword(element) {
                if ('password' == $(element).attr('type')) {
                    $(element).prop('type', 'text');
                } else {
                    $(element).prop('type', 'password');
                }
            }

            function submitForm() {
                $('#formUser').submit();
            }
        </script>
    @endpush
@endsection
