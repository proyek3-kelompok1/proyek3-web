@extends('layouts.app')

@section('title', 'Detail Rekam Medis - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-purple mb-1"><i class="fas fa-file-medical me-2"></i>Detail Rekam Medis</h2>
                    <p class="text-muted mb-0">Kode: {{ $medicalRecord->kode_rekam_medis }}</p>
                </div>
                <div class="text-end">
                    <a href="{{ route('medical-records.index') }}" class="btn btn-outline-purple me-2">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-success">
                        <i class="fas fa-print me-1"></i>Cetak
                    </button>
                </div>
            </div>

            <div class="card shadow">
                <!-- Informasi Hewan & Pemilik -->
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Umum</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nama Pemilik</strong></td>
                                    <td>{{ $medicalRecord->nama_pemilik }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Hewan</strong></td>
                                    <td>{{ $medicalRecord->nama_hewan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis/Ras</strong></td>
                                    <td>{{ $medicalRecord->jenis_hewan }} / {{ $medicalRecord->ras }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Umur</strong></td>
                                    <td>{{ $medicalRecord->umur }} bulan</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Periksa</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($medicalRecord->tanggal_pemeriksaan)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>
                                        <span class="badge 
                                            @if($medicalRecord->status == 'selesai') bg-success
                                            @elseif($medicalRecord->status == 'rawat') bg-warning
                                            @elseif($medicalRecord->status == 'kontrol') bg-info
                                            @endif">
                                            {{ ucfirst($medicalRecord->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Data Pemeriksaan -->
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Data Pemeriksaan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Berat Badan:</strong> {{ $medicalRecord->berat_badan }}</p>
                            <p><strong>Suhu Tubuh:</strong> {{ $medicalRecord->suhu_tubuh }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dokter Penanggung Jawab:</strong><br>
                                <span class="fw-bold text-purple">{{ $medicalRecord->dokter }}</span>
                            </p>
                            @if($medicalRecord->kunjungan_berikutnya)
                            <p><strong>Kunjungan Berikutnya:</strong><br>
                                {{ \Carbon\Carbon::parse($medicalRecord->kunjungan_berikutnya)->format('d F Y') }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p><strong>Keluhan Utama:</strong></p>
                            <div class="border rounded p-3 bg-light">
                                {{ $medicalRecord->keluhan_utama }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Diagnosa:</strong></p>
                            <div class="border rounded p-3 bg-light">
                                {{ $medicalRecord->diagnosa }}
                            </div>
                        </div>
                    </div>

                    @if($medicalRecord->tindakan)
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Tindakan yang Dilakukan:</strong></p>
                            <div class="border rounded p-3 bg-light">
                                {{ $medicalRecord->tindakan }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Informasi Resep (Hanya Tampilan Umum) -->
                @if($medicalRecord->resep_obat)
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-pills me-2"></i>Informasi Pengobatan</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi Resep:</strong> Resep obat telah diberikan dan dapat dilihat di klinik. 
                        Silakan hubungi dokter untuk informasi detail mengenai pengobatan.
                    </div>
                    <div class="text-center">
                        <div class="bg-light rounded p-4 border">
                            <i class="fas fa-lock fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">
                                Informasi resep obat bersifat privat dan hanya dapat diakses<br>
                                oleh pemilik hewan secara langsung di klinik.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Vaksinasi -->
                @if($medicalRecord->vaccinations->count() > 0)
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Data Vaksinasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Vaksin</th>
                                    <th>Dosis</th>
                                    <th>Tanggal Vaksin</th>
                                    <th>Tanggal Booster</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($medicalRecord->vaccinations as $vaksin)
                                <tr>
                                    <td class="fw-bold">{{ $vaksin->nama_vaksin }}</td>
                                    <td>{{ $vaksin->dosis }}</td>
                                    <td>{{ \Carbon\Carbon::parse($vaksin->tanggal_vaksin)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($vaksin->tanggal_booster)
                                            {{ \Carbon\Carbon::parse($vaksin->tanggal_booster)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $vaksin->catatan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Catatan Dokter (Umum) -->
                @if($medicalRecord->catatan_dokter)
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-notes-medical me-2"></i>Catatan dan Saran Dokter</h5>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3 bg-light">
                        {{ $medicalRecord->catatan_dokter }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Informasi Privasi -->
            <div class="mt-4 p-3 bg-light rounded">
                <h6 class="text-purple"><i class="fas fa-shield-alt me-2"></i>Informasi Privasi</h6>
                <p class="small text-muted mb-0">
                    Data rekam medis ini dilindungi privasi. Informasi sensitif seperti resep obat detail 
                    hanya dapat diakses secara langsung di klinik dengan menunjukkan identitas yang valid.
                </p>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-center mt-4">
                <div class="btn-group">
                    <a href="{{ route('medical-records.index') }}" class="btn btn-outline-purple">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Pencarian
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-success">
                        <i class="fas fa-print me-2"></i>Cetak Ringkasan
                    </button>
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20konsultasi%20tentang%20rekam%20medis%20hewan%20saya%20dengan%20kode%20{{ $medicalRecord->kode_rekam_medis }}" 
                       class="btn btn-outline-success" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Konsultasi Dokter
                    </a>
                </div>
            </div>
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

@media print {
    .btn {
        display: none !important;
    }
    .card-header {
        color: #000 !important;
        background-color: #f8f9fa !important;
    }
    .alert-info {
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
    }
}
</style>
@endsection