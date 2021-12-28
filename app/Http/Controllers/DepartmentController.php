<?php

namespace App\Http\Controllers;

use App\Actions\CreateDepartmentAction;
use App\DataTransferObjects\DepartmentData;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Resources\DepartmentResource;

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
}
