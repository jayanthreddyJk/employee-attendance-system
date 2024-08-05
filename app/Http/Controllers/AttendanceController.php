<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Punch;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function getAttendanceOverview()
    {
        $emp_id = Auth::guard('employee')->user()->emp_id;
        $daysInMonth = Carbon::now()->daysInMonth;

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->toDateString();
        $daysBetween = $startDate->diffInDays($endDate);
        $attendanceRecords = Punch::where('emp_id', $emp_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->distinct('date')
            ->get(['date'])
            ->count();
        $presentDays = $attendanceRecords;
        $endDate2 = Carbon::yesterday();

        if($startDate->lessThanOrEqualTo($endDate2)){
            $daysBetween = $startDate->diffInDays($endDate2) + 1;
            $attendanceRecords2 = Punch::where('emp_id', $emp_id)
                ->whereBetween('date', [$startDate, $endDate2])
                ->distinct('date')
                ->count();

            $absentDays = $daysBetween - $attendanceRecords2;
        }else{
            $absentDays = 0;
        }

        return view('employee.employee_dashboard',[
            'totalDays' => $daysInMonth,
            'presentDays' => $presentDays,
            'absentDays' => $absentDays
        ]);
    }
    public function fetchAttendance(Request $request)
    {
        if ($request->ajax()) {
            $date = $request->get('date');
            $data = DB::table('attendances')
                ->select(
                    'attendances.emp_id',
                    'attendances.date',
                    'attendances.login_time',
                    'attendances.logout_time',
                    'attendances.total_login_hours',
                    'attendances.break_time',
                    'attendances.overtime'
                )
                ->whereDate('attendances.date', $date)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="#" class="btn btn-primary btn-sm view-punch-records" data-emp-id="' . $row->emp_id . '" data-date="' . $row->date . '">Records</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.admin_attendance_log');
    }
    public function fetchAttendanceHistory(Request $request)
    {
        if ($request->ajax()) {
            $emp_id = $request->get('emp_id');

            $data = DB::table('attendances')
                ->join('employees', 'attendances.emp_id', '=', 'employees.emp_id')
                ->select(
                    'employees.emp_id',
                    'attendances.date',
                    'attendances.login_time',
                    'attendances.logout_time',
                    'attendances.total_login_hours',
                    'attendances.break_time',
                    'attendances.overtime'
                )
                ->where('attendances.emp_id', $emp_id)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="#" class="btn btn-primary btn-sm view-punch-records" data-emp-id="' . $row->emp_id . '" data-date="' . $row->date . '">Records</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('employee.employee_attendance_history');
    }
    public function fetchPunchRecords(Request $request)
    {
        $emp_id = $request->emp_id;
        $date = $request->date;

        $punchRecords = DB::table('punches')
            ->where('emp_id', $emp_id)
            ->whereDate('date', $date)
            ->get();
        return view('punch_records', compact('punchRecords'));
    }
}
