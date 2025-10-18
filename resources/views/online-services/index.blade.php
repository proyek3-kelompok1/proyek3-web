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
                        <h5 class="mb-0">Step 1: Pilih Layanan</h5>
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
                            <button type="button" class="btn btn-purple next-step" data-next="step2">Lanjut ke Step 2</button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Pilih Dokter & Jadwal -->
                <div class="card shadow mb-4" id="step2" style="display: none;">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0">Step 2: Pilih Dokter & Jadwal</h5>
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
                            <button type="button" class="btn btn-purple next-step" data-next="step3">Lanjut ke Step 3</button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Data Pemilik & Hewan -->
                <div class="card shadow mb-4" id="step3" style="display: none;">
                    <div class="card-header bg-purple text-white">
                        <h5 class="mb-0">Step 3: Data Pemilik & Hewan</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold text-purple mb-3">Data Pemilik</h6>
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
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon" class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control" id="telepon" name="telepon" 
                                           value="{{ old('telepon') }}" required>
                                </div>
                            </div>
                        </div>

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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Step navigation
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentStep = this.closest('.card');
            const nextStepId = this.getAttribute('data-next');
            const nextStep = document.getElementById(nextStepId);
            
            currentStep.style.display = 'none';
            nextStep.style.display = 'block';
        });
    });
    
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentStep = this.closest('.card');
            const prevStepId = this.getAttribute('data-prev');
            const prevStep = document.getElementById(prevStepId);
            
            currentStep.style.display = 'none';
            prevStep.style.display = 'block';
        });
    });

    // Service selection
    const serviceRadios = document.querySelectorAll('.service-radio');
    serviceRadios.forEach(radio => {
        radio.addEventListener('change', updateSummary);
    });

    // Doctor selection
    const doctorSelect = document.getElementById('doctorSelect');
    const doctorInfo = document.getElementById('doctorInfo');
    
    // Doctor schedule data
    const doctorSchedules = {
        @foreach($doctors as $key => $doctor)
        '{{ $key }}': `Jadwal: {{ $doctor['schedule'][0] }} ({{ $doctor['schedule'][1] }})`,
        @endforeach
    };

    doctorSelect.addEventListener('change', function() {
        const selectedDoctor = this.value;
        if (selectedDoctor && doctorSchedules[selectedDoctor]) {
            doctorInfo.textContent = doctorSchedules[selectedDoctor];
            doctorInfo.className = 'text-success small';
        } else {
            doctorInfo.textContent = 'Pilih dokter untuk melihat jadwal praktek';
            doctorInfo.className = 'text-muted small';
        }
        updateSummary();
    });

    // Date and time selection
    document.getElementById('booking_date').addEventListener('change', updateSummary);
    document.getElementById('booking_time').addEventListener('change', updateSummary);

    // Form data for summary
    const serviceData = {
        @foreach($services as $key => $service)
        '{{ $key }}': {
            name: '{{ $service["name"] }}',
            price: {{ $service["price"] }}
        },
        @endforeach
    };

    const doctorData = {
        @foreach($doctors as $key => $doctor)
        '{{ $key }}': '{{ $doctor["name"] }}',
        @endforeach
    };

    function updateSummary() {
        const selectedService = document.querySelector('input[name="service_type"]:checked');
        const selectedDoctor = doctorSelect.value;
        const selectedDate = document.getElementById('booking_date').value;
        const selectedTime = document.getElementById('booking_time').value;

        if (selectedService) {
            const service = serviceData[selectedService.value];
            document.getElementById('summaryService').textContent = service.name;
            document.getElementById('summaryPrice').textContent = 'Rp ' + service.price.toLocaleString('id-ID');
        }

        if (selectedDoctor) {
            document.getElementById('summaryDoctor').textContent = doctorData[selectedDoctor];
        }

        if (selectedDate) {
            const date = new Date(selectedDate);
            document.getElementById('summaryDate').textContent = date.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        if (selectedTime) {
            document.getElementById('summaryTime').textContent = selectedTime;
        }
    }

    // Initialize summary
    updateSummary();
});
</script>
@endsection