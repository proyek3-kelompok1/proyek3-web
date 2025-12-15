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
                                <div class="card-body">
                                    <!-- Container untuk semua antrian yang sedang dilayani -->
                                    <div id="currentQueuesContainer">
                                        <div class="text-center text-muted">
                                            <div class="display-4 fw-bold text-success mb-2">-</div>
                                            <p class="mb-0">Memuat data...</p>
                                        </div>
                                    </div>
                                    <small class="text-muted mt-2 d-block" id="filterInfo"></small>
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
                                            <small class="text-muted" id="totalQueueLabel">Total Antrian</small>
                                        </div>
                                        <div class="col-6">
                                            <div class="fw-bold text-warning fs-3" id="waitTime">0</div>
                                            <small class="text-muted" id="waitTimeLabel">Estimasi Menit</small>
                                        </div>
                                    </div>
                                    <!-- Info tambahan berdasarkan filter -->
                                    <div class="mt-2 small text-muted" id="queueStats">
                                        <div>Antrian menunggu: <span id="waitingCount">0</span></div>
                                        <div>Antrian selesai: <span id="completedCount">0</span></div>
                                        <div>Sedang dilayani: <span id="servingCount">0</span></div>
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
                            <span class="badge bg-danger me-2">Dibatalkan</span>
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

/* Style untuk multiple current queues */
.current-queue-item {
    padding: 10px;
    margin-bottom: 8px;
    border-radius: 8px;
    background-color: #f8f9fa;
    border-left: 4px solid #28a745;
}

.current-queue-item:last-child {
    margin-bottom: 0;
}

.queue-service-badge {
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 12px;
    background-color: #6f42c1;
    color: white;
    margin-left: 8px;
}

.queue-number {
    font-size: 2rem;
    font-weight: bold;
    color: #28a745;
}

.queue-service-name {
    font-size: 0.9rem;
    color: #6c757d;
}

.no-current-queue {
    text-align: center;
    padding: 20px;
    color: #6c757d;
}

.serving-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    background-color: #28a745;
    border-radius: 50%;
    margin-right: 5px;
    animation: blink 1.5s infinite;
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

    // Warna untuk setiap layanan
    const serviceColors = {
        'vaksinasi': '#28a745',
        'konsultasi_umum': '#17a2b8',
        'grooming': '#ffc107',
        'perawatan_gigi': '#dc3545',
        'pemeriksaan_darah': '#6f42c1',
        'sterilisasi': '#fd7e14'
    };

    // Format status
    const statusBadges = {
        'pending': '<span class="badge bg-warning">Menunggu</span>',
        'serving': '<span class="badge bg-success">Sedang Dilayani</span>',
        'completed': '<span class="badge bg-secondary">Selesai</span>',
        'cancelled': '<span class="badge bg-danger">Dibatalkan</span>',
        'confirmed': '<span class="badge bg-info">Terkonfirmasi</span>'
    };

    // Load data antrian
    function loadQueueData() {
        const date = document.getElementById('queueDate').value;
        const serviceType = document.getElementById('serviceFilter').value;

        fetch(`{{ route('online-services.queue-data') }}?date=${date}&service_type=${serviceType}`)
            .then(response => response.json())
            .then(data => {
                updateQueueDisplay(data, serviceType);
                updateLastUpdateTime();
            })
            .catch(error => {
                console.error('Error loading queue data:', error);
            });
    }

    // Update tampilan antrian
    function updateQueueDisplay(data, serviceType) {
        // Konversi today_queue ke array
        const todayQueueArray = convertTodayQueueToArray(data.today_queue);
        
        // Update antrian yang sedang dilayani (PERBAIKAN UTAMA)
        updateCurrentQueues(todayQueueArray, serviceType);

        // Update statistik
        updateQueueStatistics(todayQueueArray, serviceType);

        // Update tabel
        updateQueueTable(todayQueueArray, data.current_queue, serviceType);
    }

    // Konversi today_queue object ke array
    function convertTodayQueueToArray(todayQueue) {
        if (!todayQueue) {
            return [];
        }
        
        if (Array.isArray(todayQueue)) {
            return todayQueue;
        }
        
        if (typeof todayQueue === 'object') {
            return Object.values(todayQueue);
        }
        
        return [];
    }

    // PERBAIKAN: Update antrian yang sedang dilayani - sesuai dengan filter
    function updateCurrentQueues(todayQueueArray, serviceType) {
        const container = document.getElementById('currentQueuesContainer');
        
        // Cari semua antrian yang sedang dilayani (status === 'serving')
        let servingQueues = todayQueueArray.filter(item => 
            item && item.status === 'serving'
        );
        
        // Filter berdasarkan layanan jika ada filter spesifik
        if (serviceType) {
            servingQueues = servingQueues.filter(item => 
                item.service_type === serviceType
            );
        }
        
        // Jika tidak ada yang sedang dilayani
        if (servingQueues.length === 0) {
            let message = 'Tidak ada antrian yang sedang dilayani';
            if (serviceType) {
                const serviceName = serviceNames[serviceType] || serviceType;
                message = `Tidak ada antrian ${serviceName} yang sedang dilayani`;
            }
            
            container.innerHTML = `
                <div class="no-current-queue">
                    <div class="display-4 fw-bold text-muted mb-2">-</div>
                    <p class="mb-0">${message}</p>
                </div>
            `;
            return;
        }
        
        // Jika hanya 1 antrian yang sedang dilayani
        if (servingQueues.length === 1) {
            const queue = servingQueues[0];
            const serviceName = serviceNames[queue.service_type] || queue.service_type;
            const serviceColor = serviceColors[queue.service_type] || '#28a745';
            
            container.innerHTML = `
                <div class="text-center">
                    <div class="queue-number" style="color: ${serviceColor}">
                        A${String(queue.nomor_antrian).padStart(3, '0')}
                    </div>
                    <p class="queue-service-name mb-0">
                        ${serviceName}
                        ${serviceType ? '' : `<span class="queue-service-badge" style="background-color: ${serviceColor}">${serviceName}</span>`}
                    </p>
                    <small class="text-muted">${queue.nama_hewan || ''}</small>
                </div>
            `;
            return;
        }
        
        // Jika banyak antrian yang sedang dilayani (untuk "Semua Layanan")
        let html = '<div class="serving-queues-list">';
        
        servingQueues.forEach(queue => {
            const serviceName = serviceNames[queue.service_type] || queue.service_type;
            const serviceColor = serviceColors[queue.service_type] || '#28a745';
            
            html += `
                <div class="current-queue-item mb-2" style="border-left-color: ${serviceColor}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="serving-indicator"></span>
                            <div class="fw-bold d-inline-block" style="color: ${serviceColor}; font-size: 1.3rem;">
                                A${String(queue.nomor_antrian).padStart(3, '0')}
                            </div>
                            <div class="small text-muted mt-1">${serviceName}</div>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-paw me-1"></i>${queue.nama_hewan || ''}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        container.innerHTML = html;
    }

    // Update tabel antrian
    function updateQueueTable(todayQueueArray, currentQueue, serviceType) {
        const tableBody = document.getElementById('queueTableBody');
        
        // Filter data berdasarkan layanan jika dipilih
        let displayData = todayQueueArray;
        if (serviceType) {
            displayData = displayData.filter(item => 
                item && item.service_type === serviceType
            );
        }
        
        if (displayData.length === 0) {
            let message = 'Tidak ada antrian untuk tanggal ini';
            if (serviceType) {
                const serviceName = serviceNames[serviceType] || serviceType;
                message = `Tidak ada antrian ${serviceName} untuk tanggal ini`;
            }
            
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times me-2"></i>${message}
                    </td>
                </tr>
            `;
            return;
        }

        // Urutkan berdasarkan nomor antrian
        displayData.sort((a, b) => (a.nomor_antrian || 0) - (b.nomor_antrian || 0));
        
        // Buat tabel
        let tableHTML = '';
        
        displayData.forEach(item => {
            if (!item) return;
            
            const isServing = item.status === 'serving';
            const rowClass = isServing ? 'queue-serving' : '';
            
            const statusBadge = isServing 
                ? '<span class="badge bg-success"><i class="fas fa-play-circle me-1"></i>Sedang Dilayani</span>'
                : statusBadges[item.status] || `<span class="badge bg-secondary">${item.status}</span>`;
            
            tableHTML += `
                <tr class="${rowClass}">
                    <td class="fw-bold ${isServing ? 'text-success' : ''}">
                        ${isServing ? '<span class="serving-indicator"></span>' : ''}
                        A${String(item.nomor_antrian).padStart(3, '0')}
                    </td>
                    <td><code class="${isServing ? 'text-success' : ''}">${item.booking_code}</code></td>
                    <td>
                        <span class="badge" style="background-color: ${serviceColors[item.service_type] || '#6f42c1'}">
                            ${serviceNames[item.service_type] || item.service_type}
                        </span>
                    </td>
                    <td>${item.nama_hewan}</td>
                    <td>${item.waktu}</td>
                    <td>${statusBadge}</td>
                </tr>
            `;
        });

        tableBody.innerHTML = tableHTML;
    }

    // Update statistik antrian
    function updateQueueStatistics(todayQueueArray, serviceType) {
        let totalQueue = 0;
        let waitingCount = 0;
        let completedCount = 0;
        let servingCount = 0;
        let estimatedWait = 0;
        
        if (todayQueueArray && todayQueueArray.length > 0) {
            // Filter data
            let filteredData = todayQueueArray;
            if (serviceType) {
                filteredData = filteredData.filter(item => 
                    item && item.service_type === serviceType
                );
            }
            
            totalQueue = filteredData.length;
            
            // Hitung statistik
            filteredData.forEach(item => {
                if (!item) return;
                
                if (item.status === 'serving') {
                    servingCount++;
                } else if (item.status === 'pending' || item.status === 'confirmed') {
                    waitingCount++;
                } else if (item.status === 'completed') {
                    completedCount++;
                }
            });
            
            // Estimasi waktu tunggu
            estimatedWait = waitingCount * 15;
        }
        
        // Update UI
        document.getElementById('totalQueue').textContent = totalQueue;
        document.getElementById('waitTime').textContent = estimatedWait;
        document.getElementById('waitingCount').textContent = waitingCount;
        document.getElementById('completedCount').textContent = completedCount;
        document.getElementById('servingCount').textContent = servingCount;
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
                let estimatedWaitDisplay = `${queueInfo.estimated_wait_minutes} menit`;
                
                if (booking.status === 'serving') {
                    statusText = 'SEDANG DILAYANI';
                    statusClass = 'success';
                    estimatedWaitDisplay = '<span class="text-success">Sedang dilayani</span>';
                } else if (booking.status === 'completed') {
                    statusText = 'SELESAI';
                    statusClass = 'secondary';
                    estimatedWaitDisplay = '<span class="text-secondary">Sudah selesai</span>';
                } else if (booking.status === 'cancelled') {
                    statusText = 'DIBATALKAN';
                    statusClass = 'danger';
                    estimatedWaitDisplay = '<span class="text-danger">Dibatalkan</span>';
                } else if (queueInfo.current_serving === booking.nomor_antrian) {
                    statusText = 'SILAKAN MASUK';
                    statusClass = 'success';
                    estimatedWaitDisplay = '<span class="text-success">Silakan masuk</span>';
                } else if (queueInfo.current_position === 1) {
                    statusText = 'BERSIAP-SIAP';
                    statusClass = 'info';
                    estimatedWaitDisplay = `${queueInfo.estimated_wait_minutes} menit`;
                } else if (queueInfo.current_position <= 0) {
                    statusText = 'TIDAK DITEMUKAN';
                    statusClass = 'danger';
                    estimatedWaitDisplay = '-';
                } else {
                    statusText = 'MENUNGGU';
                    statusClass = 'warning';
                    estimatedWaitDisplay = `${queueInfo.estimated_wait_minutes} menit`;
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
                            <p class="mb-1"><strong>Posisi Antrian:</strong> ${queueInfo.current_position > 0 ? 'Ke-' + queueInfo.current_position : '-'}</p>
                            <p class="mb-1"><strong>Sedang Dilayani:</strong> ${queueInfo.current_serving ? 'A' + String(queueInfo.current_serving).padStart(3, '0') : '-'}</p>
                            <p class="mb-1"><strong>Estimasi Tunggu:</strong> ${estimatedWaitDisplay}</p>
                            <p class="mb-0"><strong>Status:</strong> <span class="badge bg-${statusClass}">${statusText}</span></p>
                        </div>
                    </div>
                `;
            } else {
                resultContent.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>${data.message || 'Kode booking tidak ditemukan'}
                    </div>
                `;
            }

            resultDiv.style.display = 'block';
        })
        .catch(error => {
            console.error('Error checking queue:', error);
            document.getElementById('queueResultContent').innerHTML = `
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Gagal memproses permintaan
                </div>
            `;
            document.getElementById('myQueueResult').style.display = 'block';
        })
        .finally(() => {
            checkButton.innerHTML = originalText;
            checkButton.disabled = false;
        });
    });

    // Event listeners
    document.getElementById('queueDate').addEventListener('change', loadQueueData);
    document.getElementById('serviceFilter').addEventListener('change', loadQueueData);
    document.getElementById('refreshQueue').addEventListener('click', loadQueueData);

    // Auto-refresh setiap 30 detik
    refreshInterval = setInterval(loadQueueData, 30000);

    // Load initial data
    loadQueueData();

    // Cleanup
    window.addEventListener('beforeunload', function() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    });
});
</script>
@endsection