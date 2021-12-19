<?php

namespace App\Actions;

use App\DataTransferObjects\EmployeeData;
use App\Models\Employee;

class UpsertEmployeeAction
{
    public function execute(EmployeeData $employeeData): Employee
    {
        return Employee::create([
            'full_name' => $employeeData->fullName,
            'email' => $employeeData->email,
            'department_id' => $employeeData->department->id,
            'job_title' => $employeeData->jobTitle,
            'payment_type_class' => $employeeData->paymentType,
            'salary' => $employeeData->salary,
            'hourly_rate' => $employeeData->hourlyRate,
        ]);
    }
}
