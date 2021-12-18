<?php

namespace App\Http\Controllers;

use App\Actions\CreateDepartmentAction;
use App\Actions\UpdateDepartmentAction;
use App\DataTransferObjects\DepartmentData;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly CreateDepartmentAction $createDepartment,
        private readonly UpdateDepartmentAction $updateDepartment,
    ) {}

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $departmentData = new DepartmentData(...$request->validated());
        $department = $this->createDepartment->execute($departmentData);

        return (new DepartmentResource($department))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateDepartmentRequest $request, Department $department): HttpResponse
    {
        $departmentData = new DepartmentData(...$request->validated());
        $department = $this->updateDepartment->execute($department, $departmentData);

        return response()->noContent();
    }
}
