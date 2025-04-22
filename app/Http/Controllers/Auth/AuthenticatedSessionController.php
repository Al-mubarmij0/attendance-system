<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();
        
        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Redirect based on the user's role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'lecturer':
                return redirect()->route('lecturer.dashboard');

            case 'student':
                return redirect()->route('student.dashboard');

            default:
                // If the role doesn't match, log the user out and redirect to login
                Auth::logout();
                return redirect()->route('login')->with('error', 'Unauthorized role.');
        }
    }

    /**
     * Log out the authenticated user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log out the user
        Auth::guard('web')->logout();

        // Invalidate and regenerate the session for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect('/');
    }
}
