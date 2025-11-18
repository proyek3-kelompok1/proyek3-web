<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Menampilkan halaman edukasi untuk frontend
     */
    public function index()
    {
        try {
            // Pastikan hanya mengambil yang published
            $educations = Education::where('is_published', true)
                                  ->orderBy('created_at', 'desc')
                                  ->get();

            // Debug: Cek data yang diambil
            \Log::info('Education data fetched:', [
                'total' => $educations->count(),
                'published' => $educations->where('is_published', true)->count()
            ]);

            // Pisahkan berdasarkan type untuk tabs
            $videos = $educations->where('type', 'video');
            $guides = $educations->where('type', 'guide');

            // Featured content (ambil yang terbaru)
            $featuredContent = $educations->first();

            return view('articles', compact('videos', 'guides', 'featuredContent'));
            
        } catch (\Exception $e) {
            \Log::error('Error in EducationController@index: ' . $e->getMessage());
            
            // Fallback jika ada error
            return view('articles', [
                'videos' => collect(),
                'guides' => collect(),
                'featuredContent' => null
            ]);
        }
    }

    /**
     * Menampilkan detail edukasi
     */
    public function show($id)
    {
        $education = Education::where('id', $id)
                             ->where('is_published', true)
                             ->firstOrFail();

        // Increment views counter jika ada
        if (method_exists($education, 'increment')) {
            $education->increment('views');
        }

        return view('education.show', compact('education'));
    }
}