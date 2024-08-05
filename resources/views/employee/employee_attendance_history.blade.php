<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ardhas Time Tracker | Attendance History</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

</head>
<body>
    @include('layouts.employee_sidebar')
    <section class="container">
        <div class="mt-5">
            <div class="d-flex justify-content-between">
                <p class="display-6">Attendance History</p>
            </div>
       </div>
       <div>
            <ul class="list-unstyled d-flex gap-3">
                <li><a href="{{route('myattendance.export')}}" class="btn btn-success"><i class="bi bi-file-spreadsheet"></i> Export as Excel</a></li>
                <li><a href="{{route('export.attendance.pdf')}}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export as PDF</a></li>
            </ul>
       </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('Status'))
                    <div id="successAlert" class="alert alert-success">{{ session('Status') }}</div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Total Login Hours</th>
                                        <th>Break Time</th>
                                        <th>Overtime</th>
                                        <th>Punch</th>
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
<div class="modal fade" id="punchRecordsModal" tabindex="-1" role="dialog" aria-labelledby="punchRecordsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="punchRecordsLabel">Punch Records</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function(){
            var successAlert = $('#successAlert');
        if (successAlert.length) {
            setTimeout(function() {
                successAlert.fadeOut('slow');
            }, 5000);
        }
        });
                $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('fetch.attendance.history') }}",
                        data: { emp_id: @json(Auth::guard('employee')->user()->emp_id)},
                    },
                    columns: [
                        { data: 'date', name: 'date' },
                        { data: 'login_time', name: 'login_time' },
                        { data: 'logout_time', name: 'logout_time' },
                        { data: 'total_login_hours', name: 'total_login_hours' },
                        { data: 'break_time', name: 'break_time' },
                        { data: 'overtime', name: 'overtime' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    destroy: true,
                });
                $(document).on('click', '.view-punch-records', function() {
                    var emp_id = $(this).data('emp-id');
                    var date = $(this).data('date');

                    $.ajax({
                        url: '/fetch-punch-records',
                        type: 'GET',
                        data: { emp_id: emp_id, date: date },
                        success: function(response) {
                            $('#punchRecordsModal .modal-body').html(response);
                            $('#punchRecordsModal').modal('show');
                        }
                    });
                });
    </script>
</body>
</html>
