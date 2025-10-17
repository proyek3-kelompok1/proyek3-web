<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function create()
    {
        // Data dokter hewan (bisa diambil dari database nanti)
        $doctors = [
            'drh. Andi Wijaya' => 'drh. Andi Wijaya - Spesialis Umum',
            'drh. Sari Dewi' => 'drh. Sari Dewi - Spesialis Bedah',
            'drh. Budi Santoso' => 'drh. Budi Santoso - Spesialis Dermatologi',
            'drh. Maya Purnama' => 'drh. Maya Purnama - Spesialis Gigi'
        ];

        // Data layanan
        $services = [
            'Konsultasi Umum' => 'Konsultasi Umum',
            'Vaksinasi' => 'Vaksinasi',
            'Perawatan Gigi' => 'Perawatan Gigi',
            'Pemeriksaan Darah' => 'Pemeriksaan Darah',
            'Bedah Minor' => 'Bedah Minor',
            'Grooming' => 'Grooming'
        ];

        return view('appointments.create', compact('doctors', 'services'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemilik' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:15',
            'nama_hewan' => 'required|string|max:255',
            'jenis_hewan' => 'required|string|max:255',
            'ras' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'dokter' => 'required|string|max:255',
            'layanan' => 'required|string|max:255',
            'tanggal_jam' => 'required|date|after:now',
            'keluhan' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data appointment
        $appointment = Appointment::create([
            'nama_pemilik' => $request->nama_pemilik,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis_hewan,
            'ras' => $request->ras,
            'umur' => $request->umur,
            'dokter' => $request->dokter,
            'layanan' => $request->layanan,
            'tanggal_jam' => $request->tanggal_jam,
            'keluhan' => $request->keluhan,
            'status' => 'pending',
        ]);

        // Redirect ke halaman sukses
        return redirect()->route('appointments.success')->with([
            'success' => 'Janji temu berhasil dibuat!',
            'appointment' => $appointment
        ]);
    }

    public function success()
    {
        if (!session('success')) {
            return redirect()->route('appointments.create');
        }

        return view('appointments.success');
    }
}