@extends('admin.layouts.app')

@section('title', 'Detail Layanan - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-eye me-2"></i>Detail Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-purple">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-10">
        <div class="card shadow">
            <!-- Informasi Utama -->
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Layanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="text-purple">
                            <i class="{{ $service->icon }} me-2"></i>{{ $service->name }}
                        </h3>
                        <p class="lead">{{ $service->description }}</p>
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <p><strong>Jenis Layanan:</strong><br>
                                    <span class="badge bg-info">{{ $service->service_type_label }}</span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Harga:</strong><br>
                                    <strong class="text-purple">{{ $service->formatted_price }}</strong>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Durasi:</strong><br>
                                    <strong>{{ $service->formatted_duration }}</strong>
                                </p>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <p><strong>Status:</strong><br>
                                    @if($service->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Urutan:</strong><br>
                                    <strong>{{ $service->order }}</strong>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Slug:</strong><br>
                                    <code>{{ $service->slug }}</code>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="{{ $service->icon }} fa-5x text-purple mb-3"></i>
                                <h5 class="card-title">Icon Layanan</h5>
                                <p class="card-text"><code>{{ $service->icon }}</code></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Layanan -->
            <div class="card-header bg-purple text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Detail Lengkap Layanan</h5>
            </div>
            <div class="card-body">
                <div class="bg-light p-4 rounded">
                    {!! nl2br(e($service->details)) !!}
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Informasi Tambahan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Dibuat Pada:</strong><br>
                            {{ $service->created_at->format('d F Y H:i') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Diupdate Pada:</strong><br>
                            {{ $service->updated_at->format('d F Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-center mt-4">
            <div class="btn-group">
                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit Layanan
                </a>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-purple">
                    <i class="fas fa-list me-2"></i>Daftar Layanan
                </a>
                <form action="{{ route('admin.services.destroy', $service->id) }}" 
                      method="POST" class="d-inline" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection