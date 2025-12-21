<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Menampilkan halaman layanan untuk user
     */
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('services', compact('services'));
    }

    /**
     * API untuk mendapatkan detail layanan
     */
    public function showApi($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }
}