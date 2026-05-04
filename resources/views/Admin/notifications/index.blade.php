@extends('admin.layouts.app')

@section('title', 'Kirim Notifikasi - DV Pets Admin')

@section('styles')
<style>
    .page-header {
        margin-bottom: 28px;
    }
    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e1b4b;
    }
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
    }
    .form-control:focus, .form-select:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 4px rgba(124,58,237,0.1);
    }
    .btn-purple {
        background: #7c3aed;
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-purple:hover {
        background: #6d28d9;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124,58,237,0.3);
    }
    .alert {
        border-radius: 12px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="fas fa-bell me-2" style="color: #7c3aed;"></i>Kirim Notifikasi FCM</h1>
    <p class="text-muted">Kirim pesan push notification ke aplikasi mobile pengguna.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.notifications.send') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="target" class="form-label">Target Pengguna</label>
                        <select name="target" id="target" class="form-select @error('target') is-invalid @enderror" onchange="toggleUserSelect()">
                            <option value="all">Semua Pengguna</option>
                            <option value="specific">Pengguna Spesifik</option>
                        </select>
                        @error('target')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4" id="user-selection" style="display: none;">
                        <label for="user_id" class="form-label">Pilih Pengguna</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                            <option value="">-- Pilih Pengguna --</option>
                            @foreach(\App\Models\User::whereNotNull('fcm_token')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hanya menampilkan pengguna yang memiliki token FCM aktif.</small>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="title" class="form-label">Judul Notifikasi</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul..." value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="body" class="form-label">Isi Pesan</label>
                        <textarea name="body" id="body" rows="4" class="form-control @error('body') is-invalid @enderror" placeholder="Masukkan isi pesan..." required>{{ old('body') }}</textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-purple">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Notifikasi Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4 bg-light">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Tips Testing</h5>
                <ul class="mb-0 small text-muted">
                    <li>Pastikan aplikasi mobile sudah diinstall dan sudah login di perangkat testing.</li>
                    <li>Notifikasi akan muncul di tray notifikasi perangkat meskipun aplikasi sedang di latar belakang.</li>
                    <li>Jika target "Semua Pengguna" dipilih, sistem akan mengirim ke seluruh token yang tersimpan di database.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleUserSelect() {
        const target = document.getElementById('target').value;
        const userSelection = document.getElementById('user-selection');
        if (target === 'specific') {
            userSelection.style.display = 'block';
        } else {
            userSelection.style.display = 'none';
        }
    }
    
    // Run on load in case of validation errors
    document.addEventListener('DOMContentLoaded', function() {
        toggleUserSelect();
    });
</script>
@endsection
