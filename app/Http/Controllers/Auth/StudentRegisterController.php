<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.student-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'Registration_number' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'Registration_number' => $request->matric_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', // assuming you use roles
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}
