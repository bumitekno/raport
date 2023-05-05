@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        @include('package.dropify.dropify_css')
        @include('package.switches.switches_css')
        @include('package.flatpickr.flatpickr_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Guru</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($teacher) ? 'Edit' : 'Tambah' }}
                        </li>
                    </ol>
                </nav>
            </div>
            @if (isset($teacher))
                {{ Form::model($teacher, ['route' => ['teachers.update', $teacher->slug], 'method' => 'patch', 'files' => true]) }}
            @else
                {{ Form::open(['route' => 'teachers.store', 'files' => true]) }}
            @endif
            <div class="row mb-4 layout-spacing layout-top-spacing">

                <div class="col-md-9">

                    <div class="widget-content widget-content-area ecommerce-create-section">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="field-wrapper toggle-pass d-flex justify-content-end">
                                    @php
                                        $check = 'checked';
                                        if (isset($teacher) && $teacher->status == 0) {
                                            $check = '';
                                        }
                                    @endphp
                                    <p class="d-inline-block">Status Guru</p>
                                    <label class="switch s-icons s-outline  s-outline-primary  mb-4 ml-2">
                                        <input type="checkbox" name="status" value="1" {{ $check }}>
                                        <span class="slider round"></span>
                                    </label>

                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="inputEmail3" placeholder="Nama Guru"
                                    value="{{ isset($teacher) ? old('name', $teacher->name) : old('name') }}"
                                    name="name">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>NIK</label>
                                <input type="text" class="form-control" placeholder="NIK"
                                    value="{{ isset($teacher) ? old('nik', $teacher->nik) : old('nik') }}" name="nik">
                                @error('nik')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>NUPTK</label>
                                <input type="text" class="form-control" placeholder="NUPTK"
                                    value="{{ isset($teacher) ? old('nuptk', $teacher->nuptk) : old('nuptk') }}"
                                    name="nuptk">
                                @error('nuptk')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>NIP</label>
                                <input type="text" class="form-control" placeholder="NIP"
                                    value="{{ isset($teacher) ? old('nip', $teacher->nip) : old('nip') }}" name="nip">
                                @error('nip')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Email"
                                    value="{{ isset($teacher) ? old('email', $teacher->email) : old('email') }}"
                                    name="email">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Telepon</label>
                                <input type="text" name="phone" class="form-control" id="inputEmail3"
                                    placeholder="Telepon"
                                    value="{{ isset($teacher) ? old('phone', $teacher->phone) : old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Alamat</label>
                                <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3" placeholder="Alamat">{{ isset($teacher) ? old('address', $teacher->address) : old('address') }}</textarea>
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control" name="place_of_birth" id="inputEmail3"
                                    placeholder="Tempat Lahir"
                                    value="{{ isset($teacher) ? old('place_of_birth', $teacher->place_of_birth) : old('place_of_birth') }}">
                                @error('place_of_birth')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Tanggal Lahir</label>
                                <input
                                    value="{{ isset($teacher) ? old('date_of_birth', $teacher->date_of_birth) : old('date_of_birth', now()) }}"
                                    class="form-control basicPicker active" type="text" name="date_of_birth"
                                    placeholder="Select Date..">
                                @error('date_of_birth')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>Jenis Kelamin</label>
                                <div class="n-chk p-2 my-auto">
                                    <label class="new-control new-radio radio-classic-primary mb-0 mr-2">
                                        <input type="radio" class="new-control-input" value="male"
                                            {{ isset($teacher) && old('gender', $teacher->gender) == 'male' ? 'checked' : (old('gender') == 'male' ? 'checked' : '') }}
                                            name="gender">
                                        <span class="new-control-indicator"></span>Laki - laki
                                    </label>
                                    <label class="new-control new-radio radio-classic-primary mb-0">
                                        <input type="radio" class="new-control-input" value="female" name="gender"
                                            {{ isset($teacher) && old('gender', $teacher->gender) == 'female' ? 'checked' : (old('gender') == 'female' ? 'checked' : '') }}>
                                        <span class="new-control-indicator"></span>Perempuan
                                    </label>
                                </div>
                                @error('place_of_birth')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Agama</label>
                                <select name="religion" id="religion" class="form-control">
                                    <option value="islam"
                                        {{ isset($teacher) && old('religion', $teacher->religion) == 'islam' ? 'selected' : (old('religion') == 'islam' ? 'selected' : '') }}>
                                        Islam</option>
                                    <option value="protestan"
                                        {{ isset($teacher) && old('religion', $teacher->religion) == 'protestan' ? 'selected' : (old('religion') == 'protestan' ? 'selected' : '') }}>
                                        Protestan</option>
                                    <option value="katolik"
                                        {{ isset($teacher) && old('religion', $teacher->religion) == 'katolik' ? 'selected' : (old('religion') == 'katolik' ? 'selected' : '') }}>
                                        Katolik</option>
                                    <option value="hindu"
                                        {{ isset($teacher) && old('religion', $teacher->religion) == 'hindu' ? 'selected' : (old('religion') == 'hindu' ? 'selected' : '') }}>
                                        Hindu</option>
                                    <option value="budha"
                                        {{ isset($teacher) && old('religion', $teacher->religion) == 'budha' ? 'selected' : (old('religion') == 'budha' ? 'selected' : '') }}>
                                        Budha</option>
                                    <option value="konghucu"
                                        {{ isset($teacher) && old('religion', $teacher->religion) == 'konghucu' ? 'selected' : (old('religion') == 'konghucu' ? 'selected' : '') }}>
                                        Konghucu</option>
                                    <option value="lainnya"
                                        {{ isset($teacher) && old('religion', $teacher->religion) == 'lainnya' ? 'selected' : (old('religion') == 'lainnya' ? 'selected' : '') }}>
                                        Lainnya</option>
                                </select>
                                @error('religion')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @error('file')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 info">
                                <label>Avatar</label>
                                <div class="upload pr-md-4">
                                    @php
                                        $file = asset('asset/img/200x200.jpg');
                                        if (isset($teacher) && $teacher->file) {
                                            $file = asset($teacher->file);
                                        }
                                    @endphp
                                    <input type="file" name="file" id="input-file-max-fs" class="dropify"
                                        data-default-file="{{ $file }}" data-max-file-size="2M" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Type Guru</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="teacher"
                                                {{ isset($teacher) && old('type', $teacher->type) == 'teacher' ? 'selected' : (old('type') == 'teacher' ? 'selected' : '') }}>
                                                Pengajar</option>
                                            <option value="homeroom"
                                                {{ isset($teacher) && old('type', $teacher->type) == 'homeroom' ? 'selected' : (old('type') == 'homeroom' ? 'selected' : '') }}>
                                                Wali kelas</option>
                                            <option value="other"
                                                {{ isset($teacher) && old('type', $teacher->type) == 'other' ? 'selected' : (old('type') == 'other' ? 'selected' : '') }}>
                                                Lainnya</option>
                                        </select>
                                    </div>
                                    {{-- {{ dd($teacher->type) }} --}}
                                    <div class="form-group col-md-12 {{ (isset($teacher) && $teacher->type == 'homeroom') || old('type') == 'homeroom' ? '' : 'd-none' }}"
                                        id="showClass">
                                        <label>Kelas yang di bimbing</label>
                                        <div class="n-chk px-2 my-auto">
                                            @foreach ($classes as $class)
                                                <label class="new-control new-radio radio-classic-primary mb-0 mr-2">
                                                    <input type="radio" class="new-control-input" {{ isset($teacher) && old('id_class', $teacher->id_class) == $class['id'] ? 'checked' : (old('id_class') == $class['id'] ? 'checked' : '') }}
                                                        value="{{ $class['id'] }}" name="id_class">
                                                    <span class="new-control-indicator"></span>{{ $class['name'] }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
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
                                    <div class="col-sm-12 mb-4">
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
                                    <div class="col-sm-12 mb-4">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirm_password"
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
            {{ Form::close() }}
        </div>
    </div>
    @push('scripts')
        @include('package.flatpickr.flatpickr_js')
        @include('package.dropify.dropify_js')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                $('#type').on('change', function() {
                    console.log($(this).val());
                    if ($(this).val() === 'homeroom') {
                        $('#showClass').removeClass('d-none');
                    } else {
                        $('#showClass').addClass('d-none');
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
        </script>
    @endpush
@endsection
