<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::where('trashed', "0")->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn1 = '<a href="#" class="btn btn-primary btn-sm view-btn" data-id="'.$row->emp_id.'"><i class="bi bi-pencil-square"></i></a>';
                        $btn2 = '<a href="#" class="btn btn-danger btn-sm delete-btn" data-id="'.$row->emp_id.'"><i class="bi bi-trash"></i></a>';
                        return $btn1." ".$btn2;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.admin_employee_list');
    }

    public function dashboard()
    {
        $totalEmployees = DB::table('employees')->count();

        $employeesPresent = DB::table('punches')
            ->whereDate('date', now()->toDateString())
            ->whereNotNull('punch_in')
            ->distinct('emp_id')
            ->count('emp_id');

        $employeesAbsent = $totalEmployees - $employeesPresent;

        return view('admin.admin_dashboard', [
            'totalEmployees' => $totalEmployees,
            'employeesPresent' => $employeesPresent,
            'employeesAbsent' => $employeesAbsent
        ]);
    }
    public function deleteEmployee(Request $request)
{
    try {
        $employee = Employee::where('emp_id',$request->emp_id)->first();
        if ($employee) {
            $employee->trashed = "1";
            $employee->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Employee not found']);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred']);
    }
}

public function viewEmployee(Request $request)
{
    try {
        $employee = Employee::where('emp_id',$request->emp_id)->first();
        if ($employee) {
            return response()->json(['success' => true, 'employee' => $employee]);
        }
        return response()->json(['success' => false, 'message' => 'Employee not found']);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred']);
    }
}
public function updateEmployee(Request $request){
    $validator = Validator::make($request->all(), [
        'emp_id' => 'required',
        'name' => 'required|regex:/^[a-zA-Z\s]+$/|min:3|max:30',
        'email' => 'required|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._-]+@[a-zA-Z]{3,}\.[a-zA-Z]{2,}$/|',
        'role' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:2|max:30',
    ]);
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator, 'viewEmployeeModal')->withInput();
    }else{
        $data = $validator->validated();
        $employee = Employee::where('emp_id', $data['emp_id'])->first();
        $employee->name = $data['name'];
        $employee->email = $data['email'];
        $employee->role = $data['role'];
        $employee->save();
        return back()->withSuccess('Employee details Updated Successfully');
    }
}

}
