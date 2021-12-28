<?php

namespace App\Actions;

use App\DataTransferObjects\DepartmentData;
use App\Models\Department;

class UpsertDepartmentAction
{
    public function execute(DepartmentData $departmentData, Department $department): Department
    {
        $department->name = $departmentData->name;
        $department->description = $departmentData->description;
        $department->save();

        return $department;
    }
}
