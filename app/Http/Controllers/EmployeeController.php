<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clock;


class EmployeeController extends Controller
{
    public function clockIn(Request $request)
    {
        // Get the authenticated user
    $employee = auth()->user();

    // Check if the employee is already clocked in
    if ($employee->clock_in_time && !$employee->clock_out_time) {
        return back()->with('error', 'You are already clocked in.');
    }

    // Create a new clock record
    $clock = new Clock();
    $clock->employee_id = $employee->id; // Associate with the authenticated employee
    $clock->clock_in_time = now(); // Set the current time as clock-in time
    $clock->save();  // Save the clock-in record

    // Update the user record with the clock-in time (Optional)
    $employee->clock_in_time = now();
    $employee->save();

    return back()->with('success', 'Clocked In successfully!');
    }

    public function clockOut(Request $request)
    {
        $employee = auth()->user();

    // Get the latest clock record for this employee that doesn't have a clock_out_time
    $clock = $employee->clocks()->whereNull('clock_out_time')->latest()->first();

    if ($clock) {
        // Update clock-out time in the Clock table
        $clock->clock_out_time = now();
        $clock->save();  // Save the updated clock-out record

        // Update the clock_out_time in the Employee table as well
        $employee->clock_out_time = now();
        $employee->save(); // Save the updated employee record

        // Optionally, refresh the employee data to make sure the UI reflects the change
        $employee->refresh();

        return back()->with('success', 'Clocked Out successfully!');
    }

    return back()->with('error', 'Unable to clock out. Please ensure you have clocked in.');
    }
    

    public function startBreak(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('employee.login')->with('error', 'You must be logged in to take a break.');
        }
    
        $employee = auth()->user();
        $clock = $employee->clocks()->whereNull('clock_out_time')->latest()->first();
    
        if ($clock && !$clock->break_start_time) {
            $clock->break_start_time = now();
            $clock->save();
    
            return back()->with('success', 'Break Started');
        }
    
        return back()->with('error', 'Unable to start break. Ensure you are clocked in and not already on break.');
    }
    
    public function endBreak(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('employee.login')->with('error', 'You must be logged in to end a break.');
    }

    $employee = auth()->user();
    $clock = $employee->clocks()->whereNull('clock_out_time')->latest()->first();

    if ($clock && $clock->break_start_time && !$clock->break_end_time) {
        $clock->break_end_time = now();
        $clock->save();

        return back()->with('success', 'Break Ended');
    }

    return back()->with('error', 'Unable to end break. Ensure you have started a break.');
}

    
}
