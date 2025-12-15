<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\ServiceBooking;
use App\Models\VaccinationRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController extends Controller
{
    public function index()
    {
        // Untuk demo, kita akan buat form pencarian rekam medis
        return view('medical-records.index');
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_booking' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cari booking berdasarkan kode dan email
        $booking = ServiceBooking::where('booking_code', $request->kode_booking)
                                ->where('email', $request->email)
                                ->first();

        if (!$booking) {
            return redirect()->back()
                ->with('error', 'Data tidak ditemukan. Pastikan kode booking dan email benar.')
                ->withInput();
        }

        // PERBAIKAN: Gunakan service_booking_id untuk konsistensi
        $medicalRecords = MedicalRecord::where('service_booking_id', $booking->id)
                                    ->with('vaccinations')
                                    ->orderBy('tanggal_pemeriksaan', 'desc')
                                    ->get();

        return view('medical-records.results', compact('booking', 'medicalRecords'));
    }

    public function show($id)
    {
        $medicalRecord = MedicalRecord::with('vaccinations')->findOrFail($id);
        return view('medical-records.show', compact('medicalRecord'));
    }

    // Method untuk admin/dokter membuat rekam medis
    public function createFromBooking($bookingId)
    {
        $booking = ServiceBooking::findOrFail($bookingId);
        
        $doctors = [
            'drh_andi' => 'drh. Andi Wijaya - Spesialis Umum',
            'drh_sari' => 'drh. Sari Dewi - Spesialis Bedah', 
            'drh_budi' => 'drh. Budi Santoso - Spesialis Dermatologi',
            'drh_maya' => 'drh. Maya Purnama - Spesialis Gigi'
        ];

        return view('medical-records.create', compact('booking', 'doctors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_booking_id' => 'required|exists:service_bookings,id',
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
            'vaccinations' => 'nullable|array',
            'vaccinations.*.nama_vaksin' => 'required_with:vaccinations|string|max:255',
            'vaccinations.*.dosis' => 'required_with:vaccinations|string|max:100',
            'vaccinations.*.tanggal_vaksin' => 'required_with:vaccinations|date',
            'vaccinations.*.tanggal_booster' => 'nullable|date',
            'vaccinations.*.catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // PERBAIKAN: Generate kode RM yang lebih unik
            $countToday = MedicalRecord::whereDate('created_at', today())->count();
            $kodeRM = 'RM' . date('Ymd') . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

            $booking = ServiceBooking::find($request->service_booking_id);
            
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
                'dokter' => $request->dokter,
                'tanggal_pemeriksaan' => now(),
                'kunjungan_berikutnya' => $request->kunjungan_berikutnya,
                'status' => $request->status
            ]);

            // PERBAIKAN: Gunakan transaction untuk konsistensi data
            DB::transaction(function () use ($medicalRecord, $request) {
                // Simpan data vaksinasi jika ada
                if ($request->has('vaccinations')) {
                    foreach ($request->vaccinations as $vaccination) {
                        VaccinationRecord::create([
                            'medical_record_id' => $medicalRecord->id,
                            'nama_vaksin' => $vaccination['nama_vaksin'],
                            'dosis' => $vaccination['dosis'],
                            'tanggal_vaksin' => $vaccination['tanggal_vaksin'],
                            'tanggal_booster' => $vaccination['tanggal_booster'] ?? null,
                            'dokter' => $request->dokter,
                            'catatan' => $vaccination['catatan'] ?? null
                        ]);
                    }
                }
            });

            return redirect()->route('medical-records.show', $medicalRecord->id)
                            ->with('success', 'Rekam medis berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }
}