<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function storeAfterService(Request $request)
{
    try {
        Log::info('After service feedback store method called', ['data' => $request->all()]);

        // Validasi data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255', // Opsional, bisa anonymous
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string',
            'service_type' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255'
        ]);

        // Jika nama tidak diisi, gunakan "Anonymous"
        if (empty($validated['name'])) {
            $validated['name'] = 'Anonymous';
        }

        // Tambahkan metadata service
        $validated['metadata'] = json_encode([
            'service_type' => $validated['service_type'] ?? null,
            'transaction_id' => $validated['transaction_id'] ?? null,
            'feedback_type' => 'after_service'
        ]);

        Log::info('After service validation passed', ['validated' => $validated]);

        // Simpan ke database
        // $feedback = Feedback::create($validated);

        // Log::info('After service feedback saved successfully', ['id' => $feedback->id]);

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
    public function index()
    {
        // try {
        //     Log::info('Fetching feedbacks');
            
        //     $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
            
        //     Log::info('Feedbacks fetched', ['count' => $feedbacks->count()]);
            
        //     return response()->json($feedbacks);
            
        // } catch (\Exception $e) {
        //     Log::error('Feedback index error: ' . $e->getMessage());
            
        //     return response()->json([
        //         'error' => 'Gagal memuat ulasan: ' . $e->getMessage()
        //     ], 500);
        // }
    }

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