@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/avatar.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/user-profile.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/search.css') }}">
        @include('package.loader.loader_css')
    @endpush
    <div class="layout-px-spacing">

        <div class="row layout-spacing">

            <!-- Content -->
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between">
                            <h3 class="">Info</h3>
                            <a href="user_account_setting.html" class="mt-2 edit-profile"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-edit-3">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg></a>
                        </div>
                        <div class="text-center user-info">
                            <div class="avatar avatar-xl">
                                <span class="avatar-title rounded-circle">{{ Helper::get_inital($course['name']) }}</span>
                            </div>
                            <p class="">{{ $course['name'] }}</p>
                        </div>
                        <div class="user-info-list">

                            <div class="">
                                <ul class="contacts-block list-unstyled">
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z">
                                            </path>
                                        </svg> {{ $course['group'] }}
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="16 18 22 12 16 6"></polyline>
                                            <polyline points="8 6 2 12 8 18"></polyline>
                                        </svg>{{ $course['code'] }}
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                            <line x1="3" y1="22" x2="21" y2="22"></line>
                                        </svg>{{ $course['slug'] }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">

                <div class="skills layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <h3 class="">Guru Pengampu</h3>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-9 filtered-list-search mx-auto">
                                <form class="form-inline my-2 my-lg-0 justify-content-center">
                                    <div class="w-100">
                                        <input type="text" class="w-100 form-control product-search br-30"
                                            id="input-search" placeholder="Search Attendees...">
                                        <button class="btn btn-primary" type="submit"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                </line>
                                            </svg></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12">

                                <div class="searchable-container">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="searchable-items">
                                                <div class="items">
                                                    <div class="user-profile">
                                                        <img src="{{ asset('asset/img/90x90.jpg') }}" alt="avatar">
                                                    </div>
                                                    <div class="user-name">
                                                        <p class="">Alan Green</p>
                                                    </div>
                                                    <div class="user-email">
                                                        <p>alan@mail.com</p>
                                                    </div>
                                                    <div class="user-status">
                                                        <span class="badge badge-primary">Active</span>
                                                    </div>
                                                    <div class="action-btn">
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-more-horizontal">
                                                                <circle cx="12" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="19" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="5" cy="12" r="1">
                                                                </circle>
                                                            </svg></p>
                                                    </div>
                                                </div>

                                                <div class="items">
                                                    <div class="user-profile">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                    </div>
                                                    <div class="user-name">
                                                        <p class="">Linda Nelson</p>
                                                    </div>
                                                    <div class="user-email">
                                                        <p>Linda@mail.com</p>
                                                    </div>
                                                    <div class="user-status">
                                                        <span class="badge badge-danger">Busy</span>
                                                    </div>
                                                    <div class="action-btn">
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-more-horizontal">
                                                                <circle cx="12" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="19" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="5" cy="12" r="1">
                                                                </circle>
                                                            </svg></p>
                                                    </div>
                                                </div>

                                                <div class="items">
                                                    <div class="user-profile">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                    </div>
                                                    <div class="user-name">
                                                        <p class="">Lila Perry</p>
                                                    </div>
                                                    <div class="user-email">
                                                        <p>Lila@mail.com</p>
                                                    </div>
                                                    <div class="user-status">
                                                        <span class="badge badge-warning">Closed</span>
                                                    </div>
                                                    <div class="action-btn">
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-more-horizontal">
                                                                <circle cx="12" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="19" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="5" cy="12" r="1">
                                                                </circle>
                                                            </svg></p>
                                                    </div>
                                                </div>


                                                <div class="items">
                                                    <div class="user-profile">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                    </div>
                                                    <div class="user-name">
                                                        <p class="">Andy King</p>
                                                    </div>
                                                    <div class="user-email">
                                                        <p>Andy@mail.com</p>
                                                    </div>
                                                    <div class="user-status">
                                                        <span class="badge badge-primary">Active</span>
                                                    </div>
                                                    <div class="action-btn">
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-more-horizontal">
                                                                <circle cx="12" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="19" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="5" cy="12" r="1">
                                                                </circle>
                                                            </svg></p>
                                                    </div>
                                                </div>

                                                <div class="items">
                                                    <div class="user-profile">
                                                        <img src="assets/img/90x90.jpg" alt="avatar">
                                                    </div>
                                                    <div class="user-name">
                                                        <p class="">Jesse Cory</p>
                                                    </div>
                                                    <div class="user-email">
                                                        <p>Jesse@mail.com</p>
                                                    </div>
                                                    <div class="user-status">
                                                        <span class="badge badge-danger">Busy</span>
                                                    </div>
                                                    <div class="action-btn">
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-more-horizontal">
                                                                <circle cx="12" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="19" cy="12" r="1">
                                                                </circle>
                                                                <circle cx="5" cy="12" r="1">
                                                                </circle>
                                                            </svg></p>
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

                <div class="bio layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <h3 class="">Kelas Yang diajarkan</h3>
                        <p>I'm Web Developer from California. I code and design websites worldwide. Mauris varius tellus
                            vitae tristique sagittis. Sed aliquet, est nec auctor aliquet, orci ex vestibulum ex, non
                            pharetra lacus erat ac nulla.</p>

                        <p>Sed vulputate, ligula eget mollis auctor, lectus elit feugiat urna, eget euismod turpis lectus
                            sed ex. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                            Nunc ut velit finibus, scelerisque sapien vitae, pharetra est. Nunc accumsan ligula vehicula
                            scelerisque vulputate.</p>

                        <div class="bio-skill-box">

                            <div class="row">

                                <div class="col-12 col-xl-6 col-lg-12 mb-xl-5 mb-5 ">

                                    <div class="d-flex b-skills">
                                        <div>
                                        </div>
                                        <div class="">
                                            <h5>Sass Applications</h5>
                                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse eu fugiat
                                                nulla pariatur.</p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-xl-6 col-lg-12 mb-xl-5 mb-5 ">

                                    <div class="d-flex b-skills">
                                        <div>
                                        </div>
                                        <div class="">
                                            <h5>Github Countributer</h5>
                                            <p>Ut enim ad minim veniam, quis nostrud exercitation aliquip ex ea commodo
                                                consequat.</p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-xl-6 col-lg-12 mb-xl-0 mb-5 ">

                                    <div class="d-flex b-skills">
                                        <div>
                                        </div>
                                        <div class="">
                                            <h5>Photograhpy</h5>
                                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                                anim id est laborum.</p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-xl-6 col-lg-12 mb-xl-0 mb-0 ">

                                    <div class="d-flex b-skills">
                                        <div>
                                        </div>
                                        <div class="">
                                            <h5>Mobile Apps</h5>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do et dolore
                                                magna aliqua.</p>
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

    @push('scripts')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                $('#input-search').on('keyup', function() {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable-container .items').hide();
                    $('.searchable-container .items').filter(function() {
                        return rex.test($(this).text());
                    }).show();
                });
            });
        </script>
    @endpush
@endsection
