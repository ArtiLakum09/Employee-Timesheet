<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class EmployeeAuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('employee.auth.login');
    }

    public function login(Request $request)
    {$request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('employee')->attempt($credentials, $request->remember)) {
        $employee = Auth::guard('employee')->user();
        
        // Update the employee's location
        $employee->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        
     

        return redirect()->intended(route('employee.dashboard'));
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect(route('employee.login'));
    }

    public function dashboard()
    {
        $employee = auth()->user(); // Get the authenticated employee
        $clock = $employee->clocks()->latest()->first(); // Get the latest clock record for this employee
    
        return view('employee.dashboard', compact('clock'));
    }
}
