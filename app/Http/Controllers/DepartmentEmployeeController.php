<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentEmployeeController extends Controller
{
    public function index(Request $request, Department $department)
    {
        return EmployeeResource::collection($department->employees);
    }
}
