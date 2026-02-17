<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold mb-0">Admin Panel</span>

        <!-- Navbar Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin" aria-controls="navbarNavAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNavAdmin">
            <ul class="navbar-nav ms-auto">
                <!-- View Portfolio Link -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link" target="_blank" title="View Public Portfolio">
                        <i class="bi bi-eye"></i>
                        <span class="d-none d-lg-inline ms-2">View Portfolio</span>
                    </a>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <img src="{{ Auth::user()->avatar ?? asset('assets/img/default-avatar.png') }}" alt="User Avatar" class="rounded-circle me-2" width="28" height="28" style="object-fit: cover;">
                        <span class="d-none d-md-inline text-truncate" style="max-width: 100px;">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><h6 class="dropdown-header">{{ Auth::user()->email }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        background-color: #2c3e50 !important;
        border-bottom: 1px solid #1a252f;
    }

    .navbar-brand {
        font-size: 1.3rem;
        letter-spacing: 0.5px;
    }

    .navbar .nav-link {
        color: #ecf0f1 !important;
        transition: color 0.2s ease;
        padding: 0.5rem 0.75rem !important;
    }

    .navbar .nav-link:hover {
        color: #3498db !important;
    }

    .navbar .dropdown-menu {
        background-color: #34495e;
        border: 1px solid #2c3e50;
    }

    .navbar .dropdown-item {
        color: #ecf0f1;
    }

    .navbar .dropdown-item:hover,
    .navbar .dropdown-item.active {
        background-color: #2c3e50;
        color: #3498db;
    }

    .navbar .dropdown-header {
        color: #95a5a6;
        padding: 0.5rem 1rem;
    }

    @media (max-width: 768px) {
        .navbar-brand {
            font-size: 1.1rem;
        }
    }
</style>