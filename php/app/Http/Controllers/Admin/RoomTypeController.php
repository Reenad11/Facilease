<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        return view('admin.roomTypes.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.roomTypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|unique:roomtype,type_name|max:255',
        ]);

        RoomType::create([
            'type_name' => $request->type_name,
            'admin_id' => auth('admin')->user()->admin_id
        ]);

        return redirect()->route('admin.roomTypes.index')->with('success', 'Room Type created successfully.');
    }

    public function show(RoomType $roomType)
    {
        return view('admin.roomTypes.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        return view('admin.roomTypes.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $request->validate([
            'type_name' => 'required|unique:roomtype,type_name,' . $roomType->room_type_id.',room_type_id' . '|max:255',
        ]);
        $roomType->update([
            'type_name' => $request->type_name,
        ]);
        return redirect()->route('admin.roomTypes.index')->with('success', 'Room Type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('admin.roomTypes.index')->with('success', 'Room Type deleted successfully.');
    }
}
