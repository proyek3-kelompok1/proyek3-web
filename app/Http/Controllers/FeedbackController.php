<?php
// app/Http/Controllers/FeedbackController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string'
        ]);

        // Untuk sementara, kita simpan ke session atau langsung return success
        // Nanti bisa diintegrasikan dengan database
        
        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas ulasan Anda!',
            'data' => $validated
        ]);
    }

    public function index()
    {
        // Return data kosong dulu atau data contoh
        return response()->json([
            ['name' => 'Budi Santoso', 'rating' => 5, 'message' => 'Pelayanan memuaskan!'],
            ['name' => 'Sari Indah', 'rating' => 4, 'message' => 'Harga terjangkau dan fasilitas lengkap.']
        ]);
    }

    public function destroy($id)
    {
        return response()->json(['success' => true]);
    }
}