<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Consultations;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    /**
     * Tampilkan halaman admin messages
     */
    public function index()
    {
        return view('admin.messages.index');
    }

    /**
     * API untuk mendapatkan semua messages (konsultasi + feedback)
     */
    public function api()
    {
        try {
            // Ambil semua data konsultasi
            $consultations = Consultations::with('feedbacks')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($consultation) {
                    return [
                        'id' => 'C-' . $consultation->id,
                        'type' => 'konsultasi',
                        'type_label' => 'Konsultasi',
                        'type_badge' => '<span class="badge bg-primary">Konsultasi</span>',
                        'name' => $consultation->name,
                        'email' => $consultation->email,
                        'phone' => $consultation->phone,
                        'rating' => null, // Konsultasi tidak punya rating
                        'message' => $consultation->message,
                        'source' => 'consultation',
                        'pet_type' => $consultation->pet_type,
                        'pet_type_label' => $consultation->pet_type_label,
                        'services' => $consultation->services ? json_decode($consultation->services, true) : [],
                        'service_type' => null,
                        'transaction_id' => null,
                        'is_verified' => true,
                        'has_feedback' => $consultation->feedbacks->count() > 0,
                        'feedback_count' => $consultation->feedbacks->count(),
                        'consultation_id' => $consultation->id,
                        'created_at' => $consultation->created_at->toISOString(),
                        'updated_at' => $consultation->updated_at->toISOString(),
                        'formatted_date' => $consultation->created_at->format('d M Y, H:i'),
                        'formatted_services' => $consultation->services 
                            ? implode(', ', json_decode($consultation->services, true))
                            : 'Tidak ada layanan dipilih'
                    ];
                });

            // Ambil semua feedback
            $feedbacks = Feedback::with('consultation')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($feedback) {
                    $consultation = $feedback->consultation;
                    
                    // Tentukan tipe
                    $type = 'feedback_konsultasi';
                    $type_label = 'Feedback Konsultasi';
                    $type_badge = '<span class="badge bg-info">Feedback Konsultasi</span>';
                    
                    if ($feedback->source === 'after_service') {
                        $type = 'feedback_layanan';
                        $type_label = 'Feedback Layanan';
                        $type_badge = '<span class="badge bg-success">Feedback Layanan</span>';
                    }
                    
                    return [
                        'id' => 'F-' . $feedback->id,
                        'type' => $type,
                        'type_label' => $type_label,
                        'type_badge' => $type_badge,
                        'name' => $feedback->name,
                        'email' => $consultation ? $consultation->email : null,
                        'phone' => $consultation ? $consultation->phone : null,
                        'rating' => $feedback->rating,
                        'message' => $feedback->message,
                        'source' => $feedback->source,
                        'pet_type' => $consultation ? $consultation->pet_type : null,
                        'pet_type_label' => $consultation ? $consultation->pet_type_label : null,
                        'services' => $consultation && $consultation->services 
                            ? json_decode($consultation->services, true) 
                            : null,
                        'service_type' => $feedback->service_type,
                        'transaction_id' => $feedback->transaction_id,
                        'is_verified' => $feedback->is_verified,
                        'has_feedback' => false, // Ini sudah feedback
                        'feedback_count' => 0,
                        'consultation_id' => $feedback->consultation_id,
                        'feedback_id' => $feedback->id,
                        'created_at' => $feedback->created_at->toISOString(),
                        'updated_at' => $feedback->updated_at->toISOString(),
                        'formatted_date' => $feedback->created_at->format('d M Y, H:i'),
                        'formatted_services' => $feedback->service_type 
                            ? $feedback->service_type 
                            : ($consultation && $consultation->services 
                                ? implode(', ', json_decode($consultation->services, true))
                                : 'Tidak ada layanan')
                    ];
                });

            // Gabungkan dan urutkan berdasarkan tanggal
            $allMessages = $consultations->concat($feedbacks);
            $sortedMessages = $allMessages->sortByDesc('created_at')->values();

            return response()->json($sortedMessages);

        } catch (\Exception $e) {
            \Log::error('Error fetching messages: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data pesan',
                'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Tampilkan detail message
     */
    public function show($id)
    {
        try {
            // Cek apakah ini konsultasi (C-) atau feedback (F-)
            if (strpos($id, 'C-') === 0) {
                // Ini konsultasi
                $consultationId = str_replace('C-', '', $id);
                $consultation = Consultations::with('feedbacks')->findOrFail($consultationId);
                
                $data = [
                    'id' => 'C-' . $consultation->id,
                    'type' => 'konsultasi',
                    'type_label' => 'Konsultasi',
                    'name' => $consultation->name,
                    'email' => $consultation->email,
                    'phone' => $consultation->phone,
                    'rating' => null,
                    'message' => $consultation->message,
                    'source' => 'consultation',
                    'pet_type' => $consultation->pet_type,
                    'pet_type_label' => $consultation->pet_type_label,
                    'services' => $consultation->services ? json_decode($consultation->services, true) : [],
                    'formatted_services' => $consultation->services 
                        ? implode(', ', json_decode($consultation->services, true))
                        : 'Tidak ada layanan dipilih',
                    'service_type' => null,
                    'transaction_id' => null,
                    'is_verified' => true,
                    'has_feedback' => $consultation->feedbacks->count() > 0,
                    'feedback_count' => $consultation->feedbacks->count(),
                    'consultation_id' => $consultation->id,
                    'created_at' => $consultation->created_at->toISOString(),
                    'updated_at' => $consultation->updated_at->toISOString(),
                    'formatted_date' => $consultation->created_at->format('d M Y, H:i'),
                    // Data feedback jika ada
                    'feedbacks' => $consultation->feedbacks->map(function ($feedback) {
                        return [
                            'id' => $feedback->id,
                            'name' => $feedback->name,
                            'rating' => $feedback->rating,
                            'message' => $feedback->message,
                            'created_at' => $feedback->created_at->format('d M Y, H:i'),
                            'rating_stars' => $feedback->rating_stars
                        ];
                    })
                ];
                
            } elseif (strpos($id, 'F-') === 0) {
                // Ini feedback
                $feedbackId = str_replace('F-', '', $id);
                $feedback = Feedback::with('consultation')->findOrFail($feedbackId);
                $consultation = $feedback->consultation;
                
                // Tentukan tipe
                $type = 'feedback_konsultasi';
                $type_label = 'Feedback Konsultasi';
                
                if ($feedback->source === 'after_service') {
                    $type = 'feedback_layanan';
                    $type_label = 'Feedback Layanan';
                }
                
                $data = [
                    'id' => 'F-' . $feedback->id,
                    'type' => $type,
                    'type_label' => $type_label,
                    'name' => $feedback->name,
                    'email' => $consultation ? $consultation->email : null,
                    'phone' => $consultation ? $consultation->phone : null,
                    'rating' => $feedback->rating,
                    'message' => $feedback->message,
                    'source' => $feedback->source,
                    'pet_type' => $consultation ? $consultation->pet_type : null,
                    'pet_type_label' => $consultation ? $consultation->pet_type_label : null,
                    'services' => $consultation && $consultation->services 
                        ? json_decode($consultation->services, true) 
                        : null,
                    'formatted_services' => $feedback->service_type 
                        ? $feedback->service_type 
                        : ($consultation && $consultation->services 
                            ? implode(', ', json_decode($consultation->services, true))
                            : 'Tidak ada layanan'),
                    'service_type' => $feedback->service_type,
                    'transaction_id' => $feedback->transaction_id,
                    'is_verified' => $feedback->is_verified,
                    'has_feedback' => false,
                    'feedback_count' => 0,
                    'consultation_id' => $feedback->consultation_id,
                    'feedback_id' => $feedback->id,
                    'created_at' => $feedback->created_at->toISOString(),
                    'updated_at' => $feedback->updated_at->toISOString(),
                    'formatted_date' => $feedback->created_at->format('d M Y, H:i'),
                    // Data konsultasi terkait jika ada
                    'related_consultation' => $consultation ? [
                        'id' => $consultation->id,
                        'name' => $consultation->name,
                        'email' => $consultation->email,
                        'phone' => $consultation->phone,
                        'message' => $consultation->message,
                        'created_at' => $consultation->created_at->format('d M Y, H:i')
                    ] : null
                ];
            } else {
                throw new \Exception('ID pesan tidak valid');
            }
            
            return response()->json($data);

        } catch (\Exception $e) {
            \Log::error('Error showing message: ' . $e->getMessage());
            return response()->json([
                'error' => 'Pesan tidak ditemukan',
                'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 404);
        }
    }

    /**
     * Hapus message
     */
    public function destroy($id)
    {
        try {
            // Cek apakah ini konsultasi (C-) atau feedback (F-)
            if (strpos($id, 'C-') === 0) {
                // Hapus konsultasi dan feedback terkait
                $consultationId = str_replace('C-', '', $id);
                $consultation = Consultations::findOrFail($consultationId);
                
                // Hapus feedback terkait dulu
                Feedback::where('consultation_id', $consultationId)->delete();
                
                // Hapus konsultasi
                $consultation->delete();
                
                $message = 'Konsultasi dan feedback terkait berhasil dihapus';
                
            } elseif (strpos($id, 'F-') === 0) {
                // Hapus feedback saja
                $feedbackId = str_replace('F-', '', $id);
                $feedback = Feedback::findOrFail($feedbackId);
                $feedback->delete();
                
                $message = 'Feedback berhasil dihapus';
            } else {
                throw new \Exception('ID pesan tidak valid');
            }

            return response()->json([
                'success' => true, 
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pesan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk statistik
     */
    public function stats()
    {
        try {
            $totalConsultations = Consultations::count();
            $totalFeedbacks = Feedback::count();
            $totalMessages = $totalConsultations + $totalFeedbacks;
            
            $averageRating = Feedback::avg('rating') ?? 0;
            $fiveStarFeedbacks = Feedback::where('rating', 5)->count();
            
            // Data per hari dalam 7 hari terakhir
            $consultationsByDay = Consultations::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
                
            $feedbacksByDay = Feedback::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            return response()->json([
                'total_consultations' => $totalConsultations,
                'total_feedbacks' => $totalFeedbacks,
                'total_messages' => $totalMessages,
                'average_rating' => round($averageRating, 1),
                'five_star_feedbacks' => $fiveStarFeedbacks,
                'consultations_by_day' => $consultationsByDay,
                'feedbacks_by_day' => $feedbacksByDay,
                'messages_by_type' => [
                    'konsultasi' => $totalConsultations,
                    'feedback_konsultasi' => Feedback::where('source', 'consultation')->count(),
                    'feedback_layanan' => Feedback::where('source', 'after_service')->count()
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching stats: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal mengambil statistik'
            ], 500);
        }
    }
}