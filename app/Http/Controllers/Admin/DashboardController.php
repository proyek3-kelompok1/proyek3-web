<?php
// app/Http\Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Feedback;
use App\Models\Consultations;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        $today = now()->format('Y-m-d');

        // Stats
        $totalServices = Service::count();
        try {
            $activeDoctors = Doctor::where('is_active', true)->count();
        } catch (\Exception $e) {
            $activeDoctors = Doctor::count();
        }
        $totalMessages = Consultations::count() + Feedback::count();
        $totalEducation = Education::count();

        // Today's Queue
        $todayBookings = ServiceBooking::whereDate('booking_date', $today)->count();
        $todayPending  = ServiceBooking::whereDate('booking_date', $today)->where('status', 'pending')->count();
        $todayDone     = ServiceBooking::whereDate('booking_date', $today)->where('status', 'completed')->count();

        // Average rating
        $avgRating = Feedback::avg('rating') ?? 0;

        // Recent bookings (last 5)
        $recentBookings = ServiceBooking::with('doctor')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent feedback (last 5)
        $recentFeedback = Feedback::orderBy('created_at', 'desc')->take(5)->get();

        // Booking status distribution for today
        $bookingStats = [
            'pending'   => ServiceBooking::whereDate('booking_date', $today)->where('status', 'pending')->count(),
            'confirmed' => ServiceBooking::whereDate('booking_date', $today)->where('status', 'confirmed')->count(),
            'completed' => ServiceBooking::whereDate('booking_date', $today)->where('status', 'completed')->count(),
            'cancelled' => ServiceBooking::whereDate('booking_date', $today)->where('status', 'cancelled')->count(),
        ];

        // Weekly bookings (last 7 days)
        $weeklyBookings = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d/m');
            $weeklyBookings[] = [
                'date'  => $label,
                'count' => ServiceBooking::whereDate('booking_date', $date)->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'totalServices',
            'activeDoctors',
            'totalMessages',
            'totalEducation',
            'todayBookings',
            'todayPending',
            'todayDone',
            'avgRating',
            'recentBookings',
            'recentFeedback',
            'bookingStats',
            'weeklyBookings',
            'today'
        ));
    }
}