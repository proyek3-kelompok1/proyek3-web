@extends('layouts.app')

@section('title', 'Layanan')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold text-purple mb-4">Layanan Kami</h1>
                    <p class="lead">Berbagai layanan kesehatan hewan yang kami sediakan untuk kebutuhan hewan peliharaan Anda</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Konsultasi Umum -->
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100" onclick="showServiceDetail('konsultasi-umum')" style="cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-stethoscope text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Konsultasi Umum</h5>
                            <p class="card-text">Pemeriksaan kesehatan rutin, diagnosis penyakit, dan konsultasi kesehatan untuk hewan peliharaan Anda.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-purple">Klik untuk detail</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Vaksinasi -->
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100" onclick="showServiceDetail('vaksinasi')" style="cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-syringe text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Vaksinasi</h5>
                            <p class="card-text">Program vaksinasi lengkap untuk melindungi hewan dari berbagai penyakit menular.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-purple">Klik untuk detail</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Perawatan Gigi -->
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100" onclick="showServiceDetail('dental-care')" style="cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-tooth text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Perawatan Gigi</h5>
                            <p class="card-text">Pembersihan karang gigi, pencabutan gigi, dan perawatan kesehatan mulut lainnya.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-purple">Klik untuk detail</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Operasi -->
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100" onclick="showServiceDetail('operasi')" style="cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-cut text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Operasi</h5>
                            <p class="card-text">Tindakan operasi baik elektif maupun darurat dengan standar keamanan tinggi.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-purple">Klik untuk detail</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Laboratorium -->
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100" onclick="showServiceDetail('pemeriksaan-lab')" style="cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-microscope text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Laboratorium</h5>
                            <p class="card-text">Pemeriksaan darah, urin, feses, dan tes diagnostik lainnya untuk mendukung diagnosis.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-purple">Klik untuk detail</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rawat Inap -->
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100" onclick="showServiceDetail('rawat-inap')" style="cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-home text-white"></i>
                            </div>
                            <h5 class="card-title fw-bold">Rawat Inap</h5>
                            <p class="card-text">Fasilitas rawat inap yang nyaman untuk hewan yang membutuhkan perawatan intensif.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-purple">Klik untuk detail</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk Detail Layanan -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-purple" id="serviceModalLabel"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="serviceContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <a href="{{ url('/consultations') }}" class="btn btn-purple">
                        <i class="fas fa-calendar-check me-2"></i>Booking Layanan
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <style>
        .service-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(106, 48, 147, 0.2);
            border-color: #6a3093;
        }

        .text-purple {
            color: #6a3093 !important;
        }

        .bg-purple {
            background: linear-gradient(135deg, #6a3093, #8a4dcc) !important;
        }

        .btn-purple {
            background: linear-gradient(135deg, #6a3093, #8a4dcc);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-purple:hover {
            background: linear-gradient(135deg, #8a4dcc, #6a3093);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 48, 147, 0.4);
            color: white;
        }

        .bg-light-purple {
            background-color: #f8f5ff !important;
        }

        .service-detail .list-group-item {
            border: none;
            padding: 15px 10px;
            background: transparent;
        }

        .service-detail .list-group-item:hover {
            background-color: #f8f5ff;
        }

        .vaccine-item, .surgery-item, .lab-item, .dental-item {
            transition: all 0.3s ease;
        }

        .vaccine-item:hover, .surgery-item:hover, .lab-item:hover, .dental-item:hover {
            background-color: #f8f5ff;
            border-color: #6a3093 !important;
        }

        .facility-item {
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .facility-item:hover {
            background-color: #f8f5ff;
        }

        .alert-info {
            background-color: #e6f3ff;
            border-color: #b3d9ff;
            color: #0066cc;
        }

        .alert-warning {
            background-color: #fff8e6;
            border-color: #ffd699;
            color: #cc7700;
        }

        .table-sm td {
            padding: 8px 5px;
            border-color: #f0e6ff;
        }

        .modal-header {
            border-bottom: 2px solid #f0e6ff;
            background: linear-gradient(135deg, #f8f5ff, #f0e6ff);
        }
    </style>

    <script>
        // Data detail untuk setiap layanan
        const serviceDetails = {
            'konsultasi-umum': {
                title: 'Konsultasi Umum',
                content: `
                    <div class="service-detail">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-purple mb-3">Jenis Konsultasi yang Tersedia:</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-stethoscope text-purple me-3"></i>
                                        <div>
                                            <strong>Pemeriksaan Fisik Rutin</strong>
                                            <p class="mb-0 text-muted small">Pemeriksaan kesehatan menyeluruh untuk hewan peliharaan</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-diagnoses text-purple me-3"></i>
                                        <div>
                                            <strong>Diagnosis Penyakit</strong>
                                            <p class="mb-0 text-muted small">Identifikasi dan diagnosis berbagai jenis penyakit</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-file-medical text-purple me-3"></i>
                                        <div>
                                            <strong>Konsultasi Gizi</strong>
                                            <p class="mb-0 text-muted small">Rekomendasi diet dan nutrisi yang tepat</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-heartbeat text-purple me-3"></i>
                                        <div>
                                            <strong>Konsultasi Perilaku</strong>
                                            <p class="mb-0 text-muted small">Solusi untuk masalah perilaku hewan</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light-purple p-4 rounded">
                                    <h6 class="text-purple mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Layanan</h6>
                                    <div class="mb-3">
                                        <small class="text-muted d-block"><strong>Durasi:</strong> 30-60 menit</small>
                                        <small class="text-muted d-block"><strong>Biaya:</strong> Rp 75.000 - Rp 150.000</small>
                                        <small class="text-muted d-block"><strong>Dokter:</strong> Tersedia 5 dokter umum</small>
                                    </div>
                                    <div class="alert alert-info small">
                                        <i class="fas fa-lightbulb me-2"></i>
                                        <strong>Tips:</strong> Bawa catatan kesehatan dan riwayat vaksinasi hewan Anda
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            },
            'vaksinasi': {
                title: 'Vaksinasi',
                content: `
                    <div class="service-detail">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-purple mb-3">Jenis Vaksin yang Tersedia:</h5>
                                <div class="vaccine-types">
                                    <div class="vaccine-item mb-3 p-3 border rounded">
                                        <h6 class="text-purple">💉 Vaksin Dasar (Core Vaccine)</h6>
                                        <ul class="small mb-0">
                                            <li>DHPPI-L - Untuk anjing (Distemper, Hepatitis, Parvovirus, dll)</li>
                                            <li>Triple - Untuk kucing (Panleukopenia, Calicivirus, Rhinotracheitis)</li>
                                            <li>Rabies - Wajib untuk semua hewan</li>
                                        </ul>
                                    </div>
                                    <div class="vaccine-item mb-3 p-3 border rounded">
                                        <h6 class="text-purple">🛡️ Vaksin Tambahan (Non-Core)</h6>
                                        <ul class="small mb-0">
                                            <li>Bordetella - Batuk Kennel (Anjing)</li>
                                            <li>Leptospirosis - Penyakit bakteri (Anjing)</li>
                                            <li>Feline Leukemia - Untuk kucing outdoor</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light-purple p-4 rounded">
                                    <h6 class="text-purple mb-3"><i class="fas fa-calendar-alt me-2"></i>Jadwal Vaksinasi</h6>
                                    <div class="schedule-table small">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Usia 6-8 minggu</strong></td>
                                                <td>Vaksin pertama</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Usia 10-12 minggu</strong></td>
                                                <td>Vaksin booster</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Usia 14-16 minggu</strong></td>
                                                <td>Vaksin booster + Rabies</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Setahun kemudian</strong></td>
                                                <td>Vaksin tahunan</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="pricing-info mt-3">
                                        <small class="text-muted d-block"><strong>Biaya:</strong> Rp 100.000 - Rp 300.000</small>
                                        <small class="text-muted d-block"><strong>Paket lengkap:</strong> Rp 800.000 (5x vaksin)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            },
            'operasi': {
                title: 'Operasi',
                content: `
                    <div class="service-detail">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-purple mb-3">Jenis Operasi yang Tersedia:</h5>
                                <div class="surgery-types">
                                    <div class="surgery-item mb-3">
                                        <h6 class="text-purple">🔪 Operasi Elektif</h6>
                                        <ul class="small">
                                            <li>Sterilisasi (Kucing & Anjing)</li>
                                            <li>Bedah Caesar</li>
                                            <li>Pencabutan Gigi</li>
                                            <li>Penghilangan Tumor Jinak</li>
                                        </ul>
                                    </div>
                                    <div class="surgery-item mb-3">
                                        <h6 class="text-purple">🚑 Operasi Darurat</h6>
                                        <ul class="small">
                                            <li>Operasi Fraktur (Patah Tulang)</li>
                                            <li>Bedah Saluran Cerna</li>
                                            <li>Operasi Trauma</li>
                                            <li>Pengangkatan Benda Asing</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light-purple p-4 rounded">
                                    <h6 class="text-purple mb-3"><i class="fas fa-shield-alt me-2"></i>Fasilitas Operasi</h6>
                                    <ul class="small mb-3">
                                        <li>Ruangan steril ber-AC</li>
                                        <li>Monitor anestesi modern</li>
                                        <li>Tim dokter bedah berpengalaman</li>
                                        <li>ICU pasca operasi</li>
                                    </ul>
                                    <div class="alert alert-warning small">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Perhatian:</strong> Puasa 8-12 jam sebelum operasi
                                    </div>
                                    <div class="pricing-info">
                                        <small class="text-muted d-block"><strong>Sterilisasi:</strong> Rp 500.000 - Rp 1.200.000</small>
                                        <small class="text-muted d-block"><strong>Operasi darurat:</strong> Mulai Rp 1.500.000</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            },
            'pemeriksaan-lab': {
                title: 'Pemeriksaan Laboratorium',
                content: `
                    <div class="service-detail">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-purple mb-3">Jenis Pemeriksaan Lab:</h5>
                                <div class="lab-types">
                                    <div class="lab-item mb-3 p-3 border rounded">
                                        <h6 class="text-purple">🩸 Pemeriksaan Darah</h6>
                                        <ul class="small mb-0">
                                            <li>Hematologi Lengkap</li>
                                            <li>Kimia Darah (Fungsi Hati, Ginjal)</li>
                                            <li>Tes Parasit Darah</li>
                                            <li>Gula Darah</li>
                                        </ul>
                                    </div>
                                    <div class="lab-item mb-3 p-3 border rounded">
                                        <h6 class="text-purple">🧪 Pemeriksaan Lainnya</h6>
                                        <ul class="small mb-0">
                                            <li>Analisis Urin</li>
                                            <li>Pemeriksaan Feses</li>
                                            <li>Skin Scraping (Kulit)</li>
                                            <li>Tes Fungsi Tiroid</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light-purple p-4 rounded">
                                    <h6 class="text-purple mb-3"><i class="fas fa-clock me-2"></i>Informasi Hasil</h6>
                                    <div class="timeline-info small mb-3">
                                        <p><strong>Hasil Cepat:</strong> 1-2 jam (darah rutin)</p>
                                        <p><strong>Hasil Lengkap:</strong> 24-48 jam (kimia darah)</p>
                                        <p><strong>Kultur Bakteri:</strong> 3-5 hari</p>
                                    </div>
                                    <div class="pricing-info">
                                        <small class="text-muted d-block"><strong>Darah rutin:</strong> Rp 150.000</small>
                                        <small class="text-muted d-block"><strong>Kimia darah lengkap:</strong> Rp 300.000</small>
                                        <small class="text-muted d-block"><strong>Paket check-up:</strong> Rp 400.000</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            },
            'dental-care': {
                title: 'Perawatan Gigi',
                content: `
                    <div class="service-detail">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-purple mb-3">Layanan Perawatan Gigi:</h5>
                                <div class="dental-services">
                                    <div class="dental-item mb-3 p-3 border rounded">
                                        <h6 class="text-purple">😁 Pembersihan Rutin</h6>
                                        <ul class="small mb-0">
                                            <li>Scaling (pembersihan karang gigi)</li>
                                            <li>Polishing (pemolesan gigi)</li>
                                            <li>Fluoride treatment</li>
                                        </ul>
                                    </div>
                                    <div class="dental-item mb-3 p-3 border rounded">
                                        <h6 class="text-purple">🦷 Perawatan Lanjutan</h6>
                                        <ul class="small mb-0">
                                            <li>Pencabutan gigi</li>
                                            <li>Perawatan saluran akar</li>
                                            <li>Bedah mulut</li>
                                            <li>Perawatan periodontal</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light-purple p-4 rounded">
                                    <h6 class="text-purple mb-3"><i class="fas fa-tooth me-2"></i>Tips Perawatan Gigi</h6>
                                    <ul class="small mb-3">
                                        <li>Sikat gigi 2-3x seminggu</li>
                                        <li>Gunakan dental chew toys</li>
                                        <li>Beri makanan kering untuk gigi sehat</li>
                                        <li>Periksa gigi setiap 6 bulan</li>
                                    </ul>
                                    <div class="pricing-info">
                                        <small class="text-muted d-block"><strong>Scaling:</strong> Rp 200.000 - Rp 500.000</small>
                                        <small class="text-muted d-block"><strong>Pencabutan gigi:</strong> Rp 150.000/gigi</small>
                                        <small class="text-muted d-block"><strong>Paket dental:</strong> Rp 750.000</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            },
            'rawat-inap': {
                title: 'Rawat Inap',
                content: `
                    <div class="service-detail">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-purple mb-3">Fasilitas Rawat Inap:</h5>
                                <div class="facility-list">
                                    <div class="facility-item mb-3 d-flex align-items-center">
                                        <i class="fas fa-bed text-purple me-3 fa-lg"></i>
                                        <div>
                                            <strong>Kamar Ber-AC</strong>
                                            <p class="mb-0 text-muted small">Kamar nyaman dengan pengaturan suhu</p>
                                        </div>
                                    </div>
                                    <div class="facility-item mb-3 d-flex align-items-center">
                                        <i class="fas fa-heartbeat text-purple me-3 fa-lg"></i>
                                        <div>
                                            <strong>Monitor 24 Jam</strong>
                                            <p class="mb-0 text-muted small">Pantauan terus menerus oleh perawat</p>
                                        </div>
                                    </div>
                                    <div class="facility-item mb-3 d-flex align-items-center">
                                        <i class="fas fa-utensils text-purple me-3 fa-lg"></i>
                                        <div>
                                            <strong>Makanan Khusus</strong>
                                            <p class="mb-0 text-muted small">Diet sesuai kondisi kesehatan</p>
                                        </div>
                                    </div>
                                    <div class="facility-item mb-3 d-flex align-items-center">
                                        <i class="fas fa-user-md text-purple me-3 fa-lg"></i>
                                        <div>
                                            <strong>Visit Dokter Harian</strong>
                                            <p class="mb-0 text-muted small">Pemeriksaan rutin oleh dokter</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light-purple p-4 rounded">
                                    <h6 class="text-purple mb-3"><i class="fas fa-money-bill-wave me-2"></i>Tarif Rawat Inap</h6>
                                    <div class="pricing-table small mb-3">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Kamar Standar</strong></td>
                                                <td>Rp 250.000/hari</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kamar VIP</strong></td>
                                                <td>Rp 400.000/hari</td>
                                            </tr>
                                            <tr>
                                                <td><strong>ICU</strong></td>
                                                <td>Rp 600.000/hari</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="alert alert-info small">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Include:</strong> Makan, obat, dan perawatan dasar
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            }
        };

        // Fungsi untuk membuka modal
        function showServiceDetail(serviceId) {
            const service = serviceDetails[serviceId];
            if (service) {
                document.getElementById('serviceModalLabel').textContent = service.title;
                document.getElementById('serviceContent').innerHTML = service.content;
                const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
                modal.show();
            }
        }
    </script>

@endsection