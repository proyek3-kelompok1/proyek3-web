<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #4A3298; }
        .content { padding: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #4A3298; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .highlight { color: #4A3298; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #4A3298;">Rekam Medis DVPets</h2>
        </div>
        <div class="content">
            <p>Halo <span class="highlight">{{ $medicalRecord->nama_pemilik }}</span>,</p>
            <p>Pemeriksaan untuk <span class="highlight">{{ $medicalRecord->nama_hewan }}</span> telah selesai dilakukan pada tanggal {{ $medicalRecord->tanggal_pemeriksaan->format('d M Y') }}.</p>
            
            <table style="width: 100%; background: #f9f9f9; padding: 15px; border-radius: 8px;">
                <tr>
                    <td><strong>Kode RM:</strong></td>
                    <td>{{ $medicalRecord->kode_rekam_medis }}</td>
                </tr>
                <tr>
                    <td><strong>Diagnosa:</strong></td>
                    <td>{{ $medicalRecord->diagnosa }}</td>
                </tr>
                <tr>
                    <td><strong>Dokter:</strong></td>
                    <td>{{ $medicalRecord->dokter }}</td>
                </tr>
            </table>

            <p>Kami telah melampirkan file PDF rekam medis lengkap dalam email ini untuk Anda simpan.</p>
            
            <p>Jika ada pertanyaan lebih lanjut, silakan hubungi kami atau gunakan fitur **DokterPaw** di aplikasi DVPets.</p>
            
            <p>Semoga {{ $medicalRecord->nama_hewan }} sehat selalu! 🐾</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} DVPets Veterinary Clinic. All rights reserved.</p>
            <p>Jl. Kesehatan Hewan No. 123, Indonesia</p>
        </div>
    </div>
</body>
</html>
