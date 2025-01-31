@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>

    <div class="row">
        <div class="col-md-6">
            <h3>Your Current Status:</h3>
            <p>
                @if(auth()->user()->clock_in_time && !auth()->user()->clock_out_time)
                    Clocked In at: {{ \Carbon\Carbon::parse(auth()->user()->clock_in_time)->format('M d, Y h:i A') }}
                @elseif(auth()->user()->clock_out_time)
                    Clocked Out at: {{ \Carbon\Carbon::parse(auth()->user()->clock_out_time)->format('M d, Y h:i A') }}
                @else
                    You have not clocked in yet.
                @endif
            </p>
        </div>

        <div class="col-md-6">
            <h3>Actions:</h3>
            <!-- Clock In button -->
            @if(!auth()->user()->clock_in_time || auth()->user()->clock_out_time)
                <form action="{{ route('employee.clock-in') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Clock In</button>
                </form>
            @endif

            <!-- Clock Out button -->
            @if(auth()->user()->clock_in_time && !auth()->user()->clock_out_time)
                <form action="{{ route('employee.clock-out') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Clock Out</button>
                </form>
            @endif

           <!-- Break Start & Break End buttons -->
           @php
    $clock = auth()->user()->clocks()->whereNull('clock_out_time')->latest()->first(); // Get the latest clock record that is still active
    $breakStart = $clock ? $clock->break_start_time : null;
    $breakEnd = $clock ? $clock->break_end_time : null;
@endphp

    @if(auth()->user()->clock_in_time && !auth()->user()->clock_out_time)
        @if(!$breakStart || $breakEnd) 
            <!-- If user hasn't started a break OR has already ended the break -->
            <form action="{{ route('employee.break-start') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">Take a Break</button>
            </form>
        @elseif($breakStart && !$breakEnd)
            <!-- If user has started a break but hasn't ended it -->
            <form action="{{ route('employee.break-end') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">End Break</button>
            </form>
        @endif
    @endif

        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <h3>Work History:</h3>
            @php
                $clock = auth()->user()->clocks()->latest()->first(); // Get the latest clock record
                $clockIn = $clock ? \Carbon\Carbon::parse($clock->clock_in_time) : null;
                $clockOut = $clock ? \Carbon\Carbon::parse($clock->clock_out_time) : null;
                $breakStart = $clock && $clock->break_start_time ? \Carbon\Carbon::parse($clock->break_start_time) : null;
                $breakEnd = $clock && $clock->break_end_time ? \Carbon\Carbon::parse($clock->break_end_time) : null;
                
                // Default message for total work hours
                $totalWorkHours = 'Not clocked out yet'; 

                if ($clockIn && $clockOut) {
                    $totalWorkDuration = $clockIn->diffInSeconds($clockOut);  // Work time excluding breaks
                    
                    // Subtract break time if break exists
                    if ($breakStart && $breakEnd) {
                        $breakDuration = $breakStart->diffInSeconds($breakEnd);
                        $totalWorkDuration -= $breakDuration;
                    }

                    // Format total work hours in H:i format
                    $totalWorkHours = gmdate("H:i", $totalWorkDuration);
                }
            @endphp
            <ul>
                <li><strong>Clock In Time:</strong> {{ $clockIn ? $clockIn->format('M d, Y h:i A') : 'Not clocked in' }}</li>
                <li><strong>Clock Out Time:</strong> {{ $clockOut ? $clockOut->format('M d, Y h:i A') : 'Not clocked out' }}</li>
                <li><strong>Break Start Time:</strong> {{ $breakStart ? $breakStart->format('M d, Y h:i A') : 'No break started' }}</li>
                <li><strong>Break End Time:</strong> {{ $breakEnd ? $breakEnd->format('M d, Y h:i A') : 'No break ended' }}</li>
                <li><strong>Total Work Hours:</strong> {{ $totalWorkHours }}</li>
            </ul>
        </div>
    </div>
</div>

@endsection
