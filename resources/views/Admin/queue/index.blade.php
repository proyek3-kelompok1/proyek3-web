@extends('admin.layouts.app')

@section('title', 'Kelola Antrian - DV Pets Admin')

@section('styles')
<style>
    .stat-pill {
        border-radius: 16px;
        padding: 16px 20px;
        text-align: center;
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-pill:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12) !important;
    }
    .stat-pill .num {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }
    .stat-pill .lbl {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        opacity: 0.85;
        margin-top: 4px;
    }
    .queue-table th {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f5f3ff;
        color: #6b7280;
        border: none;
        padding: 12px 14px;
        white-space: nowrap;
    }
    .queue-table td {
        vertical-align: middle;
        border-color: #f3f4f6;
        padding: 12px 14px;
    }
    .queue-table tbody tr:hover {
        background: #faf5ff;
    }
    .antrian-badge {
        font-size: 0.85rem;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 8px;
        font-family: monospace;
    }
    .booking-code {
        font-family: 'Courier New', monospace;
        font-size: 0.8rem;
        background: #f3f4f6;
        padding: 3px 7px;
        border-radius: 5px;
        color: #374151;
    }
    .status-select {
        border-radius: 8px;
        font-size: 0.8rem;
        padding: 4px 8px;
        border: 1px solid #e5e7eb;
        min-width: 130px;
    }
    .filter-card {
        background: white;
        border-radius: 14px;
        border: 1px solid #ede9fe;
        padding: 18px 20px;
        margin-bottom: 20px;
    }
    .filter-card label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #7c3aed;
        margin-bottom: 5px;
    }
    .date-hint {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 4px;
    }
    .date-hint a {
        color: #7c3aed;
        cursor: pointer;
        text-decoration: none;
        font-weight: 500;
    }
    .date-hint a:hover { text-decoration: underline; }
    .page-header h1 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1e1b4b;
    }
    .page-header p {
        color: #6b7280;
        margin: 0;
        font-size: 0.875rem;
    }
    .action-btn {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 0.8rem;
        border: 1px solid;
        transition: all 0.2s;
    }
    .table-empty {
        padding: 48px 20px;
        text-align: center;
        color: #9ca3af;
    }
    .table-empty i { font-size: 2.5rem; margin-bottom: 12px; display: block; }
    .auto-refresh-badge {
        background: #ede9fe;
        color: #7c3aed;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .alert-custom {
        border-radius: 12px;
        border: none;
        padding: 10px 16px;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('content')

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div>
            <h1><i class="fas fa-list-ol me-2" style="color: #7c3aed;"></i>Kelola Antrian</h1>
            <p>Manajemen booking & antrian layanan klinik</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="auto-refresh-badge"><i class="fas fa-sync-alt me-1"></i>Auto-refresh 30s</span>
            <button class="btn btn-purple btn-sm" id="refreshBtn">
                <i class="fas fa-sync-alt me-1"></i>Refresh
            </button>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Alert area (disi via JS) -->
<div id="alertArea"></div>

<!-- ========= STATISTIK ========= -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="stat-pill card shadow-sm" style="background: linear-gradient(135deg,#7c3aed,#a855f7); color:white;">
            <div class="num" id="stat-total">{{ $stats['total'] }}</div>
            <div class="lbl">Total</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-pill card shadow-sm" style="background: linear-gradient(135deg,#d97706,#fbbf24); color:white;">
            <div class="num" id="stat-pending">{{ $stats['pending'] }}</div>
            <div class="lbl">Menunggu</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-pill card shadow-sm" style="background: linear-gradient(135deg,#0ea5e9,#38bdf8); color:white;">
            <div class="num" id="stat-confirmed">{{ $stats['confirmed'] }}</div>
            <div class="lbl">Dilayani</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-pill card shadow-sm" style="background: linear-gradient(135deg,#059669,#34d399); color:white;">
            <div class="num" id="stat-completed">{{ $stats['completed'] }}</div>
            <div class="lbl">Selesai</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-pill card shadow-sm" style="background: linear-gradient(135deg,#dc2626,#f87171); color:white;">
            <div class="num" id="stat-cancelled">{{ $stats['cancelled'] }}</div>
            <div class="lbl">Dibatalkan</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="stat-pill card shadow-sm" style="background: linear-gradient(135deg,#6b7280,#9ca3af); color:white;">
            <div class="num" id="stat-no-record">0</div>
            <div class="lbl">Belum RM</div>
        </div>
    </div>
</div>

<!-- ========= FILTER ========= -->
<div class="filter-card">
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label>Filter Tanggal</label>
            <input type="date" class="form-control" id="dateFilter" placeholder="Semua tanggal">
            @if($availableDates->count())
            <div class="date-hint">
                Tanggal ada data:
                @foreach($availableDates->take(5) as $d => $count)
                    <a onclick="setDate('{{ $d }}')">{{ \Carbon\Carbon::parse($d)->format('d/m') }}({{ $count }})</a>
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-md-3">
            <label>Jenis Layanan</label>
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
        <div class="col-md-3">
            <label>Status</label>
            <select class="form-select" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="confirmed">Sedang Dilayani</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
                <option value="completed_no_record">Selesai (Belum Rekam Medis)</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-purple flex-grow-1" id="applyFilter">
                <i class="fas fa-search me-1"></i>Cari
            </button>
            <button class="btn btn-outline-purple" id="resetFilter" title="Reset Filter">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>

<!-- ========= TABEL ANTRIAN ========= -->
<div class="card shadow-sm" style="border-radius: 14px; border: none;">
    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg,#7c3aed,#9d5ced); border-radius: 14px 14px 0 0; border: none; padding: 14px 20px;">
        <h5 class="mb-0 text-white" style="font-size: 1rem; font-weight: 600;">
            <i class="fas fa-table me-2"></i>Daftar Booking & Antrian
            <span class="badge ms-2" style="background: rgba(255,255,255,0.2);" id="queueCount">{{ $allBookings->count() }}</span>
        </h5>
        <small class="text-white" style="opacity: 0.75;" id="lastUpdated">-</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table queue-table mb-0" id="queueTable">
                <thead>
                    <tr>
                        <th>No. Antrian</th>
                        <th>Kode</th>
                        <th>Pemilik</th>
                        <th>Hewan</th>
                        <th>Layanan</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Dokter</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="queueTableBody">
                    @forelse($allBookings as $booking)
                    <tr data-booking-id="{{ $booking->id }}">
                        <td>
                            <span class="antrian-badge bg-primary text-white">
                                A{{ str_pad($booking->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td><span class="booking-code">{{ $booking->booking_code }}</span></td>
                        <td>
                            <div class="fw-600" style="font-size: 0.875rem;">{{ $booking->nama_pemilik }}</div>
                            <small class="text-muted">{{ $booking->telepon }}</small>
                        </td>
                        <td>
                            <div style="font-size: 0.875rem;">{{ $booking->nama_hewan }}</div>
                            <small class="text-muted">{{ $booking->jenis_hewan }} — {{ $booking->ras }}</small>
                        </td>
                        <td>
                            <span class="badge" style="background:#ede9fe; color:#7c3aed; font-size: 0.78rem;">
                                {{ $booking->service_name }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 0.875rem; font-weight: 600; color: #374151;">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                            </div>
                            <small class="text-muted">{{ $booking->booking_time }}</small>
                        </td>
                        <td>
                            <small style="color: #374151;">{{ $booking->doctor_name ?? '—' }}</small>
                        </td>
                        <td>
                            <select class="form-select status-select" data-booking-id="{{ $booking->id }}">
                                <option value="pending"    {{ $booking->status == 'pending'    ? 'selected' : '' }}>⏳ Menunggu</option>
                                <option value="confirmed"  {{ $booking->status == 'confirmed'  ? 'selected' : '' }}>🔵 Dilayani</option>
                                <option value="completed"  {{ $booking->status == 'completed'  ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="cancelled"  {{ $booking->status == 'cancelled'  ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="action-btn btn-outline-info view-booking"
                                        style="color: #0ea5e9; border-color: #bae6fd;"
                                        data-booking-id="{{ $booking->id }}"
                                        title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($booking->status == 'completed' && !$booking->has_medical_record)
                                <a href="{{ route('admin.medical-records.create', $booking->id) }}"
                                   class="action-btn"
                                   style="color: #059669; border-color: #6ee7b7; border: 1px solid;"
                                   title="Buat Rekam Medis">
                                    <i class="fas fa-file-medical"></i>
                                </a>
                                @endif
                                <button class="action-btn btn-outline-danger delete-booking"
                                        style="color: #dc2626; border-color: #fca5a5;"
                                        data-booking-id="{{ $booking->id }}"
                                        data-booking-code="{{ $booking->booking_code }}"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="table-empty">
                                <i class="fas fa-calendar-times text-muted"></i>
                                <p class="mb-0">Belum ada data booking</p>
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
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 25px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(90deg,#7c3aed,#9d5ced); border-radius: 16px 16px 0 0;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-clipboard-list me-2"></i>Detail Pemesanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="bookingModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-purple"></div>
                    <p class="mt-2 text-muted">Memuat detail...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const serviceNames = {
        general: 'Konsultasi Umum', vaccination: 'Vaksinasi', grooming: 'Grooming',
        dental: 'Perawatan Gigi', surgery: 'Operasi', laboratory: 'Laboratorium',
        inpatient: 'Rawat Inap', emergency: 'Darurat'
    };

    // ===== FILTER HELPERS =====
    function setDate(d) {
        document.getElementById('dateFilter').value = d;
        loadQueueData();
    }
    window.setDate = setDate; // expose global untuk onclick

    document.getElementById('applyFilter').addEventListener('click', loadQueueData);
    document.getElementById('resetFilter').addEventListener('click', function () {
        document.getElementById('dateFilter').value = '';
        document.getElementById('serviceFilter').value = '';
        document.getElementById('statusFilter').value = '';
        loadQueueData();
    });
    document.getElementById('refreshBtn').addEventListener('click', loadQueueData);

    // ===== LOAD QUEUE DATA =====
    function loadQueueData() {
        const date    = document.getElementById('dateFilter').value    || '';
        const service = document.getElementById('serviceFilter').value || '';
        const status  = document.getElementById('statusFilter').value  || '';

        const tbody = document.getElementById('queueTableBody');
        tbody.innerHTML = `
            <tr><td colspan="9">
                <div class="table-empty">
                    <i class="fas fa-spinner fa-spin text-purple"></i>
                    <p class="mt-2 mb-0" style="color:#7c3aed;">Memuat data...</p>
                </div>
            </td></tr>`;

        const url = `{{ route('admin.queue.data') }}?date=${date}&service_type=${service}&status=${status}`;

        fetch(url, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(data => {
            if (data.success) {
                renderTable(data.bookings);
                updateStats(data.stats);
                document.getElementById('lastUpdated').textContent =
                    'Diperbarui: ' + new Date().toLocaleTimeString('id-ID');
            } else {
                showTableError(data.message || 'Gagal memuat data');
            }
        })
        .catch(err => {
            console.error(err);
            showTableError('Gagal memuat data: ' + err.message);
        });
    }

    // ===== RENDER TABLE =====
    function renderTable(bookings) {
        const tbody = document.getElementById('queueTableBody');
        document.getElementById('queueCount').textContent = bookings.length;

        if (!bookings || bookings.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="9">
                    <div class="table-empty">
                        <i class="fas fa-calendar-times text-muted"></i>
                        <p class="mb-1">Tidak ada data untuk filter yang dipilih</p>
                        <small class="text-muted">Coba ubah filter tanggal atau kosongkan filter</small>
                    </div>
                </td></tr>`;
            return;
        }

        let html = '';
        bookings.forEach(b => {
            const noAntrian = String(b.nomor_antrian).padStart(3, '0');
            const tgl = b.booking_date
            ? (() => {
                // booking_date might come as "YYYY-MM-DD" or "YYYY-MM-DD 00:00:00"
                const raw = String(b.booking_date).substring(0, 10);
                const [y, m, d] = raw.split('-');
                const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                return `${parseInt(d)} ${months[parseInt(m)-1]} ${y}`;
              })()
            : '-';
            const svcName = b.service_name || b.service_name_label || serviceNames[b.service_type] || b.service_type || '-';
            const docName = b.doctor_name || b.doctor_name_label || '—';
            const hasMR   = b.has_medical_record || false;

            const medBtn = b.status === 'completed' && !hasMR
                ? `<a href="{{ url('admin/medical-records/create') }}/${b.id}"
                      class="action-btn" style="color:#059669;border:1px solid #6ee7b7;text-decoration:none;" title="Buat Rekam Medis">
                      <i class="fas fa-file-medical"></i>
                   </a>` : '';

            html += `
            <tr data-booking-id="${b.id}">
                <td><span class="antrian-badge bg-primary text-white">A${noAntrian}</span></td>
                <td><span class="booking-code">${b.booking_code}</span></td>
                <td>
                    <div class="fw-bold" style="font-size:.875rem;">${b.nama_pemilik}</div>
                    <small class="text-muted">${b.telepon || ''}</small>
                </td>
                <td>
                    <div style="font-size:.875rem;">${b.nama_hewan}</div>
                    <small class="text-muted">${b.jenis_hewan} — ${b.ras || ''}</small>
                </td>
                <td><span class="badge" style="background:#ede9fe;color:#7c3aed;font-size:.78rem;">${svcName}</span></td>
                <td>
                    <div style="font-size:.875rem;font-weight:600;color:#374151;">${tgl}</div>
                    <small class="text-muted">${b.booking_time || ''}</small>
                </td>
                <td><small style="color:#374151;">${docName}</small></td>
                <td>
                    <select class="form-select status-select" data-booking-id="${b.id}">
                        <option value="pending"   ${b.status==='pending'   ?'selected':''}>⏳ Menunggu</option>
                        <option value="confirmed" ${b.status==='confirmed' ?'selected':''}>🔵 Dilayani</option>
                        <option value="completed" ${b.status==='completed' ?'selected':''}>✅ Selesai</option>
                        <option value="cancelled" ${b.status==='cancelled' ?'selected':''}>❌ Dibatalkan</option>
                    </select>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="action-btn btn-outline-info view-booking"
                                style="color:#0ea5e9;border-color:#bae6fd;"
                                data-booking-id="${b.id}" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${medBtn}
                        <button class="action-btn btn-outline-danger delete-booking"
                                style="color:#dc2626;border-color:#fca5a5;"
                                data-booking-id="${b.id}"
                                data-booking-code="${b.booking_code}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        });

        tbody.innerHTML = html;
        bindTableEvents();
    }

    // ===== UPDATE STATS =====
    function updateStats(s) {
        document.getElementById('stat-total').textContent     = s.total     || 0;
        document.getElementById('stat-pending').textContent   = s.pending   || 0;
        document.getElementById('stat-confirmed').textContent = s.confirmed || 0;
        document.getElementById('stat-completed').textContent = s.completed || 0;
        document.getElementById('stat-cancelled').textContent = s.cancelled || 0;
        document.getElementById('stat-no-record').textContent = s.completed_no_record || 0;
    }

    // ===== BIND EVENTS =====
    function bindTableEvents() {
        // Status change
        document.querySelectorAll('.status-select').forEach(sel => {
            sel.addEventListener('change', function () {
                updateStatus(this.dataset.bookingId, this.value, this);
            });
        });
        // View detail
        document.querySelectorAll('.view-booking').forEach(btn => {
            btn.addEventListener('click', () => showDetail(btn.dataset.bookingId));
        });
        // Delete
        document.querySelectorAll('.delete-booking').forEach(btn => {
            btn.addEventListener('click', () => deleteBooking(btn.dataset.bookingId, btn.dataset.bookingCode));
        });
        // Tooltips
        document.querySelectorAll('[title]').forEach(el => new bootstrap.Tooltip(el, { trigger: 'hover' }));
    }

    // ===== UPDATE STATUS =====
    function updateStatus(id, status, selectEl) {
        const url = `{{ route('admin.queue.updateStatus', ':id') }}`.replace(':id', id);

        // Visual feedback
        selectEl.disabled = true;
        selectEl.style.opacity = '0.6';

        fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showAlert('✅ Status berhasil diperbarui ke "' + getStatusLabel(status) + '"', 'success');
                loadQueueData();
            } else {
                showAlert('❌ Gagal update status', 'danger');
                selectEl.disabled = false;
                selectEl.style.opacity = '';
            }
        })
        .catch(err => {
            showAlert('❌ Error: ' + err.message, 'danger');
            selectEl.disabled = false;
            selectEl.style.opacity = '';
        });
    }

    // ===== SHOW DETAIL =====
    function showDetail(id) {
        document.getElementById('bookingModalBody').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border" style="color:#7c3aed;"></div>
                <p class="mt-2 text-muted">Memuat detail...</p>
            </div>`;
        new bootstrap.Modal(document.getElementById('bookingModal')).show();

        const url = `{{ route('admin.queue.detail', ':id') }}`.replace(':id', id);
        fetch(url, { headers: { 'Accept': 'text/html', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { document.getElementById('bookingModalBody').innerHTML = html; })
            .catch(err => {
                document.getElementById('bookingModalBody').innerHTML =
                    `<div class="text-center p-4 text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                        <p>Gagal memuat detail: ${err.message}</p>
                     </div>`;
            });
    }

    // ===== DELETE BOOKING =====
    function deleteBooking(id, code) {
        if (!confirm(`Yakin ingin menghapus booking ${code}?\nTindakan ini tidak bisa dibatalkan.`)) return;

        const url = `{{ route('admin.queue.destroy', ':id') }}`.replace(':id', id);
        fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showAlert('🗑️ ' + (data.message || 'Booking berhasil dihapus'), 'success');
                loadQueueData();
            } else {
                showAlert('❌ Gagal hapus: ' + data.message, 'danger');
            }
        })
        .catch(err => showAlert('❌ Error: ' + err.message, 'danger'));
    }

    // ===== HELPERS =====
    function getStatusLabel(s) {
        return { pending: 'Menunggu', confirmed: 'Sedang Dilayani', completed: 'Selesai', cancelled: 'Dibatalkan' }[s] || s;
    }

    function showAlert(msg, type) {
        const area = document.getElementById('alertArea');
        const div  = document.createElement('div');
        div.className = `alert alert-${type} alert-custom alert-dismissible fade show`;
        div.innerHTML = `${msg} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        area.prepend(div);
        setTimeout(() => div.remove(), 5000);
    }

    function showTableError(msg) {
        document.getElementById('queueTableBody').innerHTML = `
            <tr><td colspan="9">
                <div class="table-empty">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                    <p class="mb-1 text-danger">${msg}</p>
                    <button class="btn btn-sm btn-outline-purple mt-2" onclick="loadQueueData()">
                        <i class="fas fa-redo me-1"></i>Coba Lagi
                    </button>
                </div>
            </td></tr>`;
    }

    // Init: bind events pada server-rendered rows
    bindTableEvents();

    // Load data dari AJAX saat halaman siap
    loadQueueData();

    // Auto-refresh setiap 30 detik
    setInterval(loadQueueData, 30000);
});
</script>
@endsection