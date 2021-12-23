<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentEmployeeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePaycheckController;
use App\Http\Controllers\PaydayController;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', DepartmentController::class)->except('destroy');
Route::get('departments/{department}/employees', [DepartmentEmployeeController::class, 'index'])->name('department-employees.index');
Route::get('employees/{employee}/paychecks', [EmployeePaycheckController::class, 'index'])->name('employee-paychecks.index');
Route::apiResource('employees', EmployeeController::class);
Route::post('payday', [PaydayController::class, 'store'])->name('payday.store');
