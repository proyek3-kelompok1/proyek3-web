@extends('admin.layouts.app')

@section('title', 'Detail Rekam Medis - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-medical me-2"></i>Detail Rekam Medis
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.medical-records.edit', $medicalRecord->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.medical-records.print', $medicalRecord->id) }}" class="btn btn-sm btn-success" target="_blank">
                <i class="fas fa-print me-1"></i>Print
            </a>
            <a href="{{ route('admin.medical-records.index') }}" class="btn btn-sm btn-outline-purple">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-10">
        <div class="card shadow">
            <!-- Informasi Umum -->
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Umum</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Kode Rekam Medis</strong></td>
                                <td><code>{{ $medicalRecord->kode_rekam_medis }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Pemilik</strong></td>
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
                                    @php
                                        $statusColors = [
                                            'selesai' => 'success',
                                            'rawat' => 'warning',
                                            'kontrol' => 'info'
                                        ];
                                        $statusLabels = [
                                            'selesai' => 'Selesai',
                                            'rawat' => 'Dalam Perawatan',
                                            'kontrol' => 'Perlu Kontrol'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$medicalRecord->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$medicalRecord->status] ?? $medicalRecord->status }}
                                    </span>
                                </td>
                            </tr>
                            @if($medicalRecord->service_booking_id)
                            <tr>
                                <td><strong>Kode Booking</strong></td>
                                <td><code>{{ $medicalRecord->serviceBooking->booking_code ?? 'N/A' }}</code></td>
                            </tr>
                            @endif
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
                        <p><strong>Dokter Penanggung Jawab:</strong><br>
                            <span class="fw-bold text-purple">
                                @php
                                    $doctors = [
                                        'drh_roza' => 'drh. Roza Albate Chandra Adila',
                                        'drh_arundhina' => 'drh. Arundhina Girishanta M.Si',
                                    ];
                                @endphp
                                {{ $doctors[$medicalRecord->dokter] ?? $medicalRecord->dokter }}
                            </span>
                        </p>
                        <p><strong>Berat Badan:</strong> {{ $medicalRecord->berat_badan ? $medicalRecord->berat_badan . ' kg' : '-' }}</p>
                        <p><strong>Suhu Tubuh:</strong> {{ $medicalRecord->suhu_tubuh ? $medicalRecord->suhu_tubuh . ' °C' : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($medicalRecord->kunjungan_berikutnya)
                        <p><strong>Kunjungan Berikutnya:</strong><br>
                            <span class="fw-bold text-info">
                                {{ \Carbon\Carbon::parse($medicalRecord->kunjungan_berikutnya)->format('d F Y') }}
                            </span>
                        </p>
                        @endif
                        <p><strong>Dibuat Pada:</strong><br>
                            {{ $medicalRecord->created_at->format('d F Y H:i') }}
                        </p>
                        <p><strong>Diupdate Pada:</strong><br>
                            {{ $medicalRecord->updated_at->format('d F Y H:i') }}
                        </p>
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

                @if($medicalRecord->resep_obat)
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Resep Obat:</strong></p>
                        <div class="border rounded p-3 bg-light">
                            {{ $medicalRecord->resep_obat }}
                        </div>
                    </div>
                </div>
                @endif

                @if($medicalRecord->catatan_dokter)
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Catatan & Saran Dokter:</strong></p>
                        <div class="border rounded p-3 bg-light">
                            {{ $medicalRecord->catatan_dokter }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

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
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-center mt-4">
            <div class="btn-group">
                <a href="{{ route('admin.medical-records.edit', $medicalRecord->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit Rekam Medis
                </a>
                <a href="{{ route('admin.medical-records.print', $medicalRecord->id) }}" class="btn btn-success" target="_blank">
                    <i class="fas fa-print me-2"></i>Print
                </a>
                <a href="{{ route('admin.medical-records.index') }}" class="btn btn-outline-purple">
                    <i class="fas fa-list me-2"></i>Daftar Rekam Medis
                </a>
            </div>
        </div>
    </div>
</div>
@endsection