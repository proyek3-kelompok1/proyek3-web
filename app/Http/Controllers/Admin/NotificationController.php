<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        return view('admin.notifications.index');
    }

    public function sendManual(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target' => 'required|in:all,specific',
        ];

        if ($request->target === 'specific') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        $title = $request->title;
        $body = $request->body;
        $data = ['type' => 'manual'];

        if ($request->target === 'all') {
            $success = $this->firebaseService->sendToTopic('all_users', $title, $body, $data);
            if (!$success) {
                return back()->with('error', 'Gagal mengirim notifikasi ke semua pengguna. Cek log Firebase.');
            }
        } else {
            $user = User::find($request->user_id);
            if (!$user->fcm_token) {
                return back()->with('error', 'Selected user does not have an FCM token.');
            }
            $success = $this->firebaseService->sendNotification($user->fcm_token, $title, $body, $data);
            if (!$success) {
                return back()->with('error', 'Gagal mengirim notifikasi ke user tersebut.');
            }
        }

        return back()->with('success', 'Notification sent successfully!');
    }
}
