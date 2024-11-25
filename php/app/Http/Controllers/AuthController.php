<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use App\Models\Faculty;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        Auth::guard('admin')->logout();
        Auth::guard('student')->logout();
        Auth::guard('faculty')->logout();
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('id_number', 'password');
        $userType = $request->input('user_type');

        switch ($userType) {
            case 'admin':
                $guard = 'admin';
                $redirectTo = 'admin/dashboard';
                $credentialField = 'id_number';
                break;
            case 'student':
                $guard = 'student';
                $redirectTo = 'student/dashboard';
                $credentialField = 'id_number';
                break;
            case 'faculty':
                $guard = 'faculty';
                $redirectTo = 'faculty/dashboard';
                $credentialField = 'id_number';
                break;
            default:
                return redirect()->back()->withErrors(['user_type' => 'Invalid user type']);
        }

        // Attempt login with id_number and password
        if (Auth::guard($guard)->attempt([$credentialField => $credentials['id_number'], 'password' => $credentials['password']])) {
            return redirect()->intended($redirectTo);
        }

        return redirect()->back()->withInput()->with(['error' => 'Invalid credentials']);
    }


    public function logout(Request $request)
    {
        $userType = $request->input('user_type');
        if ($userType === 'admin') {
            $guard = 'admin';
        } elseif ($userType === 'student') {
            $guard = 'student';
        } elseif ($userType === 'faculty') {
            $guard = 'faculty';
        } else {
            return redirect()->back()->with(['error' => 'Invalid user type']);
        }

        // Logout the user
        Auth::guard($guard)->logout();

        return redirect()->route('auth.login');
    }

    public function showRegisterType()
    {
        return view('register_type');
    }

    public function showStudentRegisterForm()
    {
        return view('register_student');
    }

    public function registerStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_id' => 'required|numeric|digits:10|unique:student,college_id', // Numeric and exactly 10 digits
            'fullname' => 'required|string|max:255',
            'student_level' => 'required|string|max:100',
            'major' => 'required|string|max:100',
            'EXT' => ['required', 'regex:/^05[0-9]{8}$/'], // Phone number must start with 05 followed by 8 digits
            'email' => 'required|email|unique:student,email',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'], // Must include both letters and numbers
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Student::create([
            'college_id' => $request->input('college_id'),
            'fullname' => $request->input('fullname'),
            'student_level' => $request->input('student_level'),
            'major' => $request->input('major'),
            'EXT' => $request->input('EXT'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('auth.login')->with('success', 'Registration successful. You can now log in.');
    }


    public function showFacultyRegisterForm()
    {
        return view('register_faculty');
    }

    public function registerFaculty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'EXT' => ['required', 'regex:/^05[0-9]{8}$/'],
            'id_number' => 'required|numeric|digits:10|unique:faculty,id_number',
            'email' => 'required|email|unique:faculty,email',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'], // Must include both letters and numbers
            'department' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Faculty::create([
            'fullname' => $request->input('fullname'),
            'EXT' => $request->input('EXT'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'department' => $request->input('department'),
        ]);

        return redirect()->route('auth.login')->with('success', 'Registration successful. You can now log in.');
    }
}
