<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Rekam Medik Hewan - {{ $medicalRecord->kode_rekam_medis }}</title>
    <style>
        @page {
            margin: 40px 50px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo-container img {
            max-height: 60px;
            opacity: 0.8; /* Subtle for print */
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding: 3px 0;
            font-weight: bold;
        }
        .info-label {
            width: 100px;
        }
        .info-colon {
            width: 15px;
            text-align: center;
        }
        .info-val {
            font-weight: normal;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
        }
        .data-table th {
            text-align: left;
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .min-height-row td {
            min-height: 150px;
        }
    </style>
</head>
<body>

    <div class="logo-container">
        @php
            $imagePath = public_path('image/logo.png');
            $imageData = file_exists($imagePath) ? base64_encode(file_get_contents($imagePath)) : '';
            $src = 'data:image/png;base64,'.$imageData;
        @endphp
        @if($imageData)
            <img src="{{ $src }}" alt="DV Pets Logo">
        @else
            <h2>DV Pets</h2>
        @endif
    </div>
    
    <div class="header">
        KARTU REKAM MEDIK HEWAN
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama Pemilik</td>
            <td class="info-colon">:</td>
            <td class="info-val" style="width: 35%;">{{ $medicalRecord->nama_pemilik }}</td>
            
            <td class="info-label">Ciri/Warna bulu</td>
            <td class="info-colon">:</td>
            <td class="info-val">{{ $medicalRecord->ciri_warna ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Nama Pasien</td>
            <td class="info-colon">:</td>
            <td class="info-val">{{ $medicalRecord->nama_hewan }} ({{ $medicalRecord->jenis_hewan }} - {{ $medicalRecord->ras }})</td>
            
            <td class="info-label">Jenis Kelamin</td>
            <td class="info-colon">:</td>
            <td class="info-val">{{ $medicalRecord->jenis_kelamin ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Alamat</td>
            <td class="info-colon">:</td>
            <td class="info-val">{{ $medicalRecord->alamat ?? '-' }}</td>
            
            <td class="info-label">No.Telpon</td>
            <td class="info-colon">:</td>
            <td class="info-val">{{ $medicalRecord->telepon ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Umur Hewan</td>
            <td class="info-colon">:</td>
            <td class="info-val">{{ $medicalRecord->umur }} bulan</td>
            
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:4%; text-align:center;">No</th>
                <th style="width:19%">Anamnesa</th>
                <th style="width:19%">Penemuan Klinis</th>
                <th style="width:19%">Prognosa</th>
                <th style="width:25%">Penanganan/Pengobatan</th>
                <th style="width:14%">Ket.</th>
            </tr>
        </thead>
        <tbody>
            <tr class="min-height-row">
                <td style="text-align:center;">1</td>
                <td>{!! nl2br(e($medicalRecord->keluhan_utama)) !!}</td>
                <td>{!! nl2br(e($medicalRecord->diagnosa)) !!}</td>
                <td>{!! nl2br(e($medicalRecord->prognosa ?? '-')) !!}</td>
                <td>
                    @if($medicalRecord->tindakan)
                        <strong>Tindakan:</strong><br>{!! nl2br(e($medicalRecord->tindakan)) !!}<br><br>
                    @endif
                    @if($medicalRecord->resep_obat)
                        <strong>Pengobatan:</strong><br>{!! nl2br(e($medicalRecord->resep_obat)) !!}
                    @endif
                </td>
                <td>
                    <strong>Tgl:</strong> {{ \Carbon\Carbon::parse($medicalRecord->tanggal_pemeriksaan)->format('d/m/Y') }}<br><br>
                    <strong>Dr:</strong> {{ $medicalRecord->dokter }}<br><br>
                    {!! nl2br(e($medicalRecord->catatan_dokter)) !!}
                </td>
            </tr>
            <!-- 3 blank rows for future manual writing if printed -->
            <tr>
                <td style="height: 100px;"></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td style="height: 100px;"></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td style="height: 100px;"></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
