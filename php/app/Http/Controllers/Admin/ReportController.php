<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Event;
use App\Models\Room;
use App\Models\Faculty;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Display the Reservation Utilization Report
    public function reservationUtilization(Request $request)
    {
        // Get filter dates and specific room ID from the request
        $startDate = $request->filled('start_date') ? $request->input('start_date') : null;
        $endDate = $request->filled('end_date') ? $request->input('end_date') : null;
        $specificRoomId = $request->filled('room_id') ? $request->input('room_id') : null;

        // Base query for reservations with date range filtering
        $reservationsQuery = Reservation::with('room')
            ->selectRaw('room_id, SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_reserved_hours')
            ->groupBy('room_id');

        if ($startDate) {
            $reservationsQuery->whereDate('start_time', '>=', $startDate);
        }

        if ($endDate) {
            $reservationsQuery->whereDate('end_time', '<=', $endDate);
        }

        if ($specificRoomId) {
            $reservationsQuery->where('room_id', $specificRoomId);
        }

        $reservations = $reservationsQuery->get();
        $rooms = Room::all();

        // Room utilization and average rating calculation
        $roomUtilization = $reservations->map(function ($reservation) use ($rooms) {
            $room = $rooms->where('room_id', $reservation->room_id)->first();
            $totalHours = 24 * 30; // Assuming a 30-day month
            $utilization = ($reservation->total_reserved_hours / $totalHours) * 100;

            return [
                'room_number' => $room->room_number,
                'total_reserved_hours' => $reservation->total_reserved_hours,
                'utilization_percentage' => number_format($utilization, 2),
            ];
        });

        // Prepare chart data based on filters
        $totalRooms = Room::count();
        $bookedRoomsCount = $reservations->count();
        $emptyRoomsCount = $totalRooms - $bookedRoomsCount;

        // Rooms with 2 or fewer stars in rating
        $lowRatedRooms = Room::whereIn('room_id', function ($query) {
            $query->select('room_id')
                ->from('feedback')
                ->groupBy('room_id')
                ->havingRaw('AVG(rating) <= 2');
        })->count();

        // Most booked rooms
        $mostBookedRooms = $reservations->sortByDesc('total_reserved_hours')->take(5)->map(function($reservation) use ($rooms) {
            $room = $rooms->where('room_id', $reservation->room_id)->first();
            return $room->room_number;
        });

        // Average rating by room type with 5 stars
        $fiveStarRooms = Room::with('feedbacks')
            ->get()
            ->filter(function ($room) {
                return $room->feedbacks->avg('rating') == 5;
            })
            ->groupBy('room_type_id');
        $chartData = [
            'series' => [intval($emptyRoomsCount), intval($bookedRoomsCount), intval($lowRatedRooms)],
            'labels' => ['Empty Rooms', 'Booked Rooms', 'Rooms with 2 or Fewer Stars'],
        ];

        return view('admin.reports.reservation_utilization', compact('roomUtilization', 'chartData', 'mostBookedRooms', 'fiveStarRooms', 'rooms'));
    }


    // Display the Faculty Activity Report
    public function facultyActivity()
    {
        $faculties = Faculty::withCount(['reservations', 'feedbacks'])
            ->with(['reservations', 'feedbacks'])
            ->get();

        return view('admin.reports.faculty_activity', compact('faculties'));
    }
}
