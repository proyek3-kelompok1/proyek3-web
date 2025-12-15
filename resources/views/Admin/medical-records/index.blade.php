@extends('admin.layouts.app')

@section('title', 'Kelola Rekam Medis - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-medical me-2"></i>Kelola Rekam Medis
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-purple" id="refreshBtn">
                <i class="fas fa-sync-alt me-1"></i>Refresh
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Filter -->
<div class="card card-purple mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label for="dateFilter" class="form-label fw-bold">Filter Tanggal</label>
                <input type="date" class="form-control" id="dateFilter" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label for="statusFilter" class="form-label fw-bold">Filter Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="rawat">Dalam Perawatan</option>
                    <option value="kontrol">Kontrol</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">&nbsp;</label>
                <div>
                    <button type="button" class="btn btn-purple w-100" id="applyFilter">
                        <i class="fas fa-filter me-1"></i>Terapkan Filter
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Rekam Medis -->
<div class="card card-purple">
    <div class="card-header bg-purple text-black">
        <h5 class="mb-0">
            <i class="fas fa-table me-2"></i>Daftar Rekam Medis
            <span class="badge bg-light text-purple ms-2">{{ $medicalRecords->total() }}</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10%">Kode RM</th>
                        <th width="15%">Pemilik & Hewan</th>
                        <th width="15%">Layanan</th>
                        <th width="15%">Diagnosa</th>
                        <th width="10%">Dokter</th>
                        <th width="10%">Tanggal</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicalRecords as $record)
                    <tr>
                        <td>
                            <strong class="text-purple">{{ $record->kode_rekam_medis }}</strong>
                        </td>
                        <td>
                            <strong>{{ $record->nama_pemilik }}</strong>
                            <br>
                            <small class="text-muted">{{ $record->nama_hewan }} ({{ $record->jenis_hewan }})</small>
                        </td>
                        <td>
                            @if($record->serviceBooking)
                                @php
                                    $serviceNames = [
                                        'vaksinasi' => 'Vaksinasi',
                                        'konsultasi_umum' => 'Konsultasi Umum',
                                        'grooming' => 'Grooming',
                                        'perawatan_gigi' => 'Perawatan Gigi',
                                        'pemeriksaan_darah' => 'Pemeriksaan Darah',
                                        'sterilisasi' => 'Sterilisasi'
                                    ];
                                @endphp
                                <span class="badge bg-info">{{ $serviceNames[$record->serviceBooking->service_type] ?? $record->serviceBooking->service_type }}</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ Str::limit($record->diagnosa, 50) }}</small>
                        </td>
                        <td>
                            <small>{{ $record->dokter }}</small>
                        </td>
                        <td>
                            <small>{{ \Carbon\Carbon::parse($record->tanggal_pemeriksaan)->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <span class="badge 
                                @if($record->status == 'selesai') bg-success
                                @elseif($record->status == 'rawat') bg-warning
                                @elseif($record->status == 'kontrol') bg-info
                                @endif">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.medical-records.show', $record->id) }}" 
                                   class="btn btn-outline-info" data-bs-toggle="tooltip" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.medical-records.edit', $record->id) }}" 
                                   class="btn btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($record->serviceBooking)
                                <a href="{{ route('admin.queue.detail', $record->serviceBooking->id) }}" 
                                   class="btn btn-outline-purple" data-bs-toggle="tooltip" title="Lihat Booking">
                                    <i class="fas fa-calendar-check"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-file-medical-alt fa-2x mb-3"></i>
                                <p>Belum ada rekam medis</p>
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
                Menampilkan {{ $medicalRecords->firstItem() }} - {{ $medicalRecords->lastItem() }} dari {{ $medicalRecords->total() }} rekam medis
            </div>
            <nav>
                {{ $medicalRecords->links() }}
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

    // Filter functionality
    document.getElementById('applyFilter').addEventListener('click', function() {
        const date = document.getElementById('dateFilter').value;
        const status = document.getElementById('statusFilter').value;
        
        let url = '{{ route("admin.medical-records.index") }}?';
        
        if (date) {
            url += `date=${date}&`;
        }
        
        if (status) {
            url += `status=${status}&`;
        }
        
        window.location.href = url;
    });

    // Refresh button
    document.getElementById('refreshBtn').addEventListener('click', function() {
        window.location.reload();
    });
});
</script>
@endsection