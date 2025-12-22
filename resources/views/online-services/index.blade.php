@extends('layouts.app')

@section('title', 'Pemesanan Layanan Online - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="fw-bold text-purple">Pemesanan Layanan Online</h1>
                <p class="lead text-muted">Pilih layanan dan jadwalkan kunjungan untuk hewan kesayangan Anda</p>
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

            <form action="{{ route('online-services.book') }}" method="POST" id="bookingForm">
                @csrf

                <!-- Step 1: Pilih Layanan -->
                <div class="card shadow mb-4" id="step1">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0">Pilih Layanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @foreach($services as $key => $service)
                            <div class="col-md-6">
                                <div class="service-option card h-100 border">
                                    <div class="card-body text-center">
                                        <input type="radio" name="service_type" value="{{ $key }}" 
                                               id="service_{{ $key }}" class="service-radio d-none" 
                                               data-price="{{ $service['price'] }}" 
                                               data-duration="{{ $service['duration'] }}">
                                        <label for="service_{{ $key }}" class="card-label w-100 h-100 cursor-pointer">
                                            <div class="mb-3">
                                                <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas 
                                                        @if($key == 'vaksinasi') fa-syringe
                                                        @elseif($key == 'konsultasi_umum') fa-stethoscope
                                                        @elseif($key == 'grooming') fa-spa
                                                        @elseif($key == 'perawatan_gigi') fa-tooth
                                                        @elseif($key == 'pemeriksaan_darah') fa-tint
                                                        @elseif($key == 'sterilisasi') fa-cut
                                                        @endif 
                                                        text-white fs-4"></i>
                                                </div>
                                            </div>
                                            <h6 class="fw-bold text-purple">{{ $service['name'] }}</h6>
                                            <p class="small text-muted mb-2">{{ $service['description'] }}</p>
                                            <div class="service-info">
                                                <span class="badge bg-success">Rp {{ number_format($service['price'], 0, ',', '.') }}</span>
                                                <span class="badge bg-info text-dark">{{ $service['duration'] }} menit</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-purple next-step" data-next="step2">Selanjutnya</button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Pilih Dokter & Jadwal -->
                <div class="card shadow mb-4" id="step2" style="display: none;">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0">Pilih Dokter & Jadwal</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-purple">Pilih Dokter</h6>
                                <select class="form-select" name="doctor" id="doctorSelect" required>
                                    <option value="">Pilih Dokter...</option>
                                    @foreach($doctors as $key => $doctor)
                                    <option value="{{ $key }}">{{ $doctor['name'] }} - {{ $doctor['specialization'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-purple">Info Dokter</h6>
                                <div id="doctorInfo" class="text-muted small">
                                    Pilih dokter untuk melihat jadwal praktek
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_date" class="form-label fw-bold text-purple">Tanggal Kunjungan</label>
                                    <input type="date" class="form-control" id="booking_date" name="booking_date" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_time" class="form-label fw-bold text-purple">Waktu Kunjungan</label>
                                    <select class="form-select" id="booking_time" name="booking_time" required>
                                        <option value="">Pilih Waktu...</option>
                                        <option value="08:00">08:00</option>
                                        <option value="09:00">09:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step" data-prev="step1">Kembali</button>
                            <button type="button" class="btn btn-purple next-step" data-next="step3">Selanjutnya</button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Data Pemilik & Hewan -->
                <div class="card shadow mb-4" id="step3" style="display: none;">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0">Data Pemilik & Hewan</h5>
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="fw-bold text-purple mb-3">Data Pemilik</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pemilik" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" 
                                           value="{{ old('nama_pemilik') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div> --}}
                        
                        {{-- <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon" class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control" id="telepon" name="telepon" 
                                           value="{{ old('telepon') }}" required>
                                </div>
                            </div>
                        </div> --}}

                        <h6 class="fw-bold text-purple mb-3">Data Hewan Peliharaan</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_hewan" class="form-label">Nama Hewan *</label>
                                    <input type="text" class="form-control" id="nama_hewan" name="nama_hewan" 
                                           value="{{ old('nama_hewan') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_hewan" class="form-label">Jenis Hewan *</label>
                                    <select class="form-control" id="jenis_hewan" name="jenis_hewan" required>
                                        <option value="">Pilih Jenis Hewan</option>
                                        <option value="Anjing" {{ old('jenis_hewan') == 'Anjing' ? 'selected' : '' }}>Anjing</option>
                                        <option value="Kucing" {{ old('jenis_hewan') == 'Kucing' ? 'selected' : '' }}>Kucing</option>
                                        <option value="Burung" {{ old('jenis_hewan') == 'Burung' ? 'selected' : '' }}>Burung</option>
                                        <option value="Kelinci" {{ old('jenis_hewan') == 'Kelinci' ? 'selected' : '' }}>Kelinci</option>
                                        <option value="Hamster" {{ old('jenis_hewan') == 'Hamster' ? 'selected' : '' }}>Hamster</option>
                                        <option value="Lainnya" {{ old('jenis_hewan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ras" class="form-label">Ras *</label>
                                    <input type="text" class="form-control" id="ras" name="ras" 
                                           value="{{ old('ras') }}" required placeholder="Contoh: Persian, Golden Retriever">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur" class="form-label">Umur (bulan) *</label>
                                    <input type="number" class="form-control" id="umur" name="umur" 
                                           value="{{ old('umur') }}" required min="0" max="300">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="catatan" class="form-label fw-bold text-purple">Catatan Tambahan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                      placeholder="Berikan catatan khusus atau keluhan hewan (opsional)">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Summary -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold text-purple">Ringkasan Pemesanan</h6>
                                <div id="bookingSummary">
                                    <p class="mb-1">Layanan: <span id="summaryService" class="fw-bold">-</span></p>
                                    <p class="mb-1">Dokter: <span id="summaryDoctor" class="fw-bold">-</span></p>
                                    <p class="mb-1">Tanggal: <span id="summaryDate" class="fw-bold">-</span></p>
                                    <p class="mb-1">Waktu: <span id="summaryTime" class="fw-bold">-</span></p>
                                    <p class="mb-1">Estimasi Antrian: <span id="summaryQueue" class="fw-bold text-success">-</span></p>
                                    <p class="mb-0">Biaya: <span id="summaryPrice" class="fw-bold">-</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step" data-prev="step2">Kembali</button>
                            <button type="submit" class="btn btn-success">Konfirmasi Pemesanan</button>
                        </div>
                    </div>
                </div>
            </form>
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
.service-option .card-label {
    cursor: pointer;
    transition: all 0.3s ease;
}
.service-option .card-label:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.service-radio:checked + .card-label {
    border: 2px solid #6f42c1;
    background-color: #f8f9ff;
}
.cursor-pointer {
    cursor: pointer;
}

/* Style untuk alert validasi */
.step-validation-alert {
    margin-bottom: 20px;
    border-radius: 10px;
}

/* Style untuk field valid */
.is-valid {
    border-color: #198754 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Style untuk field invalid */
.is-invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6.4.4.4-.4'/%3e%3cpath d='M6 7v2'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.invalid-feedback.d-block {
    display: block;
}

/* Style untuk form group */
.form-group {
    margin-bottom: 1.5rem;
}

/* Tooltip untuk contoh email */
.email-example {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Style untuk tombol yang disabled */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Highlight untuk field yang required */
.form-label:after {
    content: " *";
    color: #dc3545;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Step navigation
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    
    nextButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const currentStep = this.closest('.card');
            const nextStepId = this.getAttribute('data-next');
            const currentStepId = currentStep.id;
            
            // Validasi berdasarkan step
            if (!validateStep(currentStepId)) {
                return false;
            }
            
            const nextStep = document.getElementById(nextStepId);
            currentStep.style.display = 'none';
            nextStep.style.display = 'block';
            
            // Scroll ke atas
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
    
    prevButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const currentStep = this.closest('.card');
            const prevStepId = this.getAttribute('data-prev');
            const prevStep = document.getElementById(prevStepId);
            
            currentStep.style.display = 'none';
            prevStep.style.display = 'block';
            
            // Scroll ke atas
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Fungsi validasi step
    function validateStep(stepId) {
        switch(stepId) {
            case 'step1':
                return validateStep1();
            case 'step2':
                return validateStep2();
            case 'step3':
                return validateStep3();
            default:
                return true;
        }
    }

    // Validasi Step 1: Pilih Layanan
    function validateStep1() {
        const selectedService = document.querySelector('input[name="service_type"]:checked');
        return !!selectedService;
    }

    // Validasi Step 2: Pilih Dokter & Jadwal
    function validateStep2() {
        const selectedDoctor = document.getElementById('doctorSelect').value;
        const selectedDate = document.getElementById('booking_date').value;
        const selectedTime = document.getElementById('booking_time').value;
        
        return !!(selectedDoctor && selectedDate && selectedTime);
    }

    // Validasi Step 3: Data Pemilik & Hewan
    function validateStep3() {
        const requiredFields = [
            { id: 'nama_pemilik', name: 'Nama Lengkap' },
            { id: 'email', name: 'Email' },
            { id: 'telepon', name: 'Nomor Telepon' },
            { id: 'nama_hewan', name: 'Nama Hewan' },
            { id: 'jenis_hewan', name: 'Jenis Hewan' },
            { id: 'ras', name: 'Ras' },
            { id: 'umur', name: 'Umur' }
        ];
        
        for (let field of requiredFields) {
            const element = document.getElementById(field.id);
            if (!element.value.trim()) {
                return false;
            }
        }
        
        // Validasi email format
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            return false;
        }
        
        // Validasi domain email
        if (!isValidEmailDomain(email)) {
            return false;
        }
        
        // Validasi telepon
        const telepon = document.getElementById('telepon').value.trim();
        const teleponRegex = /^[0-9]{10,15}$/;
        if (!teleponRegex.test(telepon)) {
            return false;
        }
        
        // Validasi umur
        const umur = document.getElementById('umur').value;
        if (umur < 0 || umur > 300) {
            return false;
        }
        
        return true;
    }

    // Fungsi validasi domain email
    function isValidEmailDomain(email) {
        const validDomains = [
            '.com', '.net', '.org', '.id', '.co.id', '.ac.id', 
            '.sch.id', '.go.id', '.mil.id', '.web.id', '.my.id',
            '.biz', '.info', '.xyz', '.site', '.online', '.store',
            '.io', '.me', '.tv', '.app', '.dev'
        ];
        
        const domain = email.substring(email.lastIndexOf('.'));
        return validDomains.some(validDomain => domain.toLowerCase().includes(validDomain));
    }

    // Service selection dengan validasi real-time dan update dokter
    const serviceRadios = document.querySelectorAll('.service-radio');
    const doctorSelect = document.getElementById('doctorSelect');
    const doctorInfo = document.getElementById('doctorInfo');
    const bookingDate = document.getElementById('booking_date');
    const bookingTime = document.getElementById('booking_time');
    
    // Data services dengan dokter yang available
    const serviceData = {
        @foreach($services as $key => $service)
        '{{ $key }}': {
            name: '{{ $service["name"] }}',
            price: {{ $service["price"] }},
            available_doctors: {!! json_encode($service['available_doctors'] ?? []) !!}
        },
        @endforeach
    };

    // Doctor schedule data
    const doctorSchedules = {
        @foreach($doctors as $key => $doctor)
        '{{ $key }}': {
            name: '{{ $doctor["name"] }}',
            specialization: '{{ $doctor["specialization"] }}',
            info: `Jadwal: {{ $doctor['schedule'][0] }} ({{ $doctor['schedule'][1] }})`,
            days: {!! json_encode($doctor['available_days'] ?? []) !!},
            hours: {!! json_encode($doctor['available_hours'] ?? []) !!},
            services: {!! json_encode($doctor['services'] ?? []) !!}
        },
        @endforeach
    };

    // Service selection event
    serviceRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                updateDoctorsForService(this.value);
                updateSummary();
            }
            updateNextButtonState('step1', !!this.checked);
        });
    });

    // Fungsi untuk update dropdown dokter berdasarkan layanan
    function updateDoctorsForService(serviceType) {
        // Reset dokter selection
        doctorSelect.innerHTML = '<option value="">Pilih Dokter...</option>';
        doctorInfo.textContent = 'Pilih dokter untuk melihat jadwal praktek';
        doctorInfo.className = 'text-muted small';
        
        // Reset tanggal dan jam
        bookingDate.value = '';
        bookingTime.innerHTML = '<option value="">Pilih Waktu...</option>';
        bookingTime.disabled = true;
        bookingDate.disabled = true;

        if (!serviceType || !serviceData[serviceType]) {
            return;
        }

        const availableDoctors = serviceData[serviceType].available_doctors;
        
        if (availableDoctors && availableDoctors.length > 0) {
            availableDoctors.forEach(doctorId => {
                if (doctorSchedules[doctorId]) {
                    const doctor = doctorSchedules[doctorId];
                    const option = document.createElement('option');
                    option.value = doctorId;
                    option.textContent = `${doctor.name} - ${doctor.specialization}`;
                    option.setAttribute('data-specialization', doctor.specialization);
                    doctorSelect.appendChild(option);
                }
            });
            
            // Enable dokter selection
            doctorSelect.disabled = false;
        } else {
            doctorSelect.innerHTML = '<option value="">Tidak ada dokter tersedia</option>';
            doctorSelect.disabled = true;
        }
        
        updateNextButtonState('step2', validateStep2());
    }

    // Update info dokter saat dokter dipilih
    doctorSelect.addEventListener('change', function() {
        const selectedDoctor = this.value;
        
        if (selectedDoctor && doctorSchedules[selectedDoctor]) {
            const doctor = doctorSchedules[selectedDoctor];
            doctorInfo.textContent = doctor.info;
            doctorInfo.className = 'text-success small';
            
            // Reset tanggal dan jam
            bookingDate.value = '';
            bookingTime.innerHTML = '<option value="">Pilih Waktu...</option>';
            bookingTime.disabled = true;
            
            // Set minimum date berdasarkan hari kerja dokter
            setMinDateForDoctor(selectedDoctor);
        } else {
            doctorInfo.textContent = 'Pilih dokter untuk melihat jadwal praktek';
            doctorInfo.className = 'text-muted small';
            bookingTime.disabled = true;
            bookingDate.disabled = true;
        }
        
        updateSummary();
        updateNextButtonState('step2', validateStep2());
    });

    // Update jam tersedia saat tanggal dipilih
    bookingDate.addEventListener('change', function() {
        const selectedDoctor = doctorSelect.value;
        const selectedDate = this.value;
        
        if (selectedDoctor && selectedDate) {
            loadAvailableHours(selectedDoctor, selectedDate);
        } else {
            bookingTime.disabled = true;
            bookingTime.innerHTML = '<option value="">Pilih Waktu...</option>';
        }
        
        updateSummary();
        updateNextButtonState('step2', validateStep2());
    });

    // Time selection
    bookingTime.addEventListener('change', function() {
        updateSummary();
        updateNextButtonState('step2', validateStep2());
    });

    // Real-time validation untuk step 3
    const step3Fields = ['nama_pemilik', 'email', 'telepon', 'nama_hewan', 'jenis_hewan', 'ras', 'umur'];
    step3Fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                const value = this.value.trim();
                
                // Validasi real-time untuk email
                if (fieldId === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    const isValidFormat = emailRegex.test(value);
                    const isValidDomain = isValidEmailDomain(value);
                    
                    if (!isValidFormat || !isValidDomain) {
                        field.classList.add('is-invalid');
                        showFieldError('email', 'Format email tidak valid! Contoh: nama@email.com');
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                        hideFieldError('email');
                    }
                }
                
                // Validasi real-time untuk telepon
                if (fieldId === 'telepon' && value) {
                    const teleponRegex = /^[0-9]{10,15}$/;
                    if (!teleponRegex.test(value)) {
                        field.classList.add('is-invalid');
                        showFieldError('telepon', 'Nomor telepon harus 10-15 digit angka');
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                        hideFieldError('telepon');
                    }
                }
                
                // Validasi real-time untuk field required lainnya
                if (value && fieldId !== 'email' && fieldId !== 'telepon') {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                    hideFieldError(fieldId);
                } else if (!value && fieldId !== 'email' && fieldId !== 'telepon') {
                    field.classList.remove('is-valid');
                    field.classList.remove('is-invalid');
                    hideFieldError(fieldId);
                }
                
                // Validasi umur
                if (fieldId === 'umur' && value) {
                    const umurValue = parseInt(value);
                    if (umurValue < 0 || umurValue > 300) {
                        field.classList.add('is-invalid');
                        showFieldError('umur', 'Umur harus antara 0 - 300 bulan');
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                        hideFieldError('umur');
                    }
                }
                
                updateNextButtonState('step3', validateStep3());
            });
        }
    });

    // Fungsi untuk menampilkan error di bawah field
    function showFieldError(fieldId, message) {
        // Hapus error sebelumnya
        hideFieldError(fieldId);
        
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.id = `error-${fieldId}`;
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }

    // Fungsi untuk menghapus error di bawah field
    function hideFieldError(fieldId) {
        const existingError = document.getElementById(`error-${fieldId}`);
        if (existingError) {
            existingError.remove();
        }
    }

    // Fungsi untuk update state tombol next
    function updateNextButtonState(stepId, isValid) {
        const nextButton = document.querySelector(`#${stepId} .next-step`);
        if (nextButton) {
            if (isValid) {
                nextButton.disabled = false;
                nextButton.classList.remove('btn-secondary');
                nextButton.classList.add('btn-purple');
            } else {
                nextButton.disabled = true;
                nextButton.classList.remove('btn-purple');
                nextButton.classList.add('btn-secondary');
            }
        }
    }

    // Fungsi untuk set minimum date berdasarkan hari kerja dokter
    function setMinDateForDoctor(doctorId) {
        const doctor = doctorSchedules[doctorId];
        if (!doctor) return;

        const today = new Date();
        let minDate = new Date(today);
        minDate.setDate(today.getDate() + 1); // Minimal besok
        
        // Cari tanggal terdekat yang sesuai dengan jadwal dokter
        let foundDate = false;
        let checkDate = new Date(minDate);
        
        for (let i = 0; i < 14; i++) { // Cek 14 hari ke depan
            const dayName = checkDate.toLocaleDateString('en-US', { weekday: 'long' });
            
            if (doctor.days.includes(dayName)) {
                // Format date untuk input type="date"
                const formattedDate = checkDate.toISOString().split('T')[0];
                bookingDate.min = formattedDate;
                foundDate = true;
                break;
            }
            
            checkDate.setDate(checkDate.getDate() + 1);
        }
        
        if (!foundDate) {
            bookingDate.min = minDate.toISOString().split('T')[0];
        }
        
        bookingDate.disabled = false;
    }

    // Fungsi untuk memuat jam tersedia
    function loadAvailableHours(doctorId, date) {
        bookingTime.disabled = true;
        bookingTime.innerHTML = '<option value="">Memuat jam tersedia...</option>';

        fetch(`/online-services/available-hours?doctor=${doctorId}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                bookingTime.innerHTML = '<option value="">Pilih Waktu...</option>';
                
                if (data.available_hours && data.available_hours.length > 0) {
                    data.available_hours.forEach(hour => {
                        const option = document.createElement('option');
                        option.value = hour;
                        option.textContent = hour;
                        bookingTime.appendChild(option);
                    });
                    bookingTime.disabled = false;
                } else {
                    bookingTime.innerHTML = '<option value="">Tidak ada jam tersedia</option>';
                    bookingTime.disabled = true;
                }
                
                updateNextButtonState('step2', validateStep2());
            })
            .catch(error => {
                console.error('Error loading available hours:', error);
                bookingTime.innerHTML = '<option value="">Error memuat jam</option>';
                bookingTime.disabled = true;
                updateNextButtonState('step2', validateStep2());
            });
    }

    // Form data for summary
    const doctorData = {
        @foreach($doctors as $key => $doctor)
        '{{ $key }}': '{{ $doctor["name"] }} - {{ $doctor["specialization"] }}',
        @endforeach
    };

    function updateSummary() {
        const selectedService = document.querySelector('input[name="service_type"]:checked');
        const selectedDoctor = doctorSelect.value;
        const selectedDate = bookingDate.value;
        const selectedTime = bookingTime.value;

        if (selectedService) {
            const service = serviceData[selectedService.value];
            document.getElementById('summaryService').textContent = service.name;
            document.getElementById('summaryPrice').textContent = 'Rp ' + service.price.toLocaleString('id-ID');
        } else {
            document.getElementById('summaryService').textContent = '-';
            document.getElementById('summaryPrice').textContent = '-';
        }

        if (selectedDoctor) {
            document.getElementById('summaryDoctor').textContent = doctorData[selectedDoctor];
        } else {
            document.getElementById('summaryDoctor').textContent = '-';
        }

        if (selectedDate) {
            const date = new Date(selectedDate);
            document.getElementById('summaryDate').textContent = date.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        } else {
            document.getElementById('summaryDate').textContent = '-';
        }

        if (selectedTime) {
            document.getElementById('summaryTime').textContent = selectedTime;
        } else {
            document.getElementById('summaryTime').textContent = '-';
        }

        // Update estimasi antrian
        updateQueueEstimation(selectedService?.value, selectedDate);
    }

    // Fungsi untuk update estimasi antrian
    function updateQueueEstimation(serviceType, date) {
        const queueElement = document.getElementById('summaryQueue');
        
        if (!serviceType || !date) {
            queueElement.textContent = '-';
            return;
        }

        const estimations = {
            'vaksinasi': '5-10 menit',
            'konsultasi_umum': '15-30 menit', 
            'grooming': '30-45 menit',
            'perawatan_gigi': '20-35 menit',
            'pemeriksaan_darah': '10-20 menit',
            'sterilisasi': '45-60 menit'
        };

        queueElement.textContent = estimations[serviceType] || '15-30 menit';
    }

    // Validasi form submission
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if (!validateStep3()) {
            e.preventDefault();
            // Scroll ke step 3 jika ada error
            document.getElementById('step3').scrollIntoView({ behavior: 'smooth' });
        }
    });

    // Initialize - disable dokter selection awalnya
    doctorSelect.disabled = true;
    bookingDate.disabled = true;
    bookingTime.disabled = true;

    // Initialize summary dan disable tombol next awalnya
    updateSummary();
    updateNextButtonState('step1', false);
    updateNextButtonState('step2', false);
    updateNextButtonState('step3', false);
});
</script>
@endsection