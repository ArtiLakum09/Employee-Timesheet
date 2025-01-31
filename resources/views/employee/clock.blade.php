@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Clock-In and Clock-Out</h2>

    <form action="{{ route('employee.clock-in') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Clock In</button>
    </form>

    <form action="{{ route('employee.clock-out') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-danger">Clock Out</button>
    </form>

    <h3 class="mt-4">Break Times</h3>
    <form action="{{ route('employee.break-start') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Start Break</button>
    </form>

    <form action="{{ route('employee.break-end') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-success">End Break</button>
    </form>

    <!-- Display Clocking Info -->
    <div class="mt-4">
        <h4>Your Clocking Information</h4>
        @foreach(auth()->user()->clocks as $clock)
            <p><strong>Clock In:</strong> {{ \Carbon\Carbon::parse($clock->clock_in)->format('Y-m-d H:i:s') }}</p>
            <p><strong>Break Start:</strong> {{ $clock->break_start ? \Carbon\Carbon::parse($clock->break_start)->format('Y-m-d H:i:s') : 'N/A' }}</p>
            <p><strong>Break End:</strong> {{ $clock->break_end ? \Carbon\Carbon::parse($clock->break_end)->format('Y-m-d H:i:s') : 'N/A' }}</p>
            <p><strong>Clock Out:</strong> {{ $clock->clock_out ? \Carbon\Carbon::parse($clock->clock_out)->format('Y-m-d H:i:s') : 'N/A' }}</p>
            @php
                $clockIn = \Carbon\Carbon::parse($clock->clock_in);
                $clockOut = \Carbon\Carbon::parse($clock->clock_out ?? now());
                $workedTime = $clockIn->diffInMinutes($clockOut);

                if ($clock->break_start && $clock->break_end) {
                    $breakStart = \Carbon\Carbon::parse($clock->break_start);
                    $breakEnd = \Carbon\Carbon::parse($clock->break_end);
                    $breakTime = $breakStart->diffInMinutes($breakEnd);
                    $workedTime -= $breakTime;
                }
            @endphp
            <p><strong>Total Worked Time:</strong> {{ $workedTime }} minutes</p>
        @endforeach
    </div>
</div>
@endsection
