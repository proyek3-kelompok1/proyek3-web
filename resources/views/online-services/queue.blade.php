@extends('layouts.app')

@section('title', 'Lihat Antrian - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="text-center mb-5">
                <h1 class="fw-bold text-purple"><i class="fas fa-list-ol me-2"></i>Info Antrian Klinik</h1>
                <p class="lead text-muted">Pantau antrian real-time dan perkiraan waktu tunggu</p>
            </div>

            <!-- Pencarian Antrian Saya -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>Cek Antrian Saya</h5>
                </div>
                <div class="card-body">
                    <form id="checkQueueForm">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label for="booking_code" class="form-label fw-bold text-purple">Masukkan Kode Booking</label>
                                <input type="text" class="form-control" id="booking_code" name="booking_code" 
                                       placeholder="Contoh: VKS20231215001" required>
                                <div class="form-text">Kode booking dapat ditemukan di tiket atau email konfirmasi</div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-purple w-100">
                                    <i class="fas fa-search me-2"></i>Cek Antrian
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Hasil Pencarian -->
                    <div id="myQueueResult" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h6 class="alert-heading"><i class="fas fa-ticket-alt me-2"></i>Informasi Antrian Anda</h6>
                            <div id="queueResultContent"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Antrian Real-time -->
            <div class="card shadow">
                <div class="card-header bg-purple text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Antrian Real-time</h5>
                        <div class="d-flex align-items-center">
                            <span class="me-2" id="lastUpdate"></span>
                            <button id="refreshQueue" class="btn btn-sm btn-light">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="queueDate" class="form-label fw-bold text-purple">Tanggal</label>
                            <input type="date" class="form-control" id="queueDate" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="serviceFilter" class="form-label fw-bold text-purple">Filter Layanan</label>
                            <select class="form-select" id="serviceFilter">
                                <option value="">Semua Layanan</option>
                                <option value="vaksinasi">Vaksinasi</option>
                                <option value="konsultasi_umum">Konsultasi Umum</option>
                                <option value="grooming">Grooming</option>
                                <option value="perawatan_gigi">Perawatan Gigi</option>
                                <option value="pemeriksaan_darah">Pemeriksaan Darah</option>
                                <option value="sterilisasi">Sterilisasi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Antrian Saat Ini -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-user-md me-2"></i>Sedang Dilayani</h6>
                                </div>
                                <div class="card-body text-center">
                                    <div id="currentQueue" class="display-4 fw-bold text-success mb-2">-</div>
                                    <p class="text-muted mb-0" id="currentService">Menunggu data...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Info Antrian</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="fw-bold text-purple fs-3" id="totalQueue">0</div>
                                            <small class="text-muted">Total Antrian</small>
                                        </div>
                                        <div class="col-6">
                                            <div class="fw-bold text-warning fs-3" id="waitTime">0</div>
                                            <small class="text-muted">Estimasi Menit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Antrian -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="15%">No. Antrian</th>
                                    <th width="20%">Kode Booking</th>
                                    <th width="20%">Layanan</th>
                                    <th width="20%">Nama Hewan</th>
                                    <th width="15%">Waktu</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody id="queueTableBody">
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Memuat data antrian...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Legend Status -->
                    <div class="mt-3">
                        <small class="text-muted">
                            <span class="badge bg-success me-2">Sedang Dilayani</span>
                            <span class="badge bg-warning me-2">Menunggu</span>
                            <span class="badge bg-secondary me-2">Selesai</span>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-4 p-3 bg-light rounded">
                <h6 class="text-purple"><i class="fas fa-info-circle me-2"></i>Informasi Penting</h6>
                <ul class="mb-0 small">
                    <li>Antrian diperbarui otomatis setiap 30 detik</li>
                    <li>Datang 15 menit sebelum perkiraan waktu antrian Anda</li>
                    <li>Perkiraan waktu tunggu dapat berubah tergantung kondisi</li>
                    <li>Pastikan membawa hewan dalam carrier atau menggunakan tali</li>
                </ul>
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
.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: white;
}

.queue-current {
    background-color: #d1edff !important;
    font-weight: bold;
}

@keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.queue-serving {
    animation: blink 2s infinite;
    background-color: #d4edda !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let refreshInterval;
    
    // Format nama layanan
    const serviceNames = {
        'vaksinasi': 'Vaksinasi',
        'konsultasi_umum': 'Konsultasi Umum',
        'grooming': 'Grooming',
        'perawatan_gigi': 'Perawatan Gigi',
        'pemeriksaan_darah': 'Pemeriksaan Darah',
        'sterilisasi': 'Sterilisasi'
    };

    // Format status
    const statusBadges = {
        'pending': '<span class="badge bg-warning">Menunggu</span>',
        'confirmed': '<span class="badge bg-success">Sedang Dilayani</span>',
        'completed': '<span class="badge bg-secondary">Selesai</span>',
        'cancelled': '<span class="badge bg-danger">Dibatalkan</span>'
    };

    // Load data antrian
    function loadQueueData() {
        const date = document.getElementById('queueDate').value;
        const serviceType = document.getElementById('serviceFilter').value;

        fetch(`{{ route('online-services.queue-data') }}?date=${date}&service_type=${serviceType}`)
            .then(response => response.json())
            .then(data => {
                updateQueueDisplay(data);
                updateLastUpdateTime();
            })
            .catch(error => {
                console.error('Error loading queue data:', error);
            });
    }

    // Update tampilan antrian
    function updateQueueDisplay(data) {
        // Update antrian saat ini
        const currentQueueEl = document.getElementById('currentQueue');
        const currentServiceEl = document.getElementById('currentService');
        
        if (data.current_queue) {
            currentQueueEl.textContent = `A${String(data.current_queue.nomor_antrian).padStart(3, '0')}`;
            currentServiceEl.textContent = serviceNames[data.current_queue.service_type] || data.current_queue.service_type;
        } else {
            currentQueueEl.textContent = '-';
            currentServiceEl.textContent = 'Tidak ada antrian';
        }

        // Update total antrian dan estimasi waktu
        document.getElementById('totalQueue').textContent = data.total_queue;
        document.getElementById('waitTime').textContent = data.estimated_wait_minutes;

        // Update tabel antrian
        const tableBody = document.getElementById('queueTableBody');
        
        if (data.today_queue.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times me-2"></i>Tidak ada antrian untuk tanggal ini
                    </td>
                </tr>
            `;
            return;
        }

        let tableHTML = '';
        data.today_queue.forEach(item => {
            const isCurrent = data.current_queue && data.current_queue.nomor_antrian === item.nomor_antrian;
            const rowClass = isCurrent ? 'queue-serving' : '';
            
            tableHTML += `
                <tr class="${rowClass}">
                    <td class="fw-bold">A${String(item.nomor_antrian).padStart(3, '0')}</td>
                    <td><code>${item.booking_code}</code></td>
                    <td>${serviceNames[item.service_type] || item.service_type}</td>
                    <td>${item.nama_hewan}</td>
                    <td>${item.waktu}</td>
                    <td>${statusBadges[item.status] || item.status}</td>
                </tr>
            `;
        });

        tableBody.innerHTML = tableHTML;
    }

    // Update waktu terakhir refresh
    function updateLastUpdateTime() {
        const now = new Date();
        document.getElementById('lastUpdate').textContent = 
            `Terupdate: ${now.toLocaleTimeString('id-ID')}`;
    }

    // Cek antrian saya
    document.getElementById('checkQueueForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const checkButton = this.querySelector('button[type="submit"]');
        const originalText = checkButton.innerHTML;

        // Show loading
        checkButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mencari...';
        checkButton.disabled = true;

        fetch('{{ route("online-services.check-my-queue") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('myQueueResult');
            const resultContent = document.getElementById('queueResultContent');

            if (data.success) {
                const queueInfo = data.data.queue_info;
                const booking = data.data.booking;
                
                let statusText = '';
                let statusClass = 'warning';
                
                if (queueInfo.status === 'confirmed') {
                    statusText = 'SEDANG DILAYANI';
                    statusClass = 'success';
                } else if (queueInfo.current_serving === booking.nomor_antrian) {
                    statusText = 'SILAKAN MASUK';
                    statusClass = 'success';
                } else if (queueInfo.current_position === 1) {
                    statusText = 'BERSIAP-SIAP';
                    statusClass = 'info';
                } else {
                    statusText = 'MENUNGGU';
                    statusClass = 'warning';
                }

                resultContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>No. Antrian:</strong> A${String(booking.nomor_antrian).padStart(3, '0')}</p>
                            <p class="mb-1"><strong>Kode Booking:</strong> <code>${booking.booking_code}</code></p>
                            <p class="mb-1"><strong>Hewan:</strong> ${booking.nama_hewan}</p>
                            <p class="mb-1"><strong>Layanan:</strong> ${serviceNames[booking.service_type] || booking.service_type}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Posisi Antrian:</strong> Ke-${queueInfo.current_position}</p>
                            <p class="mb-1"><strong>Sedang Dilayani:</strong> A${String(queueInfo.current_serving).padStart(3, '0')}</p>
                            <p class="mb-1"><strong>Estimasi Tunggu:</strong> ${queueInfo.estimated_wait_minutes} menit</p>
                            <p class="mb-0"><strong>Status:</strong> <span class="badge bg-${statusClass}">${statusText}</span></p>
                        </div>
                    </div>
                `;
            } else {
                resultContent.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>${data.message}
                    </div>
                `;
            }

            resultDiv.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('queueResultContent').innerHTML = `
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan saat memproses permintaan
                </div>
            `;
            document.getElementById('myQueueResult').style.display = 'block';
        })
        .finally(() => {
            // Restore button
            checkButton.innerHTML = originalText;
            checkButton.disabled = false;
        });
    });

    // Event listeners untuk filter dan refresh
    document.getElementById('queueDate').addEventListener('change', loadQueueData);
    document.getElementById('serviceFilter').addEventListener('change', loadQueueData);
    document.getElementById('refreshQueue').addEventListener('click', loadQueueData);

    // Auto-refresh setiap 30 detik
    refreshInterval = setInterval(loadQueueData, 30000);

    // Load data pertama kali
    loadQueueData();

    // Cleanup interval ketika page di-unload
    window.addEventListener('beforeunload', function() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    });
});
</script>
@endsection