@extends('admin.layouts.app')

@section('title', 'Kelola Antrian - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-list-ol me-2"></i>Kelola Antrian Layanan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-purple" id="refreshBtn">
                <i class="fas fa-sync-alt me-1"></i>Refresh
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4 class="mb-0" id="stat-total">{{ $stats['total'] }}</h4>
                <small>Total Antrian</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-dark">
            <div class="card-body text-center">
                <h4 class="mb-0" id="stat-pending">{{ $stats['pending'] }}</h4>
                <small>Menunggu</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4 class="mb-0" id="stat-confirmed">{{ $stats['confirmed'] }}</h4>
                <small>Sedang Dilayani</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4 class="mb-0" id="stat-completed">{{ $stats['completed'] }}</h4>
                <small>Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h4 class="mb-0" id="stat-cancelled">{{ $stats['cancelled'] }}</h4>
                <small>Dibatalkan</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h4 class="mb-0" id="stat-completed-no-record">{{ $todayBookings->where('status', 'completed')->filter(function($b) { return !$b->has_medical_record; })->count() }}</h4>
                <small>Selesai (Belum RM)</small>
            </div>
        </div>
    </div>
</div>

<!-- Filter dan Kontrol -->
<div class="card card-purple mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label for="dateFilter" class="form-label fw-bold">Filter Tanggal</label>
                <input type="date" class="form-control" id="dateFilter" value="{{ $today }}">
            </div>
            <div class="col-md-4">
                <label for="serviceFilter" class="form-label fw-bold">Filter Layanan</label>
                <select class="form-select" id="serviceFilter">
                    <option value="">Semua Layanan</option>
                    <option value="general">Konsultasi Umum</option>
                    <option value="vaccination">Vaksinasi</option>
                    <option value="grooming">Grooming</option>
                    <option value="dental">Perawatan Gigi</option>
                    <option value="surgery">Operasi</option>
                    <option value="laboratory">Laboratorium</option>
                    <option value="inpatient">Rawat Inap</option>
                    <option value="emergency">Darurat</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="statusFilter" class="form-label fw-bold">Filter Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="confirmed">Sedang Dilayani</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                    <option value="completed_no_record">Selesai (Belum Rekam Medis)</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Antrian -->
<div class="card card-purple">
    <div class="card-header bg-purple text-white">
        <h5 class="mb-0">
            <i class="fas fa-table me-2"></i>Daftar Antrian
            <span class="badge bg-light text-purple ms-2" id="queueCount">{{ $todayBookings->count() }}</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="queueTable">
                <thead>
                    <tr>
                        <th width="8%">No. Antrian</th>
                        <th width="12%">Kode Booking</th>
                        <th width="15%">Pemilik</th>
                        <th width="15%">Hewan</th>
                        <th width="12%">Layanan</th>
                        <th width="10%">Dokter</th>
                        <th width="10%">Waktu</th>
                        <th width="10%">Status</th>
                        <th width="8%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="queueTableBody">
                    @forelse($todayBookings as $booking)
                    <tr data-booking-id="{{ $booking->id }}" data-service="{{ $booking->service_type }}" data-status="{{ $booking->status }}">
                        <td>
                            <span class="badge bg-primary fs-6">A{{ str_pad($booking->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <code>{{ $booking->booking_code }}</code>
                        </td>
                        <td>
                            <strong>{{ $booking->nama_pemilik }}</strong>
                            <br>
                            <small class="text-muted">{{ $booking->telepon }}</small>
                        </td>
                        <td>
                            {{ $booking->nama_hewan }}
                            <br>
                            <small class="text-muted">{{ $booking->jenis_hewan }} - {{ $booking->ras }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $booking->service_name }}</span>
                        </td>
                        <td>
                            <small>{{ $booking->doctor_name }}</small>
                        </td>
                        <td>
                            <small>{{ $booking->booking_time }}</small>
                            <br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <select class="form-select form-select-sm status-select" data-booking-id="{{ $booking->id }}">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Sedang Dilayani</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-info view-booking" 
                                        data-bs-toggle="tooltip" title="Lihat Detail"
                                        data-booking-id="{{ $booking->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <!-- TOMBOL BUAT REKAM MEDIS - TAMPILKAN HANYA UNTUK STATUS COMPLETED -->
                                @if($booking->status == 'completed')
                                    @if(!$booking->has_medical_record)
                                        <a href="{{ route('admin.medical-records.create', $booking->id) }}" 
                                           class="btn btn-outline-success" data-bs-toggle="tooltip" title="Buat Rekam Medis">
                                            <i class="fas fa-file-medical"></i>
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary" 
                                                data-bs-toggle="tooltip" title="Rekam Medis Sudah Dibuat" disabled>
                                            <i class="fas fa-file-check"></i>
                                        </button>
                                    @endif
                                @endif
                                <button type="button" class="btn btn-outline-danger delete-booking"
                                        data-bs-toggle="tooltip" title="Hapus"
                                        data-booking-id="{{ $booking->id }}"
                                        data-booking-code="{{ $booking->booking_code }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-3"></i>
                                <p>Tidak ada antrian untuk tanggal ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Booking -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title">Detail Pemesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="bookingModalBody">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Get CSRF token
    function getCsrfToken() {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (tokenMeta) {
            return tokenMeta.content;
        }
        
        const tokenInput = document.querySelector('input[name="_token"]');
        if (tokenInput) {
            return tokenInput.value;
        }
        
        if (window.Laravel && window.Laravel.csrfToken) {
            return window.Laravel.csrfToken;
        }
        
        console.error('CSRF token not found!');
        return '';
    }

    // Format nama layanan
    const serviceNames = {
        'general': 'Konsultasi Umum',
        'vaccination': 'Vaksinasi',
        'grooming': 'Grooming',
        'dental': 'Perawatan Gigi',
        'surgery': 'Operasi',
        'laboratory': 'Laboratorium',
        'inpatient': 'Rawat Inap',
        'emergency': 'Darurat'
    };

    // Initialize filters and event listeners
    function initializeFilters() {
        const dateFilter = document.getElementById('dateFilter');
        const serviceFilter = document.getElementById('serviceFilter');
        const statusFilter = document.getElementById('statusFilter');
        const refreshBtn = document.getElementById('refreshBtn');

        if (dateFilter) dateFilter.addEventListener('change', loadQueueData);
        if (serviceFilter) serviceFilter.addEventListener('change', loadQueueData);
        if (statusFilter) statusFilter.addEventListener('change', loadQueueData);
        if (refreshBtn) refreshBtn.addEventListener('click', loadQueueData);
    }

    // Load queue data
    function loadQueueData() {
        const date = document.getElementById('dateFilter')?.value || '{{ $today }}';
        const service = document.getElementById('serviceFilter')?.value || '';
        const status = document.getElementById('statusFilter')?.value || '';

        console.log('Loading data with filters:', { date, service, status });

        // Show loading state
        const queueTableBody = document.getElementById('queueTableBody');
        if (queueTableBody) {
            queueTableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                            <p>Memuat data...</p>
                        </div>
                    </td>
                </tr>
            `;
        }

        fetch(`{{ route('admin.queue.data') }}?date=${date}&service_type=${service}&status=${status}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            
            if (data.success) {
                updateQueueTable(data.bookings);
                updateStats(data.stats);
            } else {
                throw new Error(data.message || 'Failed to load data');
            }
        })
        .catch(error => {
            console.error('Error loading queue data:', error);
            showAlert('Error memuat data antrian: ' + error.message, 'danger');
            
            // Reset to empty state on error
            if (queueTableBody) {
                queueTableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                <p>Gagal memuat data</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
            updateStats({
                total: 0,
                pending: 0,
                confirmed: 0,
                completed: 0,
                cancelled: 0,
                completed_no_record: 0
            });
        });
    }

    // Update queue table
    function updateQueueTable(bookings) {
        const queueTableBody = document.getElementById('queueTableBody');
        const queueCount = document.getElementById('queueCount');

        if (!queueTableBody) return;

        if (!bookings || bookings.length === 0) {
            queueTableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-3"></i>
                            <p>Tidak ada antrian untuk filter yang dipilih</p>
                        </div>
                    </td>
                </tr>
            `;
            if (queueCount) queueCount.textContent = '0';
            return;
        }

        let tableHTML = '';
        bookings.forEach(booking => {
            const hasMedicalRecord = booking.has_medical_record || false;
            
            const medicalRecordButton = booking.status === 'completed' 
                ? (hasMedicalRecord 
                    ? `<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="Rekam Medis Sudah Dibuat" disabled>
                          <i class="fas fa-file-check"></i>
                       </button>`
                    : `<a href="/admin/medical-records/create/${booking.id}" 
                          class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Buat Rekam Medis">
                          <i class="fas fa-file-medical"></i>
                       </a>`)
                : '';

            tableHTML += `
                <tr data-booking-id="${booking.id}" data-service="${booking.service_type}" data-status="${booking.status}">
                    <td>
                        <span class="badge bg-primary fs-6">A${String(booking.nomor_antrian).padStart(3, '0')}</span>
                    </td>
                    <td><code>${booking.booking_code}</code></td>
                    <td>
                        <strong>${booking.nama_pemilik}</strong>
                        <br>
                        <small class="text-muted">${booking.telepon}</small>
                    </td>
                    <td>
                        ${booking.nama_hewan}
                        <br>
                        <small class="text-muted">${booking.jenis_hewan} - ${booking.ras}</small>
                    </td>
                    <td>
                        <span class="badge bg-info">${booking.service_name || serviceNames[booking.service_type] || booking.service_type}</span>
                    </td>
                    <td>
                        <small>${booking.doctor_name || booking.doctor}</small>
                    </td>
                    <td>
                        <small>${booking.booking_time}</small>
                        <br>
                        <small class="text-muted">${new Date(booking.booking_date).toLocaleDateString('id-ID')}</small>
                    </td>
                    <td>
                        <select class="form-select form-select-sm status-select" data-booking-id="${booking.id}">
                            <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Menunggu</option>
                            <option value="confirmed" ${booking.status === 'confirmed' ? 'selected' : ''}>Sedang Dilayani</option>
                            <option value="completed" ${booking.status === 'completed' ? 'selected' : ''}>Selesai</option>
                            <option value="cancelled" ${booking.status === 'cancelled' ? 'selected' : ''}>Dibatalkan</option>
                        </select>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-info view-booking" 
                                    data-bs-toggle="tooltip" title="Lihat Detail"
                                    data-booking-id="${booking.id}">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${medicalRecordButton}
                            <button type="button" class="btn btn-outline-danger delete-booking"
                                    data-bs-toggle="tooltip" title="Hapus"
                                    data-booking-id="${booking.id}"
                                    data-booking-code="${booking.booking_code}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        queueTableBody.innerHTML = tableHTML;
        if (queueCount) queueCount.textContent = bookings.length;
        initializeEventListeners();
    }

    // Update statistics
    function updateStats(stats) {
        console.log('Updating stats with:', stats);
        
        const statTotal = document.getElementById('stat-total');
        const statPending = document.getElementById('stat-pending');
        const statConfirmed = document.getElementById('stat-confirmed');
        const statCompleted = document.getElementById('stat-completed');
        const statCancelled = document.getElementById('stat-cancelled');
        const statCompletedNoRecord = document.getElementById('stat-completed-no-record');

        if (statTotal) statTotal.textContent = stats.total || 0;
        if (statPending) statPending.textContent = stats.pending || 0;
        if (statConfirmed) statConfirmed.textContent = stats.confirmed || 0;
        if (statCompleted) statCompleted.textContent = stats.completed || 0;
        if (statCancelled) statCancelled.textContent = stats.cancelled || 0;
        if (statCompletedNoRecord) statCompletedNoRecord.textContent = stats.completed_no_record || 0;

        // Update queue count badge
        const queueCount = document.getElementById('queueCount');
        if (queueCount) {
            queueCount.textContent = stats.total || 0;
        }
    }

    // Initialize event listeners for dynamic content
    function initializeEventListeners() {
        // Status change
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const bookingId = this.getAttribute('data-booking-id');
                const newStatus = this.value;
                
                updateBookingStatus(bookingId, newStatus);
            });
        });

        // View booking details
        document.querySelectorAll('.view-booking').forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.getAttribute('data-booking-id');
                showBookingDetails(bookingId);
            });
        });

        // Delete booking
        document.querySelectorAll('.delete-booking').forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.getAttribute('data-booking-id');
                const bookingCode = this.getAttribute('data-booking-code');
                
                deleteBooking(bookingId, bookingCode);
            });
        });

        // Initialize tooltips for new elements
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Update booking status
    function updateBookingStatus(bookingId, status) {
        const url = `{{ route('admin.queue.updateStatus', ':id') }}`.replace(':id', bookingId);
        
        console.log('Updating status URL:', url);

        fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
            console.log('Update status response:', response.status);
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Update status success:', data);
            if (data.success) {
                showAlert('Status berhasil diperbarui', 'success');
                loadQueueData(); // Reload data
            } else {
                showAlert('Gagal memperbarui status: ' + (data.message || ''), 'danger');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            showAlert('Error memperbarui status: ' + error.message, 'danger');
        });
    }

    // Show booking details
    function showBookingDetails(bookingId) {
        console.log('Loading details for booking ID:', bookingId);
        
        const url = `{{ route('admin.queue.detail', ':id') }}`.replace(':id', bookingId);
        
        console.log('Detail URL:', url);
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            console.log('Detail response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            console.log('Detail HTML loaded successfully');
            document.getElementById('bookingModalBody').innerHTML = html;
            const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error loading booking details:', error);
            // Fallback content
            document.getElementById('bookingModalBody').innerHTML = `
                <div class="text-center p-4">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                    <h5>Gagal Memuat Detail</h5>
                    <p class="text-muted">Terjadi kesalahan saat memuat data.</p>
                    <p><small>Error: ${error.message}</small></p>
                    <button type="button" class="btn btn-purple" data-bs-dismiss="modal">Tutup</button>
                </div>
            `;
            const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
            modal.show();
        });
    }

    // Delete booking
    function deleteBooking(bookingId, bookingCode) {
        if (!confirm(`Apakah Anda yakin ingin menghapus pemesanan ${bookingCode}?`)) {
            return;
        }

        const url = `{{ route('admin.queue.destroy', ':id') }}`.replace(':id', bookingId);
        
        console.log('Delete URL:', url);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Delete response status:', response.status);
            if (!response.ok) {
                if (response.headers.get('content-type')?.includes('application/json')) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                    });
                } else {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
            }
            return response.json();
        })
        .then(data => {
            console.log('Delete success:', data);
            if (data.success) {
                showAlert('Pemesanan berhasil dihapus', 'success');
                loadQueueData(); // Reload data
            } else {
                showAlert('Gagal menghapus pemesanan: ' + (data.message || ''), 'danger');
            }
        })
        .catch(error => {
            console.error('Error deleting booking:', error);
            showAlert('Error menghapus pemesanan: ' + error.message, 'danger');
        });
    }

    // Show alert
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const main = document.querySelector('main');
        if (main) {
            main.insertBefore(alertDiv, main.firstChild);
        }
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Initialize everything
    initializeFilters();
    initializeEventListeners();

    // Load initial data
    loadQueueData();

    // Auto refresh every 30 seconds
    setInterval(loadQueueData, 30000);
});
</script>
@endsection