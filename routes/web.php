<?php

use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PunchController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('login_user',[AuthController::class, 'login_user'])->name('login.user');
Route::get('logout_user',[AuthController::class, 'logout'])->name('logout.user');
Route::get('admin_register',[AuthController::class,'admin_register']);

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('admin_dashboard',[AdminController::class,'dashboard']);
    Route::post('add_employee',[AuthController::class,'register_employee'])->name('employee.add');
    Route::post('delete_employee',[AdminController::class,'deleteEmployee'])->name('employee.delete');
    Route::get('view_employee',[AdminController::class,'viewEmployee'])->name('employee.details');
    Route::post('update_employee',[AdminController::class,'updateEmployee'])->name('employee.update');
    Route::get('admin_employee_list', [AdminController::class, 'index'])->name('employee.list');
    Route::get('admin_attendance_log',function(){
        return view('admin.admin_attendance_log');
    });
    Route::get('/fetch-attendance', [AttendanceController::class, 'fetchAttendance'])->name('fetch.attendance');
});


Route::group(['middleware' => ['role:employee']], function () {
    Route::get('employee_dashboard',[AttendanceController::class,'getAttendanceOverview']);
    Route::get('employee_attendance_log',function(){
        return view('employee.employee_attendance_log');
    });
    Route::get('employee_attendance_history',function(){
        return view('employee.employee_attendance_history');
    });
    Route::get('/fetch-attendance-history', [AttendanceController::class, 'fetchAttendanceHistory'])->name('fetch.attendance.history');
});

Route::get('fetch-punch-history',[PunchController::class,'fetchPunchesHistory'])->name('fetch.punch.history');
Route::get('fetch-punch-status',[PunchController::class,'fetchPunchesStatus'])->name('fetch.punch.status');
Route::get('update-punch',[PunchController::class,'updatePunch'])->name('update.punch.status');
Route::get('/fetch-punch-records', [AttendanceController::class, 'fetchPunchRecords'])->name('fetch-punch-records');


Route::get('generate-pdf1', [PDFController::class, 'employeePunchHistory'])->name('export.punch.pdf');
Route::get('generate-pdf2', [PDFController::class, 'employeeAttendanceHistory'])->name('export.attendance.pdf');
Route::get('generate-pdf3', [PDFController::class, 'adminAttendanceHistory'])->name('export.emp.attendance.pdf');
Route::get('generate-pdf4', [PDFController::class, 'EmployeeDetails'])->name('export.emp.details.pdf');

Route::get('employees-export', [ExcelController::class, 'Employeeexport'])->name('employees.export');
Route::get('punches-export', [ExcelController::class, 'Punchexport'])->name('punches.export');
Route::get('myattendance-export', [ExcelController::class, 'Attendanceexport'])->name('myattendance.export');
Route::get('attendance-export', [ExcelController::class, 'AdminAttendanceexport'])->name('attendance.export');
Route::post('employees-import', [ExcelController::class, 'Employeeimport'])->name('employees.import');
