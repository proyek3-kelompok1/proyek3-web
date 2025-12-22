<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use App\Models\Service;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;

class OnlineServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();
        
        // AMBIL DATA DOKTER DARI DATABASE
        $doctors = Doctor::all()
            ->mapWithKeys(function ($doctor) {
                return [
                    $doctor->id => [
                        'id' => $doctor->id,
                        'name' => $doctor->name,
                        'specialization' => $doctor->specialization,
                        'schedule' => $doctor->schedule,
                        'description' => $doctor->description,
                        'photo' => $doctor->photo_url,
                        'available_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                        'available_hours' => ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00']
                    ]
                ];
            })
            ->toArray();

        return view('online-services.index', compact('services', 'doctors'));
    }

    /**
     * Proses pemesanan
     */
    public function book(Request $request)
    {
        // Debug: Lihat data yang dikirim
        // dd($request->all());
        
        // Validasi yang lebih sederhana
        $validator = Validator::make($request->all(), [
            // 'nama_pemilik' => 'required|string|max:255',
            // 'email' => 'required|email|max:255',
            // 'telepon' => 'required|string|max:15',
            'nama_hewan' => 'required|string|max:255',
            'jenis_hewan' => 'required|string|max:255',
            'ras' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'service_id' => 'required|integer',
            'doctor' => 'required|string',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        }

        // Ambil service
        $service = Service::find($request->service_id);
        if (!$service) {
            return redirect()->back()
                ->with('error', 'Layanan tidak ditemukan')
                ->withInput();
        }

        // Cek apakah dokter valid
        $doctor = Doctor::find($request->doctor);
        if (!$doctor) {
            return redirect()->back()
                ->with('error', 'Dokter tidak ditemukan')
                ->withInput();
        }

        // Generate nomor antrian
        $nomorAntrian = ServiceBooking::whereDate('booking_date', $request->booking_date)
                                     ->where('service_id', $service->id)
                                     ->count() + 1;

        // Generate kode booking
        $serviceKode = [
            'general' => 'KON',
            'vaccination' => 'VKS',
            'surgery' => 'OPR',
            'grooming' => 'GRM',
            'dental' => 'GIG',
            'laboratory' => 'LAB',
            'inpatient' => 'RWT',
            'emergency' => 'DGL'
        ];
        
        $kodeService = $serviceKode[$service->service_type] ?? 'SV';
        $bookingCode = $kodeService . date('Ymd', strtotime($request->booking_date)) . str_pad($nomorAntrian, 3, '0', STR_PAD_LEFT);
        
        // Simpan ke database
        try {
            $booking = ServiceBooking::create([
                'nama_pemilik' => $request->nama_pemilik,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'nama_hewan' => $request->nama_hewan,
                'jenis_hewan' => $request->jenis_hewan,
                'ras' => $request->ras,
                'umur' => $request->umur,
                'service_type' => $service->service_type,
                'service_id' => $service->id,
                'doctor' => $doctor->id,
                'booking_date' => $request->booking_date,
                'booking_time' => $request->booking_time,
                'catatan' => $request->catatan,
                'status' => 'pending',
                'booking_code' => $bookingCode,
                'nomor_antrian' => $nomorAntrian,
                'total_price' => $service->price
            ]);

            // Redirect ke halaman sukses
            return redirect()->route('online-services.success')
                ->with([
                    'success' => 'Pemesanan berhasil!',
                    'booking' => $booking,
                    'service' => $service,
                    'doctor' => $doctor
                ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan pemesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function success()
    {
        if (!session('success')) {
            return redirect()->route('online-services.index');
        }

        return view('online-services.success');
    }

    public function getAvailableHours(Request $request)
    {
        $doctorId = $request->input('doctor');
        $selectedDate = $request->input('date');

        // Default available hours
        $availableHours = [
            '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'
        ];

        // Cek jam yang sudah dibooking
        $bookedHours = ServiceBooking::whereDate('booking_date', $selectedDate)
                                   ->where('doctor', $doctorId)
                                   ->whereIn('status', ['pending', 'confirmed'])
                                   ->pluck('booking_time')
                                   ->toArray();

        $availableHours = array_diff($availableHours, $bookedHours);

        return response()->json([
            'available_hours' => array_values($availableHours)
        ]);
    }
    
    // Method untuk menampilkan antrian
    public function queue()
    {
        return view('online-services.queue');
    }
    
    /**
     * Method untuk mendapatkan data antrian (PUBLIC VIEW)
     */
    public function getQueueData(Request $request)
    {
        try {
            $date = $request->get('date', now()->format('Y-m-d'));
            $serviceType = $request->get('service_type');

            \Log::info('Public Queue Data Request:', [
                'date' => $date,
                'service_type' => $serviceType
            ]);

            $query = ServiceBooking::whereDate('booking_date', $date);

            if ($serviceType && $serviceType !== 'all' && $serviceType !== '') {
                $query->where('service_type', $serviceType);
            }

            $bookings = $query->orderBy('nomor_antrian')->get();

            // Hitung statistik
            $totalQueue = $bookings->whereIn('status', ['pending', 'confirmed'])->count();
            $currentServing = $bookings->where('status', 'confirmed')->first();
            $waitingCount = $bookings->where('status', 'pending')->count();
            $completedCount = $bookings->where('status', 'completed')->count();
            $cancelledCount = $bookings->where('status', 'cancelled')->count();
            
            // Estimasi waktu tunggu (15 menit per antrian)
            $estimatedWait = $waitingCount * 15;

            \Log::info('Public Queue Data Found:', [
                'date' => $date,
                'total_bookings' => $bookings->count(),
                'total_queue' => $totalQueue,
                'current_serving' => $currentServing ? $currentServing->nomor_antrian : null
            ]);

            return response()->json([
                'success' => true,
                'today_queue' => $bookings,
                'current_queue' => $currentServing,
                'queue_stats' => [
                    'total' => $totalQueue,
                    'waiting' => $waitingCount,
                    'serving' => $currentServing ? 1 : 0,
                    'completed' => $completedCount,
                    'cancelled' => $cancelledCount,
                    'estimated_wait_minutes' => $estimatedWait
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getQueueData:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading queue data',
                'today_queue' => [],
                'queue_stats' => [
                    'total' => 0,
                    'waiting' => 0,
                    'serving' => 0,
                    'completed' => 0,
                    'cancelled' => 0,
                    'estimated_wait_minutes' => 0
                ]
            ], 500);
        }
    }
    
    /**
     * Method untuk cek antrian saya (pencarian berdasarkan kode booking)
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

        $bookingCode = $request->get('booking_code');
        
        $booking = ServiceBooking::where('booking_code', $bookingCode)->first();
        
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Kode booking tidak ditemukan'
            ]);
        }
        
        // Hitung posisi antrian
        $queueToday = ServiceBooking::whereDate('booking_date', $booking->booking_date)
            ->where('service_type', $booking->service_type)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('nomor_antrian')
            ->get();
        
        $position = $queueToday->search(function($item) use ($booking) {
            return $item->id === $booking->id;
        });
        
        $currentServing = ServiceBooking::whereDate('booking_date', $booking->booking_date)
            ->where('service_type', $booking->service_type)
            ->where('status', 'confirmed')
            ->orderBy('nomor_antrian')
            ->first();
        
        $waitingBefore = ServiceBooking::whereDate('booking_date', $booking->booking_date)
            ->where('service_type', $booking->service_type)
            ->where('status', 'pending')
            ->where('nomor_antrian', '<', $booking->nomor_antrian)
            ->count();
        
        // Estimasi waktu tunggu (15 menit per antrian)
        $estimatedWaitMinutes = $waitingBefore * 15;
        
        return response()->json([
            'success' => true,
            'data' => [
                'queue_info' => [
                    'current_position' => $position !== false ? $position + 1 : null,
                    'current_serving' => $currentServing ? $currentServing->nomor_antrian : null,
                    'waiting_before' => $waitingBefore,
                    'estimated_wait_minutes' => $estimatedWaitMinutes,
                    'total_in_queue' => $queueToday->count()
                ],
                'booking' => $booking
            ]
        ]);
    }

    /**
     * Method untuk mendapatkan posisi antrian (API endpoint)
     */
    public function getQueuePosition(Request $request)
    {
        $bookingCode = $request->get('booking_code');
        
        $booking = ServiceBooking::where('booking_code', $bookingCode)->first();
        
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Kode booking tidak ditemukan'
            ]);
        }
        
        // Gunakan method yang sama dengan checkMyQueue
        return $this->checkMyQueue($request);
    }
}