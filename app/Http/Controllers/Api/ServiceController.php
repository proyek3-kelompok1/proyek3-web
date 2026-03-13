<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', 1)
            ->orderBy('order')
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'slug' => $service->slug,
                    'description' => $service->description,
                    'price' => $service->price,
                    'formatted_price' => 'Rp ' . number_format($service->price, 0, ',', '.'),
                    'duration_minutes' => $service->duration_minutes,
                    'service_type' => $service->service_type,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }
}
