<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Klinik Hewan Ungu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #7c3aed;
            --secondary-color: #9d5ced;
            --light-purple: #ede9fe;
            --dark-purple: #4c1d95;
            --accent: #e879f9;
            --sidebar-bg: linear-gradient(180deg, #1e1045 0%, #2d1b69 50%, #4c1d95 100%);
        }

        * { font-family: 'Inter', sans-serif; }
        
        .sidebar {
            background: var(--sidebar-bg);
            color: white;
            min-height: 100vh;
            padding: 0;
            box-shadow: 4px 0 20px rgba(76, 29, 149, 0.3);
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.2);
        }

        .sidebar-brand h5 {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 12px 20px;
            border-radius: 0;
            border-left: 3px solid transparent;
            transition: all 0.25s ease;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.08);
            color: white;
            border-left-color: var(--accent);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(124,58,237,0.5), rgba(124,58,237,0.15));
            color: white;
            border-left-color: var(--accent);
            font-weight: 600;
        }

        .sidebar .nav-link i {
            width: 18px;
            text-align: center;
        }
        
        .admin-navbar {
            background: linear-gradient(90deg, #7c3aed, #9d5ced);
            padding: 0 20px;
            height: 60px;
            box-shadow: 0 2px 10px rgba(124,58,237,0.3);
        }
        
        .content {
            background-color: #f5f3ff;
            min-height: 100vh;
        }
        
        .card-purple {
            border-left: 4px solid var(--primary-color);
            border-radius: 12px;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        
        .btn-purple {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-color: var(--primary-color);
            color: white;
            font-weight: 500;
            border-radius: 8px;
        }
        
        .btn-purple:hover {
            background: linear-gradient(135deg, var(--dark-purple), var(--primary-color));
            border-color: var(--dark-purple);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124,58,237,0.35);
        }

        .btn-outline-purple {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
        }

        .btn-outline-purple:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .text-purple { color: var(--primary-color) !important; }
        .bg-purple { background-color: var(--primary-color) !important; }

        .badge {
            border-radius: 6px;
        }

        .table th {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            background-color: #f9fafb;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-card {
            border-radius: 16px;
            border: none;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12) !important;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="sidebar-brand text-center">
                    <img src="/image/logo.png" alt="Logo" style="height: 38px; margin-bottom: 8px;">
                    <h5>DV Pets Admin</h5>
                    <p class="small mb-0" style="color: rgba(255,255,255,0.5); font-size: 0.75rem;">Klinik Hewan</p>
                </div>
                
                <nav class="nav flex-column mt-2">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                        <i class="fas fa-chart-pie me-2"></i>Dashboard
                    </a>
                    <a class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                        <i class="fas fa-stethoscope me-2"></i>Layanan
                    </a>
                    <a class="nav-link {{ request()->is('admin/doctors*') ? 'active' : '' }}" href="{{ route('admin.doctors.index') }}">
                        <i class="fas fa-user-md me-2"></i>Dokter
                    </a>
                    <a class="nav-link {{ request()->is('admin/education*') ? 'active' : '' }}" href="{{ route('admin.education.index') }}">
                        <i class="fas fa-graduation-cap me-2"></i>Edukasi
                    </a>
                    <a class="nav-link {{ request()->is('admin/queue*') ? 'active' : '' }}" href="{{ route('admin.queue.index') }}">
                        <i class="fas fa-list-ol me-2"></i>Antrian
                    </a>
                    <a class="nav-link {{ request()->is('admin/medical-records*') ? 'active' : '' }}" href="{{ route('admin.medical-records.index') }}">
                        <i class="fas fa-file-medical me-2"></i>Rekam Medis
                    </a>
                    <a class="nav-link {{ request()->is('admin/messages*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                        <i class="fas fa-comments me-2"></i>Ulasan Pelanggan
                    </a>
                    <a class="nav-link {{ request()->is('admin/notifications*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}">
                        <i class="fas fa-bell me-2"></i>Notifikasi FCM
                    </a>

                    <div style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 8px;">
                        <a class="nav-link" href="{{ url('/admin/logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </div>
                    <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 content p-0">
                <nav class="admin-navbar d-flex align-items-center navbar">
                    <div class="container-fluid">
                        <span class="navbar-brand text-white fw-600" style="font-size: 0.95rem;">
                            <i class="fas fa-paw me-2" style="color: #e879f9;"></i>
                            Selamat datang, <strong>{{ Auth::guard('admin')->user()->name }}</strong>!
                        </span>
                        <div class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
                            <span style="color: rgba(255,255,255,0.8); font-size: 0.85rem;">
                                <i class="fas fa-clock me-1"></i>
                                <span id="current-time"></span>
                            </span>
                            <span class="badge" style="background: rgba(255,255,255,0.2); color: white; font-size: 0.8rem; padding: 6px 12px; border-radius: 20px;">
                                <i class="fas fa-user-shield me-1"></i>
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
    <script>
        // Live clock
        function updateTime() {
            const el = document.getElementById('current-time');
            if (el) {
                const now = new Date();
                el.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>
    @yield('scripts')
</body>
</html>