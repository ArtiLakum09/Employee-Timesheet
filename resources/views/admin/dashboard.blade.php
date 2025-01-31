@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employee Clock-in/Clock-out Reports</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Clock-In Time</th>
                <th>Break Start</th>
                <th>Break End</th>
                <th>Clock-Out Time</th>
                <th>Total Worked Time (hours:minutes)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @foreach($user->clocks as $clock)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $clock->clock_in_time ? \Carbon\Carbon::parse($clock->clock_in_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>{{ $clock->break_start_time ? \Carbon\Carbon::parse($clock->break_start_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>{{ $clock->break_end_time ? \Carbon\Carbon::parse($clock->break_end_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>{{ $clock->clock_out_time ? \Carbon\Carbon::parse($clock->clock_out_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>
                            @php
                                $workedTime = 'N/A';

                                if ($clock->clock_in_time && $clock->clock_out_time) {
                                    $clockIn = \Carbon\Carbon::parse($clock->clock_in_time);
                                    $clockOut = \Carbon\Carbon::parse($clock->clock_out_time);
                                    $workedMinutes = $clockIn->diffInMinutes($clockOut);

                                    // Subtract break time if break start and end exist
                                    if ($clock->break_start_time && $clock->break_end_time) {
                                        $breakStart = \Carbon\Carbon::parse($clock->break_start_time);
                                        $breakEnd = \Carbon\Carbon::parse($clock->break_end_time);
                                        $breakMinutes = $breakStart->diffInMinutes($breakEnd);
                                        $workedMinutes -= $breakMinutes;
                                    }

                                    // Convert to hours and minutes
                                    $hours = floor($workedMinutes / 60);
                                    $minutes = $workedMinutes % 60;
                                    $workedTime = sprintf('%02d:%02d', $hours, $minutes);
                                }
                            @endphp
                            {{ $workedTime }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
