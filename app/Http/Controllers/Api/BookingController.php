<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemilik' => 'required',
            'email' => 'required|email',
            'telepon' => 'required',
            'nama_hewan' => 'required',
            'jenis_hewan' => 'required',
            'umur' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'doctor_id' => 'required|exists:doctors,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $service = Service::findOrFail($request->service_id);

        // Ambil nomor antrian terakhir hari itu untuk service yang sama
        $lastQueue = ServiceBooking::whereDate('booking_date', $request->booking_date)
            ->where('service_id', $request->service_id)
            ->max('nomor_antrian');

        $nomorAntrian = $lastQueue ? $lastQueue + 1 : 1;

        // Generate booking code
        $bookingCode = 'BK-' . now()->format('Ymd') . '-' . str_pad($nomorAntrian, 3, '0', STR_PAD_LEFT);

        $booking = ServiceBooking::create([
            'nama_pemilik' => $request->nama_pemilik,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis_hewan,
            'ras' => $request->ras,
            'umur' => $request->umur,
            'service_id' => $service->id,
            'service_type' => $service->service_type,
            'doctor_id' => $request->doctor_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'catatan' => $request->catatan,
            'total_price' => $service->price,
            'nomor_antrian' => $nomorAntrian,
            'booking_code' => $bookingCode,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat',
            'data' => [
                'booking_code' => $booking->booking_code,
                'nomor_antrian' => $booking->nomor_antrian,
                'service_name' => $service->name,
                'doctor_name' => $booking->doctor->name ?? null,
                'booking_date' => $booking->booking_date,
                'booking_time' => $booking->booking_time,
                'total_price' => $booking->total_price,
            ]
        ]);
    }
}
