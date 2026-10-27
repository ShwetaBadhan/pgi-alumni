<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('backend.pages.auth.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        // 1. Validate the request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'remember_token' => ['nullable', 'boolean'],
        ]);

        // 2. Attempt authentication
        if (Auth::attempt($credentials, $request->boolean('remember_token'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. Block inactive users
            if (!$user->status) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is currently inactive. Please contact the administrator.',
                ])->withInput($request->only('email'));
            }

            // 4. Redirect based on role (or default to dashboard)
            return $this->authenticated($request, $user);
        }

        // 5. If authentication fails
        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Redirect based on user role
     */
    protected function authenticated(Request $request, $user)
    {
        // You can add role-based logic here later, e.g.:
        // if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        
        return redirect()->route('dashboard');
    }
}