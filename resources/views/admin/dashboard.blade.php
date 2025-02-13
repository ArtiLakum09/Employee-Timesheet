@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employee  Reports</h2>

    <table class="table table-bordered" id="employeeTable">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Employee Email</th>
            <th>Clock-In Time</th>
            <th>Break Start</th>
            <th>Break End</th>
            <th>Clock-Out Time</th>
            <th>Total Worked Time (hours:minutes)</th>
            <th>Live Location</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
             @if($user->clock_in_time)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->clock_in_time ? \Carbon\Carbon::parse($user->clock_in_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                <td>{{ $user->break_start_time ? \Carbon\Carbon::parse($user->break_start_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                <td>{{ $user->break_end_time ? \Carbon\Carbon::parse($user->break_end_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                <td>{{ $user->clock_out_time ? \Carbon\Carbon::parse($user->clock_out_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                <td>
                    @php
                        $workedTime = 'N/A';
                        if ($user->clock_in_time && $user->clock_out_time) {
                            $clockIn = \Carbon\Carbon::parse($user->clock_in_time);
                            $clockOut = \Carbon\Carbon::parse($user->clock_out_time);
                            $workedMinutes = $clockIn->diffInMinutes($clockOut);

                            if ($user->break_start_time && $user->break_end_time) {
                                $breakStart = \Carbon\Carbon::parse($user->break_start_time);
                                $breakEnd = \Carbon\Carbon::parse($user->break_end_time);
                                $breakMinutes = $breakStart->diffInMinutes($breakEnd);
                                $workedMinutes -= $breakMinutes;
                            }

                            $hours = floor($workedMinutes / 60);
                            $minutes = $workedMinutes % 60;
                            $workedTime = sprintf('%02d:%02d', $hours, $minutes);
                        }
                    @endphp
                    {{ $workedTime }}
                </td>
                <td>
                    @if($user->latitude && $user->longitude)
                        <a href="https://www.google.com/maps?q={{ $user->latitude }},{{ $user->longitude }}" target="_blank">
                            View on Map
                        </a>
                    @else
                        Location not available
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>

   
</div>
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: { lat: 20.5937, lng: 78.9629 } // Default center: India
        });

        @foreach($users as $user)
            @if($user->latitude && $user->longitude)
                new google.maps.Marker({
                    position: { lat: {{ $user->latitude }}, lng: {{ $user->longitude }} },
                    map: map,
                    title: "{{ $user->name }}"
                });
            @endif
        @endforeach
    }

    window.onload = initMap;
</script>
@endsection
