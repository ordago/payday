<?php

namespace App\Http\Controllers;

use App\Actions\UpsertEmployeeAction;
use App\DataTransferObjects\EmployeeData;
use App\Http\Requests\UpsertEmployeeRequest;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    public function __construct(private readonly UpsertEmployeeAction $upsertEmployee)
    {
    }

    public function store(UpsertEmployeeRequest $request)
    {
        $employeeData = EmployeeData::fromRequest($request);
        $employee = $this->upsertEmployee->execute($employeeData);

        return new EmployeeResource($employee);
    }
}
