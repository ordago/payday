<?php

namespace App\Http\Controllers;

use App\Actions\UpsertDepartmentAction;
use App\DataTransferObjects\DepartmentData;
use App\Http\Requests\UpsertDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly UpsertDepartmentAction $upsertDepartment,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return DepartmentResource::collection(Department::all());
    }

    public function show(Department $department): DepartmentResource
    {
        return new DepartmentResource($department);
    }

    public function store(UpsertDepartmentRequest $request): JsonResponse
    {
        return (new DepartmentResource($this->upsert($request, new Department())))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpsertDepartmentRequest $request, Department $department): HttpResponse
    {
        $this->upsert($request, $department);
        return response()->noContent();
    }

    private function upsert(UpsertDepartmentRequest $request, Department $department): Department
    {
        $departmentData = new DepartmentData(...$request->validated());
        return $this->upsertDepartment->execute($department, $departmentData);
    }
}
