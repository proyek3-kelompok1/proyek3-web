<?php

namespace App\Http\Controllers;

use App\Models\Consultations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ConsultationsController extends Controller
{
    public function showForm()
    {
        return view('consultations');
    }

    public function store(Request $request)
    {
        Log::info('Consultation form submitted:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'pet_type' => 'required|string',
            'services' => 'nullable|array',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'pet_type.required' => 'Jenis hewan harus dipilih',
            'message.required' => 'Pesan konsultasi harus diisi',
            'message.min' => 'Pesan konsultasi minimal 10 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $validator->validated();
            
            // Convert services array to JSON
            if (isset($data['services'])) {
                $data['services'] = json_encode($data['services']);
            }

            // Create consultation
            $consultation = Consultations::create($data);

            Log::info('Consultation created:', $consultation->toArray());

            return redirect()->back()
                ->with('success', 'Terima kasih! Form konsultasi Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.');

        } catch (\Exception $e) {
            Log::error('Error creating consultation: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengirim form. Silakan coba lagi.')
                ->withInput();
        }
    }
}