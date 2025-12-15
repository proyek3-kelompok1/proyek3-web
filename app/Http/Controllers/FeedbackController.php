<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    // Simpan feedback dari after_service page
    public function storeAfterService(Request $request)
    {
        try {
            Log::info('After service feedback store method called', ['data' => $request->all()]);

            // Validasi data
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'message' => 'nullable|string',
                'service_type' => 'nullable|string|max:255',
                'transaction_id' => 'nullable|string|max:255'
            ]);

            // Jika nama tidak diisi, gunakan "Anonymous"
            if (empty($validated['name'])) {
                $validated['name'] = 'Anonymous';
            }

            // Tambahkan metadata dan source
            $validated['source'] = 'after_service';
            $validated['is_verified'] = true;
            $validated['metadata'] = json_encode([
                'service_type' => $validated['service_type'] ?? null,
                'transaction_id' => $validated['transaction_id'] ?? null,
                'feedback_type' => 'after_service'
            ]);

            Log::info('After service validation passed', ['validated' => $validated]);

            // Simpan ke database
            $feedback = Feedback::create($validated);

            Log::info('After service feedback saved successfully', ['id' => $feedback->id]);

            // Redirect ke halaman consultations dengan pesan sukses
            return redirect()->route('consultations')->with([
                'success' => 'Terima kasih atas ulasan Anda! Ulasan telah ditambahkan.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('After service validation error', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('After service feedback store error: ' . $e->getMessage());
            
            return back()->with([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->withInput();
        }
    }

    // Simpan feedback dari consultation page (AJAX)
    public function storeFromConsultation(Request $request)
    {
        try {
            Log::info('Consultation feedback store method called', ['data' => $request->all()]);

            $validator = \Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'message' => 'required|string|max:1000',
                'name' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $feedback = Feedback::create([
                'name' => $request->name,
                'rating' => $request->rating,
                'message' => $request->message,
                'source' => 'consultation',
                'is_verified' => true,
                'metadata' => json_encode(['feedback_type' => 'consultation'])
            ]);

            Log::info('Consultation feedback saved successfully', ['id' => $feedback->id]);

            return response()->json([
                'success' => true,
                'feedback' => [
                    'id' => $feedback->id,
                    'name' => $feedback->name,
                    'rating' => $feedback->rating,
                    'message' => $feedback->message,
                    'source' => $feedback->source,
                    'created_at' => $feedback->created_at->format('Y-m-d H:i:s'),
                    'formatted_date' => $feedback->formatted_date
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Consultation feedback store error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan ulasan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Ambil semua feedback (untuk consultation page)
    public function index()
{
    try {
        Log::info('=== START FETCHING FEEDBACKS ===');
        
        // Debug: Cek apakah model Feedback ada
        Log::info('Model check: ' . class_exists(Feedback::class));
        
        // Coba query sederhana dulu
        $count = Feedback::count();
        Log::info('Total feedbacks in database: ' . $count);
        
        // Coba tanpa scope dulu
        $feedbacks = Feedback::orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        Log::info('Raw feedbacks query executed', ['count' => $feedbacks->count()]);
        
        // Mapping data dengan cara yang lebih aman
        $mappedFeedbacks = [];
        foreach ($feedbacks as $feedback) {
            $mappedFeedbacks[] = [
                'id' => $feedback->id,
                'name' => $feedback->name,
                'rating' => $feedback->rating,
                'message' => $feedback->message,
                'service_type' => $feedback->service_type,
                'source' => $feedback->source,
                'created_at' => $feedback->created_at ? $feedback->created_at->format('Y-m-d H:i:s') : null,
                'formatted_date' => $feedback->created_at ? $feedback->created_at->format('d M Y') : 'N/A'
            ];
        }
        
        Log::info('Feedbacks mapped successfully', ['count' => count($mappedFeedbacks)]);
        Log::info('=== END FETCHING FEEDBACKS ===');
        
        return response()->json($mappedFeedbacks);
        
    } catch (\Exception $e) {
        Log::error('Feedback index error: ' . $e->getMessage());
        Log::error('Error trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'error' => 'Gagal memuat ulasan: ' . $e->getMessage(),
            'debug' => 'Check laravel.log for details'
        ], 500);
    }
}

    // Hapus feedback
    public function destroy($id)
    {
        try {
            Log::info('Deleting feedback', ['id' => $id]);
            
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();
            
            Log::info('Feedback deleted successfully', ['id' => $id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Feedback destroy error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus ulasan: ' . $e->getMessage()
            ], 500);
        }
    }
}