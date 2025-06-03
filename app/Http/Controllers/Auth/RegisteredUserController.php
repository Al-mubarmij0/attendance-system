<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'matric_number' => 'required|string|max:255|unique:students,index_number',
            'department' => 'required|string|max:255',
            'level' => 'required|string|max:10',
        ], [
            'matric_number.unique' => 'This Matric Number is already registered.',
            'email.unique' => 'This email address is already registered.',
        ]);

        // 2. Create the new User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // 3. Create the associated Student record
        Student::create([
            'user_id' => $user->id,
            'index_number' => $request->matric_number,
            'department' => $request->department,
            'level' => $request->level,
        ]);

        // 4. Fire the registration event
        event(new Registered($user));

        // 5. Log in the user
        Auth::login($user);

        // 6. Redirect with a success message
        return redirect(route('dashboard'))->with('success', 'Registration successful! Welcome, ' . $user->name . '.');
    }
}
