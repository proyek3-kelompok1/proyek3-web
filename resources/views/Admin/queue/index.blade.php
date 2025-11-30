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
                    <option value="vaksinasi">Vaksinasi</option>
                    <option value="konsultasi_umum">Konsultasi Umum</option>
                    <option value="grooming">Grooming</option>
                    <option value="perawatan_gigi">Perawatan Gigi</option>
                    <option value="pemeriksaan_darah">Pemeriksaan Darah</option>
                    <option value="sterilisasi">Sterilisasi</option>
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
                            @php
                                $serviceNames = [
                                    'vaksinasi' => 'Vaksinasi',
                                    'konsultasi_umum' => 'Konsultasi Umum',
                                    'grooming' => 'Grooming',
                                    'perawatan_gigi' => 'Perawatan Gigi',
                                    'pemeriksaan_darah' => 'Pemeriksaan Darah',
                                    'sterilisasi' => 'Sterilisasi'
                                ];
                            @endphp
                            <span class="badge bg-info">{{ $serviceNames[$booking->service_type] ?? $booking->service_type }}</span>
                        </td>
                        <td>
                            @php
                                $doctorNames = [
                                    'drh_roza' => 'drh. Roza Albate Chandra Adila',
                                    'drh_arundhina' => 'drh. Arundhina Girishanta M.Si',
                                ];
                            @endphp
                            <small>{{ $doctorNames[$booking->doctor] ?? $booking->doctor }}</small>
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
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    }

    // Format nama layanan
    const serviceNames = {
        'vaksinasi': 'Vaksinasi',
        'konsultasi_umum': 'Konsultasi Umum',
        'grooming': 'Grooming',
        'perawatan_gigi': 'Perawatan Gigi',
        'pemeriksaan_darah': 'Pemeriksaan Darah',
        'sterilisasi': 'Sterilisasi'
    };

    // Format nama dokter
    const doctorNames = {
        'drh_roza': 'drh. Roza Albate Chandra Adila',
        'drh_arundhina': 'drh. Arundhina Girishanta M.Si', 
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
    // Load queue data
// Load queue data - FIXED VERSION
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
            cancelled: 0
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
                        <span class="badge bg-info">${serviceNames[booking.service_type] || booking.service_type}</span>
                    </td>
                    <td>
                        <small>${doctorNames[booking.doctor] || booking.doctor}</small>
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
    // Update statistics - FIXED VERSION
// Update statistics - FIXED VERSION WITH ID
function updateStats(stats) {
    console.log('Updating stats with:', stats);
    
    // Update using IDs
    const statTotal = document.getElementById('stat-total');
    const statPending = document.getElementById('stat-pending');
    const statConfirmed = document.getElementById('stat-confirmed');
    const statCompleted = document.getElementById('stat-completed');
    const statCancelled = document.getElementById('stat-cancelled');

    if (statTotal) statTotal.textContent = stats.total || 0;
    if (statPending) statPending.textContent = stats.pending || 0;
    if (statConfirmed) statConfirmed.textContent = stats.confirmed || 0;
    if (statCompleted) statCompleted.textContent = stats.completed || 0;
    if (statCancelled) statCancelled.textContent = stats.cancelled || 0;

    // Update queue count badge
    const queueCount = document.getElementById('queueCount');
    if (queueCount) {
        queueCount.textContent = stats.total || 0;
    }

    // Show debug info
    const debugInfo = document.getElementById('debugInfo');
    const debugContent = document.getElementById('debugContent');
    if (debugInfo && debugContent) {
        debugContent.innerHTML = `
            Total: ${stats.total}<br>
            Pending: ${stats.pending}<br>
            Confirmed: ${stats.confirmed}<br>
            Completed: ${stats.completed}<br>
            Cancelled: ${stats.cancelled}
        `;
        debugInfo.classList.remove('d-none');
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
    
    // Gunakan route name yang benar
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
         loadBookingDetailFallback(bookingId);
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

function loadBookingDetailFallback(bookingId) {
    console.log('Using fallback for booking ID:', bookingId);
    
    // Coba load data booking spesifik dari endpoint langsung
    fetch(`/admin/queue/${bookingId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(booking => {
            console.log('Booking data loaded:', booking);
            showBookingDetailModal(booking);
        })
        .catch(error => {
            console.error('Error loading specific booking:', error);
            // Fallback ke data dari queue
            loadFromQueueData(bookingId);
        });
}

// Load dari queue data
function loadFromQueueData(bookingId) {
    fetch(`{{ route('admin.queue.data') }}`)
        .then(response => response.json())
        .then(data => {
            console.log('All bookings data:', data.bookings);
            const booking = data.bookings.find(b => b.id == bookingId);
            if (booking) {
                showBookingDetailModal(booking);
            } else {
                throw new Error(`Booking ID ${bookingId} not found in queue data. Available IDs: ${data.bookings.map(b => b.id).join(', ')}`);
            }
        })
        .catch(error => {
            console.error('Error in queue data fallback:', error);
            showErrorModal(bookingId, error.message);
        });
}

// Tampilkan modal dengan data booking
function showBookingDetailModal(booking) {
    const serviceNames = {
        'vaksinasi': 'Vaksinasi',
        'konsultasi_umum': 'Konsultasi Umum',
        'grooming': 'Grooming',
        'perawatan_gigi': 'Perawatan Gigi',
        'pemeriksaan_darah': 'Pemeriksaan Darah',
        'sterilisasi': 'Sterilisasi'
    };
    
    const statusLabels = {
        'pending': '<span class="badge bg-warning">Menunggu</span>',
        'confirmed': '<span class="badge bg-info">Sedang Dilayani</span>',
        'completed': '<span class="badge bg-success">Selesai</span>',
        'cancelled': '<span class="badge bg-danger">Dibatalkan</span>'
    };

    const doctorNames = {
        'drh_roza': 'drh. Roza Albate Chandra Adila',
        'drh_arundhina': 'drh. Arundhina Girishanta M.Si',
    };

    const html = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="border-bottom pb-2">Informasi Pemilik</h6>
                <table class="table table-sm table-borderless">
                    <tr><th width="40%">Nama Pemilik</th><td>${booking.nama_pemilik}</td></tr>
                    <tr><th>Telepon</th><td>${booking.telepon}</td></tr>
                    <tr><th>Email</th><td>${booking.email || '-'}</td></tr>
                    <tr><th>Alamat</th><td>${booking.alamat || '-'}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="border-bottom pb-2">Informasi Hewan</h6>
                <table class="table table-sm table-borderless">
                    <tr><th width="40%">Nama Hewan</th><td>${booking.nama_hewan}</td></tr>
                    <tr><th>Jenis</th><td>${booking.jenis_hewan}</td></tr>
                    <tr><th>Ras</th><td>${booking.ras}</td></tr>
                    <tr><th>Usia</th><td>${booking.umur || booking.usia || '-'}</td></tr>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <h6 class="border-bottom pb-2">Informasi Layanan</h6>
                <table class="table table-sm table-borderless">
                    <tr><th width="40%">Layanan</th><td><span class="badge bg-info">${serviceNames[booking.service_type] || booking.service_type}</span></td></tr>
                    <tr><th>Dokter</th><td>${doctorNames[booking.doctor] || booking.doctor || '-'}</td></tr>
                    <tr><th>Tanggal</th><td>${formatDate(booking.booking_date)}</td></tr>
                    <tr><th>Waktu</th><td>${booking.booking_time}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="border-bottom pb-2">Status & Informasi</h6>
                <table class="table table-sm table-borderless">
                    <tr><th width="40%">No. Antrian</th><td><span class="badge bg-primary">A${String(booking.nomor_antrian).padStart(3, '0')}</span></td></tr>
                    <tr><th>Kode Booking</th><td><code>${booking.booking_code}</code></td></tr>
                    <tr><th>Status</th><td>${statusLabels[booking.status] || booking.status}</td></tr>
                    <tr><th>Dibuat</th><td>${formatDate(booking.created_at)}</td></tr>
                </table>
            </div>
        </div>
        ${booking.catatan ? `
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="border-bottom pb-2">Catatan</h6>
                <div class="alert alert-light bg-light">
                    <p class="mb-0">${booking.catatan}</p>
                </div>
            </div>
        </div>
        ` : ''}
        <div class="modal-footer mt-3">
            <button type="button" class="btn btn-purple" data-bs-dismiss="modal">Tutup</button>
        </div>
    `;
    
    document.getElementById('bookingModalBody').innerHTML = html;
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
}

// Format date helper
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID');
}

// Tampilkan error modal
function showErrorModal(bookingId, errorMessage) {
    document.getElementById('bookingModalBody').innerHTML = `
        <div class="text-center p-4">
            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
            <h5>Gagal Memuat Detail</h5>
            <p class="text-muted">Data booking tidak ditemukan.</p>
            <p><small>Booking ID: ${bookingId}</small></p>
            <p><small>Error: ${errorMessage}</small></p>
            <div class="mt-3">
                <p class="small text-muted">Pastikan:</p>
                <ul class="small text-muted text-start">
                    <li>Booking dengan ID ${bookingId} ada di database</li>
                    <li>Model ServiceBooking terhubung dengan table yang benar</li>
                    <li>Data memiliki field yang sesuai</li>
                </ul>
            </div>
        </div>
    `;
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
}
    // Delete booking
    // Delete booking - VERSI FIXED
function deleteBooking(bookingId, bookingCode) {
    if (!confirm(`Apakah Anda yakin ingin menghapus pemesanan ${bookingCode}?`)) {
        return;
    }

    // Gunakan route name yang benar
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
            // Jika response bukan JSON, handle differently
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