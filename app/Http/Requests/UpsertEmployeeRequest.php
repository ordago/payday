<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertEmployeeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'fullName' => ['required'],
            'email' => ['required', 'unique:employees,email'],
            'departmentId' => ['required', 'exists:departments,uuid'],
        ];
    }
}
