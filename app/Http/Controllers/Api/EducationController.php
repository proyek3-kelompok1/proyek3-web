<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::published()
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $education
        ]);
    }

    public function show($id)
    {
        $education = Education::published()->find($id);

        if (!$education) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $education->increment('view');

        return response()->json([
            'status' => true,
            'data' => $education
        ]);
    }
}
