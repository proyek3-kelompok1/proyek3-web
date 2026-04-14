{{-- Modal Detail Booking --}}
{{-- Cara pakai: include atau taruh di dalam @section('content') --}}

<style>
:root {
    --purple-50: #EEEDFE;
    --purple-100: #CECBF6;
    --purple-200: #AFA9EC;
    --purple-400: #7F77DD;
    --purple-600: #534AB7;
    --purple-800: #3C3489;
    --purple-900: #26215C;
}
* { box-sizing: border-box; margin: 0; padding: 0; }

.modal-wrap {
    background: rgba(38,33,92,0.18);
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 12px;
    border-radius: 16px;
}
.modal-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid var(--purple-200);
    width: 100%;
    max-width: 720px;
    overflow: hidden;
    box-shadow: 0 0 0 4px var(--purple-50);
}
.modal-header {
    background: linear-gradient(135deg, var(--purple-800) 0%, var(--purple-600) 100%);
    padding: 22px 28px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.modal-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.header-icon {
    width: 42px; height: 42px;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid rgba(255,255,255,0.2);
}
.header-icon svg {
    width: 22px; height: 22px;
    fill: none; stroke: #fff;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.modal-title { color: #fff; font-size: 17px; font-weight: 600; }
.modal-subtitle { color: var(--purple-100); font-size: 12px; margin-top: 2px; }
.booking-code-badge {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    padding: 6px 14px;
    color: #fff;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.5px;
    font-family: monospace;
}
.modal-body { padding: 24px 28px; background: #f8f7ff; }

/* Status Bar */
.status-row {
    background: #fff;
    border-radius: 14px;
    padding: 16px 18px;
    border: 0.5px solid var(--purple-100);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.status-item { display: flex; flex-direction: column; gap: 4px; }
.status-item .sk {
    font-size: 10px;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-weight: 500;
}
.badge-antrian {
    background: var(--purple-600);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    display: inline-block;
}
.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
}
.badge-purple   { background: var(--purple-50); color: var(--purple-800); border: 1px solid var(--purple-200); }
.badge-pending  { background: #FAEEDA; color: #633806; }
.badge-confirmed{ background: var(--purple-50); color: var(--purple-800); border: 1px solid var(--purple-200); }
.badge-completed{ background: #EAF3DE; color: #27500A; }
.badge-cancelled{ background: #FCEBEB; color: #791F1F; }

/* Info grid */
.section-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}
@media (max-width: 520px) { .section-grid { grid-template-columns: 1fr; } }

.info-section {
    background: #fff;
    border-radius: 14px;
    padding: 16px 18px;
    border: 0.5px solid var(--purple-100);
}
.section-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--purple-600);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 7px;
    padding-bottom: 10px;
    border-bottom: 1.5px solid var(--purple-100);
}
.section-label svg {
    width: 14px; height: 14px;
    fill: none;
    stroke: var(--purple-600);
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 6px 0;
    gap: 8px;
}
.info-row + .info-row { border-top: 0.5px solid #f0eeff; }
.info-key  { font-size: 12px; color: #888; white-space: nowrap; min-width: 80px; padding-top: 1px; }
.info-val  { font-size: 13px; color: #1a1a2e; font-weight: 600; text-align: right; }
.info-val.mono { font-family: monospace; font-size: 12px; }

/* Notes */
.notes-box {
    background: var(--purple-50);
    border: 1px solid var(--purple-100);
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-size: 13px;
    color: var(--purple-900);
    line-height: 1.6;
}
.notes-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    color: var(--purple-600);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.notes-label svg {
    width: 13px; height: 13px;
    fill: none;
    stroke: var(--purple-600);
    stroke-width: 1.8;
    stroke-linecap: round;
}

/* Footer */
.modal-footer {
    padding: 16px 28px 20px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    border-top: 1px solid var(--purple-100);
    background: #fff;
}
.btn-tutup {
    background: var(--purple-600);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 28px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.18s, transform 0.1s;
    font-family: inherit;
    letter-spacing: 0.3px;
}
.btn-tutup:hover  { background: var(--purple-800); }
.btn-tutup:active { transform: scale(0.97); background: var(--purple-900); }
.btn-outline-purple {
    background: transparent;
    color: var(--purple-600);
    border: 1px solid var(--purple-200);
    border-radius: 10px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.18s, border-color 0.18s;
    font-family: inherit;
}
.btn-outline-purple:hover { background: var(--purple-50); border-color: var(--purple-400); }
</style>

<div class="modal-wrap">
  <div class="modal-card" id="bookingDetailCard">

    {{-- ===== HEADER ===== --}}
    <div class="modal-header">
      <div class="modal-header-left">
        <div class="header-icon">
          <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/><path d="M9 12h6M9 16h4"/></svg>
        </div>
        <div>
          <div class="modal-title">Detail Booking</div>
          <div class="modal-subtitle">
            Klinik Hewan Peliharaan
            &nbsp;•&nbsp;
            {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') : '-' }}
          </div>
        </div>
      </div>
      <div class="booking-code-badge">{{ $booking->booking_code ?? 'N/A' }}</div>
    </div>

    {{-- ===== BODY ===== --}}
    <div class="modal-body">

      {{-- Status Bar --}}
      <div class="status-row">
        <div class="status-item">
          <span class="sk">No. Antrian</span>
          @if(isset($booking->nomor_antrian))
            <span class="badge-antrian">A{{ str_pad($booking->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</span>
          @else
            <span style="font-size:13px;color:#888">N/A</span>
          @endif
        </div>

        <div class="status-item">
          <span class="sk">Status</span>
          @php
            $statusBadge = [
              'pending'   => ['class' => 'badge badge-pending',   'label' => 'Menunggu'],
              'confirmed' => ['class' => 'badge badge-confirmed', 'label' => 'Sedang Dilayani'],
              'completed' => ['class' => 'badge badge-completed', 'label' => 'Selesai'],
              'cancelled' => ['class' => 'badge badge-cancelled', 'label' => 'Dibatalkan'],
            ];
            $s = $statusBadge[$booking->status] ?? ['class' => 'badge badge-purple', 'label' => $booking->status ?? 'N/A'];
          @endphp
          <span class="{{ $s['class'] }}">{{ $s['label'] }}</span>
        </div>

        <div class="status-item">
          <span class="sk">Layanan</span>
          @php
            $serviceNames = [
              'vaksinasi'        => 'Vaksinasi',
              'konsultasi_umum'  => 'Konsultasi Umum',
              'grooming'         => 'Grooming',
              'perawatan_gigi'   => 'Perawatan Gigi',
              'pemeriksaan_darah'=> 'Pemeriksaan Darah',
              'sterilisasi'      => 'Sterilisasi',
            ];
          @endphp
          <span class="badge badge-purple">
            {{ $serviceNames[$booking->service_type] ?? $booking->service_type ?? 'N/A' }}
          </span>
        </div>

        <div class="status-item">
          <span class="sk">Waktu Booking</span>
          <span style="font-size:13px;font-weight:600;color:#1a1a2e">{{ $booking->booking_time ?? 'N/A' }}</span>
        </div>

        <div class="status-item">
          <span class="sk">Dibuat</span>
          <span style="font-size:12px;color:#888">
            {{ isset($booking->created_at) ? $booking->created_at->format('d/m/Y H:i') : '-' }}
          </span>
        </div>
      </div>

      {{-- Info Grid --}}
      <div class="section-grid">

        {{-- Pemilik --}}
        <div class="info-section">
          <div class="section-label">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Informasi Pemilik
          </div>
          <div class="info-row">
            <span class="info-key">Nama</span>
            <span class="info-val">{{ $booking->nama_pemilik ?? 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="info-key">Telepon</span>
            <span class="info-val">{{ $booking->telepon ?? 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="info-key">Email</span>
            <span class="info-val">{{ $booking->email ?? '-' }}</span>
          </div>
          <div class="info-row">
            <span class="info-key">Alamat</span>
            <span class="info-val" style="max-width:160px">{{ $booking->alamat ?? '-' }}</span>
          </div>
        </div>

        {{-- Hewan --}}
        <div class="info-section">
          <div class="section-label">
            <svg viewBox="0 0 24 24"><path d="M10 5.172C10 3.782 8.423 2.679 6.5 3c-2.823.47-4.113 6.006-4 7 .08.703 1.725 1.722 3.656 2.028.954.155 1.544.432 1.844.932"/><path d="M14.267 5.172c0-1.39 1.577-2.493 3.5-2.172 2.823.47 4.113 6.006 4 7-.08.703-1.725 1.722-3.656 2.028-.954.155-1.544.432-1.844.932"/><path d="M8 14v.5M16 14v.5M11.25 16.25h1.5M8.5 21h7l-.5-4H9l-.5 4z"/></svg>
            Informasi Hewan
          </div>
          <div class="info-row">
            <span class="info-key">Nama</span>
            <span class="info-val">{{ $booking->nama_hewan ?? 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="info-key">Jenis</span>
            <span class="info-val">{{ $booking->jenis_hewan ?? 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="info-key">Ras</span>
            <span class="info-val">{{ $booking->ras ?? 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="info-key">Usia</span>
            <span class="info-val">{{ $booking->umur ?? $booking->usia ?? '-' }}</span>
          </div>
        </div>

        {{-- Jadwal --}}
        <div class="info-section">
          <div class="section-label">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Jadwal
          </div>
          <div class="info-row">
            <span class="info-key">Tanggal</span>
            <span class="info-val">
              {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') : 'N/A' }}
            </span>
          </div>
          <div class="info-row">
            <span class="info-key">Waktu</span>
            <span class="info-val">{{ $booking->booking_time ?? 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="info-key">Layanan</span>
            <span class="info-val">{{ $serviceNames[$booking->service_type] ?? $booking->service_type ?? 'N/A' }}</span>
          </div>
        </div>

        {{-- Dokter --}}
        <div class="info-section">
          <div class="section-label">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Dokter
          </div>
          <div class="info-row">
            <span class="info-key">Nama</span>
            <span class="info-val">
              @if($booking->doctor)
                {{ $booking->doctor->name }}
              @else
                <span style="color:#aaa;font-weight:400">-</span>
              @endif
            </span>
          </div>
          <div class="info-row">
            <span class="info-key">Spesialisasi</span>
            <span class="info-val">
              @if($booking->doctor && $booking->doctor->specialization)
                {{ $booking->doctor->specialization }}
              @else
                <span style="color:#aaa;font-weight:400">-</span>
              @endif
            </span>
          </div>
          <div class="info-row">
            <span class="info-key">Kode</span>
            <span class="info-val mono">{{ $booking->booking_code ?? 'N/A' }}</span>
          </div>
        </div>

      </div>{{-- end section-grid --}}

      {{-- Catatan (conditional) --}}
      @if(!empty($booking->catatan))
      <div class="notes-box">
        <div class="notes-label">
          <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Catatan
        </div>
        {{ $booking->catatan }}
      </div>
      @endif

    </div>{{-- end modal-body --}}

    {{-- ===== FOOTER ===== --}}
    <div class="modal-footer">
      <button class="btn-outline-purple" onclick="window.print()">Cetak</button>
      <button type="button" class="btn-tutup" data-bs-dismiss="modal">Tutup</button>
    </div>

  </div>{{-- end modal-card --}}
</div>{{-- end modal-wrap --}}