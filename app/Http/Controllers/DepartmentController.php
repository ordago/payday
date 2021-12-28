<?php

namespace App\Http\Controllers;

use App\Actions\CreateDepartmentAction;
use App\DataTransferObjects\DepartmentData;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(private readonly CreateDepartmentAction $createDepartment)
    {
    }

    public function store(CreateDepartmentRequest $request)
    {
        $departmentData = new DepartmentData(...$request->validated());
        return DepartmentResource::make($this->createDepartment->execute($departmentData));
    }

    public function update(Request $request, Department $department)
    {
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();

        return response()->noContent();
    }
}
