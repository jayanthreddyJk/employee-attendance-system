<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeAttendanceExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendance::select("emp_id", "date", "login_time","logout_time","total_login_hours","break_time","overtime")->get();
    }
    public function headings(): array
    {
        return ["Employee ID", "Date", "Login Time","Logout Time","Total hours worked","Break Time","Overtime"];
    }
}
