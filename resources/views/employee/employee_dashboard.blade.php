<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ardhas Time Tracker | Dashboard</title>
</head>
<body>
    @include('layouts.employee_sidebar')
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h3 class="card-title fs-5">This month</h3>
                        <p class="card-text fs-1">{{ $totalDays }}</p>
                        <p class="card-text fs-6">Days</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h3 class="card-title fs-5">Present</h3>
                        <p class="card-text fs-1">{{ $presentDays }}</p>
                        <p class="card-text fs-6">Days</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-danger text-white text-center">
                    <div class="card-body">
                        <h3 class="card-title fs-5">Absent</h3>
                        <p class="card-text fs-1">{{ $absentDays }}</p>
                        <p class="card-text fs-6">Days</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
