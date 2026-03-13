<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $serviceType = $request->service_type;

        $doctors = Doctor::when($serviceType, function ($query) use ($serviceType) {
                $query->where('specialization', $serviceType);
            })
            ->get()
            ->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'specialization' => $doctor->specialization,
                    'schedule' => $doctor->schedule,
                    'photo_url' => $doctor->photo 
                        ? asset('storage/' . $doctor->photo)
                        : null,
                    'description' => $doctor->description,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $doctors
        ]);
    }
}
