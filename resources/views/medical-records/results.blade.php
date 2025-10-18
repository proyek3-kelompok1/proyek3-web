@extends('layouts.app')

@section('title', 'Hasil Rekam Medis - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-purple"><i class="fas fa-file-medical me-2"></i>Rekam Medis Hewan</h2>
                <a href="{{ route('medical-records.index') }}" class="btn btn-outline-purple">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Info Hewan -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-paw me-2"></i>Informasi Hewan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p class="mb-2"><strong>Nama Hewan:</strong><br>{{ $booking->nama_hewan }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-2"><strong>Jenis/Ras:</strong><br>{{ $booking->jenis_hewan }} - {{ $booking->ras }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-2"><strong>Umur:</strong><br>{{ $booking->umur }} bulan</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-2"><strong>Pemilik:</strong><br>{{ $booking->nama_pemilik }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($medicalRecords->count() > 0)
                <!-- Daftar Rekam Medis -->
                <div class="card shadow">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pemeriksaan</h5>
                    </div>
                    <div class="card-body">
                        @foreach($medicalRecords as $record)
                        <div class="medical-record-item border-bottom pb-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="text-purple mb-1">Pemeriksaan Tanggal: 
                                        {{ \Carbon\Carbon::parse($record->tanggal_pemeriksaan)->format('d F Y') }}
                                    </h5>
                                    <span class="badge 
                                        @if($record->status == 'selesai') bg-success
                                        @elseif($record->status == 'rawat') bg-warning
                                        @elseif($record->status == 'kontrol') bg-info
                                        @endif">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                    <span class="badge bg-secondary ms-2">Kode: {{ $record->kode_rekam_medis }}</span>
                                </div>
                                <a href="{{ route('medical-records.show', $record->id) }}" class="btn btn-sm btn-outline-purple">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Dokter:</strong> {{ $record->dokter }}</p>
                                    <p><strong>Keluhan:</strong> {{ Str::limit($record->keluhan_utama, 100) }}</p>
                                    <p><strong>Diagnosa:</strong> {{ Str::limit($record->diagnosa, 100) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Berat Badan:</strong> {{ $record->berat_badan ?? '-' }}</p>
                                    <p><strong>Suhu Tubuh:</strong> {{ $record->suhu_tubuh ?? '-' }}</p>
                                    @if($record->kunjungan_berikutnya)
                                    <p><strong>Kontrol Berikutnya:</strong> 
                                        {{ \Carbon\Carbon::parse($record->kunjungan_berikutnya)->format('d F Y') }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            @if($record->vaccinations->count() > 0)
                            <div class="mt-3">
                                <h6 class="text-success"><i class="fas fa-syringe me-1"></i>Vaksinasi:</h6>
                                <div class="row">
                                    @foreach($record->vaccinations as $vaksin)
                                    <div class="col-md-4">
                                        <div class="border rounded p-2 mb-2">
                                            <small class="fw-bold">{{ $vaksin->nama_vaksin }}</small><br>
                                            <small>Dosis: {{ $vaksin->dosis }}</small><br>
                                            <small>Tanggal: {{ \Carbon\Carbon::parse($vaksin->tanggal_vaksin)->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card shadow text-center">
                    <div class="card-body py-5">
                        <i class="fas fa-file-medical-alt fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Rekam Medis</h4>
                        <p class="text-muted">Rekam medis akan tersedia setelah hewan Anda menjalani pemeriksaan di klinik.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-purple {
    background-color: #6f42c1;
}
.text-purple {
    color: #6f42c1;
}
.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}
.btn-outline-purple {
    border-color: #6f42c1;
    color: #6f42c1;
}
.medical-record-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
</style>
@endsection