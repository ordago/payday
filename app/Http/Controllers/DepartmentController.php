<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(CreateDepartmentRequest $request)
    {
        return DepartmentResource::make(Department::create($request->all()));
    }
}
