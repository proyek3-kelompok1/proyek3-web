<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EducationController extends Controller
{
    /**
     * Menampilkan halaman edukasi untuk frontend
     */
    public function index()
{
    // Ambil semua edukasi yang published
    $educations = Education::where('is_published', true)
                            ->orderBy('created_at', 'desc')
                            ->get();

    // Featured (ambil konten pertama)
    $featuredContent = $educations->first();

    return view('education.index', [
    'educations' => $educations,
    'featuredContent' => $featuredContent
]);

}


    /**
     * Menampilkan detail edukasi
     */
    public function show($id)
{
    $education = Education::where('id', $id)
        ->where('is_published', true)
        ->firstOrFail();

    // Increment views
    $education->increment('view');

    // Ambil artikel terkait
    $related = Education::where('id', '!=', $education->id)
                ->where('is_published', true)
                ->limit(5)
                ->get();

    return view('education.show', [
        'education' => $education,
        'related'   => $related
    ]);
}

}