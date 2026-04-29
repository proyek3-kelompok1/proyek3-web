<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    private function getAiServiceUrl(): string
    {
        return env('AI_SERVICE_URL', 'http://127.0.0.1:5000');
    }

    // ─────────────────────────────────────────────────────
    //  GET HISTORY
    // ─────────────────────────────────────────────────────
    public function getHistory()
    {
        $userId = auth()->id();

        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // ─────────────────────────────────────────────────────
    //  DELETE HISTORY
    // ─────────────────────────────────────────────────────
    public function deleteHistory()
    {
        $userId = auth()->id();
        ChatMessage::where('user_id', $userId)->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Riwayat chat berhasil dihapus'
        ], 200);
    }

    // ─────────────────────────────────────────────────────
    //  CHAT — Model .pkl + ZhipuAI GLM hybrid
    // ─────────────────────────────────────────────────────
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $userMessage    = $request->message ?? '';
        $base64Image    = $request->image; // Data gambar base64
        $medicalContext = $this->getMedicalContext($user);

        // Simpan pesan user
        ChatMessage::create([
            'user_id' => $user->id,
            'message' => $userMessage,
            'is_user' => true,
        ]);

        // STEP 1: Python service (model .pkl) → deteksi gejala & diagnosa
        // (Gambar sementara diabaikan untuk klasifikasi .pkl, hanya untuk LLM)
        $modelResult = $this->callPythonAiService($userMessage);

        $providerUsed = 'zhipu';

        // STEP 2: AI generate jawaban
        if ($modelResult !== null && $modelResult['ada_gejala']) {
            $aiResponse = $this->callZhipuWithDiagnosis($userMessage, $modelResult, $medicalContext, $base64Image)
                       ?? $this->buildLocalDiagnosisResponse($modelResult);
        } else {
            $aiResponse = $this->callZhipuGeneral($userMessage, $medicalContext, $base64Image)
                       ?? $this->buildLocalGeneralResponse();
        }

        // Cek apakah fallback ke groq terjadi
        if (str_contains(session('ai_provider_used', 'zhipu'), 'groq')) {
            $providerUsed = 'groq';
        }

        // Simpan jawaban AI
        ChatMessage::create([
            'user_id' => $user->id,
            'message' => $aiResponse,
            'is_user' => false,
        ]);

        return response()->json([
            'message' => $aiResponse,
            'provider' => $providerUsed
        ]);
    }

    // ─────────────────────────────────────────────────────
    //  PYTHON SERVICE
    // ─────────────────────────────────────────────────────
    private function callPythonAiService(string $userMessage): ?array
    {
        try {
            $response = Http::timeout(3)->post($this->getAiServiceUrl() . '/chat', [
                'message' => $userMessage,
            ]);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::warning('Python AI service tidak bisa dijangkau: ' . $e->getMessage());
            return null;
        }
    }

    // ─────────────────────────────────────────────────────
    //  ZHIPUAI GLM — Dengan hasil diagnosa model
    // ─────────────────────────────────────────────────────
    private function callZhipuWithDiagnosis(string $userMessage, array $model, string $medicalContext, ?string $base64Image = null): ?string
    {
        $diagnosa     = $model['diagnosa_display'] ?? '-';
        $probabilitas = $model['probabilitas'] ?? 0;
        $saran        = $model['saran'] ?? '';
        $gejala       = implode(', ', $model['gejala_aktif'] ?? []);
        $urgensi      = $model['level_urgensi'] ?? 'normal';

        $top3Text = collect($model['top3'] ?? [])->map(function ($item, $i) {
            return ($i + 1) . '. ' . str_replace('_', ' ', ucwords($item['penyakit'])) . " ({$item['probabilitas']}%)";
        })->implode("\n");

        $urgensiNote = match ($urgensi) {
            'darurat' => 'PENTING: Ini kondisi DARURAT. Tekankan untuk segera ke klinik.',
            'serius'  => 'Kondisi ini serius, sarankan periksa secepatnya.',
            default   => 'Kondisi stabil, sampaikan dengan tenang.',
        };

        // System Prompt: Ramah, Profesional, dan Peduli (Tidak Lebay)
        $systemPrompt = "Kamu adalah DokterPaw, asisten cerdas dari klinik DVPets yang sangat peduli dengan kesehatan hewan. "
            . "Kepribadianmu: Ramah, hangat, jujur, dan sedikit ceria tapi tetap profesional. Jangan terlalu berlebihan (lebay) atau sok akrab yang mengganggu. "
            . "PENTING: Selalu sebut dirimu 'DokterPaw' secara natural (contoh: 'DokterPaw sudah cek gejalanya...', 'Menurut catatan DokterPaw...'). "
            . "Gunakan bahasa Indonesia yang santai tapi sopan. Gunakan emoji secukupnya dan pastikan RELEVAN (contoh: 🐱 untuk kucing, 🐶 untuk anjing, 🐾 untuk umum). "
            . "Berikan diagnosa awal berdasarkan data dengan jelas dan tenang. Jika kondisi serius, sampaikan dengan empati dan sarankan ke dokter hewan secepatnya. "
            . "Jangan gunakan markdown tebal (**) atau heading (#).";

        $userPrompt = "Konteks Medis:\n{$medicalContext}\n\n"
            . "User bertanya: \"{$userMessage}\"\n\n"
            . "DATA ANALISIS DOKTERPAW (WAJIB DISEBUTKAN):\n"
            . "- Gejala terdeteksi: {$gejala}\n"
            . "- Diagnosa Utama: {$diagnosa} ({$probabilitas}%)\n"
            . "- Top 3 Kemungkinan:\n{$top3Text}\n"
            . "- Saran DokterPaw: {$saran}\n"
            . "- Urgensi: {$urgensi}\n\n"
            . "INSTRUKSI: Jawab dengan gaya DokterPaw yang ramah, empati, dan informatif. Sebutkan diagnosa dan top 3 dengan jelas agar user paham. {$urgensiNote}";

        return $this->callMultiProviderAi($systemPrompt, $userPrompt, $base64Image);
    }

    // ─────────────────────────────────────────────────────
    //  ZHIPUAI GLM — Pertanyaan umum
    // ─────────────────────────────────────────────────────
    private function callZhipuGeneral(string $userMessage, string $medicalContext, ?string $base64Image = null): ?string
    {
        $systemPrompt = "Kamu adalah DokterPaw, asisten virtual DVPets yang ramah dan membantu. "
            . "Tugasmu menjawab pertanyaan umum seputar perawatan hewan dengan bahasa yang hangat namun tetap informatif. "
            . "Gunakan sedikit emoji yang relevan agar suasana chat tetap menyenangkan tapi tidak berlebihan.";

        $userPrompt = "Konteks Medis:\n{$medicalContext}\n\n"
            . "User bertanya: \"{$userMessage}\"";

        return $this->callMultiProviderAi($systemPrompt, $userPrompt, $base64Image);
    }

    // ─────────────────────────────────────────────────────
    //  MULTI-PROVIDER AI WRAPPER (Switching Logic)
    // ─────────────────────────────────────────────────────
    private function callMultiProviderAi(string $systemPrompt, string $userPrompt, ?string $base64Image = null): ?string
    {
        // 1. Coba ZhipuAI (GLM) sebagai utama
        $zhipu = $this->callZhipuRaw($systemPrompt, $userPrompt, $base64Image);
        if ($zhipu) {
            session(['ai_provider_used' => 'zhipu']);
            return $zhipu;
        }

        // 2. Jika Zhipu gagal/limit, coba Groq (Llama)
        Log::warning('ZhipuAI gagal atau limit, beralih ke Groq...');
        session(['ai_provider_used' => 'groq']);
        return $this->callGroqRaw($systemPrompt, $userPrompt);
    }

    // ─────────────────────────────────────────────────────
    //  ZHIPUAI GLM RAW CALLER
    // ─────────────────────────────────────────────────────
    private function callZhipuRaw(string $systemPrompt, string $userPrompt, ?string $base64Image = null): ?string
    {
        $apiKey = env('ZHIPU_API_KEY');
        $model  = env('ZHIPU_MODEL', 'glm-4.5-flash');
        $url    = 'https://open.bigmodel.cn/api/paas/v4/chat/completions';

        if (!$apiKey) return null;

        $content = [['type' => 'text', 'text' => $userPrompt]];
        if ($base64Image) {
            $content[] = [
                'type' => 'image_url',
                'image_url' => ['url' => 'data:image/png;base64,' . $base64Image]
            ];
        }

        try {
            $response = Http::timeout(25)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])
                ->post($url, [
                    'model'    => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $content],
                    ],
                ]);

            if ($response->successful()) {
                $rawContent = $response->json('choices.0.message.content');
                $text = is_array($rawContent) ? ($rawContent[0]['text'] ?? null) : $rawContent;
                if ($text) {
                    $text = preg_replace('/\*{1,2}([^*]+)\*{1,2}/', '$1', $text);
                    $text = preg_replace('/#{1,3}\s*/', '', $text);
                    return trim($text);
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::error("ZhipuAI Error: " . $e->getMessage());
            return null;
        }
    }

    // ─────────────────────────────────────────────────────
    //  GROQ RAW CALLER (Fallback)
    // ─────────────────────────────────────────────────────
    private function callGroqRaw(string $systemPrompt, string $userPrompt): ?string
    {
        $apiKey = env('GROQ_API_KEY');
        $model  = env('GROQ_MODEL', 'llama-3.1-8b-instant');
        $url    = 'https://api.groq.com/openai/v1/chat/completions';

        if (!$apiKey) return null;

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])
                ->post($url, [
                    'model'    => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                ]);

            if ($response->successful()) {
                $text = $response->json('choices.0.message.content');
                if ($text) {
                    $text = preg_replace('/\*{1,2}([^*]+)\*{1,2}/', '$1', $text);
                    $text = preg_replace('/#{1,3}\s*/', '', $text);
                    Log::info("Groq Fallback OK");
                    return trim($text);
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Groq exception: ' . $e->getMessage());
            return null;
        }
    }

    // ─────────────────────────────────────────────────────
    //  FALLBACK LOKAL — Diagnosa
    // ─────────────────────────────────────────────────────
    private function buildLocalDiagnosisResponse(array $model): string
    {
        $diagnosa     = $model['diagnosa_display'] ?? 'tidak diketahui';
        $probabilitas = $model['probabilitas'] ?? 0;
        $saran        = $model['saran'] ?? 'Segera konsultasikan ke dokter hewan.';
        $gejala       = implode(', ', $model['gejala_aktif'] ?? []);
        $urgensi      = $model['level_urgensi'] ?? 'normal';

        $top3Lines = collect($model['top3'] ?? [])->map(function ($item, $i) {
            return ($i + 1) . '. ' . ucfirst(str_replace('_', ' ', $item['penyakit'])) . " ({$item['probabilitas']}%)";
        })->implode("\n");

        $urgensiTeks = match ($urgensi) {
            'darurat' => 'Ini kondisi DARURAT. Segera bawa hewan kamu ke dokter hewan sekarang!',
            'serius'  => 'Kondisi ini perlu penanganan segera. Jangan tunda untuk ke dokter hewan.',
            default   => 'Disarankan segera periksakan hewan kamu ke dokter hewan.',
        };

        return "Berdasarkan gejala yang kamu ceritakan ({$gejala}), berikut hasil analisis AI kami.\n\n"
            . "Kemungkinan utama: {$diagnosa} ({$probabilitas}%)\n\n"
            . "Top 3 kemungkinan:\n{$top3Lines}\n\n"
            . "Saran penanganan:\n{$saran}\n\n"
            . $urgensiTeks;
    }

    // ─────────────────────────────────────────────────────
    //  FALLBACK LOKAL — Umum
    // ─────────────────────────────────────────────────────
    private function buildLocalGeneralResponse(): string
    {
        return "Halo! Saya DokterPaw, asisten kesehatan hewan peliharaan kamu.\n\n"
            . "Ceritakan gejala hewan kesayanganmu secara spesifik agar saya bisa membantu mendiagnosa, misalnya:\n"
            . "Kucing saya demam dan tidak mau makan sejak kemarin\n"
            . "Anjing saya muntah, lemas, dan diare\n"
            . "Kelinci saya ada luka dan terlihat lesu\n\n"
            . "Saya akan menganalisa menggunakan model AI kami. Untuk diagnosis resmi, tetap konsultasikan ke dokter hewan ya!";
    }

    // ─────────────────────────────────────────────────────
    //  MEDICAL CONTEXT
    // ─────────────────────────────────────────────────────
    private function getMedicalContext($user): string
    {
        $bookings = ServiceBooking::where('user_id', $user->id)
            ->whereHas('medicalRecords')
            ->with(['medicalRecords' => fn($q) => $q->orderBy('tanggal_pemeriksaan', 'desc')])
            ->orderBy('id', 'desc')
            ->get();

        if ($bookings->isEmpty()) {
            return 'Pengguna belum memiliki rekam medis hewan.';
        }

        $context = "RIWAYAT REKAM MEDIS HEWAN USER:\n";
        foreach ($bookings as $booking) {
            foreach ($booking->medicalRecords as $record) {
                $tgl = $record->tanggal_pemeriksaan ? $record->tanggal_pemeriksaan->format('d M Y') : '-';
                $context .= "--- Kunjungan $tgl ---\n"
                    . "Nama Hewan: {$record->nama_hewan} ({$record->jenis_hewan})\n"
                    . "Keluhan: {$record->keluhan_utama}\n"
                    . "Diagnosa: {$record->diagnosa}\n"
                    . "Tindakan: {$record->tindakan}\n"
                    . "Resep Obat: {$record->resep_obat}\n"
                    . "Catatan Dokter: {$record->catatan_dokter}\n"
                    . "Suhu: {$record->suhu_tubuh}, Berat: {$record->berat_badan}\n\n";
            }
        }

        return $context;
    }
}
