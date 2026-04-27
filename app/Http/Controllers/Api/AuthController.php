<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;

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
                // Update google_id jika belum ada, avatar hanya jika masih kosong
                $updateData = ['google_id' => $googleUser->getId()];
                if (empty($user->avatar)) {
                    $updateData['avatar'] = $googleUser->getAvatar();
                }
                $user->update($updateData);
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
     * Handle Login via Email and Password
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    /**
     * Handle Registration via Email and Password
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto-verify, tidak perlu OTP
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil! Silakan login dengan akun Anda.',
            'email' => $user->email
        ]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp_code', $request->otp)
                    ->first();

        if (!$user) {
            return response()->json([
                'message' => 'Kode OTP salah atau tidak berlaku.'
            ], 400);
        }

        // Tandai sebagai diverifikasi (Direct assignment lebih aman dari Mass Assignment)
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->save();

        return response()->json([
            'message' => 'Email berhasil diverifikasi! Silakan login.',
            'is_verified' => $user->email_verified_at ? true : false
        ]);
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan.'
            ], 404);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Email ini sudah diverifikasi.'
            ], 400);
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);
        $user->update(['otp_code' => $otp]);

        try {
            Mail::to($user->email)->send(new OTPMail($otp));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengirim email. Silakan coba lagi.'
            ], 500);
        }

        return response()->json([
            'message' => 'Kode OTP baru telah dikirim ke email Anda.'
        ]);
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
        \Log::info("Update Profile Request", [
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'has_file' => $request->hasFile('avatar')
        ]);

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning("Profile Validation Failed", $e->errors());
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        }

        $data = $request->only('name', 'phone');

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada dan bukan dari google (opsional, tapi bagus untuk hemat storage)
            // Untuk simpelnya kita simpan saja yang baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = asset('storage/' . $path);
        }

        $user->update($data);
        \Log::info("Profile Updated for user {$user->id}", ['avatar' => $user->avatar]);

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

    /**
     * Update FCM Token
     */
    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        $user = $request->user();
        if ($user) {
            $user->update(['fcm_token' => $request->fcm_token]);
            return response()->json(['success' => true, 'message' => 'FCM Token updated']);
        }

        return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
    }
}
