<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<style>
    .navbar,.sidebar{
        background-color: rgb(11,46,82);
    }
    .popover-body a {
        color: #007bff;
        text-decoration: none;
        font-size: 18px;
    }
    .popover-body a:hover {
        text-decoration: underline;
    }
    .offcanvas-body ul li{
        transition: all 0.3s;
    }
    .offcanvas-body ul li:hover{
        transform: translateX(5px);
    }
    .greeting{
        cursor: pointer;
    }
</style>
<body>
    <div class="navbar px-3 navbar-dark align-items-center">
        <div class="d-flex gap-3">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Menu"></span>
            </button>
            <p class="navbar-brand mb-0">Ardhas Time Tracker</p>
        </div>
        <div class=" text-center ">
            <p class="navbar-brand mb-0 greeting"  data-bs-toggle="popover" data-bs-html="true" data-bs-content="<a href='#'>Settings</a>"><i class="bi bi-person-circle pe-3"></i>Hi, Admin</p>
        </div>
    </div>
    <div class="offcanvas offcanvas-start sidebar" style="width: 300px" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title text-white" id="offcanvasExampleLabel">Ardhas Time Tracker</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled ps-4 pt-4 fs-5">
                <li class="mb-3"><a class="text-decoration-none text-white " href="{{url('admin_dashboard')}}"><i class="bi bi-house pe-3"></i>Dashboard</a></li>
                <li class="mb-3"><a class="text-decoration-none text-white " href="{{url('admin_employee_list')}}"><i class="bi bi-person-lines-fill pe-3"></i>Employee List</a></li>
                <li class="mb-3"><a class="text-decoration-none text-white " href="{{url('admin_attendance_log')}}"><i class="bi bi-file-earmark-spreadsheet pe-3"></i>Attendance Log</a></li>
                <li><a class="text-decoration-none text-white" href="{{route('logout.user')}}"><i class="bi bi-box-arrow-right pe-3"></i>Log Out</a></li>
            </ul>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
</body>
</html>
