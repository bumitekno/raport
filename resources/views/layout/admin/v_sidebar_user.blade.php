<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ Auth::guard('user')->user()->file ? asset(Auth::guard('user')->user()->file) : asset('asset/img/90x90.jpg') }}"
                    alt="avatar">
                <h6 class="">{{ Auth::guard('user')->user()->name }}</h6>
                <p class="text-capitalize">{{ session('role') }}</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu">
                <a href="{{ route('user.dashboard') }}" aria-expanded="{{ Request::is('home*') ? 'true' : 'false' }}"
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

            <li class="menu">
                <a href="{{ route('previews.index') }}" aria-expanded="{{ Request::is('preview*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                            </path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span> Cetak Raport</span>
                    </div>
                </a>
            </li>



        </ul>

    </nav>

</div>
