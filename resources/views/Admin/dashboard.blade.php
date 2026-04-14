@extends('admin.layouts.app')

@section('title', 'Dashboard - DV Pets Admin')

@section('styles')
<style>
    .stat-card-value {
        font-size: 2.2rem;
        font-weight: 700;
        line-height: 1;
        margin: 8px 0 4px;
    }
    .stat-card-label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        opacity: 0.85;
    }
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    .today-bar {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        border-radius: 16px;
        color: white;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }
    .today-bar::after {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 120px; height: 120px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .today-bar::before {
        content: '';
        position: absolute;
        bottom: -50px; right: 60px;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .queue-mini {
        background: rgba(255,255,255,0.15);
        border-radius: 10px;
        padding: 12px 16px;
        text-align: center;
        backdrop-filter: blur(4px);
    }
    .queue-mini .num {
        font-size: 1.8rem;
        font-weight: 700;
    }
    .queue-mini .lbl {
        font-size: 0.72rem;
        opacity: 0.85;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 5px;
    }
    .rating-stars { color: #f59e0b; }
    .chart-bar {
        transition: height 0.5s ease;
    }
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
    }
    .page-header {
        margin-bottom: 28px;
    }
    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e1b4b;
    }
    .page-header p {
        color: #6b7280;
        margin: 0;
    }
    .quick-actions a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 10px;
        background: #f5f3ff;
        color: #7c3aed;
        font-weight: 500;
        font-size: 0.875rem;
        text-decoration: none;
        border: 1px solid #ede9fe;
        transition: all 0.2s;
    }
    .quick-actions a:hover {
        background: #7c3aed;
        color: white;
        border-color: #7c3aed;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(124,58,237,0.25);
    }
    .quick-actions a i {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: rgba(124,58,237,0.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
    }
    .quick-actions a:hover i {
        background: rgba(255,255,255,0.2);
    }
    .status-dot {
        display: inline-block;
        width: 8px; height: 8px;
        border-radius: 50%;
        margin-right: 6px;
    }
    .booking-code {
        font-family: monospace;
        font-size: 0.8rem;
        background: #f3f4f6;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h1><i class="fas fa-chart-pie me-2" style="color: #7c3aed;"></i>Dashboard</h1>
            <p>Ringkasan aktivitas klinik — <strong>{{ now()->format('l, d F Y') }}</strong></p>
        </div>
        <a href="{{ route('admin.queue.index') }}" class="btn btn-purple">
            <i class="fas fa-list-ol me-2"></i>Lihat Antrian
        </a>
    </div>
</div>

<!-- ========= STAT CARDS ========= -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg, #7c3aed, #9d5ced); color: white;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-card-label">Total Layanan</div>
                    <div class="stat-card-value">{{ $totalServices }}</div>
                    <small style="opacity: 0.8;">Layanan terdaftar</small>
                </div>
                <div class="stat-icon" style="background: rgba(255,255,255,0.2);">
                    <i class="fas fa-stethoscope" style="color: white;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg, #059669, #10b981); color: white;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-card-label">Dokter Aktif</div>
                    <div class="stat-card-value">{{ $activeDoctors }}</div>
                    <small style="opacity: 0.8;">Dokter siap melayani</small>
                </div>
                <div class="stat-icon" style="background: rgba(255,255,255,0.2);">
                    <i class="fas fa-user-md" style="color: white;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg, #d97706, #f59e0b); color: white;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-card-label">Ulasan & Pesan</div>
                    <div class="stat-card-value">{{ $totalMessages }}</div>
                    <small style="opacity: 0.8;">
                        ⭐ Rating rata-rata: <strong>{{ number_format($avgRating, 1) }}</strong>
                    </small>
                </div>
                <div class="stat-icon" style="background: rgba(255,255,255,0.2);">
                    <i class="fas fa-comments" style="color: white;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-card-label">Artikel Edukasi</div>
                    <div class="stat-card-value">{{ $totalEducation }}</div>
                    <small style="opacity: 0.8;">Artikel dipublikasikan</small>
                </div>
                <div class="stat-icon" style="background: rgba(255,255,255,0.2);">
                    <i class="fas fa-graduation-cap" style="color: white;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========= TODAY'S QUEUE BANNER ========= -->
<div class="today-bar mb-4">
    <div class="row align-items-center">
        <div class="col-md-5">
            <h5 class="mb-1" style="font-weight: 700; font-size: 1.2rem;">
                <i class="fas fa-calendar-day me-2"></i>Antrian Hari Ini
            </h5>
            <p style="opacity: 0.8; font-size: 0.875rem; margin: 0;">{{ now()->format('d F Y') }}</p>
        </div>
        <div class="col-md-7">
            <div class="row g-2">
                <div class="col-3">
                    <div class="queue-mini">
                        <div class="num">{{ $todayBookings }}</div>
                        <div class="lbl">Total</div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="queue-mini">
                        <div class="num">{{ $bookingStats['pending'] }}</div>
                        <div class="lbl">Menunggu</div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="queue-mini">
                        <div class="num">{{ $bookingStats['confirmed'] }}</div>
                        <div class="lbl">Dilayani</div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="queue-mini">
                        <div class="num">{{ $bookingStats['completed'] }}</div>
                        <div class="lbl">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- ========= WEEKLY CHART ========= -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-body">
                <div class="section-title">
                    <i class="fas fa-chart-bar me-2" style="color: #7c3aed;"></i>Booking 7 Hari Terakhir
                </div>
                <div class="d-flex align-items-end gap-2" style="height: 150px;">
                    @php
                        $counts = array_column($weeklyBookings, 'count');
                        $counts[] = 1;
                        $maxCount = max($counts);
                    @endphp
                    @foreach($weeklyBookings as $day)
                    @php $pct = ($day['count'] / $maxCount) * 100; @endphp
                    <div class="flex-1 text-center" style="flex: 1;">
                        <div style="font-size: 0.75rem; font-weight: 600; color: #7c3aed; margin-bottom: 4px;">
                            {{ $day['count'] > 0 ? $day['count'] : '' }}
                        </div>
                        <div style="
                            height: {{ max(8, ($pct / 100) * 120) }}px;
                            background: linear-gradient(180deg, #7c3aed, #c4b5fd);
                            border-radius: 6px 6px 0 0;
                            transition: all 0.4s;
                            min-height: 8px;
                        "></div>
                        <div style="font-size: 0.7rem; color: #9ca3af; margin-top: 4px;">{{ $day['date'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ========= QUICK ACTIONS ========= -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="section-title">
                    <i class="fas fa-bolt me-2" style="color: #7c3aed;"></i>Aksi Cepat
                </div>
                <div class="quick-actions d-flex flex-column gap-2">
                    <a href="{{ route('admin.services.create') }}">
                        <i class="fas fa-plus"></i>
                        Tambah Layanan
                    </a>
                    <a href="{{ route('admin.doctors.create') }}">
                        <i class="fas fa-user-plus"></i>
                        Tambah Dokter
                    </a>
                    <a href="{{ route('admin.education.create') }}">
                        <i class="fas fa-pencil-alt"></i>
                        Tulis Artikel
                    </a>
                    <a href="{{ route('admin.queue.index') }}">
                        <i class="fas fa-list-ol"></i>
                        Lihat Antrian
                    </a>
                    <a href="{{ route('admin.messages.index') }}">
                        <i class="fas fa-comments"></i>
                        Baca Ulasan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- ========= RECENT BOOKINGS ========= -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title mb-0">
                        <i class="fas fa-calendar-check me-2" style="color: #7c3aed;"></i>Booking Terbaru
                    </div>
                    <a href="{{ route('admin.queue.index') }}" class="btn btn-sm btn-outline-purple">Lihat Semua</a>
                </div>
                @forelse($recentBookings as $booking)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    <div class="stat-icon" style="
                        width: 40px; height: 40px; border-radius: 10px;
                        background: #f5f3ff; font-size: 1rem; flex-shrink: 0;
                    ">
                        <i class="fas fa-paw" style="color: #7c3aed;"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-600" style="font-size: 0.875rem; color: #111827;">
                            {{ $booking->nama_pemilik }}
                            <span class="booking-code ms-1">{{ $booking->booking_code }}</span>
                        </div>
                        <div style="font-size: 0.78rem; color: #6b7280;">
                            {{ $booking->service_name }} • {{ $booking->nama_hewan }}
                        </div>
                    </div>
                    <div class="text-end" style="flex-shrink: 0;">
                        @php
                            $statusMap = [
                                'pending'   => ['bg-warning text-dark', 'Menunggu'],
                                'confirmed' => ['bg-info text-white', 'Dilayani'],
                                'completed' => ['bg-success text-white', 'Selesai'],
                                'cancelled' => ['bg-danger text-white', 'Batal'],
                            ];
                            $s = $statusMap[$booking->status] ?? ['bg-secondary text-white', $booking->status];
                        @endphp
                        <span class="badge {{ $s[0] }}" style="font-size: 0.72rem;">{{ $s[1] }}</span>
                        <div style="font-size: 0.72rem; color: #9ca3af; margin-top: 2px;">
                            {{ $booking->created_at->format('d/m H:i') }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-calendar-times fa-2x mb-2"></i>
                    <p class="mb-0">Belum ada booking</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ========= RECENT REVIEWS ========= -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title mb-0">
                        <i class="fas fa-star me-2" style="color: #f59e0b;"></i>Ulasan Terbaru
                    </div>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-purple">Lihat Semua</a>
                </div>
                @forelse($recentFeedback as $fb)
                <div class="py-2 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="fw-600" style="font-size: 0.875rem; color: #111827;">{{ $fb->name }}</div>
                        <div class="rating-stars" style="font-size: 0.75rem; color: #f59e0b;">
                            @for($i=1;$i<=5;$i++)
                                <i class="{{ $i <= $fb->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p style="font-size: 0.8rem; color: #6b7280; margin: 4px 0 0; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        {{ $fb->message }}
                    </p>
                    <div style="font-size: 0.72rem; color: #9ca3af;">{{ $fb->created_at->format('d M Y') }}</div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-comment-slash fa-2x mb-2"></i>
                    <p class="mb-0">Belum ada ulasan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ========= ADMIN INFO ========= -->
<div class="card mt-3" style="background: linear-gradient(135deg, #ede9fe, #f5f3ff); border: 1px solid #ddd6fe;">
    <div class="card-body py-3">
        <div class="d-flex align-items-center gap-3">
            <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #7c3aed, #9d5ced);">
                <i class="fas fa-user-shield" style="color: white; font-size: 1rem;"></i>
            </div>
            <div>
                <div style="font-weight: 600; color: #1e1b4b;">{{ Auth::guard('admin')->user()->name }}</div>
                <div style="font-size: 0.8rem; color: #6b7280;">
                    {{ Auth::guard('admin')->user()->email }} &bull; Login: {{ now()->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection