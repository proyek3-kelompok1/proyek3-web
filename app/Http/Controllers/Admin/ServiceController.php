<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $serviceTypes = $this->getServiceTypes();
        $icons = $this->getAvailableIcons();
        return view('admin.services.create', compact('serviceTypes', 'icons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'details' => 'required|string',
            'icon' => 'required|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'service_type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Set default values
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['order'] = $validated['order'] ?? 0;

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $serviceTypes = $this->getServiceTypes();
        $icons = $this->getAvailableIcons();
        return view('admin.services.edit', compact('service', 'serviceTypes', 'icons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'details' => 'required|string',
            'icon' => 'required|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'service_type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        // Update slug jika name berubah
        if ($service->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Set boolean value
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }

    /**
     * Get available service types
     */
    private function getServiceTypes()
    {
        return [
            'general' => 'Umum',
            'vaccination' => 'Vaksinasi',
            'surgery' => 'Operasi',
            'grooming' => 'Grooming',
            'dental' => 'Perawatan Gigi',
            'laboratory' => 'Laboratorium',
            'inpatient' => 'Rawat Inap',
            'emergency' => 'Darurat'
        ];
    }

    /**
     * Get available FontAwesome icons
     */
    private function getAvailableIcons()
    {
        return [
            'fas fa-stethoscope' => 'Stetoskop',
            'fas fa-syringe' => 'Suntik',
            'fas fa-tooth' => 'Gigi',
            'fas fa-cut' => 'Operasi',
            'fas fa-microscope' => 'Mikroskop',
            'fas fa-home' => 'Rumah',
            'fas fa-heartbeat' => 'Jantung',
            'fas fa-eye' => 'Mata',
            'fas fa-ear' => 'Telinga',
            'fas fa-paw' => 'Kaki',
            'fas fa-shower' => 'Mandi',
            'fas fa-prescription' => 'Resep',
            'fas fa-x-ray' => 'X-Ray',
            'fas fa-ambulance' => 'Ambulans',
            'fas fa-user-md' => 'Dokter',
            'fas fa-clinic-medical' => 'Klinik',
            'fas fa-band-aid' => 'Pertolongan',
            'fas fa-bone' => 'Tulang',
            'fas fa-brain' => 'Otak',
            'fas fa-dna' => 'DNA',
            'fas fa-allergies' => 'Alergi',
            'fas fa-vial' => 'Lab',
            'fas fa-temperature-high' => 'Suhu',
            'fas fa-weight' => 'Berat',
            'fas fa-pills' => 'Obat'
        ];
    }
}