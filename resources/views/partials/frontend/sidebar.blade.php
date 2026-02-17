<nav id="navmenu" class="navmenu">

    <div class="profile-img">
        <img src="{{ asset('assets/img/profile/profile-square-1.jpeg') }}" alt="" class="img-fluid rounded-circle">
    </div>

    <a href="{{ url('/') }}" class="logo d-flex align-items-center justify-content-center active">
        <h1 class="sitename">Najwa Fauziah R</h1>
    </a>

    <div class="social-links text-center">
        <a href="https://instagram.com/ianfaazr" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="https://www.linkedin.com/in/najwa-fauziah-rahmania-614162307" class="linkedin"><i class="bi bi-linkedin"></i></a>
        <a href="https://github.com/Najwafr14" class="github"><i class="bi bi-github"></i></a>
    </div>

    <ul>
        <li><a href="#hero">Dashboard</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#resume">Resume</a></li>
        <li><a href="#portfolio">Portfolio</a></li>
        <li><a href="#contact">Contact</a></li>
        <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>