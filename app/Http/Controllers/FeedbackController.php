<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Simpan feedback dari consultation page (AJAX)
     */
    public function storeFromConsultation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'Nama harus diisi',
            'rating.required' => 'Rating harus dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'message.required' => 'Pesan ulasan harus diisi',
            'message.min' => 'Pesan ulasan minimal 10 karakter',
            'message.max' => 'Pesan ulasan maksimal 1000 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $feedback = Feedback::create([
                'name' => $request->name,
                'rating' => $request->rating,
                'message' => $request->message,
                'source' => 'consultation',
                'is_verified' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dikirim! Terima kasih atas feedback Anda.',
                'data' => [
                    'id' => $feedback->id,
                    'name' => $feedback->name,
                    'rating' => $feedback->rating,
                    'message' => $feedback->message,
                    'source' => $feedback->source,
                    'created_at' => $feedback->created_at->toISOString(),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ulasan. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Ambil semua feedback untuk ditampilkan (AJAX)
     */
    public function index()
    {
        try {
            $feedbacks = Feedback::verified()
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get()
                ->map(function ($feedback) {
                    return [
                        'id' => $feedback->id,
                        'name' => $feedback->name,
                        'rating' => $feedback->rating,
                        'message' => $feedback->message,
                        'source' => $feedback->source,
                        'service_type' => $feedback->service_type,
                        'created_at' => $feedback->created_at->toISOString(),
                        'formatted_date' => $feedback->formatted_date,
                    ];
                });

            return response()->json($feedbacks);

        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    /**
     * Hapus feedback (AJAX)
     */
    public function destroy($id)
    {
        try {
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus ulasan'
            ], 500);
        }
    }

    /**
     * Simpan feedback dari after service
     */
    public function storeAfterService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
            'message' => 'required|string|min:10',
            'service_type' => 'nullable|string',
            'transaction_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Feedback::create([
                'name' => $request->name,
                'rating' => $request->rating,
                'message' => $request->message,
                'service_type' => $request->service_type,
                'transaction_id' => $request->transaction_id,
                'source' => 'after_service',
                'is_verified' => true,
            ]);

            return redirect()->back()
                ->with('success', 'Terima kasih atas ulasan Anda!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim ulasan. Silakan coba lagi.');
        }
    }
}