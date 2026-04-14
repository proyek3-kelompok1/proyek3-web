@extends('layouts.app')

@section('title', 'Pemesanan Layanan Online - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="fw-bold text-purple mb-3">Pemesanan Layanan Online</h1>
                <p class="lead text-muted">Pilih layanan dan jadwalkan kunjungan untuk hewan kesayangan Anda</p>
            </div>

            <!-- Progress Steps -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="steps d-flex justify-content-between">
                        <div class="step text-center" data-step="1">
                            <div class="step-icon rounded-circle bg-purple text-white d-inline-flex align-items-center justify-content-center mb-2">
                                <span>1</span>
                            </div>
                            <h6 class="step-title">Pilih Layanan</h6>
                        </div>
                        <div class="step text-center" data-step="2">
                            <div class="step-icon rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-2">
                                <span>2</span>
                            </div>
                            <h6 class="step-title">Dokter & Jadwal</h6>
                        </div>
                        <div class="step text-center" data-step="3">
                            <div class="step-icon rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-2">
                                <span>3</span>
                            </div>
                            <h6 class="step-title">Data Pemilik & Hewan</h6>
                        </div>
                        <div class="step text-center" data-step="4">
                            <div class="step-icon rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-2">
                                <span>4</span>
                            </div>
                            <h6 class="step-title">Konfirmasi</h6>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Multi-Step Form -->
            <form action="{{ route('online-services.book') }}" method="POST" id="bookingForm">
                @csrf
                
                <!-- Step 1: Pilih Layanan -->
                <div class="step-content card shadow mb-4" id="step1-content">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Pilih Layanan</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4">Silakan pilih layanan yang Anda butuhkan untuk hewan peliharaan Anda.</p>
                        
                        <div class="row g-4">
                            @forelse($services as $service)
                            <div class="col-md-6 col-lg-4">
                                <div class="service-card card h-100 border">
                                    <div class="card-body text-center p-4">
                                        <input type="radio" name="service_id" value="{{ $service->id }}" 
                                               id="service_{{ $service->id }}" class="service-radio d-none" 
                                               data-price="{{ $service->price ?? 0 }}" 
                                               data-duration="{{ $service->duration_minutes ?? 30 }}"
                                               data-service-name="{{ $service->name }}">
                                        <label for="service_{{ $service->id }}" class="card-label w-100 h-100 cursor-pointer">
                                            <div class="mb-3">
                                                <div class="service-icon bg-purple-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                                     style="width: 70px; height: 70px;">
                                                    <i class="{{ $service->icon ?? 'fas fa-stethoscope' }} fa-2x text-purple"></i>
                                                </div>
                                            </div>
                                            <h6 class="fw-bold text-purple mb-2">{{ $service->name }}</h6>
                                            <p class="small text-muted mb-3" style="min-height: 60px;">{{ $service->description }}</p>
                                            <div class="service-details">
                                                <div class="price mb-2">
                                                    @if($service->price)
                                                        <span class="fw-bold text-success">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                                    @else
                                                        <span class="fw-bold text-success">Konsultasi</span>
                                                    @endif
                                                </div>
                                                <div class="duration">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>{{ $service->duration_minutes ?? 30 }} menit
                                                    </small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-info-circle me-2"></i>Belum ada layanan tersedia. Silakan hubungi admin.
                                </div>
                            </div>
                            @endforelse
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-purple btn-next" data-next="step2">
                                Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Pilih Dokter & Jadwal -->
                <div class="step-content card shadow mb-4 d-none" id="step2-content">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0"><i class="fas fa-user-md me-2"></i>Pilih Dokter & Jadwal</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4">Pilih dokter yang tersedia dan tentukan jadwal kunjungan.</p>
                        
                        <div class="row">
                            <!-- Pilih Dokter -->
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold text-purple mb-3"><i class="fas fa-user-md me-2"></i>Pilih Dokter</h6>
                                <select class="form-select form-select-lg" name="doctor" id="doctorSelect" required disabled>
                                    <option value="">Pilih Dokter...</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor['id'] }}">{{ $doctor['name'] }} - {{ $doctor['specialization'] }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-1">Dokter yang tersedia akan disesuaikan dengan layanan yang dipilih</small>
                            </div>
                            
                            <!-- Info Dokter -->
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold text-purple mb-3"><i class="fas fa-info-circle me-2"></i>Info Dokter</h6>
                                <div id="doctorInfo" class="bg-light p-3 rounded">
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-user-md fa-2x mb-2"></i>
                                        <p class="mb-0">Pilih dokter untuk melihat informasi lengkap</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tanggal -->
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold text-purple mb-3"><i class="fas fa-calendar-alt me-2"></i>Tanggal Kunjungan</h6>
                                <input type="date" class="form-control form-control-lg" id="booking_date" name="booking_date" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required disabled>
                                <small class="text-muted mt-1">Minimal booking untuk besok hari</small>
                            </div>
                            
                            <!-- Waktu -->
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold text-purple mb-3"><i class="fas fa-clock me-2"></i>Waktu Kunjungan</h6>
                                <select class="form-select form-select-lg" id="booking_time" name="booking_time" required disabled>
                                    <option value="">Pilih Waktu...</option>
                                </select>
                                <div id="timeLoading" class="mt-2" style="display: none;">
                                    <div class="spinner-border spinner-border-sm text-purple" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <small class="text-muted ms-2">Memuat jam tersedia...</small>
                                </div>
                                <small class="text-muted mt-1">Waktu yang tersedia akan muncul setelah memilih dokter dan tanggal</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="step1">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </button>
                            <button type="button" class="btn btn-purple btn-next" data-next="step3" disabled>
                                Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Data Pemilik & Hewan -->
                <div class="step-content card shadow mb-4 d-none" id="step3-content">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pemilik & Hewan</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4">Lengkapi data pemilik dan hewan peliharaan Anda.</p>

                        <!-- Data Pemilik -->
                        <div class="mb-5">
                            <h6 class="fw-bold text-purple mb-3 border-bottom pb-2">
                                <i class="fas fa-user-tie me-2"></i>Data Pemilik
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_pemilik" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" 
                                           value="{{ old('nama_pemilik') }}" required>
                                    <div class="invalid-feedback" id="nama_pemilik_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required>
                                    <small class="text-muted">Contoh: nama@email.com</small>
                                    <div class="invalid-feedback" id="email_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telepon" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="telepon" name="telepon" 
                                           value="{{ old('telepon') }}" required>
                                    <small class="text-muted">Contoh: 081234567890</small>
                                    <div class="invalid-feedback" id="telepon_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label fw-bold">Alamat Rumah</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="2"
                                              placeholder="Contoh: Jl. Sudirman No 123">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Data Hewan -->
                        <div class="mb-5">
                            <h6 class="fw-bold text-purple mb-3 border-bottom pb-2">
                                <i class="fas fa-paw me-2"></i>Data Hewan Peliharaan
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_hewan" class="form-label fw-bold">Nama Hewan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_hewan" name="nama_hewan" 
                                           value="{{ old('nama_hewan') }}" required>
                                    <div class="invalid-feedback" id="nama_hewan_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_hewan" class="form-label fw-bold">Jenis Hewan <span class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_hewan" name="jenis_hewan" required>
                                        <option value="">Pilih Jenis Hewan</option>
                                        <option value="Anjing" {{ old('jenis_hewan') == 'Anjing' ? 'selected' : '' }}>Anjing</option>
                                        <option value="Kucing" {{ old('jenis_hewan') == 'Kucing' ? 'selected' : '' }}>Kucing</option>
                                        <option value="Burung" {{ old('jenis_hewan') == 'Burung' ? 'selected' : '' }}>Burung</option>
                                        <option value="Kelinci" {{ old('jenis_hewan') == 'Kelinci' ? 'selected' : '' }}>Kelinci</option>
                                        <option value="Hamster" {{ old('jenis_hewan') == 'Hamster' ? 'selected' : '' }}>Hamster</option>
                                        <option value="Lainnya" {{ old('jenis_hewan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    <div class="invalid-feedback" id="jenis_hewan_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ras" class="form-label fw-bold">Ras <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ras" name="ras" 
                                           value="{{ old('ras') }}" required placeholder="Contoh: Persian, Golden Retriever">
                                    <div class="invalid-feedback" id="ras_error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="umur" class="form-label fw-bold">Umur (bulan) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="umur" name="umur" 
                                           value="{{ old('umur') }}" required min="0" max="600">
                                    <small class="text-muted">Maksimal 50 tahun (600 bulan)</small>
                                    <div class="invalid-feedback" id="umur_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">Pilih Kelamin</option>
                                        <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                                        <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ciri_warna" class="form-label fw-bold">Ciri/Warna bulu</label>
                                    <input type="text" class="form-control" id="ciri_warna" name="ciri_warna" 
                                           value="{{ old('ciri_warna') }}" placeholder="Contoh: Putih corak hitam">
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-4">
                            <label for="catatan" class="form-label fw-bold text-purple">
                                <i class="fas fa-notes-medical me-2"></i>Catatan Tambahan
                            </label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                      placeholder="Berikan catatan khusus atau keluhan hewan (opsional)">{{ old('catatan') }}</textarea>
                            <small class="text-muted">Maksimal 500 karakter</small>
                        </div>

                        <!-- Ringkasan -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-purple mb-3">
                                    <i class="fas fa-clipboard-check me-2"></i>Ringkasan Pemesanan
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Layanan:</strong> <span id="summaryService" class="fw-bold text-purple">-</span></p>
                                        <p class="mb-2"><strong>Dokter:</strong> <span id="summaryDoctor" class="fw-bold">-</span></p>
                                        <p class="mb-2"><strong>Tanggal:</strong> <span id="summaryDate" class="fw-bold">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Waktu:</strong> <span id="summaryTime" class="fw-bold">-</span></p>
                                        <p class="mb-2"><strong>Estimasi Antrian:</strong> <span id="summaryQueue" class="fw-bold text-success">-</span></p>
                                        <p class="mb-0"><strong>Biaya:</strong> <span id="summaryPrice" class="fw-bold text-success fs-5">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="step2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-calendar-check me-2"></i>Konfirmasi Pemesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Progress Steps */
.steps {
    position: relative;
}

.steps::before {
    content: '';
    position: absolute;
    top: 35px;
    left: 50px;
    right: 50px;
    height: 2px;
    background-color: #e9ecef;
    z-index: 1;
}

.step {
    position: relative;
    z-index: 2;
    flex: 1;
}

.step-icon {
    width: 70px;
    height: 70px;
    font-size: 24px;
    font-weight: bold;
    margin: 0 auto;
}

.step.active .step-icon {
    background-color: #6f42c1 !important;
}

.step-title {
    font-size: 14px;
    margin-top: 8px;
    color: #6c757d;
}

.step.active .step-title {
    color: #6f42c1;
    font-weight: bold;
}

/* Service Card */
.service-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #6f42c1;
}

.service-radio:checked + .card-label {
    border: 2px solid #6f42c1;
    border-radius: 8px;
}

.service-icon {
    transition: all 0.3s ease;
}

.service-radio:checked + .card-label .service-icon {
    background-color: #6f42c1 !important;
}

.service-radio:checked + .card-label .service-icon i {
    color: white !important;
}

/* Colors */
.bg-purple {
    background-color: #6f42c1 !important;
}

.text-purple {
    color: #6f42c1 !important;
}

.bg-purple-light {
    background-color: rgba(111, 66, 193, 0.1);
}

.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}

.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: white;
}

.btn-purple:disabled {
    background-color: #6c757d;
    border-color: #6c757d;
    cursor: not-allowed;
}

/* Form Controls */
.form-control:focus, .form-select:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
}

/* Cursor */
.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data
    const doctors = @json($doctors);
    
    // State
    let currentStep = 1;
    let selectedService = null;
    
    // Initialize
    updateProgressSteps();
    
    // Progress Steps
    function updateProgressSteps() {
        document.querySelectorAll('.step').forEach(step => {
            const stepNumber = parseInt(step.getAttribute('data-step'));
            const stepIcon = step.querySelector('.step-icon');
            
            step.classList.remove('active');
            stepIcon.classList.remove('bg-purple');
            stepIcon.classList.add('bg-secondary');
            
            if (stepNumber <= currentStep) {
                step.classList.add('active');
                stepIcon.classList.remove('bg-secondary');
                stepIcon.classList.add('bg-purple');
            }
        });
    }
    
    // Show/Hide Steps
    function showStep(stepNumber) {
        // Hide all
        document.querySelectorAll('.step-content').forEach(content => {
            content.classList.add('d-none');
        });
        
        // Show selected
        const stepContent = document.getElementById(`step${stepNumber}-content`);
        if (stepContent) {
            stepContent.classList.remove('d-none');
            currentStep = stepNumber;
            updateProgressSteps();
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
    
    // Validasi Step 1 - Pilih Layanan
    function validateStep1() {
        return document.querySelector('input[name="service_id"]:checked') !== null;
    }
    
    // Validasi Step 2 - Dokter & Jadwal
    function validateStep2() {
        const doctor = document.getElementById('doctorSelect').value;
        const date = document.getElementById('booking_date').value;
        const time = document.getElementById('booking_time').value;
        
        return doctor && date && time;
    }
    
    // Validasi Step 3 - Data Form
    function validateStep3() {
        const requiredIds = ['nama_pemilik', 'email', 'telepon', 'nama_hewan', 'jenis_hewan', 'ras', 'umur'];
        
        // Cek field kosong
        for (let id of requiredIds) {
            const field = document.getElementById(id);
            if (!field || !field.value.trim()) {
                return false;
            }
        }
        
        // Validasi email
        const email = document.getElementById('email').value;
        if (!isValidEmail(email)) {
            return false;
        }
        
        // Validasi telepon
        const telepon = document.getElementById('telepon').value;
        if (!isValidPhone(telepon)) {
            return false;
        }
        
        // Validasi umur
        const umur = parseInt(document.getElementById('umur').value);
        if (umur < 0 || umur > 600) {
            return false;
        }
        
        return true;
    }
    
    // Validasi email
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    // Validasi telepon
    function isValidPhone(phone) {
        const re = /^[0-9]{10,13}$/;
        return re.test(phone);
    }
    
    // Update tombol next
    function updateNextButton() {
        const nextButton = document.querySelector(`#step${currentStep}-content .btn-next`);
        if (nextButton) {
            let isValid = false;
            
            switch(currentStep) {
                case 1:
                    isValid = validateStep1();
                    break;
                case 2:
                    isValid = validateStep2();
                    break;
                case 3:
                    // Di step 3, tombol next diganti dengan submit
                    break;
            }
            
            nextButton.disabled = !isValid;
        }
    }
    
    // Event Listeners untuk field
    function setupFieldListeners() {
        // Field untuk step 1
        document.querySelectorAll('.service-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                updateNextButton();
                if (this.checked) {
                    selectedService = {
                        id: this.value,
                        name: this.getAttribute('data-service-name'),
                        price: parseFloat(this.getAttribute('data-price')) || 0
                    };
                    
                    // Enable doctor selection
                    document.getElementById('doctorSelect').disabled = false;
                    updateSummary();
                }
            });
        });
        
        // Field untuk step 2
        const doctorSelect = document.getElementById('doctorSelect');
        const bookingDate = document.getElementById('booking_date');
        const bookingTime = document.getElementById('booking_time');
        
        if (doctorSelect) {
            doctorSelect.addEventListener('change', function() {
                const doctorId = this.value;
                
                if (doctorId && doctors[doctorId]) {
                    const doctor = doctors[doctorId];
                    
                    // Update info dokter
                    const doctorInfo = document.getElementById('doctorInfo');
                    doctorInfo.innerHTML = `
                        <h6 class="fw-bold text-purple">${doctor.name}</h6>
                        <p class="mb-1"><strong>Spesialisasi:</strong> ${doctor.specialization}</p>
                        <p class="mb-0"><strong>Jadwal:</strong> ${doctor.schedule}</p>
                    `;
                    
                    // Enable tanggal
                    bookingDate.disabled = false;
                    
                    // Reset waktu
                    bookingTime.disabled = true;
                    bookingTime.innerHTML = '<option value="">Pilih Waktu...</option>';
                    
                } else {
                    document.getElementById('doctorInfo').innerHTML = 
                        '<p class="text-muted mb-0">Pilih dokter untuk melihat informasi</p>';
                    
                    bookingDate.disabled = true;
                    bookingTime.disabled = true;
                    bookingDate.value = '';
                    bookingTime.innerHTML = '<option value="">Pilih Waktu...</option>';
                }
                
                updateNextButton();
                updateSummary();
            });
        }
        
        if (bookingDate) {
            bookingDate.addEventListener('change', function() {
                const date = this.value;
                const doctorId = doctorSelect.value;
                
                if (date && doctorId && doctors[doctorId]) {
                    loadAvailableHours(doctorId, date);
                } else {
                    bookingTime.disabled = true;
                    bookingTime.innerHTML = '<option value="">Pilih Waktu...</option>';
                }
                
                updateNextButton();
                updateSummary();
            });
        }
        
        if (bookingTime) {
            bookingTime.addEventListener('change', function() {
                updateNextButton();
                updateSummary();
            });
        }
        
        // Field untuk step 3
        const step3Fields = ['nama_pemilik', 'email', 'telepon', 'nama_hewan', 'jenis_hewan', 'ras', 'umur'];
        step3Fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', function() {
                    validateAndShowError(this);
                });
            }
        });
    }
    
    // Validasi dan tampilkan error
    function validateAndShowError(field) {
        const fieldId = field.id;
        const value = field.value.trim();
        
        // Hapus error sebelumnya
        hideError(fieldId);
        
        // Validasi berdasarkan field
        if (!value) {
            showError(fieldId, 'Field ini wajib diisi');
            return false;
        }
        
        switch(fieldId) {
            case 'email':
                if (!isValidEmail(value)) {
                    showError(fieldId, 'Format email tidak valid');
                    return false;
                }
                break;
                
            case 'telepon':
                if (!isValidPhone(value)) {
                    showError(fieldId, 'Nomor telepon harus 10-13 digit angka');
                    return false;
                }
                break;
                
            case 'umur':
                const umur = parseInt(value);
                if (umur < 0 || umur > 600) {
                    showError(fieldId, 'Umur harus antara 0-600 bulan');
                    return false;
                }
                break;
        }
        
        return true;
    }
    
    // Tampilkan error
    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.id = `error-${fieldId}`;
        errorDiv.textContent = message;
        
        field.classList.add('is-invalid');
        field.parentNode.appendChild(errorDiv);
    }
    
    // Sembunyikan error
    function hideError(fieldId) {
        const errorDiv = document.getElementById(`error-${fieldId}`);
        if (errorDiv) {
            errorDiv.remove();
        }
        const field = document.getElementById(fieldId);
        if (field) {
            field.classList.remove('is-invalid');
        }
    }
    
    // Load jam tersedia
    function loadAvailableHours(doctorId, date) {
        const timeSelect = document.getElementById('booking_time');
        const loadingDiv = document.getElementById('timeLoading');
        
        timeSelect.disabled = true;
        timeSelect.innerHTML = '<option value="">Memuat jam tersedia...</option>';
        if (loadingDiv) loadingDiv.style.display = 'block';
        
        fetch(`/online-services/available-hours?doctor=${doctorId}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                timeSelect.innerHTML = '<option value="">Pilih Waktu...</option>';
                
                if (data.available_hours && data.available_hours.length > 0) {
                    data.available_hours.forEach(hour => {
                        const option = document.createElement('option');
                        option.value = hour;
                        option.textContent = hour;
                        timeSelect.appendChild(option);
                    });
                    timeSelect.disabled = false;
                } else {
                    timeSelect.innerHTML = '<option value="">Tidak ada jam tersedia</option>';
                    timeSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                timeSelect.innerHTML = '<option value="">Error memuat jam</option>';
                timeSelect.disabled = true;
            })
            .finally(() => {
                if (loadingDiv) loadingDiv.style.display = 'none';
            });
    }
    
    // Update summary
    function updateSummary() {
        // Service
        if (selectedService) {
            document.getElementById('summaryService').textContent = selectedService.name;
            document.getElementById('summaryPrice').textContent = selectedService.price > 0 ? 
                'Rp ' + selectedService.price.toLocaleString('id-ID') : 'Konsultasi';
        }
        
        // Doctor
        const doctorId = document.getElementById('doctorSelect')?.value;
        if (doctorId && doctors[doctorId]) {
            document.getElementById('summaryDoctor').textContent = doctors[doctorId].name;
        } else {
            document.getElementById('summaryDoctor').textContent = '-';
        }
        
        // Date
        const date = document.getElementById('booking_date')?.value;
        if (date) {
            const dateObj = new Date(date);
            document.getElementById('summaryDate').textContent = dateObj.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        } else {
            document.getElementById('summaryDate').textContent = '-';
        }
        
        // Time
        const time = document.getElementById('booking_time')?.value;
        if (time) {
            document.getElementById('summaryTime').textContent = time;
        } else {
            document.getElementById('summaryTime').textContent = '-';
        }
        
        // Queue estimation
        updateQueueEstimation();
    }
    
    // Estimasi antrian
    function updateQueueEstimation() {
        const queueElement = document.getElementById('summaryQueue');
        
        if (!selectedService) {
            queueElement.textContent = '-';
            return;
        }
        
        // Estimasi sederhana
        const estimations = {
            15: '5-15 menit',
            20: '10-20 menit',
            25: '10-25 menit',
            30: '15-30 menit',
            45: '30-45 menit',
            60: '45-60 menit',
            90: '60-90 menit'
        };
        
        // Ambil durasi dari radio button yang dipilih
        const selectedRadio = document.querySelector('input[name="service_id"]:checked');
        const duration = selectedRadio ? parseInt(selectedRadio.getAttribute('data-duration')) || 30 : 30;
        
        queueElement.textContent = estimations[duration] || '15-30 menit';
    }
    
    // Setup button events
    function setupButtonEvents() {
        // Next buttons
        document.querySelectorAll('.btn-next').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const nextStep = this.getAttribute('data-next');
                const stepNumber = parseInt(nextStep.replace('step', ''));
                
                let isValid = false;
                switch(currentStep) {
                    case 1:
                        isValid = validateStep1();
                        break;
                    case 2:
                        isValid = validateStep2();
                        break;
                }
                
                if (isValid) {
                    showStep(stepNumber);
                    updateNextButton();
                    
                    // Update summary di step 3
                    if (stepNumber === 3) {
                        updateSummary();
                    }
                } else {
                    alert('Silakan lengkapi data terlebih dahulu!');
                }
            });
        });
        
        // Previous buttons
        document.querySelectorAll('.btn-prev').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const prevStep = this.getAttribute('data-prev');
                const stepNumber = parseInt(prevStep.replace('step', ''));
                
                showStep(stepNumber);
                updateNextButton();
            });
        });
        
        // Form submission
        const bookingForm = document.getElementById('bookingForm');
        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                // Validasi final sebelum submit
                if (currentStep === 3) {
                    const isValid = validateStep3();
                    
                    if (!isValid) {
                        e.preventDefault();
                        alert('Silakan lengkapi semua data dengan benar!');
                        
                        // Tampilkan semua error
                        const requiredIds = ['nama_pemilik', 'email', 'telepon', 'nama_hewan', 'jenis_hewan', 'ras', 'umur'];
                        requiredIds.forEach(fieldId => {
                            const field = document.getElementById(fieldId);
                            if (field && !field.value.trim()) {
                                showError(fieldId, 'Field ini wajib diisi');
                            }
                        });
                        
                        // Validasi khusus
                        const email = document.getElementById('email');
                        if (email && email.value.trim() && !isValidEmail(email.value)) {
                            showError('email', 'Format email tidak valid');
                        }
                        
                        const telepon = document.getElementById('telepon');
                        if (telepon && telepon.value.trim() && !isValidPhone(telepon.value)) {
                            showError('telepon', 'Nomor telepon harus 10-13 digit angka');
                        }
                        
                        return false;
                    }
                }
                
                // Jika semua valid, lanjutkan submit
                return true;
            });
        }
    }
    
    // Initialize semua
    function init() {
        setupFieldListeners();
        setupButtonEvents();
        updateNextButton();
    }
    
    // Jalankan init
    init();
});
</script>
@endsection

