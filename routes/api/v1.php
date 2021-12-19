<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentEmployeeController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', DepartmentController::class)->except('destroy');
Route::get('departments/{department}/employees', [DepartmentEmployeeController::class, 'index'])->name('department-employees.index');
Route::apiResource('employees', EmployeeController::class);
