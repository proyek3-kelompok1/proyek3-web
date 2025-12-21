@extends('admin.layouts.app')

@section('title', 'Kelola Layanan - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-stethoscope me-2"></i>Kelola Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-purple">
            <i class="fas fa-plus me-1"></i>Tambah Layanan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card card-purple">
    <div class="card-header bg-purple text-white">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Daftar Layanan
            <span class="badge bg-light text-purple ms-2">{{ $services->total() }}</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Icon</th>
                        <th width="20%">Nama Layanan</th>
                        <th width="15%">Jenis</th>
                        <th width="15%">Harga</th>
                        <th width="10%">Durasi</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>{{ $services->firstItem() + $loop->index }}</td>
                        <td>
                            <i class="{{ $service->icon }} fa-lg text-purple"></i>
                        </td>
                        <td>
                            <strong>{{ $service->name }}</strong>
                            <br>
                            <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $service->service_type_label }}</span>
                        </td>
                        <td>
                            @if($service->price)
                                <strong>{{ $service->formatted_price }}</strong>
                            @else
                                <span class="text-muted">Konsultasi</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $service->formatted_duration }}</small>
                        </td>
                        <td>
                            @if($service->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.services.show', $service->id) }}" 
                                   class="btn btn-outline-info" data-bs-toggle="tooltip" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.services.edit', $service->id) }}" 
                                   class="btn btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service->id) }}" 
                                      method="POST" class="d-inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-stethoscope fa-2x mb-3"></i>
                                <p>Belum ada layanan. Silakan tambah layanan baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan {{ $services->firstItem() }} - {{ $services->lastItem() }} dari {{ $services->total() }} layanan
            </div>
            <nav>
                {{ $services->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection