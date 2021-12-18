<?php

namespace App\Actions;

use App\DataTransferObjects\DepartmentData;
use App\Models\Department;

class UpdateDepartmentAction
{
    public function execute(Department $department, DepartmentData $departmentData): Department
    {
        $department->name = $departmentData->name;
        $department->description = $departmentData->description;
        $department->save();

        return $department;
    }
}
