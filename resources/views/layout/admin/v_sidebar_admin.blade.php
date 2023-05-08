<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ Auth::guard('admin')->user()->file ? asset(Auth::guard('admin')->user()->file) : asset('asset/img/90x90.jpg') }}"
                    alt="avatar">
                <h6 class="">{{ Auth::guard('admin')->user()->name }}</h6>
                <p class="">Admin</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <div class="form-group mb-4">
                    <label for="exampleFormControlSelect1">PILIH KURIKULUM</label>
                    <select class="form-control" id="curriculumSelect">
                        <option value="" selected disabled>Pilih Kurikulum</option>
                        <option value="merdeka" {{ session('template') == 'merdeka' ? 'selected' : '' }}>Kurikulum
                            Merdeka</option>
                        <option value="k13" {{ session('template') == 'k13' ? 'selected' : '' }}>Kurikulum 13
                        </option>
                    </select>
                </div>
            </li>
            <li class="menu">
                <a href="{{ route('dashboard') }}" aria-expanded="{{ Request::is('dashboard*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
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

            <li class="menu merdeka d-none {{ Request::is('setting-score*') ? 'active' : '' }}">
                <a href="#submenu" data-toggle="collapse"
                    aria-expanded="{{ Request::is('setting-score*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                            <line x1="3" y1="22" x2="21" y2="22"></line>
                        </svg>
                        <span> Pengaturan Nilai</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('setting-score*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="submenu" data-parent="#accordionExample">
                    <li class="{{ Route::is('setting_scores.competence*') ? 'active' : '' }}">
                        <a href="{{ route('setting_scores.competence') }}"> Capaian Kompetensi </a>
                    </li>
                    <li class="{{ Route::is('setting_scores.description*') ? 'active' : '' }}">
                        <a href="{{ route('setting_scores.description') }}"> Deskripsi CP </a>
                    </li>
                    <li class="{{ Route::is('setting_scores.assesment_weight*') ? 'active' : '' }}">
                        <a href="{{ route('setting_scores.assesment_weight') }}"> Bobot Penilaian </a>
                    </li>
                </ul>
            </li>

            <li class="menu k13 d-none {{ Route::is('attitudes*') ? 'active' : '' }}">
                <a href="#attitude" data-toggle="collapse"
                    aria-expanded="{{ Route::is('attitudes*') ? 'true' : 'false' }}" class="dropdown-toggle">
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
                        <span> Sikap</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Route::is('attitudes*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="attitude" data-parent="#accordionExample">
                    <li
                        class="{{ Route::is('attitudes*') && Route::current()->parameter('type') == 'social' ? 'active' : '' }}">
                        <a href="{{ route('attitudes.index', 'social') }}"> Sikap Sosial</a>
                    </li>
                    <li
                        class="{{ Route::is('attitudes*') && Route::current()->parameter('type') == 'spiritual' ? 'active' : '' }}">
                        <a href="{{ route('attitudes.index', 'spiritual') }}"> Sikap Spiritual</a>
                    </li>
                </ul>
            </li>

            <li class="menu k13 d-none {{ Route::is('setting_scores*') ? 'active' : '' }}">
                <a href="#setting-score" data-toggle="collapse"
                    aria-expanded="{{ Route::is('setting_scores*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="4" y1="21" x2="4" y2="14"></line>
                            <line x1="4" y1="10" x2="4" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12" y2="3"></line>
                            <line x1="20" y1="21" x2="20" y2="16"></line>
                            <line x1="20" y1="12" x2="20" y2="3"></line>
                            <line x1="1" y1="14" x2="7" y2="14"></line>
                            <line x1="9" y1="8" x2="15" y2="8"></line>
                            <line x1="17" y1="16" x2="23" y2="16"></line>
                        </svg>
                        <span> Pengaturan Nilai</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Route::is('setting_scores*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="setting-score" data-parent="#accordionExample">
                    <li class="{{ Route::is('setting_scores.predicated_scores*') ? 'active' : '' }}">
                        <a href="{{ route('setting_scores.predicated_scores.index') }}"> Nilai Predikat Raport</a>
                    </li>
                    <li class="{{ Route::is('setting_scores.pts_configurations*') ? 'active' : '' }}">
                        <a href="{{ route('setting_scores.pts_configurations.index') }}"> Nilai PTS</a>
                    </li>
                    <li class="{{ Route::is('setting_scores.pas_configurations*') ? 'active' : '' }}">
                        <a href="{{ route('setting_scores.pas_configurations.index') }}"> Nilai PAS</a>
                    </li>
                    <li class="{{ Route::is('setting_scores.kkm*') ? 'active' : '' }}">
                        <a href="{{ route('setting_scores.kkm.index', ['year' => session('slug_year')]) }}"> KKM</a>
                    </li>
                </ul>
            </li>

            <li
                class="menu k13 d-none {{ Route::is('basic_competencies*') || Route::is('general_weights*') ? 'active' : '' }}">
                <a href="#setting-other" data-toggle="collapse"
                    aria-expanded="{{ Route::is('basic_competencies*') || Route::is('general_weights*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M13 17l5-5-5-5M6 17l5-5-5-5" />
                        </svg>
                        <span> Other</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Route::is('basic_competencies*') || Route::is('general_weights*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="setting-other" data-parent="#accordionExample">
                    <li class="{{ Route::is('basic_competencies*') ? 'active' : '' }}">
                        <a href="{{ route('basic_competencies.index') }}"> Kompetensi Dasar</a>
                    </li>
                    <li
                        class="{{ Route::is('general_weights*') && Route::current()->parameter('type') == 'uas' ? 'active' : '' }}">
                        <a href="{{ route('general_weights.index', 'uas') }}"> Bobot Nilai UAS</a>
                    </li>
                    <li
                        class="{{ Route::is('general_weights*') && Route::current()->parameter('type') == 'uts' ? 'active' : '' }}">
                        <a href="{{ route('general_weights.index', 'uts') }}"> Bobot Nilai UTS</a>
                    </li>
                </ul>
            </li>

            <li class="menu merdeka d-none {{ Route::is('manages*') ? 'true' : 'false' }}">
                <a href="{{ route('manages.index') }}" aria-expanded="{{ Route::is('manages*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                        <span> Kelola P5</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{ route('extracurriculars.index') }}"
                    aria-expanded="{{ Route::is('extracurriculars*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                            </polygon>
                        </svg>
                        <span> Ekstrakurikuler</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ Route::is('settings*') || Route::is('configs*') || Route::is('covers*') || Route::is('letterheads*') || Route::is('templates*') ? 'active' : '' }}">
                <a href="#submenu2" data-toggle="collapse"
                    aria-expanded="{{ Route::is('settings*') || Route::is('configs*') || Route::is('covers*') || Route::is('letterheads*') || Route::is('templates*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                            </path>
                        </svg>
                        <span> Setelan</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Route::is('settings*') || Route::is('configs*') || Route::is('covers*') || Route::is('letterheads*') || Route::is('templates*') ? 'recent-submenu mini-recent-submenu show' : '' }}" id="submenu2" data-parent="#accordionExample">
                    <li class="{{ Route::is('settings*') ? 'active' : '' }}">
                        <a href="{{ route('settings.index') }}"> Sekolah</a>
                    </li>
                    <li class="{{ Route::is('configs*') ? 'active' : '' }}">
                        <a href="{{ route('configs.index', ['year' => session('slug_year')]) }}"> Konfigurasi</a>
                    </li>
                    <li class="{{ Route::is('covers*') ? 'active' : '' }}">
                        <a href="{{ route('covers.index', ['year' => session('slug_year')]) }}"> Sampul</a>
                    </li>
                    <li class="{{ Route::is('letterheads*') ? 'active' : '' }}">
                        <a href="{{ route('letterheads.index') }}"> KOP Surat</a>
                    </li>
                    <li class="{{ Route::is('templates*') ? 'active' : '' }}">
                        <a href="{{ route('templates.index', ['year' => session('slug_year')]) }}"> Template
                            Raport</a>
                    </li>

                </ul>
            </li>

            <li
                class="menu {{ Route::is('majors.*') || Route::is('levels.*') || Route::is('classes.*') || Route::is('courses.*') || Route::is('school-years.*') || Route::is('student_classes.*') ? 'active' : '' }}">
                <a href="#side-master" data-toggle="collapse"
                    aria-expanded="{{ Route::is('majors.*') || Route::is('levels.*') || Route::is('classes.*') || Route::is('courses.*') || Route::is('school-years.*') || Route::is('student_classes.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M11 21H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h5l2 3h9a2 2 0 0 1 2 2v2M19 15v6M16 18h6" />
                        </svg>
                        <span>Master</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Route::is('majors.*') || Route::is('levels.*') || Route::is('classes.*') || Route::is('courses.*') || Route::is('student_classes.*') || Route::is('school-years.*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="side-master" data-parent="#accordionExample">
                    <li class="{{ Route::is('school-years.*') ? 'active' : '' }}">
                        <a href="{{ route('school-years.index') }}"> Tahun Ajar </a>
                    </li>
                    <li class="{{ Route::is('majors.*') ? 'active' : '' }}">
                        <a href="{{ route('majors.index') }}"> Jurusan </a>
                    </li>
                    <li class="{{ Route::is('levels.*') ? 'active' : '' }}">
                        <a href="{{ route('levels.index') }}"> Tingkat</a>
                    </li>
                    <li class="{{ Route::is('classes.*') ? 'active' : '' }}">
                        <a href="{{ route('classes.index') }}"> Rombel</a>
                    </li>
                    <li class="{{ Route::is('courses.*') ? 'active' : '' }}">
                        <a href="{{ route('courses.index') }}"> Mata Pelajaran</a>
                    </li>
                    <li class="{{ Route::is('student_classes.*') ? 'active' : '' }}">
                        <a href="{{ route('student_classes.index', ['origin' => 'user']) }}"> Rotasi Siswa</a>
                    </li>
                </ul>
            </li>
            <li
                class="menu {{ Route::is('admins.*') || Route::is('teachers.*') || Route::is('users.*') ? 'active' : '' }}">
                <a href="#side-user" data-toggle="collapse"
                    aria-expanded="{{ Route::is('admins.*') || Route::is('teachers.*') || Route::is('users.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>

                        <span>User</span>
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
                        <a href="{{ route('admins.index') }}"> Admin</a>
                    </li>
                    <li class="{{ Route::is('teachers.*') ? 'active' : '' }}">
                        <a href="{{ route('teachers.index') }}"> Guru </a>
                    </li>
                    <li class="{{ Route::is('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}"> Siswa</a>
                    </li>
                </ul>
            </li>
            <li
                class="menu {{ Route::is('legers.*')? 'active' : '' }}">
                <a href="#side-user" data-toggle="collapse"
                    aria-expanded="{{ Route::is('legers.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
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
                <ul class="collapse submenu list-unstyled {{ Route::is('legers.*') ? 'recent-submenu mini-recent-submenu show' : '' }}"
                    id="side-user" data-parent="#accordionExample">
                    <li class="{{ Route::is('legers.*') ? 'active' : '' }}">
                        <a href="{{ route('legers.list_classes') }}"> Leger</a>
                    </li>
                    {{-- <li class="{{ Route::is('teachers.*') ? 'active' : '' }}">
                        <a href="{{ route('teachers.index') }}"> Guru </a>
                    </li>
                    <li class="{{ Route::is('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}"> Siswa</a>
                    </li> --}}
                </ul>
            </li>
        </ul>
    </nav>
</div>
@push('scripts')
    <script>
        $(function() {
            checkTemplate($('#curriculumSelect').val());
            $('#curriculumSelect').on('change', function() {
                var curriculum = $(this).val();
                checkTemplate(curriculum);
                $.ajax({
                    url: '{{ route('session.template') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'curriculum': curriculum
                    },
                    success: function(response) {
                        console.log(response);

                    }
                });
            });
        })

        function checkTemplate(param) {
            if (param === 'merdeka') {
                $('.merdeka').removeClass('d-none');
                $('.k13').addClass('d-none');
            }
            if (param === 'k13') {
                $('.k13').removeClass('d-none');
                $('.merdeka').addClass('d-none');
            }

        }
    </script>
@endpush
