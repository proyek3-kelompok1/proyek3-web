<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\Service;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * GET /api/bookings
     * Ambil semua data booking (riwayat)
     */
    public function index(Request $request)
    {
        $user = auth('sanctum')->user();

        if ($user) {
            // "Claim" booking lama yang belum ada user_id tapi emailnya sama (Case Insensitive)
            \App\Models\ServiceBooking::whereNull('user_id')
                ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
                ->update(['user_id' => $user->id]);

            $query = ServiceBooking::with(['service', 'doctor', 'medicalRecords'])
                ->where('user_id', $user->id)
                ->orWhere(function($q) use ($user) {
                    $q->whereNull('user_id')
                      ->whereRaw('LOWER(email) = ?', [strtolower($user->email)]);
                });
        } elseif ($request->has('email') && $request->email) {
            $query = ServiceBooking::with(['service', 'doctor', 'medicalRecords'])
                ->whereRaw('LOWER(email) = ?', [strtolower($request->email)]);
        } else {
            return response()->json(['success' => true, 'data' => []]);
        }

        $bookings = $query->orderBy('booking_date', 'desc')
            ->orderBy('nomor_antrian', 'asc')
            ->get();

        $data = $bookings->map(function ($b) {
            return [
                'id'             => $b->id,
                'booking_code'   => $b->booking_code,
                'nomor_antrian'  => $b->nomor_antrian,
                'nama_pemilik'   => $b->nama_pemilik,
                'email'          => $b->email,
                'telepon'        => $b->telepon,
                'alamat'         => $b->alamat,
                'nama_hewan'     => $b->nama_hewan,
                'jenis_hewan'    => $b->jenis_hewan,
                'jenis_kelamin'  => $b->jenis_kelamin,
                'ras'            => $b->ras,
                'umur'           => $b->umur,
                'ciri_warna'     => $b->ciri_warna,
                'service_type'   => $b->service_type,
                'service_id'     => $b->service_id,
                'doctor_id'      => $b->doctor_id,
                'booking_date'   => $b->booking_date,
                'booking_time'   => $b->booking_time,
                'catatan'        => $b->catatan,
                'status'         => $b->status,
                'total_price'    => $b->total_price,
                'service_name'   => $b->service ? $b->service->name : null,
                'doctor_name'    => $b->doctor ? $b->doctor->name : null,
                'has_medical_record' => $b->medicalRecords->count() > 0,
                'medical_records' => $b->medicalRecords
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * GET /api/medical-records
     * Ambil semua daftar rekam medis milik user
     */
    public function allMedicalRecords(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        // "Claim" booking lama yang belum ada user_id tapi emailnya sama sebelum ambil rekam medis
        \App\Models\ServiceBooking::whereNull('user_id')
            ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
            ->update(['user_id' => $user->id]);

        $records = MedicalRecord::whereHas('serviceBooking', function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhereRaw('LOWER(email) = ?', [strtolower($user->email)]);
        })
        ->orderBy('tanggal_pemeriksaan', 'desc')
        ->get();

        \Log::info("Medical records fetched for user {$user->id}", ['count' => $records->count()]);

        return response()->json([
            'success' => true,
            'data'    => $records,
        ]);
    }

    /**
     * GET /api/medical-records/{id}/pdf
     * Generate PDF rekam medis
     */
    public function downloadPdf($id)
    {
        // Izinkan auth via query string 'token' untuk kemudahan download PDF di mobile
        if (!auth('sanctum')->check() && request()->has('token')) {
            $token = request()->query('token');
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            if ($accessToken && $accessToken->tokenable) {
                auth('sanctum')->setUser($accessToken->tokenable);
            }
        }

        $user = auth('sanctum')->user();
        
        $medicalRecord = MedicalRecord::with(['serviceBooking', 'vaccinations'])->findOrFail($id);
        
        // Verifikasi kepemilikan (Opsional tapi disarankan)
        $booking = $medicalRecord->serviceBooking;
        if ($user && $booking->user_id !== $user->id && strtolower($booking->email) !== strtolower($user->email)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access to this record'], 403);
        }

        $pdf = Pdf::loadView('admin.medical-records.pdf', compact('medicalRecord'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Rekam_Medis_' . $medicalRecord->kode_rekam_medis . '.pdf');
    }

    /**
     * POST /api/bookings
     * Buat booking baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemilik' => 'required',
            'email'        => 'required|email',
            'telepon'      => 'required',
            'alamat'       => 'required',
            'nama_hewan'   => 'required',
            'jenis_hewan'  => 'required',
            'umur'         => 'required|integer',
            'service_id'   => 'required|exists:services,id',
            'doctor_id'    => 'required|exists:doctors,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $service = Service::findOrFail($request->service_id);

        // Nomor antrian: hitung booking pada tanggal yang sama
        $lastQueue = ServiceBooking::whereDate('booking_date', $request->booking_date)
            ->max('nomor_antrian');

        $nomorAntrian = $lastQueue ? $lastQueue + 1 : 1;

        // Generate booking code based on appointment date
        $datePrefix = date('Ymd', strtotime($request->booking_date));
        $bookingCode = 'BK-' . $datePrefix . '-' . str_pad($nomorAntrian, 3, '0', STR_PAD_LEFT);

        $bookingData = [
            'nama_pemilik'  => $request->nama_pemilik,
            'email'         => $request->email,
            'telepon'       => $request->telepon,
            'alamat'        => $request->alamat,
            'nama_hewan'    => $request->nama_hewan,
            'jenis_hewan'   => $request->jenis_hewan,
            'jenis_kelamin' => $request->jenis_kelamin ?? 'Jantan',
            'ras'           => $request->ras,
            'umur'          => $request->umur,
            'ciri_warna'    => $request->ciri_warna,
            'service_id'    => $service->id,
            'service_type'  => $service->service_type,
            'doctor_id'     => $request->doctor_id,
            'booking_date'  => $request->booking_date,
            'booking_time'  => $request->booking_time,
            'catatan'       => $request->catatan,
            'total_price'   => $service->price,
            'nomor_antrian' => $nomorAntrian,
            'booking_code'  => $bookingCode,
            'status'        => 'pending',
            'user_id'       => auth()->id(), // Simpan ID User yang sedang login
        ];

        $booking = ServiceBooking::create($bookingData);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat',
            'data'    => [
                'booking_code'  => $booking->booking_code,
                'nomor_antrian' => $booking->nomor_antrian,
                'service_name'  => $service->name,
                'doctor_name'   => $booking->doctor->name ?? null,
                'booking_date'  => $booking->booking_date,
                'booking_time'  => $booking->booking_time,
                'total_price'   => $booking->total_price,
            ]
        ]);
    }

    /**
     * GET /api/bookings/queue?date=2026-04-15&service_type=all
     * Ambil daftar antrian untuk tanggal tertentu
     */
    public function queue(Request $request)
    {
        $date        = $request->get('date', now()->toDateString());
        $serviceType = $request->get('service_type', 'all');

        $query = ServiceBooking::with(['service', 'doctor'])
            ->whereDate('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->orderBy('nomor_antrian', 'asc');

        if ($serviceType && $serviceType !== 'all') {
            $query->where('service_type', $serviceType);
        }

        $allQueue = $query->get();

        // Yang sedang dilayani (status confirmed)
        $currentQueue = $allQueue->firstWhere('status', 'confirmed');

        // Stats
        $stats = [
            'total'                  => $allQueue->count(),
            'waiting'                => $allQueue->where('status', 'pending')->count(),
            'completed'              => $allQueue->where('status', 'completed')->count(),
            'serving'                => $allQueue->where('status', 'confirmed')->count(),
            'estimated_wait_minutes' => $allQueue->where('status', 'pending')->count() * 15,
        ];

        $queueData = $allQueue->map(function ($b) {
            return [
                'id'            => $b->id,
                'nomor_antrian' => $b->nomor_antrian,
                'booking_code'  => $b->booking_code,
                'nama_hewan'    => $b->nama_hewan,
                'jenis_hewan'   => $b->jenis_hewan,
                'service_type'  => $b->service_type,
                'booking_time'  => $b->booking_time,
                'status'        => $b->status,
                'service_name'  => $b->service ? $b->service->name : null,
                'doctor_name'   => $b->doctor ? $b->doctor->name : null,
            ];
        });

        $currentData = $currentQueue ? [
            'id'            => $currentQueue->id,
            'nomor_antrian' => $currentQueue->nomor_antrian,
            'nama_hewan'    => $currentQueue->nama_hewan,
            'service_type'  => $currentQueue->service_type,
        ] : null;

        return response()->json([
            'success'       => true,
            'today_queue'   => $queueData->values(),
            'current_queue' => $currentData,
            'queue_stats'   => $stats,
        ]);
    }

    /**
     * POST /api/bookings/check-queue
     * Cek status antrian berdasarkan booking code
     */
    public function checkQueue(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
        ]);

        $booking = ServiceBooking::with(['service', 'doctor'])
            ->where('booking_code', $request->booking_code)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Kode booking tidak ditemukan. Pastikan kode sudah benar.',
            ], 404);
        }

        // Hitung posisi antrian (berapa pending sebelumnya)
        $position = ServiceBooking::whereDate('booking_date', $booking->booking_date)
            ->where('nomor_antrian', '<', $booking->nomor_antrian)
            ->where('status', 'pending')
            ->count() + 1;

        // Sedang dilayani nomor berapa
        $currentServing = ServiceBooking::whereDate('booking_date', $booking->booking_date)
            ->where('status', 'confirmed')
            ->value('nomor_antrian');

        // Estimasi tunggu
        $waitingBefore = ServiceBooking::whereDate('booking_date', $booking->booking_date)
            ->where('nomor_antrian', '<', $booking->nomor_antrian)
            ->where('status', 'pending')
            ->count();

        $estimatedWait = $waitingBefore * 15;

        return response()->json([
            'success' => true,
            'data'    => [
                'booking' => [
                    'id'            => $booking->id,
                    'booking_code'  => $booking->booking_code,
                    'nomor_antrian' => $booking->nomor_antrian,
                    'nama_pemilik'  => $booking->nama_pemilik,
                    'nama_hewan'    => $booking->nama_hewan,
                    'jenis_hewan'   => $booking->jenis_hewan,
                    'service_type'  => $booking->service_type,
                    'service_name'  => $booking->service ? $booking->service->name : null,
                    'doctor_name'   => $booking->doctor ? $booking->doctor->name : null,
                    'booking_date'  => $booking->booking_date,
                    'booking_time'  => $booking->booking_time,
                    'status'        => $booking->status,
                    'total_price'   => $booking->total_price,
                ],
                'queue_info' => [
                    'current_position'       => $booking->status === 'pending' ? $position : null,
                    'current_serving'        => $currentServing,
                    'estimated_wait_minutes' => $estimatedWait,
                ],
            ],
        ]);
    }
}
