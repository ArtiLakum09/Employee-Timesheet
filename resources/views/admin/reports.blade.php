@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employee Clock-in/Clock-out Reports</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Clock-In Time</th>
                <th>Break Start</th>
                <th>Break End</th>
                <th>Clock-Out Time</th>
                <th>Total Worked Time (minutes)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    @foreach($user->clocks as $clock)
                        <td>{{ \Carbon\Carbon::parse($clock->clock_in)->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $clock->break_start ? \Carbon\Carbon::parse($clock->break_start)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>{{ $clock->break_end ? \Carbon\Carbon::parse($clock->break_end)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>{{ $clock->clock_out ? \Carbon\Carbon::parse($clock->clock_out)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>
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
                            {{ $workedTime }} minutes
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
