<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Klinik Hewan Ungu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a0dad;
            --secondary-color: #8a2be2;
            --light-purple: #e6e6fa;
            --dark-purple: #4b0082;
        }
        
        .sidebar {
            background-color: var(--dark-purple);
            color: white;
            min-height: 100vh;
            padding: 0;
        }
        
        .sidebar .nav-link {
            color: white;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar .nav-link:hover {
            background-color: var(--primary-color);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .navbar {
            background-color: var(--primary-color);
        }
        
        .content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        .card-purple {
            border-left: 4px solid var(--primary-color);
        }
        
        .btn-purple {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-purple:hover {
            background-color: var(--dark-purple);
            border-color: var(--dark-purple);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center py-4">
                    <h4><i class="fas fa-paw me-2"></i>Admin Panel</h4>
                    <p class="small mb-0">Klinik Hewan Ungu</p>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-stethoscope me-2"></i>Kelola Layanan
                    </a>
                    <a class="nav-link {{ request()->is('admin/doctors*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-user-md me-2"></i>Kelola Dokter
                    </a>
                    <a class="nav-link {{ request()->is('admin/posts*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-newspaper me-2"></i>Kelola Artikel
                    </a>
                    <a class="nav-link {{ request()->is('admin/gallery*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-images me-2"></i>Kelola Galeri
                    </a>
                    <a class="nav-link {{ request()->is('admin/messages*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-envelope me-2"></i>Pesan Masuk
                    </a>
                    <a class="nav-link" href="{{ url('/admin/logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 content p-0">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container-fluid">
                        <span class="navbar-brand">Selamat Datang, {{ Auth::guard('admin')->user()->name }}!</span>
                        <div class="navbar-nav ms-auto">
                            <span class="navbar-text">
                                <i class="fas fa-user me-1"></i> 
                                {{ Auth::guard('admin')->user()->email }}
                            </span>
                        </div>
                    </div>
                </nav>

                <main class="p-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>