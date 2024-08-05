<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Punch;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function employeePunchHistory()
    {
        $emp_id = 1001;
        $punches = Punch::where('emp_id', $emp_id)->get();
        $data = [
            'title' => 'Welcome to Ardhas Technology',
            'date' => date('m/d/Y'),
            'punches' => $punches
        ];

        $pdf = PDF::loadView('pdf.employee_punch_pdf', $data);

        return $pdf->download('punch.pdf');
    }

    public function employeeAttendanceHistory()
    {
        $emp_id = 1001;
        $attendances = Attendance::where('emp_id', $emp_id)->get();
        $data = [
            'title' => 'Welcome to Ardhas Technology',
            'date' => date('m/d/Y'),
            'attendances' => $attendances
        ];

        $pdf = PDF::loadView('pdf.employee_attendance_pdf', $data);

        return $pdf->download('attendance.pdf');
    }
    public function adminAttendanceHistory()
    {
        $attendances = Attendance::get();
        $data = [
            'title' => 'Welcome to Ardhas Technology',
            'date' => date('m/d/Y'),
            'attendances' => $attendances
        ];

        $pdf = PDF::loadView('pdf.admin_attendance_pdf', $data);
        return $pdf->download('employeeAttendance.pdf');
    }
    public function EmployeeDetails()
    {
        $employees = Employee::where('trashed', "0")->get();

        $data = [
            'title' => 'Welcome to Ardhas Technology',
            'date' => date('m/d/Y'),
            'employees' => $employees
        ];

        $pdf = PDF::loadView('pdf.employee_details_pdf', $data);
        return $pdf->download('employeeDetails.pdf');
    }
}
