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
                'kode' => 'VKS',
                'available_doctors' => ['drh_roza', 'drh_arundhina'] // Kedua dokter melayani semua layanan
            ],
            'konsultasi_umum' => [
                'name' => 'Konsultasi Umum',
                'description' => 'Pemeriksaan kesehatan rutin dan konsultasi untuk hewan peliharaan',
                'price' => 80000,
                'duration' => 45,
                'kode' => 'KON',
                'available_doctors' => ['drh_roza', 'drh_arundhina'] // Kedua dokter melayani semua layanan
            ],
            'grooming' => [
                'name' => 'Grooming',
                'description' => 'Perawatan kebersihan lengkap termasuk mandi, potong kuku, dan sisir bulu',
                'price' => 120000,
                'duration' => 60,
                'kode' => 'GRM',
                'available_doctors' => ['drh_roza', 'drh_arundhina'] // Kedua dokter melayani semua layanan
            ],
            'perawatan_gigi' => [
                'name' => 'Perawatan Gigi',
                'description' => 'Pembersihan gigi dan perawatan kesehatan mulut untuk hewan kesayangan',
                'price' => 200000,
                'duration' => 45,
                'kode' => 'GIG',
                'available_doctors' => ['drh_roza', 'drh_arundhina'] // Kedua dokter melayani semua layanan
            ],
            'pemeriksaan_darah' => [
                'name' => 'Pemeriksaan Darah',
                'description' => 'Tes darah lengkap untuk mendiagnosis kondisi kesehatan hewan',
                'price' => 250000,
                'duration' => 30,
                'kode' => 'DRH',
                'available_doctors' => ['drh_roza', 'drh_arundhina'] // Kedua dokter melayani semua layanan
            ],
            'sterilisasi' => [
                'name' => 'Sterilisasi',
                'description' => 'Tindakan sterilisasi untuk mengontrol populasi dan kesehatan hewan',
                'price' => 500000,
                'duration' => 120,
                'kode' => 'STR',
                'available_doctors' => ['drh_roza', 'drh_arundhina'] // Kedua dokter melayani semua layanan
            ]
        ];

        // Data dokter dengan jadwal baru
        $doctors = [
            'drh_roza' => [
                'name' => 'drh. Roza Albate Chandra Adila',
                'specialization' => 'Dokter Umum',
                'schedule' => ['Senin - Minggu', '11:00 - 19:00 WIB'],
                'available_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'available_hours' => ['11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'],
                'services' => ['vaksinasi', 'konsultasi_umum', 'grooming', 'perawatan_gigi', 'pemeriksaan_darah', 'sterilisasi'] // Semua layanan
            ],
            'drh_arundhina' => [
                'name' => 'drh. Arundhina Girishanta M.Si',
                'specialization' => 'Dokter Umum',
                'schedule' => ['Senin - Minggu', '17:00 - 22:00 WIB'],
                'available_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'available_hours' => ['17:00', '18:00', '19:00', '20:00', '21:00'],
                'services' => ['vaksinasi', 'konsultasi_umum', 'grooming', 'perawatan_gigi', 'pemeriksaan_darah', 'sterilisasi'] // Semua layanan
            ]
        ];

        return view('online-services.index', compact('services', 'doctors'));
    }

    public function book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'nama_pemilik' => 'required|string|max:255',
            // 'email' => 'required|email|max:255',
            // 'telepon' => 'required|string|max:15',
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
            // 'nama_pemilik' => $request->nama_pemilik,
            // 'email' => $request->email,
            // 'telepon' => $request->telepon,
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

    /**
     * Menampilkan halaman lihat antrian
     */
    public function queue()
    {
        return view('online-services.queue');
    }

    /**
     * API untuk mendapatkan data antrian real-time
     */
    public function getQueueData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $serviceType = $request->input('service_type');

        // Data antrian hari ini
        $todayQueue = ServiceBooking::whereDate('booking_date', $date)
                                ->where('status', 'pending')
                                ->orderBy('nomor_antrian')
                                ->get();

        // Data antrian berdasarkan service type jika dipilih
        if ($serviceType) {
            $todayQueue = $todayQueue->where('service_type', $serviceType);
        }

        // Antrian saat ini (yang sedang dilayani)
        $currentQueue = ServiceBooking::whereDate('booking_date', $date)
                                    ->where('status', 'confirmed')
                                    ->orderBy('nomor_antrian')
                                    ->first();

        // Estimasi waktu tunggu
        $estimatedWait = $todayQueue->count() * 30; // 30 menit per antrian

        return response()->json([
            'current_queue' => $currentQueue ? [
                'nomor_antrian' => $currentQueue->nomor_antrian,
                'service_type' => $currentQueue->service_type,
                'booking_code' => $currentQueue->booking_code
            ] : null,
            'today_queue' => $todayQueue->map(function($item) {
                return [
                    'nomor_antrian' => $item->nomor_antrian,
                    'service_type' => $item->service_type,
                    'booking_code' => $item->booking_code,
                    'nama_hewan' => $item->nama_hewan,
                    'waktu' => $item->booking_time,
                    'status' => $item->status
                ];
            }),
            'total_queue' => $todayQueue->count(),
            'estimated_wait_minutes' => $estimatedWait,
            'current_date' => $date
        ]);
    }

    /**
     * Cek antrian berdasarkan kode booking
     */
    public function checkMyQueue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_code' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode booking harus diisi'
            ]);
        }

        $booking = ServiceBooking::where('booking_code', $request->booking_code)->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Kode booking tidak ditemukan'
            ]);
        }

        // Hitung posisi antrian
        $queuePosition = ServiceBooking::whereDate('booking_date', $booking->booking_date)
                                    ->where('service_type', $booking->service_type)
                                    ->where('status', 'pending')
                                    ->where('nomor_antrian', '<=', $booking->nomor_antrian)
                                    ->count();

        // Antrian saat ini
        $currentQueue = ServiceBooking::whereDate('booking_date', $booking->booking_date)
                                    ->where('service_type', $booking->service_type)
                                    ->where('status', 'confirmed')
                                    ->orderBy('nomor_antrian')
                                    ->first();

        $currentQueueNumber = $currentQueue ? $currentQueue->nomor_antrian : 0;
        $estimatedWait = ($queuePosition - 1) * 30; // Estimasi menit

        return response()->json([
            'success' => true,
            'data' => [
                'booking' => [
                    'nomor_antrian' => $booking->nomor_antrian,
                    'booking_code' => $booking->booking_code,
                    'service_type' => $booking->service_type,
                    'nama_hewan' => $booking->nama_hewan,
                    'dokter' => $booking->doctor,
                    'waktu' => $booking->booking_time,
                    'tanggal' => $booking->booking_date
                ],
                'queue_info' => [
                    'current_position' => $queuePosition,
                    'current_serving' => $currentQueueNumber,
                    'estimated_wait_minutes' => $estimatedWait,
                    'status' => $booking->status
                ]
            ]
        ]);
    }

    /**
     * API untuk mendapatkan jam tersedia berdasarkan dokter dan tanggal
     */
    public function getAvailableHours(Request $request)
    {
        $doctorId = $request->input('doctor');
        $selectedDate = $request->input('date');

        $doctors = [
            'drh_roza' => [
                'available_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'available_hours' => ['11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00']
            ],
            'drh_arundhina' => [
                'available_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'available_hours' => ['17:00', '18:00', '19:00', '20:00', '21:00']
            ]
        ];

        if (!isset($doctors[$doctorId])) {
            return response()->json(['available_hours' => []]);
        }

        $doctor = $doctors[$doctorId];
        $selectedDay = date('l', strtotime($selectedDate));

        // Cek apakah tanggal sesuai dengan hari kerja dokter
        if (!in_array($selectedDay, $doctor['available_days'])) {
            return response()->json(['available_hours' => []]);
        }

        // Filter jam yang sudah dipesan
        $bookedHours = ServiceBooking::whereDate('booking_date', $selectedDate)
                                   ->where('doctor', $doctorId)
                                   ->pluck('booking_time')
                                   ->toArray();

        $availableHours = array_diff($doctor['available_hours'], $bookedHours);

        return response()->json([
            'available_hours' => array_values($availableHours),
            'doctor_schedule' => $doctor['available_hours']
        ]);
    }
}