<!DOCTYPE html>
<html>
<head>
    <title>Punch_PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>All Employee Details</p>

    <table class="table table-bordered">
        <tr>
            <th>Employee Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
        </tr>
        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->emp_id }}</td>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->role }}</td>
        </tr>
        @endforeach
    </table>

</body>
</html>
