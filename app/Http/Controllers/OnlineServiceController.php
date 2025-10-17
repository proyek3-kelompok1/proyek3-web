<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OnlineServiceController extends Controller
{
    public function index()
    {
        // Data layanan yang tersedia
        $services = [
            'vaksinasi' => [
                'name' => 'Vaksinasi',
                'description' => 'Program vaksinasi lengkap untuk melindungi hewan dari berbagai penyakit',
                'price' => 150000,
                'duration' => 30,
                'kode' => 'VKS'
            ],
            'konsultasi_umum' => [
                'name' => 'Konsultasi Umum',
                'description' => 'Pemeriksaan kesehatan rutin dan konsultasi untuk hewan peliharaan',
                'price' => 80000,
                'duration' => 45,
                'kode' => 'KON'
            ],
            'grooming' => [
                'name' => 'Grooming',
                'description' => 'Perawatan kebersihan lengkap termasuk mandi, potong kuku, dan sisir bulu',
                'price' => 120000,
                'duration' => 60,
                'kode' => 'GRM'
            ],
            'perawatan_gigi' => [
                'name' => 'Perawatan Gigi',
                'description' => 'Pembersihan gigi dan perawatan kesehatan mulut untuk hewan kesayangan',
                'price' => 200000,
                'duration' => 45,
                'kode' => 'GIG'
            ],
            'pemeriksaan_darah' => [
                'name' => 'Pemeriksaan Darah',
                'description' => 'Tes darah lengkap untuk mendiagnosis kondisi kesehatan hewan',
                'price' => 250000,
                'duration' => 30,
                'kode' => 'DRH'
            ],
            'sterilisasi' => [
                'name' => 'Sterilisasi',
                'description' => 'Tindakan sterilisasi untuk mengontrol populasi dan kesehatan hewan',
                'price' => 500000,
                'duration' => 120,
                'kode' => 'STR'
            ]
        ];

        // Data dokter
        $doctors = [
            'drh_andi' => [
                'name' => 'drh. Andi Wijaya',
                'specialization' => 'Spesialis Umum',
                'schedule' => ['Senin - Jumat', '08:00 - 16:00']
            ],
            'drh_sari' => [
                'name' => 'drh. Sari Dewi',
                'specialization' => 'Spesialis Bedah',
                'schedule' => ['Selasa - Sabtu', '09:00 - 17:00']
            ],
            'drh_budi' => [
                'name' => 'drh. Budi Santoso',
                'specialization' => 'Spesialis Dermatologi',
                'schedule' => ['Senin - Kamis', '10:00 - 18:00']
            ],
            'drh_maya' => [
                'name' => 'drh. Maya Purnama',
                'specialization' => 'Spesialis Gigi',
                'schedule' => ['Rabu - Minggu', '08:00 - 16:00']
            ]
        ];

        return view('online-services.index', compact('services', 'doctors'));
    }

    public function book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemilik' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:15',
            'nama_hewan' => 'required|string|max:255',
            'jenis_hewan' => 'required|string|max:255',
            'ras' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'service_type' => 'required|string|max:255',
            'doctor' => 'required|string|max:255',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate nomor antrian
        $nomorAntrian = $this->generateNomorAntrian($request->booking_date, $request->service_type);

        // Generate booking code dengan format: KODE_SERVICE + TANGGAL + NOMOR_ANTRIAN
        $serviceKode = [
            'vaksinasi' => 'VKS',
            'konsultasi_umum' => 'KON', 
            'grooming' => 'GRM',
            'perawatan_gigi' => 'GIG',
            'pemeriksaan_darah' => 'DRH',
            'sterilisasi' => 'STR'
        ];

        $kodeService = $serviceKode[$request->service_type] ?? 'SV';
        $bookingCode = $kodeService . date('Ymd', strtotime($request->booking_date)) . str_pad($nomorAntrian, 3, '0', STR_PAD_LEFT);

        // Simpan booking
        $booking = ServiceBooking::create([
            'nama_pemilik' => $request->nama_pemilik,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis_hewan,
            'ras' => $request->ras,
            'umur' => $request->umur,
            'service_type' => $request->service_type,
            'doctor' => $request->doctor,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'booking_code' => $bookingCode,
            'nomor_antrian' => $nomorAntrian
        ]);

        return redirect()->route('online-services.success')->with([
            'success' => 'Pemesanan layanan berhasil!',
            'booking' => $booking
        ]);
    }

    /**
     * Generate nomor antrian berdasarkan tanggal dan jenis layanan
     */
    private function generateNomorAntrian($bookingDate, $serviceType)
    {
        // Hitung jumlah booking pada tanggal yang sama untuk layanan yang sama
        $count = ServiceBooking::whereDate('booking_date', $bookingDate)
                              ->where('service_type', $serviceType)
                              ->count();

        // Nomor antrian dimulai dari 1
        return $count + 1;
    }

    public function success()
    {
        if (!session('success')) {
            return redirect()->route('online-services.index');
        }

        return view('online-services.success');
    }

    /**
     * API untuk mendapatkan estimasi antrian (opsional)
     */
    public function getQueueInfo(Request $request)
    {
        $date = $request->input('date');
        $serviceType = $request->input('service_type');

        $currentQueue = ServiceBooking::whereDate('booking_date', $date)
                                    ->where('service_type', $serviceType)
                                    ->count();

        $estimatedWait = $currentQueue * 30; // Estimasi 30 menit per pasien

        return response()->json([
            'current_queue' => $currentQueue,
            'estimated_wait_minutes' => $estimatedWait,
            'next_queue_number' => $currentQueue + 1
        ]);
    }
}