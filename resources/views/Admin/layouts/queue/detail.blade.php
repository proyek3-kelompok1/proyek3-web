<div class="row">
    <div class="col-md-6">
        <h6 class="border-bottom pb-2">Informasi Pemilik</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <th width="40%">Nama Pemilik</th>
                <td>{{ $booking->nama_pemilik ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $booking->telepon ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $booking->alamat ?? '-' }}</td>
            </tr>
        </table>
    </div>
    
    <div class="col-md-6">
        <h6 class="border-bottom pb-2">Informasi Hewan</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <th width="40%">Nama Hewan</th>
                <td>{{ $booking->nama_hewan ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Jenis</th>
                <td>{{ $booking->jenis_hewan ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Ras</th>
                <td>{{ $booking->ras ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Usia</th>
                <td>{{ $booking->umur ?? $booking->usia ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <h6 class="border-bottom pb-2">Informasi Layanan</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <th width="40%">Layanan</th>
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
                    <span class="badge bg-info">{{ $serviceNames[$booking->service_type] ?? $booking->service_type ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <th>Dokter</th>
                <td>
                    @php
                        $doctorNames = [
                            'drh_roza' => 'drh. Roza Albate Chandra Adila',
                            'drh_arundhina' => 'drh. Arundhina Girishanta M.Si',
                        ];
                    @endphp
                    {{ $doctorNames[$booking->doctor] ?? $booking->doctor ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Waktu</th>
                <td>{{ $booking->booking_time ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
    
    <div class="col-md-6">
        <h6 class="border-bottom pb-2">Status & Informasi</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <th width="40%">No. Antrian</th>
                <td>
                    @if(isset($booking->nomor_antrian))
                        <span class="badge bg-primary">A{{ str_pad($booking->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</span>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <th>Kode Booking</th>
                <td><code>{{ $booking->booking_code ?? 'N/A' }}</code></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @php
                        $statusLabels = [
                            'pending' => '<span class="badge bg-warning">Menunggu</span>',
                            'confirmed' => '<span class="badge bg-info">Sedang Dilayani</span>',
                            'completed' => '<span class="badge bg-success">Selesai</span>',
                            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>'
                        ];
                    @endphp
                    {!! $statusLabels[$booking->status] ?? $booking->status ?? 'N/A' !!}
                </td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>
                    @if(isset($booking->created_at))
                        {{ $booking->created_at->format('d/m/Y H:i') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

@if(!empty($booking->catatan))
<div class="row mt-4">
    <div class="col-12">
        <h6 class="border-bottom pb-2">Catatan</h6>
        <div class="alert alert-light bg-light">
            <p class="mb-0">{{ $booking->catatan }}</p>
        </div>
    </div>
</div>
@endif

<div class="modal-footer mt-4">
    <button type="button" class="btn btn-purple" data-bs-dismiss="modal">Tutup</button>
</div>