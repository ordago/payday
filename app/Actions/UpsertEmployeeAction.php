<?php

namespace App\Actions;

use App\DataTransferObjects\EmployeeData;
use App\Models\Employee;

class UpsertEmployeeAction
{
    public function execute(Employee $employee, EmployeeData $employeeData): Employee
    {
            $employee->full_name = $employeeData->fullName;
            $employee->email = $employeeData->email;
            $employee->department_id = $employeeData->department->id;
            $employee->job_title = $employeeData->jobTitle;
            $employee->payment_type_class = $employeeData->paymentType;
            $employee->salary = $employeeData->salary;
            $employee->hourly_rate = $employeeData->hourlyRate;
            $employee->save();

            return $employee;
    }
}
