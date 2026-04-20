<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\MedicalRecord;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    /**
     * Get chat history for the authenticated user
     */
    public function getHistory()
    {
        $userId = auth()->id();
        Log::info("AI Chat History requested by user: $userId");

        $messages = ChatMessage::where('user_id', $userId)
            ->where('is_user', true)
            ->orWhere(function($query) use ($userId) {
                $query->where('user_id', $userId)->where('is_user', false);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        Log::info("Found " . $messages->count() . " chat messages for user: $userId");

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Handle chat with Gemini AI
     */
    public function chat(Request $request)
    {
        Log::info("AI Chat Request started", ['user_id' => auth()->id(), 'message' => $request->message]);

        $request->validate([
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        if (!$user) {
            Log::warning("AI Chat: User unauthorized");
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $userMessage = $request->message;

        // 1. Ambil data rekam medis untuk konteks
        try {
            $medicalContext = $this->getMedicalContext($user);
        } catch (\Exception $e) {
            Log::error("Medical Context Error: " . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil konteks medis.'], 500);
        }

        // 2. Simpan pesan user ke database
        try {
            Log::info("AI Chat Request started", [
                'user_id' => $user->id,
                'email' => $user->email,
                'message' => $request->message
            ]);
            ChatMessage::create([
                'user_id' => $user->id,
                'message' => $userMessage,
                'is_user' => true,
            ]);
        } catch (\Exception $e) {
            Log::error("DB Chat Store Error: " . $e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan pesan ke database.'], 500);
        }

        // 3. Panggil Gemini AI
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::error("AI Chat Error: GEMINI_API_KEY is missing in .env");
            return response()->json(['message' => 'AI Configuration error.'], 500);
        }

        try {
            $systemPrompt = "Kamu adalah asisten dokter hewan profesional di DevPets yang ramah. " .
                "Bantulah pengguna menjawab pertanyaan mereka tentang hewan peliharaan. " .
                "Berikut adalah data rekam medis hewan peliharaan pengguna untuk memberimu konteks (urutkan dari yang terbaru):\n" .
                $medicalContext . "\n\n" .
                "Gunakan data di atas untuk menjawab jika relevan. Jika pengguna bertanya hal umum, jawablah secara profesional.";

            Log::info("Calling Gemini API...");
            $response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nUser: " . $userMessage]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $aiResponse = $response->json('candidates.0.content.parts.0.text');

                // 4. Simpan jawaban AI ke database
                ChatMessage::create([
                    'user_id' => $user->id,
                    'message' => $aiResponse,
                    'is_user' => false,
                ]);

                return response()->json([
                    'message' => $aiResponse,
                ]);
            } else {
                Log::error("Gemini API Error: " . $response->body());
                return response()->json(['message' => 'Gagal menghubungi AI.'], 500);
            }
        } catch (\Exception $e) {
            Log::error("AI Chat Error: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan sistem.'], 500);
        }
    }

    /**
     * Build medical record string for AI context
     */
    private function getMedicalContext($user)
    {
        // Ambil booking milik user yang punya rekam medis
        $bookings = ServiceBooking::where('user_id', $user->id)
            ->whereHas('medicalRecords')
            ->with(['medicalRecords' => function($q) {
                $q->orderBy('tanggal_pemeriksaan', 'desc');
            }])
            ->orderBy('id', 'desc')
            ->get();

        if ($bookings->isEmpty()) {
            return "Pengguna belum memiliki rekam medis.";
        }

        $context = "";
        foreach ($bookings as $booking) {
            foreach ($booking->medicalRecords as $record) {
                $context .= "- Tanggal: {$record->tanggal_pemeriksaan}, Hewan: {$record->nama_hewan} ({$record->jenis_hewan}), " .
                    "Diagnosa: {$record->diagnosa}, Tindakan: {$record->tindakan}, " .
                    "Catatan Dokter: {$record->catatan_dokter}\n";
            }
        }

        return $context;
    }
}
