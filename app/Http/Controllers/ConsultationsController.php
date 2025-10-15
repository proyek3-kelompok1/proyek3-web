<?php

namespace App\Http\Controllers;

use App\Models\Consultations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationsController extends Controller
{
public function showForm()
{
    return view('consultations'); // Sesuaikan dengan view yang ada
}

  // ConsultationsController.php
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'pet_type' => 'required|string',
        'services' => 'nullable|array',
        'message' => 'required|string|min:10',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $data = $validator->validated();
    
    // Convert services array to JSON
    if (isset($data['services'])) {
        $data['services'] = json_encode($data['services']);
    }

    // Pastikan modelnya ada
    Consultations::create($data);

    return redirect()->back()
        ->with('success', 'Terima kasih! Form konsultasi Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.');
}
}