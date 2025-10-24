@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-purple">Export</button>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 card-purple">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Layanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 card-purple">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Dokter Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-md fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 card-purple">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pesan Baru
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 card-purple">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Artikel
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4 card-purple">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-purple">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-purple btn-block">
                            <i class="fas fa-plus me-2"></i>Tambah Layanan
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-purple btn-block">
                            <i class="fas fa-user-plus me-2"></i>Tambah Dokter
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-purple btn-block">
                            <i class="fas fa-edit me-2"></i>Tulis Artikel
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-purple btn-block">
                            <i class="fas fa-image me-2"></i>Upload Galeri
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4 card-purple">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-purple">Aktivitas Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-user-circle text-purple me-3"></i>
                        <div>
                            <small class="text-muted">5 menit lalu</small>
                            <p class="mb-0">Admin menambah layanan baru</p>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-user-circle text-purple me-3"></i>
                        <div>
                            <small class="text-muted">1 jam lalu</small>
                            <p class="mb-0">Pesan baru dari customer</p>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-user-circle text-purple me-3"></i>
                        <div>
                            <small class="text-muted">2 jam lalu</small>
                            <p class="mb-0">Artikel baru dipublikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Admin Login -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-body">
                <h6 class="card-title">Informasi Login</h6>
                <p class="mb-1"><strong>Nama:</strong> {{ Auth::guard('admin')->user()->name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ Auth::guard('admin')->user()->email }}</p>
                <p class="mb-0"><strong>Login Time:</strong> {{ now()->format('d M Y H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection