<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Handle Login / Register via Google Token from Flutter
     */
    public function googleLogin(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        try {
            // Kita verifikasi token yang dikirim dari Flutter menggunakan Socialite
            $googleUser = Socialite::driver('google')->userFromToken($request->token);

            // Cari user berdasarkan email atau google_id
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update data jika user sudah ada
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Buat user baru jika belum ada
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)), // Random password
                ]);
            }

            // Generate token Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid Google Token',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Get User Profile
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Update User Profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('name', 'phone');

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada dan bukan dari google (opsional, tapi bagus untuk hemat storage)
            // Untuk simpelnya kita simpan saja yang baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = asset('storage/' . $path);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // Hapus token aktif saat ini
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Logged out successfully']);
    }
}
