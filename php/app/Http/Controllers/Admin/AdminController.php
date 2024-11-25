<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $facultyCount = Faculty::count();
        $roomCount = Room::count();
        $resCount = Reservation::count();

        // Reservation counts by week for the current year
        $reservationStats = Reservation::selectRaw('YEAR(date) as year, WEEK(date) as week, COUNT(*) as count')
            ->whereYear('date', Carbon::now()->year)
            ->groupBy('year', 'week')
            ->having('count', '>', 0)
            ->orderBy('week')
            ->get()
            ->map(function ($reservation) {
                return [
                    'week' => 'Week ' . $reservation->week,
                    'count' => $reservation->count,
                ];
            });

        $latestReservations = Reservation::with(['faculty', 'room'])
            ->orderBy('start_time', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('facultyCount', 'resCount','roomCount', 'reservationStats', 'latestReservations'));
    }


    public function showProfile()
    {
        $admin = Auth::user(); // Get the authenticated admin
        return view('admin.profile', compact('admin')); // Return the profile view
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user();
        $request->validate([
            'fullname' => 'required|string|max:255',
            'EXT' => 'required|string|max:50',
            'id_number' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:admin,email,' . $admin->admin_id . ',admin_id',
        ]);
        $admin->update([
            'fullname' => $request->fullname,
            'EXT' => $request->EXT,
            'id_number' => $request->id_number,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);
        $admin = Auth::user();
        // Check if current password is correct
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->with(['error' => 'Current password is incorrect']);
        }

        // Update the password
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }



    public function index()
    {
        $admins = Admin::all();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'EXT' => ['required', 'regex:/^05[0-9]{8}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
        ]);

        Admin::create([
            'fullname' => $request->fullname,
            'EXT' => $request->EXT,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
    }

    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $admin->admin_id . ',admin_id',
            'EXT' => ['required', 'regex:/^05[0-9]{8}$/'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],

        ]);

        $admin->update([
            'fullname' => $request->fullname,
            'EXT' => $request->EXT,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully.');
    }
}
