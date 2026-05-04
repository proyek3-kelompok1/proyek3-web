<?php

namespace App\Console\Commands;

use App\Models\ServiceBooking;
use App\Services\FirebaseService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotifyBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send FCM notification to users 30 minutes before booking';

    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        parent::__construct();
        $this->firebaseService = $firebaseService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for bookings in 30 minutes...');

        // Cari booking yang akan datang dalam 30 menit
        // Kita cari yang booking_date = hari ini DAN booking_time = sekarang + 30 menit
        $now = Carbon::now();
        $targetTime = $now->addMinutes(30)->format('H:i');
        
        $bookings = ServiceBooking::whereDate('booking_date', Carbon::today())
            ->where('booking_time', 'like', $targetTime . '%')
            ->where('status', 'confirmed')
            ->with('user')
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No bookings found for ' . $targetTime);
            return;
        }

        foreach ($bookings as $booking) {
            if ($booking->user && $booking->user->fcm_token) {
                $title = 'Pengingat Booking';
                $body = "Halo {$booking->nama_pemilik}, jangan lupa jadwal booking Anda untuk {$booking->service_name} 30 menit lagi!";
                
                $sent = $this->firebaseService->sendNotification(
                    $booking->user->fcm_token,
                    $title,
                    $body,
                    ['type' => 'booking_reminder', 'booking_id' => (string)$booking->id]
                );

                if ($sent) {
                    $this->info("Notification sent to {$booking->nama_pemilik} for booking ID: {$booking->id}");
                } else {
                    $this->error("Failed to send notification to {$booking->nama_pemilik}");
                }
            } else {
                $this->warn("User for booking ID: {$booking->id} has no FCM token or no user record.");
            }
        }
    }
}
