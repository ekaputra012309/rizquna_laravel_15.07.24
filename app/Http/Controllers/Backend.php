<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PermintaanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Backend extends Controller
{
    public function signin()
    {
        $data = array(
            'title' => 'Login | ',
        );
        return view('backend.login', $data);
    }

    public function register()
    {
        $data = array(
            'title' => 'Register | ',
        );
        return view('backend.register', $data);
    }

    public function dashboard()
    {
        $bookings = Booking::with('agent', 'hotel', 'details', 'user')
            ->whereDate('tgl_booking', Carbon::today())
            ->get();
        $data = [
            'title' => 'Dashboard | ',
            'databooking' => $bookings,
        ];

        return view('backend.dashboard', $data);
    }

    public function profile(Request $request)
    {
        $data = array(
            'title' => 'Profile | ',
            'user' => $request->user(),
        );
        return view('backend.profile', $data);
    }
}
