@extends('admin.layouts.app')

@section('title', 'Edit Rekam Medis - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>Edit Rekam Medis
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.medical-records.show', $medicalRecord->id) }}" class="btn btn-sm btn-outline-info me-2">
            <i class="fas fa-eye me-1"></i>Lihat Detail
        </a>
        <a href="{{ route('admin.medical-records.index') }}" class="btn btn-sm btn-outline-purple">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.medical-records.update', $medicalRecord->id) }}" method="POST" id="medicalRecordForm">
    @csrf
    @method('PUT')
    
    <div class="card card-purple">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Hewan & Pemilik</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_pemilik" class="form-label fw-bold">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" 
                               value="{{ old('nama_pemilik', $medicalRecord->nama_pemilik) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_hewan" class="form-label fw-bold">Nama Hewan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_hewan" name="nama_hewan" 
                               value="{{ old('nama_hewan', $medicalRecord->nama_hewan) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="jenis_hewan" class="form-label fw-bold">Jenis Hewan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="jenis_hewan" name="jenis_hewan" 
                               value="{{ old('jenis_hewan', $medicalRecord->jenis_hewan) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="ras" class="form-label fw-bold">Ras <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ras" name="ras" 
                               value="{{ old('ras', $medicalRecord->ras) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="umur" class="form-label fw-bold">Umur (bulan) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="umur" name="umur" 
                               value="{{ old('umur', $medicalRecord->umur) }}" min="0" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemeriksaan & Diagnosa -->
    <div class="card card-purple mt-4">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Pemeriksaan & Diagnosa</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tanggal_pemeriksaan" class="form-label fw-bold">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" 
                               value="{{ old('tanggal_pemeriksaan', $medicalRecord->tanggal_pemeriksaan->format('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="dokter" class="form-label fw-bold">Dokter <span class="text-danger">*</span></label>
                        <select class="form-select" id="dokter" name="dokter" required>
                            <option value="">Pilih Dokter</option>
                            @foreach($doctors as $key => $doctor)
                                <option value="{{ $key }}" {{ old('dokter', $medicalRecord->dokter) == $key ? 'selected' : '' }}>
                                    {{ $doctor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            @foreach($statuses as $key => $status)
                                <option value="{{ $key }}" {{ old('status', $medicalRecord->status) == $key ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="berat_badan" class="form-label fw-bold">Berat Badan (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="berat_badan" name="berat_badan" 
                               value="{{ old('berat_badan', $medicalRecord->berat_badan) }}" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="suhu_tubuh" class="form-label fw-bold">Suhu Tubuh (°C)</label>
                        <input type="number" step="0.1" class="form-control" id="suhu_tubuh" name="suhu_tubuh" 
                               value="{{ old('suhu_tubuh', $medicalRecord->suhu_tubuh) }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kunjungan_berikutnya" class="form-label fw-bold">Kunjungan Berikutnya</label>
                        <input type="date" class="form-control" id="kunjungan_berikutnya" name="kunjungan_berikutnya" 
                               value="{{ old('kunjungan_berikutnya', $medicalRecord->kunjungan_berikutnya ? $medicalRecord->kunjungan_berikutnya->format('Y-m-d') : '') }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="keluhan_utama" class="form-label fw-bold">Keluhan Utama <span class="text-danger">*</span></label>
                <textarea class="form-control" id="keluhan_utama" name="keluhan_utama" rows="3" required>{{ old('keluhan_utama', $medicalRecord->keluhan_utama) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="diagnosa" class="form-label fw-bold">Diagnosa <span class="text-danger">*</span></label>
                <textarea class="form-control" id="diagnosa" name="diagnosa" rows="3" required>{{ old('diagnosa', $medicalRecord->diagnosa) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="tindakan" class="form-label fw-bold">Tindakan yang Dilakukan</label>
                <textarea class="form-control" id="tindakan" name="tindakan" rows="3">{{ old('tindakan', $medicalRecord->tindakan) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="resep_obat" class="form-label fw-bold">Resep Obat</label>
                <textarea class="form-control" id="resep_obat" name="resep_obat" rows="3">{{ old('resep_obat', $medicalRecord->resep_obat) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="catatan_dokter" class="form-label fw-bold">Catatan & Saran Dokter</label>
                <textarea class="form-control" id="catatan_dokter" name="catatan_dokter" rows="3">{{ old('catatan_dokter', $medicalRecord->catatan_dokter) }}</textarea>
            </div>
        </div>
    </div>

    <!-- Vaksinasi Section -->
    <div class="card card-purple mt-4">
        <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Data Vaksinasi</h5>
            <button type="button" class="btn btn-sm btn-light" id="addVaccination">
                <i class="fas fa-plus me-1"></i>Tambah Vaksinasi
            </button>
        </div>
        <div class="card-body">
            <div id="vaccinations-container">
                @foreach($medicalRecord->vaccinations as $index => $vaksin)
                <div class="vaccination-item border rounded p-3 mb-3">
                    <input type="hidden" name="vaccinations[{{ $index }}][id]" value="{{ $vaksin->id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Vaksin</label>
                                <input type="text" class="form-control" name="vaccinations[{{ $index }}][nama_vaksin]" 
                                       value="{{ old('vaccinations.'.$index.'.nama_vaksin', $vaksin->nama_vaksin) }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Dosis</label>
                                <input type="text" class="form-control" name="vaccinations[{{ $index }}][dosis]" 
                                       value="{{ old('vaccinations.'.$index.'.dosis', $vaksin->dosis) }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Vaksin</label>
                                <input type="date" class="form-control" name="vaccinations[{{ $index }}][tanggal_vaksin]" 
                                       value="{{ old('vaccinations.'.$index.'.tanggal_vaksin', $vaksin->tanggal_vaksin->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Booster</label>
                                <input type="date" class="form-control" name="vaccinations[{{ $index }}][tanggal_booster]" 
                                       value="{{ old('vaccinations.'.$index.'.tanggal_booster', $vaksin->tanggal_booster ? $vaksin->tanggal_booster->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label fw-bold">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm w-100 remove-vaccination">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan</label>
                                <textarea class="form-control" name="vaccinations[{{ $index }}][catatan]" rows="2">{{ old('vaccinations.'.$index.'.catatan', $vaksin->catatan) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <input type="hidden" name="deleted_vaccinations" id="deletedVaccinations" value="">
        </div>
    </div>

    <!-- Form Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.medical-records.show', $medicalRecord->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-purple">
                    <i class="fas fa-save me-1"></i>Update Rekam Medis
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let vaccinationCount = {{ $medicalRecord->vaccinations->count() }};
    const deletedVaccinations = [];

    // Add vaccination field
    document.getElementById('addVaccination').addEventListener('click', function() {
        const container = document.getElementById('vaccinations-container');
        const index = vaccinationCount++;
        
        const vaccinationHtml = `
            <div class="vaccination-item border rounded p-3 mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Vaksin</label>
                            <input type="text" class="form-control" name="vaccinations[${index}][nama_vaksin]" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dosis</label>
                            <input type="text" class="form-control" name="vaccinations[${index}][dosis]" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Vaksin</label>
                            <input type="date" class="form-control" name="vaccinations[${index}][tanggal_vaksin]" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Booster</label>
                            <input type="date" class="form-control" name="vaccinations[${index}][tanggal_booster]">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label fw-bold">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm w-100 remove-vaccination">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan</label>
                            <textarea class="form-control" name="vaccinations[${index}][catatan]" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', vaccinationHtml);
    });

    // Remove vaccination field
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-vaccination')) {
            const vaccinationItem = e.target.closest('.vaccination-item');
            const hiddenIdInput = vaccinationItem.querySelector('input[type="hidden"][name*="[id]"]');
            
            if (hiddenIdInput && hiddenIdInput.value) {
                deletedVaccinations.push(hiddenIdInput.value);
                document.getElementById('deletedVaccinations').value = JSON.stringify(deletedVaccinations);
            }
            
            vaccinationItem.remove();
        }
    });

    // Set today's date as default for new vaccination dates
    document.getElementById('addVaccination').addEventListener('click', function() {
        setTimeout(() => {
            const vaccinationItems = document.querySelectorAll('.vaccination-item');
            const lastItem = vaccinationItems[vaccinationItems.length - 1];
            if (lastItem) {
                const today = new Date().toISOString().split('T')[0];
                const dateInput = lastItem.querySelector('input[type="date"][name*="tanggal_vaksin"]');
                if (dateInput && !dateInput.value) {
                    dateInput.value = today;
                }
            }
        }, 100);
    });
});
</script>
@endsection