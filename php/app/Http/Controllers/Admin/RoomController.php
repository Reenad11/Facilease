<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Traits\UploadFile;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    use UploadFile;

    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:room,room_number|numeric',
            'location' => 'required',
            'capacity' => 'required|integer|min:5',
            'equipment' => 'nullable',
            'availability_status' => 'required',
            'room_type_id' => 'required|exists:roomtype,room_type_id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth('admin')->user()->admin_id;
        $data['need_admin_approve'] = $request->has('need_admin_approve'); // Checkbox value

        $room = Room::create($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->upload($image);
                $room->images()->create(['image_url' => $imagePath]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }


    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::all(); // Fetch all room types
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|numeric|unique:room,room_number,' . $room->room_id . ',room_id',
            'location' => 'required',
            'capacity' => 'required|integer|min:5',
            'equipment' => 'nullable',
            'availability_status' => 'required',
            'room_type_id' => 'required|exists:roomtype,room_type_id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth('admin')->user()->admin_id;
        $data['need_admin_approve'] = $request->has('need_admin_approve'); // Checkbox value

        $room->update($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->upload($image);
                $room->images()->create(['image_url' => $imagePath]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
