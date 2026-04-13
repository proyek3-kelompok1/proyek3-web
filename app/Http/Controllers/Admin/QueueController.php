<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    /**
     * Display queue management page
     */
    public function index()
    {
        $today = now()->format('Y-m-d');
        
        // DEBUG: Cek data di database
        $allBookings = ServiceBooking::all();
        \Log::info('All ServiceBookings:', [
            'total' => $allBookings->count(),
            'data' => $allBookings->map(function($booking) {
                return [
                    'id' => $booking->id,
                    'booking_date' => $booking->booking_date,
                    'status' => $booking->status,
                    'nomor_antrian' => $booking->nomor_antrian,
                    'booking_code' => $booking->booking_code
                ];
            })->toArray()
        ]);

        // Ambil data hari ini
        $todayBookings = ServiceBooking::whereDate('booking_date', $today)
            ->orderBy('nomor_antrian')
            ->get();

        \Log::info('Today Bookings Filter:', [
            'date' => $today,
            'count' => $todayBookings->count(),
            'bookings' => $todayBookings->map(function($booking) {
                return [
                    'id' => $booking->id,
                    'booking_date' => $booking->booking_date,
                    'status' => $booking->status,
                    'nomor_antrian' => $booking->nomor_antrian,
                    'booking_code' => $booking->booking_code
                ];
            })->toArray()
        ]);

        // Tambahkan informasi rekam medis
        foreach ($todayBookings as $booking) {
            $booking->has_medical_record = $booking->medicalRecords()->exists();
        }

        $stats = [
            'total' => $todayBookings->count(),
            'pending' => $todayBookings->where('status', 'pending')->count(),
            'confirmed' => $todayBookings->where('status', 'confirmed')->count(),
            'completed' => $todayBookings->where('status', 'completed')->count(),
            'cancelled' => $todayBookings->where('status', 'cancelled')->count(),
        ];

        \Log::info('Stats:', $stats);

        return view('admin.queue.index', compact('todayBookings', 'stats', 'today'));
    }

    /**
     * Get queue data for AJAX requests
     */
    public function getQueueData(Request $request)
    {
        try {
            $date = $request->get('date', now()->format('Y-m-d'));
            $serviceType = $request->get('service_type');
            $status = $request->get('status');

            \Log::info('Queue Data Request:', [
                'date' => $date,
                'service_type' => $serviceType,
                'status' => $status
            ]);

            // Query dengan whereDate
            $query = ServiceBooking::whereDate('booking_date', $date);

            if ($serviceType && $serviceType !== '') {
                $query->where('service_type', $serviceType);
            }

            if ($status && $status !== '') {
                // Handle special case for completed_no_record
                if ($status === 'completed_no_record') {
                    $query->where('status', 'completed')
                          ->whereDoesntHave('medicalRecords');
                } else {
                    $query->where('status', $status);
                }
            }

            $bookings = $query->orderBy('nomor_antrian')->get();

            // Tambahkan informasi rekam medis
            foreach ($bookings as $booking) {
                $booking->has_medical_record = $booking->medicalRecords()->exists();
                $booking->service_name = $booking->service_name;
                $booking->doctor_name = $booking->doctor_name;
            }

            \Log::info('Queue Data Found:', [
                'date' => $date,
                'total_bookings' => $bookings->count(),
                'booking_ids' => $bookings->pluck('id')->toArray(),
                'status_counts' => [
                    'pending' => $bookings->where('status', 'pending')->count(),
                    'confirmed' => $bookings->where('status', 'confirmed')->count(),
                    'completed' => $bookings->where('status', 'completed')->count(),
                    'cancelled' => $bookings->where('status', 'cancelled')->count(),
                ]
            ]);

            $stats = [
                'total' => $bookings->count(),
                'pending' => $bookings->where('status', 'pending')->count(),
                'confirmed' => $bookings->where('status', 'confirmed')->count(),
                'completed' => $bookings->where('status', 'completed')->count(),
                'cancelled' => $bookings->where('status', 'cancelled')->count(),
                'completed_no_record' => $bookings->where('status', 'completed')
                    ->filter(function($booking) {
                        return !$booking->has_medical_record;
                    })->count()
            ];

            return response()->json([
                'success' => true,
                'bookings' => $bookings,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getQueueData:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading queue data',
                'bookings' => [],
                'stats' => [
                    'total' => 0,
                    'pending' => 0,
                    'confirmed' => 0,
                    'completed' => 0,
                    'cancelled' => 0,
                    'completed_no_record' => 0
                ]
            ], 500);
        }
    }

    /**
     * Show booking details modal
     */
    public function showDetail($id)
    {
        $booking = ServiceBooking::with(['service', 'doctor'])->findOrFail($id);
        
        // Tambahkan informasi rekam medis
        $booking->has_medical_record = $booking->medicalRecords()->exists();
        
        return view('admin.queue.detail', compact('booking'));
    }
    
    /**
     * Show single booking
     */
    public function show($id)
    {
        $booking = ServiceBooking::with(['service', 'doctor'])->findOrFail($id);
        return view('admin.queue.show', compact('booking'));
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking = ServiceBooking::findOrFail($id);
        $oldStatus = $booking->status;
        $newStatus = $request->status;
        
        $booking->update([
            'status' => $newStatus
        ]);

        // Log perubahan status
        \Log::info('Booking status updated:', [
            'booking_id' => $id,
            'booking_code' => $booking->booking_code,
            'old_status' => $oldStatus,
            'new_status' => $newStatus
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui',
            'booking' => $booking
        ]);
    }

    /**
     * Delete booking
     */
    public function destroy($id)
    {
        $booking = ServiceBooking::findOrFail($id);
        $bookingCode = $booking->booking_code;
        
        $booking->delete();

        \Log::info('Booking deleted:', [
            'booking_id' => $id,
            'booking_code' => $bookingCode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dihapus'
        ]);
    }
}