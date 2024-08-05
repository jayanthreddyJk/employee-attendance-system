<!DOCTYPE html>
<html>
<head>
    <title>Punch_PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>All Punch In and Punch Out Details</p>

    <table class="table table-bordered">
        <tr>
            <th>Punch In</th>
            <th>Punch Out</th>
        </tr>
        @foreach($punches as $punch)
        <tr>
            <td>{{ $punch->punch_in }}</td>
            <td>{{ $punch->punch_out }}</td>
        </tr>
        @endforeach
    </table>

</body>
</html>
