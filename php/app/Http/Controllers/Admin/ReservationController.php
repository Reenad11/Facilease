<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::query();

        // Apply filters
        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->input('faculty_id'));
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->input('room_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
        }

        $reservations = $query->latest('reservation_id')->get();

        // Fetch faculties and rooms for filters
        $faculties = Faculty::all();
        $rooms = Room::all();

        return view('admin.reservations.index', [
            'reservations' => $reservations,
            'faculties' => $faculties,
            'rooms' => $rooms
        ]);
    }


    public function create(Request $request)
    {
        $faculties = Faculty::all();
        $rooms = Room::all();

        $date = $request->input('date');
        $availableRooms = Room::whereDoesntHave('reservations', function($query) use ($date) {
            $query->where('date', $date);
        })->get();

        return view('admin.reservations.create', [
            'faculties' => $faculties,
            'rooms' => $availableRooms,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:room,room_id',
            'date' => 'required|date|after_or_equal:' . now()->toDateString(),
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'nullable|string',

        ]);
        $roomAvailable = Reservation::where('room_id', $request->room_id)
            ->where('date', $request->date)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function($query) use ($request) {
                        $query->where('start_time', '<', $request->start_time)
                            ->where('end_time', '>', $request->end_time);
                    });
            })
            ->doesntExist();
        if (!$roomAvailable) {
            return redirect()->back()->withInput()->withErrors(['room_id' => 'This room is not available for the selected date and time.']);
        }
        Reservation::create([
            'notes' => $request->notes,
            'room_id' => $request->room_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'Confirmed',
            'admin_id' => auth()->id(),
        ]);
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation created successfully.');
    }



    public function updateStatus(Request $request,$id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'status' => $request->status
        ]);
        return redirect()->back()->with('success', 'Reservation '.$request->status. 'successfully.');
    }
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
