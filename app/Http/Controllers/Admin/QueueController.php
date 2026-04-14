<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    /**
     * Display queue management page
     * Default: tampilkan semua booking, bisa difilter by date
     */
    public function index()
    {
        $today = now()->format('Y-m-d');

        // Default: ambil SEMUA booking (terbaru dulu), bisa difilter via AJAX
        $allBookings = ServiceBooking::with('doctor')
            ->orderBy('booking_date', 'desc')
            ->orderBy('nomor_antrian')
            ->get();

        // Tambahkan informasi rekam medis
        foreach ($allBookings as $booking) {
            $booking->has_medical_record = $booking->medicalRecords()->exists();
        }

        $stats = [
            'total'     => $allBookings->count(),
            'pending'   => $allBookings->where('status', 'pending')->count(),
            'confirmed' => $allBookings->where('status', 'confirmed')->count(),
            'completed' => $allBookings->where('status', 'completed')->count(),
            'cancelled' => $allBookings->where('status', 'cancelled')->count(),
        ];

        // Tanggal-tanggal yang punya booking untuk smart hint
        $availableDates = ServiceBooking::selectRaw('DATE(booking_date) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->pluck('total', 'date');

        return view('admin.queue.index', compact('allBookings', 'stats', 'today', 'availableDates'));
    }

    /**
     * Get queue data for AJAX requests
     * Jika date kosong = tampilkan semua booking
     */
    public function getQueueData(Request $request)
    {
        try {
            $date        = $request->get('date', '');
            $serviceType = $request->get('service_type', '');
            $status      = $request->get('status', '');

            $query = ServiceBooking::with('doctor');

            // Filter tanggal hanya jika diisi
            if ($date && $date !== '') {
                $query->whereDate('booking_date', $date);
            }

            // Filter jenis layanan
            if ($serviceType && $serviceType !== '') {
                $query->where('service_type', $serviceType);
            }

            // Filter status
            if ($status && $status !== '') {
                if ($status === 'completed_no_record') {
                    $query->where('status', 'completed')
                          ->whereDoesntHave('medicalRecords');
                } else {
                    $query->where('status', $status);
                }
            }

            $bookings = $query->orderBy('booking_date', 'desc')
                              ->orderBy('nomor_antrian')
                              ->get();

            // Tambahkan informasi rekam medis & nama
            foreach ($bookings as $booking) {
                $booking->has_medical_record = $booking->medicalRecords()->exists();
                $booking->service_name_label = $booking->service_name;
                $booking->doctor_name_label  = $booking->doctor_name;
            }

            $stats = [
                'total'               => $bookings->count(),
                'pending'             => $bookings->where('status', 'pending')->count(),
                'confirmed'           => $bookings->where('status', 'confirmed')->count(),
                'completed'           => $bookings->where('status', 'completed')->count(),
                'cancelled'           => $bookings->where('status', 'cancelled')->count(),
                'completed_no_record' => $bookings->where('status', 'completed')
                    ->filter(fn($b) => !$b->has_medical_record)->count(),
            ];

            return response()->json([
                'success'  => true,
                'bookings' => $bookings,
                'stats'    => $stats,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getQueueData: ' . $e->getMessage());

            return response()->json([
                'success'  => false,
                'message'  => 'Error loading queue data: ' . $e->getMessage(),
                'bookings' => [],
                'stats'    => ['total' => 0, 'pending' => 0, 'confirmed' => 0, 'completed' => 0, 'cancelled' => 0, 'completed_no_record' => 0],
            ], 500);
        }
    }

    /**
     * Show booking details (modal partial)
     */
    public function showDetail($id)
    {
        $booking = ServiceBooking::with(['service', 'doctor'])->findOrFail($id);
        $booking->has_medical_record = $booking->medicalRecords()->exists();
        return view('admin.queue.detail', compact('booking'));
    }

    /**
     * Show single booking page
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
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking    = ServiceBooking::findOrFail($id);
        $oldStatus  = $booking->status;
        $newStatus  = $request->status;

        $booking->update(['status' => $newStatus]);

        \Log::info("Booking #{$id} status: {$oldStatus} → {$newStatus}");

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui',
            'booking' => $booking,
        ]);
    }

    /**
     * Delete booking
     */
    public function destroy($id)
    {
        $booking     = ServiceBooking::findOrFail($id);
        $bookingCode = $booking->booking_code;
        $booking->delete();

        \Log::info("Booking #{$id} ({$bookingCode}) deleted");

        return response()->json([
            'success' => true,
            'message' => "Booking {$bookingCode} berhasil dihapus",
        ]);
    }
}