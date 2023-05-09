<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ Auth::guard('teacher')->user()->file ? asset(Auth::guard('teacher')->user()->file) : asset('asset/img/90x90.jpg') }}"
                    alt="avatar">
                <h6 class="">{{ Auth::guard('teacher')->user()->name }}</h6>
                <p class="">Wali Kelas</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="{{ route('teacher.dashboard') }}" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span> Dashboard</span>
                    </div>
                </a>
            </li>
            <li
                class="menu {{ session()->has('templates') && session('templates.template') == 'merdeka' ? 'd-none' : '' }} {{ Route::is('admins.*') || Route::is('teachers.*') || Route::is('users.*') ? 'active' : '' }}">
                <a href="#side-user" data-toggle="collapse"
                    aria-expanded="{{ Route::is('admins.*') || Route::is('teachers.*') || Route::is('users.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 11a9 9 0 0 1 9 9"></path>
                            <path d="M4 4a16 16 0 0 1 16 16"></path>
                            <circle cx="5" cy="19" r="1"></circle>
                        </svg>
                        <span>Sikap</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Route::is('admins.*') || Route::is('teachers.*') || Route::is('users.*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="side-user" data-parent="#accordionExample">
                    <li class="{{ Route::is('admins.*') ? 'active' : '' }}">
                        <a href="{{ route('attitude_grades.index', 'social') }}"> Sosial</a>
                    </li>
                    <li class="{{ Route::is('teachers.*') ? 'active' : '' }}">
                        <a href="{{ route('attitude_grades.index', 'spiritual') }}"> Spiritual </a>
                    </li>

                </ul>
            </li>
            <li class="menu">
                <a href="{{ route('score_extras.index', $side_extra->slug) }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="4" y="2" width="16" height="20" rx="2"
                                ry="2"></rect>
                            <circle cx="12" cy="14" r="4"></circle>
                            <line x1="12" y1="6" x2="12.01" y2="6"></line>
                        </svg>
                        <span> Ekstrakurikuler</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{ route('teacher_notes.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1"
                                ry="1"></rect>
                        </svg>
                        <span> Catatan</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{ route('achievements.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="12" y1="2" x2="12" y2="6"></line>
                            <line x1="12" y1="18" x2="12" y2="22"></line>
                            <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                            <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                            <line x1="2" y1="12" x2="6" y2="12"></line>
                            <line x1="18" y1="12" x2="22" y2="12"></line>
                            <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                            <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                        </svg>
                        <span> Prestasi</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="{{ route('attendances.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        <span> Absensi</span>
                    </div>
                </a>
            </li>
            <li
                class="menu {{ session()->has('templates') && session('templates.template') == 'merdeka' ? 'd-none' : '' }} {{ Route::is('admins.*') || Route::is('teachers.*') || Route::is('users.*') ? 'active' : '' }}">
                <a href="#side-user" data-toggle="collapse"
                    aria-expanded="{{ Route::is('admins.*') || Route::is('teachers.*') || Route::is('users.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 11a9 9 0 0 1 9 9"></path>
                            <path d="M4 4a16 16 0 0 1 16 16"></path>
                            <circle cx="5" cy="19" r="1"></circle>
                        </svg>
                        <span>Cetak</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Route::is('previews.*') || Route::is('legers.*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="side-user" data-parent="#accordionExample">
                    <li class="{{ Route::is('previews.*') ? 'active' : '' }}">
                        <a href="{{ route('previews.index', ['template' => 'k13', 'year' => session('slug_year')]) }}"> Cetak Raport</a>
                    </li>
                    <li class="{{ Route::is('legers.*') ? 'active' : '' }}">
                        <a href="{{ route('legers.by_classes', session('slug_class')) }}"> Cetak Leger </a>
                    </li>

                </ul>
            </li>
            <li class="menu {{ session()->has('templates') && session('templates.template') != 'merdeka' ? 'd-none' : '' }}">
                <a href="{{ route('previews.index', ['template' => 'merdeka', 'year' => session('slug_year')]) }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                            </path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span> Cetak</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
</div>
