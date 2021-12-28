<?php

namespace App\Http\Controllers;

use App\Actions\UpsertDepartmentAction;
use App\DataTransferObjects\DepartmentData;
use App\Http\Requests\UpsertDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function __construct(private readonly UpsertDepartmentAction $upsertDepartment)
    {
    }

    public function store(UpsertDepartmentRequest $request)
    {
        $departmentData = new DepartmentData(...$request->validated());
        return DepartmentResource::make($this->upsertDepartment->execute($departmentData, new Department()));
    }

    public function update(UpsertDepartmentRequest $request, Department $department)
    {
        $departmentData = new DepartmentData(...$request->validated());
        $this->upsertDepartment->execute($departmentData, $department);

        return response()->noContent();
    }
}
