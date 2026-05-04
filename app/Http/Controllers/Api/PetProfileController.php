<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetProfile;
use Illuminate\Support\Facades\Auth;

class PetProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pets = clone $user->petProfiles()->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $pets,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'breed' => 'nullable|string',
            'age_months' => 'nullable|integer',
            'weight_kg' => 'nullable|numeric',
            'photo' => 'nullable|image|max:2048',
            'health_history_notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        $data = $request->except('photo');
        $data['user_id'] = $user->id;

        // Simulasi sistem rekomendasi/pengingat cerdas
        if ($request->has('age_months')) {
            $age = $request->age_months;
            if ($age < 3 || ($age > 12 && $age % 12 == 0)) {
                $data['needs_vaccine'] = true;
            }
        }
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }

        $pet = PetProfile::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil hewan berhasil ditambahkan',
            'data' => $pet,
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $pet = $user->petProfiles()->find($id);

        if (!$pet) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        // Generate dynamic recommendations
        $recommendations = [];
        if ($pet->needs_vaccine) {
            $recommendations[] = "Sudah waktunya vaksinasi tahunan/rutin. Segera buat jadwal konsultasi.";
        }
        if ($pet->needs_grooming) {
            $recommendations[] = "Bulu anabul mungkin sudah mulai kotor. Jadwalkan grooming.";
        }
        if ($pet->weight_kg > 10 && $pet->type === 'Kucing') {
            $recommendations[] = "Peringatan: Berat badan kucing sedikit berlebih. Perhatikan pola makan diet.";
        }
        if (count($recommendations) == 0) {
            $recommendations[] = "Kondisi anabul terlihat sehat. Terus pertahankan asupan nutrisi yang baik!";
        }

        $petArray = $pet->toArray();
        $petArray['smart_recommendations'] = $recommendations;

        return response()->json([
            'success' => true,
            'data' => $petArray,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $pet = $user->petProfiles()->find($id);

        if (!$pet) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string',
            'type' => 'nullable|string',
            'breed' => 'nullable|string',
            'age_months' => 'nullable|integer',
            'weight_kg' => 'nullable|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil hewan berhasil diupdate',
            'data' => $pet,
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $pet = $user->petProfiles()->find($id);

        if ($pet) {
            $pet->delete();
            return response()->json(['success' => true, 'message' => 'Profil hewan dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Not found'], 404);
    }
}
