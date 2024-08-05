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
        <div id="successAlert" class="alert alert-success mt-3" style="display: none;"></div>
        <div class="mt-5">
            <div class="d-flex justify-content-between">
                <p class="display-6">Attendance Log</p>
                <div>
                    <button class="punchbutton btn btn-danger" id="punchout" style="display: none;">Punch Out</button>
                    <button class="punchbutton btn btn-primary" id="punchin" style="display: none;">Punch In</button>
                </div>
            </div>
       </div>
       <div>
            <ul class="list-unstyled d-flex gap-3">
                <li><a href="{{route('punches.export')}}" class="btn btn-success"><i class="bi bi-file-spreadsheet"></i> Export as Excel</a></li>
                <li><a href="{{ route('export.punch.pdf') }}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export as PDF</a></li>
            </ul>
       </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Punch In</th>
                                        <th>Punch Out</th>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
                var emp = @json(Auth::guard('employee')->user()->emp_id);
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('fetch.punch.history') }}",
                        data: { emp_id: emp },
                    },
                    columns: [
                        { data: 'punch_in', name: 'punch_in' },
                        { data: 'punch_out', name: 'punch_out' },
                    ],
                    destroy: true,
                });


                $('#punchin').on('click', function() {
                    $.ajax({
                        url: "{{ route('update.punch.status') }}",
                        type: 'GET',
                        data: { emp_id: emp, punch: 'in' },
                        success: function(response){
                            if (response.success) {
                                $('#successAlert').text(response.message).show();
                                setTimeout(function() {
                                    $('#successAlert').fadeOut('slow');
                                }, 5000);
                            }
                        }
                    });
                });

                $('#punchout').on('click', function() {
                    $.ajax({
                        url: "{{ route('update.punch.status') }}",
                        type: 'GET',
                        data: { emp_id: emp, punch: 'out' },
                        success: function(response){
                            if (response.success) {
                                $('#successAlert').text(response.message).show();
                                setTimeout(function() {
                                    $('#successAlert').fadeOut('slow');
                                }, 5000);
                            }
                        }
                    });
                });

                function updatePunchButton() {
                    $.ajax({
                        url: "{{ route('fetch.punch.status') }}",
                        type: 'GET',
                        data: { emp_id: emp },
                        success: function(response) {
                            if (response.status === 'in') {
                                $('#punchout').show();
                                $('#punchin').hide();
                            } else {
                                $('#punchin').show();
                                $('#punchout').hide();
                            }

                            table.ajax.reload(null, false);
                        }
                    });
                }

                updatePunchButton();

                $('.punchbutton').on('click', function() {
                    updatePunchButton();
                });

    </script>
</body>
</html>
