<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-purple py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <img src="/image/logo.png" alt="Logo" style="height: 40px; margin-right: 10px;">DV Pets Klinik </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ url('/services') }}">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('articles') ? 'active' : '' }}" href="{{ url('/articles') }}">Artikel & Edukasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('consultations') ? 'active' : '' }}" href="{{ url('/consultations') }}">Kontak</a>
                </li>
            </ul>

            {{-- Bagian Login/Logout Dinamis --}}
            <div class="ms-lg-3 mt-3 mt-lg-0">
                @auth
                    {{-- Jika user sudah login --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                @else
                    {{-- Jika user belum login --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .bg-purple {
        background: linear-gradient(135deg, #6a3093, #8a4dcc) !important;
    }
    
    .navbar-brand {
        font-size: 1.5rem;
    }
    
    .nav-link {
        font-weight: 500;
        margin: 0 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }
    
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: 600;
    }
    
    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }
</style>