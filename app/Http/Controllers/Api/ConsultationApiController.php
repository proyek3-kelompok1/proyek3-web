<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConsultationSession;
use App\Models\ConsultationMessage;
use App\Models\Doctor;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationApiController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    // Get or Create Session
    public function startSession(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $user = Auth::user();
        
        $session = ConsultationSession::where('user_id', $user->id)
            ->where('doctor_id', $request->doctor_id)
            ->where('status', 'active')
            ->first();

        if (!$session) {
            $session = ConsultationSession::create([
                'user_id' => $user->id,
                'doctor_id' => $request->doctor_id,
                'status' => 'active',
            ]);
        } else {
            $session->touch();
        }

        return response()->json([
            'success' => true,
            'data' => $session->load(['doctor', 'user']),
        ]);
    }

    // List Sessions (for Doctor or User)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'doctor') {
            $doctor = $user->doctor;
            if (!$doctor) {
                return response()->json(['success' => false, 'message' => 'User is not linked to a doctor record'], 403);
            }
            $sessions = ConsultationSession::where('doctor_id', $doctor->id)
                ->with(['user', 'lastMessage'])
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $sessions = ConsultationSession::where('user_id', $user->id)
                ->with(['doctor.user', 'lastMessage'])
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $sessions,
        ]);
    }

    // Get Messages
    public function getMessages($sessionId)
    {
        $session = ConsultationSession::findOrFail($sessionId);
        
        // Mark messages as read
        ConsultationMessage::where('session_id', $sessionId)
            ->where('sender_type', Auth::user()->role === 'doctor' ? 'user' : 'doctor')
            ->update(['is_read' => true]);

        $messages = $session->messages()->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    // Send Message
    public function sendMessage(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $session = ConsultationSession::findOrFail($sessionId);
        $user = Auth::user();
        $senderType = $user->role === 'doctor' ? 'doctor' : 'user';

        $message = ConsultationMessage::create([
            'session_id' => $sessionId,
            'sender_type' => $senderType,
            'message' => $request->message,
        ]);

        // Update session timestamp
        $session->touch();

        // Send Notification
        $this->notifyReceiver($session, $message);

        return response()->json([
            'success' => true,
            'data' => $message,
        ]);
    }

    protected function notifyReceiver($session, $message)
    {
        try {
            $senderUser = Auth::user();
            if ($message->sender_type === 'user') {
                // Notify Doctor
                $doctorUser = $session->doctor->user;
                if ($doctorUser && $doctorUser->fcm_token && $doctorUser->id !== $senderUser->id) {
                    $this->firebaseService->sendNotification(
                        $doctorUser->fcm_token,
                        'Pesan Baru dari ' . $session->user->name,
                        $message->message,
                        [
                            'type' => 'consultation',
                            'session_id' => (string)$session->id,
                        ]
                    );
                }
            } else {
                // Notify User
                $patientUser = $session->user;
                if ($patientUser && $patientUser->fcm_token && $patientUser->id !== $senderUser->id) {
                    // Send FCM
                    $this->firebaseService->sendNotification(
                        $patientUser->fcm_token,
                        'Pesan Baru dari Dr. ' . $session->doctor->name,
                        $message->message,
                        [
                            'type' => 'consultation',
                            'session_id' => (string)$session->id,
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            \Log::error('FCM Consultation Error: ' . $e->getMessage());
        }
    }
}
