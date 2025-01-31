<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Employee;
class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
       // Log out the admin
       auth()->guard('admin')->logout();

       // Invalidate the session and regenerate the CSRF token
       $request->session()->invalidate();
       $request->session()->regenerateToken();

       // Redirect to the admin login page
       return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $users = Employee::with('clocks')->get();
        return view('admin.dashboard', compact('users'));
    }
}
