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
        return DepartmentResource::make($this->upsert($request, new Department()));
    }

    public function update(UpsertDepartmentRequest $request, Department $department)
    {
        $this->upsert($request, $department);
        return response()->noContent();
    }

    private function upsert(UpsertDepartmentRequest $request, Department $department): Department
    {
        $departmentData = new DepartmentData(...$request->validated());
        return $this->upsertDepartment->execute($departmentData, $department);
    }
}
