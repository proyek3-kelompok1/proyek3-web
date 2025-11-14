<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Feedback store method called', ['data' => $request->all()]);

            // Validasi data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'message' => 'required|string'
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Simpan ke database
            $feedback = Feedback::create($validated);

            Log::info('Feedback saved successfully', ['id' => $feedback->id]);

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih atas ulasan Anda!',
                'data' => $feedback
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Feedback store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            Log::info('Fetching feedbacks');
            
            $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
            
            Log::info('Feedbacks fetched', ['count' => $feedbacks->count()]);
            
            return response()->json($feedbacks);
            
        } catch (\Exception $e) {
            Log::error('Feedback index error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Gagal memuat ulasan: ' . $e->getMessage()
            ], 500);
        }
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