@extends('admin.layouts.app')

@section('title', 'Tambah Layanan Baru - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus me-2"></i>Tambah Layanan Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-purple">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.services.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <!-- Informasi Dasar -->
            <div class="card card-purple mb-4">
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="order" class="form-label fw-bold">Urutan</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Angka lebih kecil akan muncul lebih dulu</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maksimal 500 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label fw-bold">Detail Layanan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('details') is-invalid @enderror" 
                                  id="details" name="details" rows="5" required>{{ old('details') }}</textarea>
                        @error('details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Jelaskan detail lengkap layanan ini</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Pengaturan Layanan -->
            <div class="card card-purple mb-4">
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Pengaturan Layanan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="service_type" class="form-label fw-bold">Jenis Layanan <span class="text-danger">*</span></label>
                        <select class="form-select @error('service_type') is-invalid @enderror" 
                                id="service_type" name="service_type" required>
                            <option value="">Pilih Jenis Layanan</option>
                            @foreach($serviceTypes as $key => $type)
                                <option value="{{ $key }}" {{ old('service_type') == $key ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold">Icon <span class="text-danger">*</span></label>
                        <select class="form-select @error('icon') is-invalid @enderror" 
                                id="icon" name="icon" required>
                            <option value="">Pilih Icon</option>
                            @foreach($icons as $key => $icon)
                                <option value="{{ $key }}" {{ old('icon') == $key ? 'selected' : '' }}>
                                    <i class="{{ $key }} me-2"></i>{{ $icon }}
                                </option>
                            @endforeach
                        </select>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2 text-center">
                            <i id="icon-preview" class="fas fa-question-circle fa-2x text-purple"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-bold">Harga (Rp)</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price') }}" min="0" step="1000">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika konsultasi gratis</small>
                    </div>

                    <div class="mb-3">
                        <label for="duration_minutes" class="form-label fw-bold">Durasi (menit)</label>
                        <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                               id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" min="0">
                        @error('duration_minutes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-bold" for="is_active">
                                Aktifkan Layanan
                            </label>
                        </div>
                        <small class="text-muted">Jika nonaktif, layanan tidak akan ditampilkan di website</small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card card-purple">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-purple">
                            <i class="fas fa-save me-2"></i>Simpan Layanan
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview icon
    const iconSelect = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');
    
    iconSelect.addEventListener('change', function() {
        if (this.value) {
            iconPreview.className = this.value + ' fa-2x text-purple';
        } else {
            iconPreview.className = 'fas fa-question-circle fa-2x text-purple';
        }
    });
    
    // Initialize preview
    if (iconSelect.value) {
        iconPreview.className = iconSelect.value + ' fa-2x text-purple';
    }
});
</script>
@endsection