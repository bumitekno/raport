<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ Auth::guard('teacher')->user()->file ? asset(Auth::guard('teacher')->user()->file) : asset('asset/img/90x90.jpg') }}"
                    alt="avatar">
                <h6 class="">{{ Auth::guard('teacher')->user()->name }}</h6>
                <p class="">Guru</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <form action="{{ route('session.set_layout_teacher') }}" method="post" id="formClassCourse">
                @csrf
                <li class="menu">
                    <div class="form-group mb-4">
                        <label for="exampleFormControlSelect1">PILIH KELAS</label>
                        <select class="form-control" name="id_study_class" id="id_study_class">
                            <option value="" selected disabled>Pilih Kelas</option>
                            @foreach ($class_course['study_class'] as $key_class => $study_class)
                                <option value="{{ $key_class }}"
                                    {{ session()->has('teachers') && session('teachers.id_study_class') == $key_class ? 'selected' : '' }}>
                                    {{ $study_class }}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li class="menu">
                    <div class="form-group mb-4">
                        <label for="exampleFormControlSelect1">PILIH MAPEL</label>
                        <select class="form-control" name="id_course" id="id_course">
                            <option value="" selected disabled>Pilih Mapel</option>
                            @foreach ($class_course['course'] as $key_course => $course)
                                <option value="{{ $key_course }}"
                                    {{ session()->has('teachers') && session('teachers.id_course') == $key_course ? 'selected' : '' }}>
                                    {{ $course }}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
            </form>
            @if (session()->has('teachers'))
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
                    class="menu {{ session()->has('teachers') && session('teachers.template') != 'merdeka' ? 'd-none' : '' }}">
                    <a href="#submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M12 18v-6M9 15h6" />
                            </svg>
                            <span> Tujuan Pembelajaran</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="submenu" data-parent="#accordionExample">
                        <li>
                            <a href="{{ route('setting_scores.list_competence') }}"> Capaian Kompetensi </a>
                        </li>
                        <li>
                            <a href="{{ route('setting_scores.description') }}"> Pengaturan Deskripsi </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="menu {{ session()->has('teachers') && session('teachers.template') != 'merdeka' ? 'd-none' : '' }}">
                    <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                            </svg>
                            <span> Penilaian Siswa</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="submenu2" data-parent="#accordionExample">
                        <li>
                            <a href="{{ route('setting_scores.score') }}"> Input Nilai</a>
                        </li>
                        <li>
                            <a href="{{ route('setting_scores.score_competency') }}"> Kelola Deskripsi</a>
                        </li>
                        <li>
                            <a
                                href="{{ url('/setting-score/assesment-weight/' . session('teachers.type') . '?study_class=' . session('teachers.slug_classes')) }}">
                                Bobot Penilaian</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="menu {{ session()->has('teachers') && session('teachers.template') != 'k13' ? 'd-none' : '' }}">
                    <a href="#score-k16" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                <line x1="3" y1="22" x2="21" y2="22"></line>
                            </svg>
                            <span> Penilaian Siswa</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="score-k16" data-parent="#accordionExample">
                        <li>
                            <a href="{{ route('k13.scores.index') }}"> Nilai</a>
                        </li>
                        <li>
                            <a href="{{ route('basic_competencies.index') }}"> Kompetensi Dasar</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="menu {{ session()->has('teachers') && session('teachers.template') != 'merdeka' ? 'd-none' : '' }}">
                    <a href="{{ route('manages.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                <line x1="3" y1="22" x2="21" y2="22"></line>
                            </svg>
                            <span> Penilaian P5</span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu {{ session()->has('teachers') && session('teachers.template') != 'manual' ? 'd-none' : '' }}">
                    <a href="{{ route('manuals.scores.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                <line x1="3" y1="22" x2="21" y2="22"></line>
                            </svg>
                            <span> Penilaian Siswa</span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu {{ session()->has('teachers') && session('teachers.template') != 'manual2' ? 'd-none' : '' }}">
                    <a href="{{ route('manual2s.scores.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                <line x1="3" y1="22" x2="21" y2="22"></line>
                            </svg>
                            <span> Penilaian Siswa</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="javascript:void(0);" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.5 2v6h6M2.66 15.57a10 10 0 1 0 .57-8.38" />
                            </svg>
                            <span> Riwayat Mengajar</span>
                        </div>
                    </a>
                </li>
            @else
                <li class="menu">
                    <a href="javascript:void(0);">
                        <div class="text-danger text-center">
                            <span class="font-weight-bold"> Pilih mapel dan kelas dulu</span>
                        </div>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
@push('scripts')
    <script>
        $(function() {
            $('#id_study_class').change(function() {
                loadSiswa($(this).val(), $('#id_course').val());
            });


            $('#id_course').change(function() {
                loadSiswa($('#id_study_class').val(), $(this).val());
            });
        })

        function loadSiswa(id_study_class, id_course) {
            var notempty = id_study_class && id_course;
            if (notempty) {
                $('#formClassCourse').submit();
            }
        }
    </script>
@endpush
