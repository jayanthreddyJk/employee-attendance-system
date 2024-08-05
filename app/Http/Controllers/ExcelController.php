<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\RegisterMail;
use App\Exports\PunchExport;
use Illuminate\Http\Request;
use App\Imports\EmployeeImport;
use App\Exports\EmployeesExport;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminAttendanceLogExport;
use App\Exports\EmployeeAttendanceExport;

class ExcelController extends Controller
{
    public function Employeeexport()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }public function Punchexport()
    {
        return Excel::download(new PunchExport, 'punches.xlsx');
    }public function Attendanceexport()
    {
        return Excel::download(new EmployeeAttendanceExport, 'myattendance.xlsx');
    }public function AdminAttendanceexport()
    {
        return Excel::download(new AdminAttendanceLogExport, 'attendance.xlsx');
    }
    public function Employeeimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $import = new EmployeeImport;
        Excel::import($import, $request->file('file'));
        $importedEmployees = $import->importedEmployees;
        foreach ($importedEmployees as $employee) {
            try {
                SendEmail::dispatch($employee);
            } catch (\Exception $e) {
                \Log::error('Error sending email: ' . $e->getMessage());
            }
        }
        return back()->with('success', 'Users imported successfully.');
    }
}
