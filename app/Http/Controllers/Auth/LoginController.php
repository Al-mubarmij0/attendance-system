<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect based on user role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->hasRole('lecturer')) {
                return redirect()->route('lecturer.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
