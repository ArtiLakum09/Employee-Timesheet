<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clocking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery (Make sure it's loaded before DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>

    <div class="container mt-4">
        @auth
            <div class="mb-4">
                <span>Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('employee.logout') }}" class="btn btn-danger btn-sm ml-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('employee.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @endauth

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#employeeTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable search bar
            "ordering": true,       // Enable sorting
            "info": true,           // Show table info
            "lengthMenu": [10, 25, 50, 100], // Page length options
            "language": {
                "search": "Search Employee:", // Customize search text
                "lengthMenu": "Show _MENU_ entries per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ employees"
            }
        });
    });
</script>

</body>

</html>
