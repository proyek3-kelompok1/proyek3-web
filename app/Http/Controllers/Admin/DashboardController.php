<?php
// app/Http\Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Check manual jika admin sudah login
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }
        
        return view('admin.dashboard');
    }
}