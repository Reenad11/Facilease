<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::all();
        return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculties.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'EXT' => ['required', 'regex:/^05[0-9]{8}$/'],
            'id_number' => 'required|numeric|digits:10|unique:Faculty,id_number',
            'email' => 'required|email|unique:Faculty,email',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
            'department' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Faculty::create([
            'fullname' => $request->fullname,
            'EXT' => $request->EXT,
            'id_number' => $request->id_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department' => $request->department,
        ]);
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty created successfully');
    }

    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, $id)
    {
        $faculty = Faculty::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'EXT' => ['required', 'regex:/^05[0-9]{8}$/'],
            'id_number' => 'required|numeric|digits:10|unique:Faculty,id_number,' . $faculty->faculty_id.',faculty_id',
            'email' => 'required|email|unique:Faculty,email,' . $faculty->faculty_id.',faculty_id',
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
            'department' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $faculty->update([
            'fullname' => $request->fullname,
            'EXT' => $request->EXT,
            'id_number' => $request->id_number,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $faculty->password,
            'department' => $request->department,
        ]);

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty updated successfully');
    }

    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty deleted successfully');
    }
}
