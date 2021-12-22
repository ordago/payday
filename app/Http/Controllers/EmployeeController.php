<?php

namespace App\Http\Controllers;

use App\Actions\UpsertEmployeeAction;
use App\DataTransferObjects\EmployeeData;
use App\Http\Requests\GetEmployeesRequest;
use App\Http\Requests\UpsertEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function __construct(private readonly UpsertEmployeeAction $upsertEmployee)
    {
    }

    public function index(GetEmployeesRequest $request)
    {
        $employees = QueryBuilder::for(Employee::class)
            ->allowedFilters(['full_name', 'job_title', 'email', 'department.name'])
            ->allowedIncludes(['department'])
            ->get();

        return EmployeeResource::collection($employees);
    }

    public function show(Employee $employee)
    {
        return EmployeeResource::make($employee);
    }

    public function store(UpsertEmployeeRequest $request): JsonResponse
    {
        return EmployeeResource::make($this->upsert($request, new Employee()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpsertEmployeeRequest $request, Employee $employee): HttpResponse
    {
        $employee = $this->upsert($request, $employee);
        return response()->noContent();
    }

    public function destroy(Employee $employee): HttpResponse
    {
        $employee->delete();
        return response()->noContent();
    }

    private function upsert(UpsertEmployeeRequest $request, Employee $employee): Employee
    {
        $employeeData = EmployeeData::fromRequest($request);
        return $this->upsertEmployee->execute($employee, $employeeData);
    }
}
