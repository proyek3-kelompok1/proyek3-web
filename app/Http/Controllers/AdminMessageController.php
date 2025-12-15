<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Consultation;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index');
    }

    public function api()
    {
        $messages = Feedback::orderBy('created_at', 'desc')
            ->get()
            ->map(function ($feedback) {
                // Get consultation data if exists
                $consultation = null;
                if ($feedback->consultation_id) {
                    $consultation = Consultation::find($feedback->consultation_id);
                }
                
                return [
                    'id' => $feedback->id,
                    'name' => $feedback->name,
                    'email' => $consultation ? $consultation->email : null,
                    'phone' => $consultation ? $consultation->phone : null,
                    'rating' => $feedback->rating,
                    'message' => $feedback->message,
                    'source' => $feedback->source,
                    'pet_type' => $consultation ? $consultation->pet_type : null,
                    'services' => $consultation && $consultation->services 
                        ? json_decode($consultation->services, true) 
                        : null,
                    'created_at' => $feedback->created_at->toISOString(),
                    'updated_at' => $feedback->updated_at->toISOString(),
                ];
            });

        return response()->json($messages);
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        $consultation = null;
        
        if ($feedback->consultation_id) {
            $consultation = Consultation::find($feedback->consultation_id);
        }
        
        return response()->json([
            'id' => $feedback->id,
            'name' => $feedback->name,
            'email' => $consultation ? $consultation->email : null,
            'phone' => $consultation ? $consultation->phone : null,
            'rating' => $feedback->rating,
            'message' => $feedback->message,
            'source' => $feedback->source,
            'pet_type' => $consultation ? $consultation->pet_type : null,
            'services' => $consultation && $consultation->services 
                ? json_decode($consultation->services, true) 
                : null,
            'created_at' => $feedback->created_at->toISOString(),
            'updated_at' => $feedback->updated_at->toISOString(),
        ]);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Ulasan berhasil dihapus'
        ]);
    }
}