<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking; // GANTI INI
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
                'nomor_antrian' => $booking->nomor_antrian
            ];
        })->toArray()
    ]);

    // Coba tanpa whereDate dulu untuk testing
    $todayBookings = ServiceBooking::where('booking_date', $today)
        ->orderBy('nomor_antrian')
        ->get();

    \Log::info('Today Bookings Filter:', [
        'date' => $today,
        'count' => $todayBookings->count(),
        'bookings' => $todayBookings->map(function($booking) {
            return [
                'id' => $booking->id,
                'booking_date' => $booking->booking_date,
                'status' => $booking->status
            ];
        })->toArray()
    ]);

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
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('nomor_antrian')->get();

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
            ]
        ], 500);
    }
}

    /**
     * Show booking details modal
     */
    public function showDetail($id)
    {
        $booking = ServiceBooking::findOrFail($id); // GANTI INI
        
        return view('admin.queue.detail', compact('booking'));
    }
    
    /**
     * Show single booking
     */
    public function show($id)
    {
        $booking = ServiceBooking::findOrFail($id); // GANTI INI
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

        $booking = ServiceBooking::findOrFail($id); // GANTI INI
        $booking->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    }

    /**
     * Delete booking
     */
    public function destroy($id)
    {
        $booking = ServiceBooking::findOrFail($id); // GANTI INI
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dihapus'
        ]);
    }
}