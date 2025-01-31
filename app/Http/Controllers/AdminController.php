<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clock;
use Carbon\Carbon;


class AdminController extends Controller
{
    //
    public function showReports()
{
    $users = User::with('clocks')->get();
    return view('admin.reports', compact('users'));
}

public function calculateTotalTime($userId)
{
    $clocks = Clock::where('user_id', $userId)->get();
    $totalTime = 0;
    foreach ($clocks as $clock) {
        $clockIn = Carbon::parse($clock->clock_in);
        $clockOut = Carbon::parse($clock->clock_out ?? now());
        $breakStart = $clock->break_start ? Carbon::parse($clock->break_start) : null;
        $breakEnd = $clock->break_end ? Carbon::parse($clock->break_end) : null;

        $workedTime = $clockIn->diffInMinutes($clockOut);
        if ($breakStart && $breakEnd) {
            $breakTime = $breakStart->diffInMinutes($breakEnd);
            $workedTime -= $breakTime;
        }

        $totalTime += $workedTime;
    }

    return $totalTime;
}
}
