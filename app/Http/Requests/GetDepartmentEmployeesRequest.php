<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetDepartmentEmployeesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'filter' => ['nullable', 'sometimes', 'array'],
            'filter.full_name' => ['nullable', 'sometimes', 'string'],
            'filter.job_title' => ['nullable', 'sometimes', 'string'],
            'filter.email' => ['nullable', 'sometimes', 'string'],
        ];
    }
}
