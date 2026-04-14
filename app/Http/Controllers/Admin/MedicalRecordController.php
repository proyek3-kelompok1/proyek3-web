<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\ServiceBooking;
use App\Models\VaccinationRecord;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with('serviceBooking')
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->paginate(10);

        return view('admin.medical-records.index', compact('medicalRecords'));
    }

    public function create($bookingId)
    {
        $booking = ServiceBooking::findOrFail($bookingId);
        
        // AMBIL DOKTER DARI DATABASE - GANTI DARI ARRAY DUMMY
        $doctors = Doctor::all()
            ->mapWithKeys(function ($doctor) {
                return [
                    $doctor->id => $doctor->name . ($doctor->specialization ? ' - ' . $doctor->specialization : '')
                ];
            })
            ->toArray();

        $statuses = [
            'selesai' => 'Selesai',
            'rawat' => 'Dalam Perawatan',
            'kontrol' => 'Perlu Kontrol'
        ];

        return view('admin.medical-records.create', compact('booking', 'doctors', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_booking_id' => 'required|exists:service_bookings,id',
            'berat_badan' => 'required|string|max:50',
            'suhu_tubuh' => 'required|string|max:50',
            'keluhan_utama' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'dokter' => 'required|string|max:255', // Sekarang menyimpan ID dokter
            'kunjungan_berikutnya' => 'nullable|date',
            'status' => 'required|in:selesai,rawat,kontrol',
            'vaccinations' => 'nullable|array',
            'vaccinations.*.nama_vaksin' => 'required_with:vaccinations|string|max:255',
            'vaccinations.*.dosis' => 'required_with:vaccinations|string|max:100',
            'vaccinations.*.tanggal_vaksin' => 'required_with:vaccinations|date',
            'vaccinations.*.tanggal_booster' => 'nullable|date',
            'vaccinations.*.catatan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'ciri_warna' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string',
            'prognosa' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $booking = ServiceBooking::find($request->service_booking_id);
            
            // Update status booking menjadi completed
            $booking->update(['status' => 'completed']);

            // Generate kode rekam medis
            $countToday = MedicalRecord::whereDate('created_at', today())->count();
            $kodeRM = 'RM' . date('Ymd') . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

            // Cari dokter berdasarkan ID untuk mendapatkan nama
            $doctor = Doctor::find($request->dokter);
            $namaDokter = $doctor ? $doctor->name . ($doctor->specialization ? ' - ' . $doctor->specialization : '') : 'Dokter tidak ditemukan';

            // Buat rekam medis
            $medicalRecord = MedicalRecord::create([
                'kode_rekam_medis' => $kodeRM,
                'service_booking_id' => $request->service_booking_id,
                'nama_pemilik' => $booking->nama_pemilik,
                'nama_hewan' => $booking->nama_hewan,
                'jenis_hewan' => $booking->jenis_hewan,
                'ras' => $booking->ras,
                'umur' => $booking->umur,
                'berat_badan' => $request->berat_badan,
                'suhu_tubuh' => $request->suhu_tubuh,
                'keluhan_utama' => $request->keluhan_utama,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'resep_obat' => $request->resep_obat,
                'catatan_dokter' => $request->catatan_dokter,
                'dokter' => $namaDokter, // Simpan nama dokter lengkap
                'tanggal_pemeriksaan' => now(),
                'kunjungan_berikutnya' => $request->kunjungan_berikutnya,
                'status' => $request->status,
                'alamat' => $request->alamat ?? '',
                'telepon' => $request->telepon ?? $booking->telepon,
                'ciri_warna' => $request->ciri_warna ?? '',
                'jenis_kelamin' => $request->jenis_kelamin ?? '',
                'prognosa' => $request->prognosa ?? ''
            ]);

            // Simpan data vaksinasi jika ada
            if ($request->has('vaccinations')) {
                foreach ($request->vaccinations as $vaccination) {
                    VaccinationRecord::create([
                        'medical_record_id' => $medicalRecord->id,
                        'nama_vaksin' => $vaccination['nama_vaksin'],
                        'dosis' => $vaccination['dosis'],
                        'tanggal_vaksin' => $vaccination['tanggal_vaksin'],
                        'tanggal_booster' => $vaccination['tanggal_booster'] ?? null,
                        'dokter' => $namaDokter, // Gunakan nama dokter yang sama
                        'catatan' => $vaccination['catatan'] ?? null
                    ]);
                }
            }
        });

        return redirect()->route('admin.medical-records.index')
                         ->with('success', 'Rekam medis berhasil disimpan!');
    }

    public function show($id)
    {
        $medicalRecord = MedicalRecord::with(['serviceBooking', 'vaccinations'])->findOrFail($id);
        return view('admin.medical-records.show', compact('medicalRecord'));
    }

    public function edit($id)
    {
        $medicalRecord = MedicalRecord::with(['serviceBooking', 'vaccinations'])->findOrFail($id);
        
        // AMBIL DOKTER DARI DATABASE - GANTI DARI ARRAY DUMMY
        $doctors = Doctor::all()
            ->mapWithKeys(function ($doctor) {
                return [
                    $doctor->id => $doctor->name . ($doctor->specialization ? ' - ' . $doctor->specialization : '')
                ];
            })
            ->toArray();

        $statuses = [
            'selesai' => 'Selesai',
            'rawat' => 'Dalam Perawatan',
            'kontrol' => 'Perlu Kontrol'
        ];

        return view('admin.medical-records.edit', compact('medicalRecord', 'doctors', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'berat_badan' => 'required|string|max:50',
            'suhu_tubuh' => 'required|string|max:50',
            'keluhan_utama' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'dokter' => 'required|string|max:255',
            'kunjungan_berikutnya' => 'nullable|date',
            'status' => 'required|in:selesai,rawat,kontrol',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'ciri_warna' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string',
            'prognosa' => 'nullable|string'
        ]);

        $medicalRecord = MedicalRecord::findOrFail($id);
        
        // Cari dokter berdasarkan ID untuk mendapatkan nama
        $doctor = Doctor::find($request->dokter);
        $namaDokter = $doctor ? $doctor->name . ($doctor->specialization ? ' - ' . $doctor->specialization : '') : 'Dokter tidak ditemukan';
        
        $data = $request->all();
        $data['dokter'] = $namaDokter;
        
        $medicalRecord->update($data);

        return redirect()->route('admin.medical-records.show', $medicalRecord->id)
                         ->with('success', 'Rekam medis berhasil diperbarui!');
    }

    public function downloadPdf($id)
    {
        $medicalRecord = MedicalRecord::with(['serviceBooking', 'vaccinations'])->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.medical-records.pdf', compact('medicalRecord'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Rekam_Medis_' . $medicalRecord->kode_rekam_medis . '.pdf');
    }
}