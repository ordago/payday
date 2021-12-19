<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaycheckResource;
use App\Models\Employee;

class EmployeePaycheckController extends Controller
{
    public function index(Employee $employee)
    {
        return PaycheckResource::collection($employee->paychecks()->latest()->get());
    }
}
