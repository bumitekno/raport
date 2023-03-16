@extends('layout.admin.v_main')
@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Inner Page</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">Resources</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">Timesheet</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="m-content">
        <form action="{{ route('admin.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Nama</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="">File</label>
                <input type="file" name="file" class="form-control-file">
            </div>
            <button type="submit">Simpan</button>
        </form>
    </div>
@endsection
