<?php

namespace App\Actions;

use App\DataTransferObjects\DepartmentData;
use App\Models\Department;

class CreateDepartmentAction
{
    public function execute(string $name, ?string $description): Department
    {
        return Department::create(compact('name', 'description'));
    }
}
