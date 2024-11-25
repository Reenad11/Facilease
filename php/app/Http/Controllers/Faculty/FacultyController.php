<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    public function dashboard(Request $request)
    {
        // Set default date to today if no date is provided by the filter
        $date = $request->get('date', today()->toDateString());

        $query = Room::query();

        // Filter by room type
        if ($request->has('room_type') && $request->room_type != '') {
            $query->where('room_type_id', $request->room_type);
        }

        // Filter by capacity
        if ($request->has('capacity') && $request->capacity != '') {
            $query->where('capacity', '>=', $request->capacity);
        }

        // Filter by equipment
        if ($request->has('equipment') && !empty($request->equipment)) {
            $equipment = $request->equipment;
            $query->where(function ($q) use ($equipment) {
                foreach ($equipment as $item) {
                    $q->where('equipment', 'LIKE', "%$item%");
                }
            });
        }

        // Fetch rooms with reservations for the selected date
        $rooms = $query->with(['reservations' => function ($reservationQuery) use ($date) {
            $reservationQuery->whereDate('date', $date);
        }])->latest('room_id')->get();

        // Set availability status dynamically based on the reservation for the selected date
        $rooms->each(function ($room) {
            $room->availability_status = $room->reservations->isEmpty() ? 'Available' : 'Reserved';
        });

        return view('faculty.dashboard', compact('rooms', 'date'));
    }



    public function showRoom($id)
    {
        $room = Room::findOrFail($id);
        return view('faculty.room_details', compact('room'));
    }
    public function showProfile()
    {
        $faculty = Auth::guard('faculty')->user();
        return view('faculty.profile', compact('faculty'));
    }

    // Update faculty profile
    public function updateProfile(Request $request)
    {
        $faculty = Auth::guard('faculty')->user();

        $request->validate([
            'EXT' => 'required|regex:/^05[0-9]{8}$/',
            'email' => 'required|email|unique:faculty,email,' . $faculty->faculty_id.',faculty_id',
            'department' => 'nullable|string',
        ]);

        $faculty->update($request->all());

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Update faculty password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $faculty = Auth::guard('faculty')->user();

        if (!Hash::check($request->current_password, $faculty->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $faculty->password = Hash::make($request->new_password);
        $faculty->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
