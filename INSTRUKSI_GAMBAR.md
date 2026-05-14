# Instruksi Menambahkan Gambar

## Gambar yang Perlu Ditambahkan

### 1. Gambar Dokter dengan Handphone
**Lokasi**: `public/image/doctor-app.png`

**Cara:**
1. Simpan gambar dokter yang memegang handphone
2. Rename menjadi `doctor-app.png`
3. Copy ke folder `public/image/`
4. Pastikan nama file exact: `doctor-app.png`

**Spesifikasi:**
- Format: PNG (dengan background transparan lebih bagus)
- Ukuran: Maksimal 500KB
- Dimensi: Tinggi sekitar 800-1000px (akan auto resize)

## Alternatif Jika Gambar Tidak Ada

Jika file `doctor-app.png` tidak ditemukan, halaman akan tetap berfungsi normal, hanya gambar tidak muncul.

Untuk sementara, Anda bisa:
1. Screenshot gambar dokter yang Anda kirim
2. Crop background hitamnya (atau biarkan)
3. Save as PNG
4. Upload ke `public/image/doctor-app.png`

## Verifikasi

Setelah upload, cek di browser:
- Buka: `http://127.0.0.1:8000/download`
- Gambar dokter harus muncul di atas tulisan "Download Aplikasi DV Pets"
- Jika tidak muncul, cek:
  - Nama file harus exact: `doctor-app.png`
  - Lokasi harus di: `public/image/`
  - Refresh browser (Ctrl + F5)

## Path Lengkap

```
d:\laragon\www\devpets\public\image\doctor-app.png
```

Pastikan file ada di path tersebut!
