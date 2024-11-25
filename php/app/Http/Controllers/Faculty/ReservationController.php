<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function showBookingPage($id)
    {
        $room = Room::with(['reservations'])->findOrFail($id);
        $events = $room->reservations->map(function($reservation) {
            return [
                'title' => 'Reservation',
                'start' => $reservation->date . 'T' . $reservation->start_time,
                'end' => $reservation->date . 'T' . $reservation->end_time,
                'color' => 'red',
            ];
        });
        return view('faculty.reservation', [
            'room' => $room,
            'events' => $events
        ]);
    }

    public function confirmReservation(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'selected_date' => 'required',
        ]);
        $room = Room::findOrFail($id);
        $overlappingReservations = Reservation::where('room_id', $room->room_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time,$request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time,  $request->end_time])
                    ->orWhere(function($query) use ($request) {
                        $query->where('start_time', '<=',$request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })->exists();
        if ($overlappingReservations) {
            return redirect()->back()->with(['error' => 'The selected time slot is already booked. Please choose a different time.']);
        }
        $reservation = Reservation::create([
            'faculty_id' => Auth::guard('faculty')->id(),
            'room_id' => $room->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'date' => $request->selected_date,
            'status' => $room->need_admin_approve ?  'Pending' : 'Confirmed',
        ]);
       if ($reservation) {
           $facultyName = optional($reservation->faculty)->fullname;
           $roomNumber = optional($reservation->room)->room_number;
           $selectedDate = $reservation->date;
           $startTime = $reservation->start_time;
           $endTime = $reservation->end_time;
           $endMessage = $room->need_admin_approve ? 'Please review and confirm if admin approval is required.' : '';
           $message = "A new reservation has been made by {$facultyName} for Room {$roomNumber} on {$selectedDate} from {$startTime} to {$endTime}.{$endMessage} ";
           Notification::create([
               'faculty_id' => Auth::guard('faculty')->id(),
               'message' => $message,
               'date_time' => now(),
               'status' => 'unread',
           ]);
       }
        return redirect()->back()->with('success', 'Room booked successfully.');
    }


    public function cancelReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->faculty_id !== Auth::guard('faculty')->id()) {
            return redirect()->back()->with('error', 'You are not authorized to cancel this reservation.');
        }
        $reservation->update([
            'status' => 'Cancelled'
        ]);
        if ($reservation) {
            $facultyName = optional($reservation->faculty)->fullname;
            $roomNumber = optional($reservation->room)->room_number;
            $selectedDate = $reservation->date;
            $startTime = $reservation->start_time;
            $endTime = $reservation->end_time;
            $message = "{$facultyName} has canceled their reservation for Room {$roomNumber} on {$selectedDate} from {$startTime} to {$endTime}.";
            Notification::create([
                'faculty_id' => Auth::guard('faculty')->id(),
                'message' => $message,
                'date_time' => now(),
                'status' => 'unread',
            ]);
        }

        return redirect()->back()->with('success', 'Reservation cancelled successfully.');
    }
}
