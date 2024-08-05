<!DOCTYPE html>
<html>
<head>
    <title>Punch_PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>All Attendance Details</p>

    <table class="table table-bordered">
        <tr>
            <th>Date</th>
            <th>LogIn Time</th>
            <th>LogOut Time</th>
            <th>Total Time</th>
            <th>Break Time</th>
            <th>Overtime</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr>
            <td>{{ $attendance->date}}</td>
            <td>{{ $attendance->login_time}}</td>
            <td>{{ $attendance->logout_time}}</td>
            <td>{{ $attendance->total_login_hours}}</td>
            <td>{{ $attendance->break_time}}</td>
            <td>{{ $attendance->overtime}}</td>
        </tr>
        @endforeach
    </table>

</body>
</html>
