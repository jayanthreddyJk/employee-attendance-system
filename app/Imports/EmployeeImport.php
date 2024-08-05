<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
class EmployeeImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $importedEmployees = [];

    public function model(array $row)
    {
        $employee = Employee::create([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
            'role'     => $row['role'],
        ]);
        $employeeData = [
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => $row['password'],
            'role' => $employee->role
        ];
        $this->importedEmployees[] = $employeeData;
        return $employee;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|min:3|max:30',
            'email' => 'required|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._-]+@[a-zA-Z]{3,}\.[a-zA-Z]{2,}$/|unique:employees,email',
            'role' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:2|max:30',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        ];
    }
}
