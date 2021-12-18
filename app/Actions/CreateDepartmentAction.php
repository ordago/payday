<?php

namespace App\Actions;

use App\DataTransferObjects\DepartmentData;
use App\Models\Department;

class CreateDepartmentAction
{
    public function execute(DepartmentData $departmentData): Department
    {
        return Department::create([
            'name' => $departmentData->name,
            'description' => $departmentData->description,
        ]);
    }
}
