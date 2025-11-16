<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'specialization' => 'nullable|string|max:255',
        'schedule' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'nullable|string',
    ]);

    $doctor = new Doctor();
    $doctor->name = $request->name;
    $doctor->specialization = $request->specialization;
    $doctor->schedule = $request->schedule;
    $doctor->description = $request->description;

    if ($request->hasFile('photo')) {
        // Simpan di folder 'doctors' dalam storage
        $photoPath = $request->file('photo')->store('doctors', 'public');
        $doctor->photo = $photoPath; // Simpan path relatif
    }

    $doctor->save();

    return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil ditambahkan.');
}

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'schedule' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $doctor->name = $request->name;
        $doctor->specialization = $request->specialization;
        $doctor->schedule = $request->schedule;
        $doctor->description = $request->description;

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($doctor->photo) {
                Storage::disk('public')->delete($doctor->photo);
            }
            
            $photoPath = $request->file('photo')->store('doctors', 'public');
            $doctor->photo = $photoPath;
        }

        $doctor->save();

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->photo) {
            Storage::disk('public')->delete($doctor->photo);
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil dihapus.');
    }
}