<?php

namespace App\Http\Controllers;

use App\Models\Consultations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationsController extends Controller
{
    public function showForm()
    {
        return view('konsultasi-form'); // Ganti dengan view yang sudah ada
    }

   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'message' => 'required|string|min:10',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Ambil hanya data yang sudah tervalidasi
    $data = $validator->validated();

    // Pastikan model yang dipanggil sesuai: Konsultasi (sesuaikan namespace/import)
    Consultations::create($data);

    return redirect()->back()
        ->with('success', 'Terima kasih! Form konsultasi Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.');
}

    public function index()
    {
        // $consultations = Konsultasi::orderBy('created_at', 'desc')->get();
        // return view('admin.consultations', compact('consultations'));
    }

    public function updateStatus(Request $request, $id)
    {
        // $consultation = Konsultasi::findOrFail($id);
        // $consultation->update([
        //     'is_responded' => $request->has('is_responded')
        // ]);

        // return redirect()->back()->with('success', 'Status berhasil diupdate!');
    }
}