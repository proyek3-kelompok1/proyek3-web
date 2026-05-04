<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    protected $firebaseService;

    public function __construct(\App\Services\FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $educations = Education::latest()->get();
        return view('admin.education.index', compact('educations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.education.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'type' => 'required|string',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string',
            'level' => 'nullable|string',
            'reading_time' => 'nullable|string',
            'is_published' => 'boolean'
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('education/thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        // Set default value untuk is_published jika tidak dicentang
        $validated['is_published'] = $request->has('is_published');

        $education = Education::create($validated);

        // Kirim notifikasi jika dipublish
        if ($education->is_published) {
            $this->firebaseService->sendToTopic('education', 'Edukasi Baru!', $education->title, [
                'type' => 'education',
                'id' => (string)$education->id
            ]);
        }

        return redirect()->route('admin.education.index')
            ->with('success', 'Edukasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        return view('admin.education.show', compact('education'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        return view('admin.education.edit', compact('education'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'type' => 'required|string',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string',
            'level' => 'nullable|string',
            'reading_time' => 'nullable|string',
            'is_published' => 'boolean'
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($education->thumbnail) {
                Storage::disk('public')->delete($education->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('education/thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        // Set default value untuk is_published jika tidak dicentang
        $validated['is_published'] = $request->has('is_published');

        $education->update($validated);

        return redirect()->route('admin.education.index')
            ->with('success', 'Edukasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        // Hapus thumbnail jika ada
        if ($education->thumbnail) {
            Storage::disk('public')->delete($education->thumbnail);
        }

        $education->delete();

        return redirect()->route('admin.education.index')
            ->with('success', 'Edukasi berhasil dihapus!');
    }
}