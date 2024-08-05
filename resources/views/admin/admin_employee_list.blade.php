<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ardhas Time Tracker | Employee List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

</head>
<body>
    @include('layouts.admin_sidebar')
    <section class="container">
        <div class="mt-5 d-flex justify-content-between">
            <div>

                @if (session('success'))
                    <div id="successAlert" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            <p class="display-6">Employee Details</p>
            </div>
            <div>
                <a href="" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addEmployee">Add</a>
            </div>
            <div class="modal fade" id="addEmployee" >
                <div class="modal-dialog custom-width">
                    <div class="modal-content px-4">
                        <div class="modal-header">
                            <h3 class="modal-title">Add Employee</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('employee.add')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="name">Name</label>
                                    <input class="form-control" type="text" name="name" id="name" placeholder="Enter FullName" value="{{ old('name') }}">
                                    @if($errors->getBag('addEmployee')->has('name'))
                                        <div class="text-danger">{{ $errors->getBag('addEmployee')->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="email">Email</label>
                                    <input class="form-control" type="email" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email') }}">
                                    @if($errors->getBag('addEmployee')->has('email'))
                                        <div class="text-danger">{{ $errors->getBag('addEmployee')->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold"  for="role">Position</label>
                                    <input class="form-control"  type="text" name="role" id="role" placeholder="Enter Position" value="{{ old('role') }}">
                                    @if($errors->getBag('addEmployee')->has('role'))
                                        <div class="text-danger">{{ $errors->getBag('addEmployee')->first('role') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold"  for="password">Create Password</label>
                                    <input class="form-control"  type="password" name="password" id="password" placeholder="Create Password">
                                    @if($errors->getBag('addEmployee')->has('password'))
                                        <div class="text-danger">{{ $errors->getBag('addEmployee')->first('password') }}</div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-end gap-3 mt-3">
                                    <button class="btn btn-primary px-4 fw-bold" type="submit">Add</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6">
                <form class="form-group" action="{{route('employees.import')}}" method="post" enctype="multipart/form-data">
                    <input type="file" class="form-control" name="file" id="file" placeholder="Choose File">
                    @csrf
                    <button class="btn btn-success my-3"><i class="bi bi-file-earmark-spreadsheet"></i>Import from Excel</button>
                </form>
            </div>
            <ul class="list-unstyled d-flex gap-3 col-md-6 mt-5">
                <li><a href="{{route('employees.export')}}" class="btn btn-success"><i class="bi bi-file-spreadsheet"></i> Export as Excel</a></li>
                <li><a href="{{route('export.emp.details.pdf')}}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export as PDF</a></li>
            </ul>
       </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('Status'))
                    <div class="alert alert-success">{{ session('Status') }}</div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>EmpId</th>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Position</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="viewEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="viewEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewEmployeeLabel">Employee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee.update')}}" method="POST" id="employeeForm">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id" value="{{ old('emp_id') }}">
                    <div class="form-group mb-3">
                        <label for="empname" class="form-label">Name</label>
                        <input type="text" class="form-control" id="empname" name="name" value="{{ old('name') }}">
                        @if($errors->getBag('viewEmployeeModal')->has('name'))
                            <div class="text-danger">{{ $errors->getBag('viewEmployeeModal')->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="empemail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="empemail" name="email" value="{{ old('email') }}">
                        @if($errors->getBag('viewEmployeeModal')->has('email'))
                            <div class="text-danger">{{ $errors->getBag('viewEmployeeModal')->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="empposition" class="form-label">Position</label>
                        <input type="text" class="form-control" id="empposition" name="role" value="{{ old('role') }}">
                        @if($errors->getBag('viewEmployeeModal')->has('role'))
                            <div class="text-danger">{{ $errors->getBag('viewEmployeeModal')->first('role') }}</div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end gap-3 mt-3">
                        <button type="submit" class="btn btn-primary" id="editButton">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($errors->hasBag('viewEmployeeModal'))
    <script>
        $(document).ready(function() {
            $('#viewEmployeeModal').modal('show');

            $('#empname').val("{{ old('name') }}");
            $('#empemail').val("{{ old('email') }}");
            $('#empposition').val("{{ old('role') }}");
        });
    </script>
@endif
@if ($errors->hasBag('addEmployee'))
    <script>
        $(document).ready(function() {
            $('#addEmployee').modal('show');
        });
    </script>
@endif
@if (session('error'))
    <script>
        $(document).ready(function() {
            $('#addEmployee').modal('show');
            alert("{{ session('error') }}");
        });
    </script>
@endif
@if (session('error'))
    <script>
        $(document).ready(function() {
            $('#viewEmployeeModal').modal('show');
            alert("{{ session('error') }}");
        });
    </script>
@endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function (){
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.list') }}",
                columns: [
                    {data: 'emp_id', name: 'emp_id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className:'action-buttons'},
                ]
            });
        });
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    var successAlert = $('#successAlert');
        if (successAlert.length) {
            setTimeout(function() {
                successAlert.fadeOut('slow');
            }, 5000);
        }
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var emp_id = $(this).data('id');
        if (confirm("Are you sure you want to delete this employee?")) {
            $.ajax({
                url: "{{ route('employee.delete') }}",
                method: 'POST',
                data: { emp_id: emp_id, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        alert('Employee deleted successfully');
                        $('.data-table').DataTable().ajax.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    $(document).on('click', '.view-btn', function(e) {
        e.preventDefault();
        var emp_id = $(this).data('id');

        $.ajax({
            url: "{{ route('employee.details') }}",
            method: 'GET',
            data: { emp_id: emp_id },
            success: function(response) {
                if (response) {
                    $('#emp_id').val(response.employee.emp_id);
                    $('#empname').val(response.employee.name);
                    $('#empemail').val(response.employee.email);
                    $('#empposition').val(response.employee.role);
                    $('#viewEmployeeModal').modal('show');
                } else {
                    alert('Employee details not found');
                }
            }
        });
    });
});

</script>
</body>
</html>
